<?php

namespace Anticaptcha\Tests\Unit\Task;

use Anticaptcha\Task\AbstractTask;
use PHPUnit\Framework\TestCase;

class AbstractTaskTest extends TestCase
{
    public function testGetType(): void
    {
        $task = new TestTask([
            'requiredAttribute' => 'test'
        ]);

        self::assertEquals('TestTask', $task->getType());
    }

    public function testToArray(): void
    {
        $task = new TestTask([
            'requiredAttribute' => 'test',
            'optionalAttribute' => 'testOptional'
        ]);

        self::assertArrayHasKey('requiredAttribute', $task->toArray());
        self::assertArrayHasKey('optionalAttribute', $task->toArray());
    }
}

class TestTask extends AbstractTask
{
    public string $requiredAttribute;
    public ?string $optionalAttribute = null;
}