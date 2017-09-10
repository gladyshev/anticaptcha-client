<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Entity;

/**
 * Class QueueStats
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class QueueStats extends Entity
{
    const QUEUE_IMAGE_TO_TEXT_EN        = 1;
    const QUEUE_IMAGE_TO_TEXT_RU        = 2;
    const QUEUE_NO_CAPTCHA              = 5;
    const QUEUE_NO_CAPTCHA_PROXYLESS    = 6;

    /**
     * Amount of idle workers online, waiting for a task.
     *
     * @var int
     */
    protected $waiting;

    /**
     * Queue load in percents.
     *
     * @var float
     */
    protected $load;

    /**
     * Average task solution cost in USD.
     *
     * @var float
     */
    protected $bid;

    /**
     * Average task solution speed in seconds.
     *
     * @var float
     */
    protected $speed;

    /**
     * Total number of workers
     *
     * @var int
     */
    protected $total;

    /**
     * @param array $response
     * @return static
     */
    public static function fromResponse($response)
    {
        return new static($response);
    }

    /**
     * @return int
     */
    public function getWaiting()
    {
        return $this->waiting;
    }

    /**
     * @return float
     */
    public function getLoad()
    {
        return $this->load;
    }

    /**
     * @return float
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
}
