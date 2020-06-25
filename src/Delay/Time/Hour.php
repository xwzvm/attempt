<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay\Time;

/**
 * Represents time in hours.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Hour extends Unit
{
    /**
     * @inheritDoc
     */
    protected function factor(): int
    {
        return 3_600_000_000;
    }
}
