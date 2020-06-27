<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay\Time;

/**
 * Must be implemented by classes that represent a time unit or an attempt delay.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface InMicroseconds
{
    /**
     * Returns a number of microseconds.
     *
     * @return float
     */
    public function microseconds(): float;
}
