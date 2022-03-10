<?php

namespace Anticaptcha;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

abstract class Entity
{
    public function __construct(array $properties = [])
    {
        /* Validate required */

        foreach ($this->getRequiredProperties() as $property) {
            if (!isset($properties[$property])) {
                throw new InvalidArgumentException(
                    sprintf('Property "%s" is required.', $property)
                );
            }
        }

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
            } else {
                throw new InvalidArgumentException(
                    sprintf('Property "%s" not found in class "%s".', $option, static::class)
                );
            }
        }
    }

    /**
     * @return string[]
     */
    protected function getRequiredProperties(): array
    {
        $properties = [];

        foreach ((new ReflectionClass(static::class))->getProperties(ReflectionProperty::IS_PUBLIC) as $reflection) {
            if ($reflection->hasDefaultValue()) {
                continue;
            }
            $properties[] = $reflection->getName();
        }

        return $properties;
    }
}
