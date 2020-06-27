<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Problem;

use Throwable;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Blank implements Resolver
{
    /**
     * @inheritDoc
     */
    public function pass(Throwable $problem): void
    {

    }

    /**
     * @inheritDoc
     */
    public function before(Resolver $next): Resolver
    {
        return $next;
    }
}
