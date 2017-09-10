<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

use Anticaptcha\Client;
use Anticaptcha\CredentialsInterface;
use Anticaptcha\Exception\InvalidArgumentException;
use Anticaptcha\Exception\ResponseTimeoutException;
use function Anticaptcha\t;

/**
 * Class Result
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class Result extends Entity
{
    const TASK_STATUS_READY = 'ready';
    const TASK_STATUS_PROCESSING = 'processing';

    /**
     * @var CredentialsInterface
     */
    protected $credentials;

    /**
     * @var int
     */
    protected $taskId;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Entity
     */
    protected $solution;

    /**
     * Task cost in USD.
     *
     * @var string
     */
    protected $cost;

    /**
     * IP from which the task was created.
     *
     * @var string
     */
    protected $ip;

    /**
     * UNIX Timestamp of task creation.
     *
     * @var int
     */
    protected $createTime;

    /**
     * UNIX Timestamp of task completion.
     *
     * @var int
     */
    protected $endTime;

    /**
     * Number of workers who tried to complete your task
     *
     * @var int
     */
    protected $solveCount;

    /**
     * @param $response
     * @return Result
     * @throws InvalidArgumentException
     */
    public static function fromResponse($response)
    {
        if (isset($response['solution'])) {
            if (isset($response['solution']['url'], $response['solution']['text'])) {
                $response['solution'] = new ImageToTextSolution($response['solution']);
            } else {
                $response['solution'] = new NoCaptchaSolution($response['solution']);
            }
        }

        return new Result($response);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Entity | ImageToTextSolution | NoCaptchaSolution
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return floatval($this->cost);
    }

    /**
     * @return string
     */
    public function getCostAsString()
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return int
     */
    public function getSolveCount()
    {
        return $this->solveCount;
    }

    /**
     * @param int $requestInterval
     * @param int $timeout
     * @throws ResponseTimeoutException
     */
    public function await($requestInterval = 5, $timeout = 60)
    {
        $client = new Client($this->credentials);
        $startTime = time();
        $result = $client->getTaskResult($this->taskId);
        while ($result->status !== self::TASK_STATUS_READY) {
            sleep($requestInterval);
            if (time() - $startTime >= $timeout) {
                throw new ResponseTimeoutException(t('Getting result timeout.'));
            }
            $result = $client->getTaskResult($this->taskId);
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

    /**
     * Solving elapsed time in seconds.
     *
     * @return int
     */
    public function getElapsedTime()
    {
        return $this->getEndTime() - $this->getCreateTime();
    }
}
