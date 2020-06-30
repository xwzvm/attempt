<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Problem;

use Throwable;

/**
 * End of problem resolver chain.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Tail implements Resolver
{
    /**
     * @inheritDoc
     */
    public function pass(Throwable $problem): void
    {
    }
}
