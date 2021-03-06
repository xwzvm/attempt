<?php declare(strict_types=1);

namespace Tamer;

use InvalidArgumentException;

/**
 * Must be implemented by the attempt class.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Repeat
{
    /**
     * @param callable $action Callable that may throw a \Throwable.
     * @param float $times Number of attempts.
     * @return callable Wrapped $action that will attempt several $times
     *                  before throwing final \Throwable in case of failure.
     * @throws InvalidArgumentException if $times < 1.
     */
    public function __invoke(callable $action, float $times): callable;
}
