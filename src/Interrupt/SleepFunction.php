<?php declare(strict_types=1);

namespace Tamer\Interrupt;

/**
 * Must be implemented by classes that wraps built-in sleep functions.
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
