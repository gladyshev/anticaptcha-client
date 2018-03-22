<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

use Anticaptcha\Entity\ImageToTextTask;
use Anticaptcha\Entity\QueueStats;
use Anticaptcha\Entity\Result;

/**
 * Class Client
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class Client extends Service
{
    /**
     * @param string $string # base64 to resolve
     * @return int
     */
    public function createTaskByBase64($string)
    {
        return $this->createTask(ImageToTextTask::fromBase64($string));
    }
    /**
     * @param string $link  # Path or URL of image to resolve
     * @return int
     */
    public function createTaskByImage($link)
    {
        return $this->createTask(ImageToTextTask::fromImage($link));
    }

    /**
     * @param TaskInterface $task
     * @return int
     * @see https://anticaptcha.atlassian.net/wiki/spaces/API/pages/5079073/createTask+captcha+task+creating
     */
    public function createTask(TaskInterface $task)
    {
        return $this->call('createTask', [
            'task' => $task->toArray(),
        ]);
    }

    /**
     * @return double
     * @see https://anticaptcha.atlassian.net/wiki/spaces/API/pages/6389791/getBalance+retrieve+account+balance
     */
    public function getBalance()
    {
        return $this->call('getBalance');
    }

    /**
     * @param int $queueId
     * @return QueueStats
     * @see https://anticaptcha.atlassian.net/wiki/spaces/API/pages/8290316/getQueueStats+obtain+queue+load+statistics
     */
    public function getQueueStats($queueId)
    {
        return $this->call('getQueueStats', [
            'queueId' => $queueId
        ]);
    }

    /**
     * @param int $taskId
     * @return Result
     * https://anticaptcha.atlassian.net/wiki/spaces/API/pages/5079103/getTaskResult+request+task+result
     */
    public function getTaskResult($taskId)
    {
        return $this->call('getTaskResult', [
            'taskId' => $taskId
        ]);
    }

    /**
     * @param $taskId
     * @return mixed
     * @see https://anticaptcha.atlassian.net/wiki/spaces/API/pages/48693258/reportIncorrectImageCaptcha+sent+complaint+on+an+image+captcha
     */
    public function reportIncorrectImageCaptcha($taskId)
    {
        return $this->call('reportIncorrectImageCaptcha', [
            'taskId' => $taskId
        ]);
    }
}
