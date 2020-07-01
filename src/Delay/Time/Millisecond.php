<?php declare(strict_types=1);

namespace Tamer\Delay\Time;

/**
 * Represents time in milliseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Millisecond extends Unit
{
    /**
     * @inheritDoc
     */
    protected function factor(): int
    {
        return 1000;
    }
}
