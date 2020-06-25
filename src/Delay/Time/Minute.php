<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay\Time;

/**
 * Represents time in minutes.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Minute extends Unit
{
    /**
     * @inheritDoc
     */
    protected function factor(): int
    {
        return 60_000_000;
    }
}
