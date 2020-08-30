<?php declare(strict_types=1);

namespace Tamer;

use Throwable;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Fluency
{
    /**
     * @param callable $action
     * @return Fluency
     */
    public function __invoke(callable $action): Fluency;

    /**
     * @param string ...$problems
     * @return Fluency
     */
    public function retryingOn(string ...$problems): Fluency;

    /**
     * @param int $times
     * @return Fluency
     */
    public function until(int $times): Fluency;

    /**
     * @return Fluency
     */
    public function untilSucceeded(): Fluency;

    /**
     * @param float $seconds
     * @param float $factor
     * @param float $increment
     * @return Fluency
     */
    public function waitingFor(float $seconds, float $factor = 1., float $increment = 0.): Fluency;

    /**
     * @param mixed ...$arguments
     * @return mixed
     * @throws Throwable
     */
    public function with(...$arguments);
}
