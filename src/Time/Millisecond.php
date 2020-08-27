<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Represents time in milliseconds.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Millisecond extends Unit
{
    /**
     * {@inheritdoc}
     */
    protected function factor(): int
    {
        return 1000;
    }
}
