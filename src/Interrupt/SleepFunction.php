<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

/**
 * Interface for built-in sleep functions wrapping.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface SleepFunction
{
    /**
     * @param int $microseconds
     * @return void
     */
    public function execute(int $microseconds): void;
}
