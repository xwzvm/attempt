<?php declare(strict_types=1);

namespace Tamer\Test\Time;

use Tamer\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class MinuteTest extends TimeUnitTest
{
    /**
     * {@inheritdoc}
     */
    protected function unit(float $amount): Time\Unit
    {
        return new Time\Minute($amount);
    }

    /**
     * {@inheritdoc}
     */
    protected function factor(): int
    {
        return 60_000_000;
    }
}
