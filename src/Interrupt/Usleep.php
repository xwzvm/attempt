<?php declare(strict_types=1);

namespace Tamer\Interrupt;

use Closure;
use Tamer\Time;

/**
 * Usleep wrapper.
 * Doesn't interrupt for less than 1 or more than PHP_INT_MAX microseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Usleep implements Interrupt
{
    /**
     * @var Closure
     */
    private Closure $usleep;

    /**
     * @param callable|null $usleep
     */
    public function __construct(callable $usleep = null)
    {
        $this->usleep = Closure::fromCallable($usleep ?? 'usleep');
    }

    /**
     * {@inheritdoc}
     */
    public function for(Time\InMicroseconds $time): void
    {
        $microseconds = intval($time->microseconds());

        if ($microseconds < 1) {
            return;
        }

        ($this->usleep)($microseconds);
    }
}
