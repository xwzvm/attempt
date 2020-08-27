<?php declare(strict_types=1);

namespace Tamer\Interrupt;

use Tamer\Time;

/**
 * Must be implemented by classes that pause between attempts.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Interrupt
{
    /**
     * Interrupts execution.
     *
     * @param Time\InMicroseconds $time
     */
    public function for(Time\InMicroseconds $time): void;
}
