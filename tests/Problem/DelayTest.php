<?php declare(strict_types=1);

namespace Tamer\Test\Problem;

use PHPUnit\Framework\TestCase;
use Throwable;
use Tamer\Interrupt\Interrupt;
use Tamer\Problem;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class DelayTest extends TestCase
{
    /**
     * @param Throwable $problem
     * @dataProvider problems
     */
    public function testPass(Throwable $problem): void
    {
        $interrupt = $this->createMock(Interrupt::class);
        $interrupt->expects($this->once())->method('halt');

        $next = $this->createMock(Problem\Resolver::class);
        $next->expects($this->once())->method('pass')->with($problem);

        $delay = new Problem\Delay($interrupt);

        $this->assertEquals($next, $delay->before($next));

        $delay->pass($problem);
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
