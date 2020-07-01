<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Represents time in microseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Microsecond extends Unit
{
    /**
     * @inheritDoc
     */
    protected function factor(): int
    {
        return 1;
    }
}
