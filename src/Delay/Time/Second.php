<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay\Time;

/**
 * Represents time in seconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Second extends Unit
{
    /**
     * @inheritDoc
     */
    protected function factor(): int
    {
        return 1_000_000;
    }
}
