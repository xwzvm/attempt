<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

use Xwzvm\Attempt\Delay\Time;

/**
 * Delays using the usleep function.
 * Doesn't delay for less than 1 or more than PHP_INT_MAX microseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Usleep implements Interrupt
{
    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $delay;

    /**
     * @param Time\InMicroseconds $delay
     */
    public function __construct(Time\InMicroseconds $delay)
    {
        $this->delay = $delay;
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

        usleep($time);
    }
}
