<?php declare(strict_types=1);

namespace Tamer\Test;

use PHPUnit\Framework\TestCase;
use Tamer\Tamer;
use Throwable;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class TamerTest extends TestCase
{
    use AttemptDataProvider;

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @param string $problem
     * @throws Throwable
     * @dataProvider actions
     */
    public function testInvoke(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        $try = new Tamer();

        $result = $try($action)
            ->until($bound + 1)
            ->retryingOn($problem)
            ->with(...$arguments);

        $this->assertEquals($expected, $result);
    }

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @param string $problem
     * @dataProvider actions
     * @throws Throwable
     */
    public function testInvokeUntilSucceeded(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        $try = new Tamer();

        $result = $try($action)
            ->untilSucceeded()
            ->retryingOn($problem)
            ->with(...$arguments);

        $this->assertEquals($expected, $result);
    }

    /**
     * @param callable $action
     * @param int $times
     * @param string $problem
     * @dataProvider problems
     * @throws Throwable
     */
    public function testLastProblemWasThrown(callable $action, int $times, string $problem): void
    {
        /** @psalm-var class-string<\Throwable> $problem */
        $this->expectException($problem);

        $try = new Tamer();

        $try($action)->until($times)->with();
    }

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @param string $problem
     * @dataProvider actions
     * @throws Throwable
     */
    public function testNotEnoughAttempts(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        /** @psalm-var class-string<\Throwable> $problem */
        $this->expectException($problem);

        $try = new Tamer();

        $try($action)
            ->until(mt_rand(1, $bound - 1))
            ->retryingOn($problem)
            ->with(...$arguments);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testInvalidTimesNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $times must be at least 1.');

        $try = new Tamer();

        $try(fn () => 42)->until(0)->with();
    }
}
