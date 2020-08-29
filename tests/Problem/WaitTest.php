<?php declare(strict_types=1);

namespace Tamer\Test\Problem;

use PHPUnit\Framework\TestCase;
use Tamer\Time;
use Throwable;
use Tamer\Interrupt\Interrupt;
use Tamer\Problem;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class WaitTest extends TestCase
{
    /**
     * @param Throwable $problem
     * @throws Throwable
     * @dataProvider problems
     */
    public function testPass(Throwable $problem): void
    {
        $microseconds = $this->createMock(Time\InMicroseconds::class);
        $microseconds->method('microseconds')->willReturn(1000.);

        $interrupt = $this->createMock(Interrupt::class);
        $interrupt
            ->expects($this->once())
            ->method('for')
            ->with($microseconds);

        $next = $this->createMock(Problem\ChainCapture::class);
        $next->expects($this->once())->method('take')->with($problem);

        $wait = new Problem\Wait($interrupt, $microseconds);

        $this->assertEquals($next, $wait->before($next));

        $wait->take($problem);
    }

    /**
     * @return array[]
     */
    public function problems(): array
    {
        return [
            [new \RuntimeException()],
            [new \Error()],
            [new \LogicException()],
        ];
    }
}
