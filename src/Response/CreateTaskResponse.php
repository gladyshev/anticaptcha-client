<?php

namespace Anticaptcha\Response;

final class CreateTaskResponse extends AbstractResponse
{
    public ?int $taskId = null;

    public function getTaskId(): int
    {
        if (empty($this->taskId)) {
            throw new \RuntimeException('Response is failed.');
        }

        return $this->taskId;
    }
}
