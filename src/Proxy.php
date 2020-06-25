<?php declare(strict_types=1);

namespace Xwzvm\Attempt;

use InvalidArgumentException;

/**
 * Must be implemented by classes that wrap a callable.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Proxy
{
    /**
     * @param callable $action Callable that may throw a \Throwable.
     * @param int $times Number of attempts.
     * @return callable Wrapped $action that will attempt several $times
     *                  before throwing final \Throwable in case of failure.
     * @throws InvalidArgumentException if $times < 1.
     */
    public function __invoke(callable $action, int $times): callable;
}
