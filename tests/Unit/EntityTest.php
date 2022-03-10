<?php

namespace Anticaptcha\Tests\Unit;

use Anticaptcha\Entity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testRequiredAttribute(): void
    {
        $entity = new TestEntity([
            'requiredAttribute' => 'test'
        ]);

        self::assertEquals($entity->requiredAttribute, 'test');

        $this->expectException(\InvalidArgumentException::class);

        new TestEntity();
    }

    public function testOptionalAttributeUnfilled(): void
    {
        $entity = new TestEntity([
            'requiredAttribute' => 'test'
        ]);

        self::assertNull($entity->optionalAttribute);
    }

    public function testOptionalAttributeFilled(): void
    {
        $entity = new TestEntity([
            'requiredAttribute' => 'test',
            'optionalAttribute' => 'testOptional'
        ]);

        self::assertEquals($entity->optionalAttribute, 'testOptional');
    }
}


class TestEntity extends Entity
{
    public string $requiredAttribute;
    public ?string $optionalAttribute = null;
}