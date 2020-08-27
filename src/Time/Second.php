<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Represents time in seconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Second extends Unit
{
    /**
     * {@inheritdoc}
     */
    protected function factor(): int
    {
        return 1_000_000;
    }
}
