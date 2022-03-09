<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Response;

/**
 * Class QueueStats
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
final class GetQueueStatsResponse extends AbstractResponse
{
    /**
     * Amount of idle workers online, waiting for a task.
     */
    public ?int $waiting = null;

    /**
     * Queue load in percents.
     */
    public ?float $load = null;

    /**
     * Average task solution cost in USD.
     */
    public ?float $bid = null;

    /**
     * Average task solution speed in seconds.
     */
    public ?float $speed = null;

    /**
     * Total number of workers
     */
    public ?int $total = null;
}
