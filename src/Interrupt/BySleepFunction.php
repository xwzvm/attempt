<?php declare(strict_types=1);

namespace Tamer\Interrupt;

use Tamer\Time;

/**
 * Doesn't delay for less than 1 or more than PHP_INT_MAX microseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class BySleepFunction implements Interrupt
{
    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $delay;

    /**
     * @var SleepFunction
     */
    private SleepFunction $sleep;

    /**
     * @param Time\InMicroseconds $delay
     * @param SleepFunction $sleep
     */
    public function __construct(Time\InMicroseconds $delay, SleepFunction $sleep)
    {
        $this->delay = $delay;
        $this->sleep = $sleep;
    }

    /**
     * @inheritDoc
     */
    public function halt(): void
    {
        $time = intval($this->delay->microseconds());

        if ($time < 1) {
            return;
        }

        $this->sleep->execute($time);
    }
}
