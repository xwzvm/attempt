<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Test;

use PHPUnit\Framework\TestCase;
use Xwzvm\Attempt;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class PipelineTest extends TestCase
{
    use AttemptDataProvider;

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @param class-string<\Throwable> $problem
     * @dataProvider actions
     */
    public function testInvoke(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        $try = new Attempt\Pipeline();

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
     * @param class-string<\Throwable> $problem
     * @dataProvider actions
     */
    public function testInvokeUntilSucceeded(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        $try = new Attempt\Pipeline();

        $result = $try($action)
            ->untilSucceeded()
            ->retryingOn($problem)
            ->with(...$arguments);

        $this->assertEquals($expected, $result);
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

        $try = new Attempt\Pipeline();

        $try($action)->until($times)->with();
    }

    /**
     * @param callable $action
     * @param int $bound
     * @param mixed[] $arguments
     * @param int $expected
     * @param class-string<\Throwable> $problem
     * @dataProvider actions
     */
    public function testNotEnoughAttempts(
        callable $action,
        int $bound,
        array $arguments,
        int $expected,
        string $problem
    ): void {
        $this->expectException($problem);

        $try = new Attempt\Pipeline();

        $try($action)
            ->until(mt_rand(1, $bound - 1))
            ->retryingOn($problem)
            ->with(...$arguments);
    }

    /**
     * @return void
     */
    public function testInvalidTimesNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $times must be at least 1.');

        $try = new Attempt\Pipeline();

        $try(fn () => 42)->until(0)->with();
    }
}
