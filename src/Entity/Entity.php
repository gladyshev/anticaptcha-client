<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

/**
 * Class Entity
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
abstract class Entity
{
    /**
     * Entity constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $option => $value) {
            $setter = 'set' . ucfirst($option);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } elseif (property_exists($this, $option)) {
                $this->$option = $value;
            }
        }
    }
}
