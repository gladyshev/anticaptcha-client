<?php

namespace Anticaptcha;

abstract class Entity
{
    public function __construct(array $properties = [])
    {
        /**
         * @var string $option
         * @var mixed $value
         */
        foreach ($properties as $option => $value) {
            $setter = 'set' . ucfirst($option);
            if (method_exists($this, $setter)) {
                call_user_func([$this, $setter], $value);
            } elseif (property_exists($this, $option)) {
                $this->$option = $value;
            }
        }
    }
}
