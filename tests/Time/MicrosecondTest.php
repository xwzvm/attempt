<?php declare(strict_types=1);

namespace Tamer\Test\Time;

use Tamer\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class MicrosecondTest extends TimeUnitTest
{
    /**
     * {@inheritdoc}
     */
    protected function unit(float $amount): Time\Unit
    {
        return new Time\Microsecond($amount);
    }

    /**
     * {@inheritdoc}
     */
    protected function factor(): int
    {
        return 1;
    }
}
