<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Problem;

use Throwable;

/**
 * Must be implemented by classes that resolve a \Throwable that occurred during the attempt.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Resolver
{
    /**
     * @param Throwable $problem
     */
    public function pass(Throwable $problem): void;

    /**
     * @param Resolver $next
     * @return Resolver
     */
    public function before(Resolver $next): Resolver;
}
