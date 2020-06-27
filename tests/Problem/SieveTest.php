<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test\Problem;

use PHPUnit\Framework\TestCase;
use Throwable;
use Xwzvm\Attempt\Problem;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class SieveTest extends TestCase
{
    /**
     * @param class-string<\Throwable>[] $acceptable
     * @param Throwable $problem
     * @param bool $ok
     * @return void
     * @dataProvider problems
     */
    public function testPass(array $acceptable, Throwable $problem, bool $ok): void
    {
        $sieve = new Problem\Sieve(...$acceptable);

        $next = $this->createMock(Problem\Resolver::class);
        $next->expects($this->exactly((int) $ok))->method('pass')->with($problem);

        $this->assertEquals($next, $sieve->before($next));

        try {
            $sieve->pass($problem);
            $this->assertTrue($ok);
        } catch (\Throwable $exception) {
            $this->assertFalse($ok);
        }
    }

    /**
     * @return void
     */
    public function testInvalidProblem(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('InvalidException must implement ' . Throwable::class . '.');

        /** @phpstan-ignore-next-line */
        new Problem\Sieve(\RuntimeException::class, 'InvalidException', \LogicException::class);
    }

    /**
     * @return array[]
     */
    public function problems(): array
    {
        return [
            [[\RuntimeException::class, \LogicException::class], new \LogicException(), true],
            [[\RuntimeException::class, \PharException::class], new \Error(), false],
            [[Throwable::class], new \Error(), true],
        ];
    }
}
