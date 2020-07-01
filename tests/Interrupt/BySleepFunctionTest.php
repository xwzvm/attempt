<?php declare(strict_types=1);

namespace Tamer\Test\Interrupt;

use PHPUnit\Framework\TestCase;
use Tamer\Time;
use Tamer\Interrupt;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class BySleepFunctionTest extends TestCase
{
    /**
     * @param float $microseconds
     * @dataProvider microseconds
     */
    public function testHalt(float $microseconds): void
    {
        $delay = $this->createMock(Time\InMicroseconds::class);
        $delay
            ->expects($this->once())
            ->method('microseconds')
            ->willReturn($microseconds);

        $sleep = $this->createMock(Interrupt\SleepFunction::class);
        $sleep
            ->expects($this->exactly(intval($microseconds > 0. && $microseconds < PHP_INT_MAX)))
            ->method('execute')
            ->with(intval($microseconds));

        $interrupt = new Interrupt\BySleepFunction($delay, $sleep);

        $interrupt->halt();
    }

    /**
     * @return array[]
     */
    public function microseconds(): array
    {
        return [
            [(float) mt_rand(1, 1_000_000)],
            [0.],
            [(float) mt_rand(-1_000_000, -1)],
            [1. + PHP_INT_MAX]
        ];
    }
}
