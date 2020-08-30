<?php declare(strict_types=1);

namespace Tamer\Test\Interrupt;

use PHPUnit\Framework\TestCase;
use Tamer\Time;
use Tamer\Interrupt;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class UsleepTest extends TestCase
{
    /**
     * @param float $microseconds
     * @dataProvider microseconds
     */
    public function testFor(float $microseconds): void
    {
        $delay = $this->createMock(Time\InMicroseconds::class);
        $delay
            ->expects($this->once())
            ->method('microseconds')
            ->willReturn($microseconds);

        $usleep = function (int $microseconds): void {
            // I'm an usleep mock.
        };

        $interrupt = new Interrupt\Usleep($usleep);

        $interrupt->for($delay);
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
