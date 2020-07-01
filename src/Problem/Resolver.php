<?php declare(strict_types=1);

namespace Tamer\Problem;

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
     * @throws Throwable
     */
    public function pass(Throwable $problem): void;
}
