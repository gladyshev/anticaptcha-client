<?php

namespace Anticaptcha\Response;

use Anticaptcha\Client;
use BadMethodCallException;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;

final class GetTaskResultResponse extends AbstractResponse
{
    public const TASK_STATUS_READY = 'ready';
    public const TASK_STATUS_PROCESSING = 'processing';

    public ?string $status = null;
    public ?array $solution = null;
    public ?string $cost = null;
    public ?string $ip = null;
    public ?int $createTime = null;
    public ?int $endTime = null;
    public ?int $solveCount = null;

    private ?int $taskId = null;
    private ?Client $client = null;

    public function isReady(): bool
    {
        return $this->status === self::TASK_STATUS_READY;
    }

    public function setTaskId(int $taskId): void
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getSolution(): ?array
    {
        return $this->solution;
    }

    /**
     * @param int $pollingInterval
     * @param int $timeout
     * @return void
     *
     * @throws JsonException
     * @throws ClientExceptionInterface
     */
    public function wait(int $pollingInterval = 5, int $timeout = 60): void
    {
        if (
            $pollingInterval < 1
            || $timeout < 1
        ) {
            throw new InvalidArgumentException('Timeout must be positive integer.');
        }

        if (
            $this->client === null
            || $this->taskId === null
        ) {
            throw new BadMethodCallException('Can\'t wait due to inconsistency.');
        }

        $startTime = time();
        $result = $this->client->getTaskResult($this->taskId);

        while (!$result->isReady()) {
            sleep($pollingInterval);
            if (time() - $startTime >= $timeout) {
                throw new RuntimeException('Waiting for ready timeout.');
            }
            $result = $this->client->getTaskResult($this->taskId);
        }

        // Self update
        $this->status = $result->status;
        $this->solution = $result->solution;
        $this->cost = $result->cost;
        $this->ip = $result->ip;
        $this->createTime = $result->createTime;
        $this->endTime = $result->endTime;
        $this->solveCount = $result->solveCount;
    }
}
