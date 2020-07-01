<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test;

use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt\Attempt;
use Xwzvm\Attempt\Problem;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class AttemptTest extends TestCase
{
    use AttemptDataProvider;

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @dataProvider actions
     */
    public function testInvoke(callable $action, int $bound, array $arguments, int $expected): void
    {
        $resolver = $this->createMock(Problem\Resolver::class);
        $resolver->expects($this->exactly($bound))->method('pass');

        $attempt = new Attempt($resolver);

        $result = $attempt($action, $bound + 1)(...$arguments);

        $this->assertEquals($expected, $result);
    }

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @dataProvider actions
     */
    public function testNotEnoughAttempts(callable $action, int $bound, array $arguments): void
    {
        $this->expectException(\Throwable::class);

        $times = mt_rand(1, $bound - 1);

        $resolver = $this->createMock(Problem\Resolver::class);
        $resolver->expects($this->exactly($times))->method('pass');

        $attempt = new Attempt($resolver);

        $attempt($action, $times)(...$arguments);
    }

    /**
     * @return void
     */
    public function testInvalidTimesNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $times must be at least 1.');

        $resolver = $this->createMock(Problem\Resolver::class);
        $resolver->expects($this->never())->method('pass');

        $attempt = new Attempt($resolver);

        $attempt(fn () => 42, 0);
    }

    /**
     * @param callable $action
     * @param int $times
     * @param class-string<\Throwable> $problem
     * @dataProvider problems
     */
    public function testLastProblemWasThrown(callable $action, int $times, string $problem): void
    {
        $this->expectException($problem);

        $resolver = $this->createMock(Problem\Resolver::class);
        $resolver->expects($this->exactly($times))->method('pass');

        $attempt = new Attempt($resolver);

        $attempt($action, $times)();
    }
}
