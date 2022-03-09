<?php

namespace Anticaptcha\Task;

use Anticaptcha\Entity;
use ReflectionClass;
use ReflectionProperty;

abstract class AbstractTask extends Entity
{
    abstract public function getType(): string;

    public function toArray(): array
    {
        $obj = new ReflectionClass(static::class);

        $attributes = [
            'type' => $this->getType()
        ];

        foreach ($obj->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $name = $reflectionProperty->getName();
            $value = $this->$name ?? null;

            if (is_null($value)) {
                continue;
            }

            $attributes[$name] = $value;
        }

        return $attributes;
    }
}
