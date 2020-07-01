<?php declare(strict_types=1);

namespace Xwzvm\Attempt;

use Closure;
use InvalidArgumentException;
use Xwzvm\Attempt\Problem\ResolverChain;

/**
 * Hides the boilerplate by providing pipeline API.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Pipeline
{
    /**
     * @var Closure
     */
    private Closure $action;

    /**
     * @var mixed[]
     */
    private array $arguments;

    /**
     * @var float
     */
    private float $times;

    /**
     * @var Problem\ChainableResolver
     */
    private Problem\ChainableResolver $sieve;

    /**
     * @var Problem\ChainableResolver
     */
    private Problem\ChainableResolver $delay;

    /**
     * @return void
     */
    public function __construct()
    {
        /**
         * @codeCoverageIgnore
         */
        $this->action = function (): void {
        };

        $this->arguments = [];

        $this->until(1);
        $this->retryingOn(\Throwable::class);
        $this->delayingFor(0);
    }

    /**
     * @param callable $action
     * @return self
     */
    public function __invoke(callable $action): self
    {
        $this->action = Closure::fromCallable($action);

        return $this;
    }

    /**
     * @param class-string<\Throwable> ...$problems
     * @return self
     */
    public function retryingOn(string ...$problems): self
    {
        $this->sieve = new Problem\Sieve(...$problems);

        return $this;
    }

    /**
     * @param int $times
     * @return self
     * @throws InvalidArgumentException if $times < 1.
     */
    public function until(int $times): self
    {
        $this->times = (float) $times;

        if ($times < 1) {
            throw new InvalidArgumentException('Argument $times must be at least 1.');
        }

        return $this;
    }

    /**
     * @return self
     */
    public function untilSucceeded(): self
    {
        $this->times = INF;

        return $this;
    }

    /**
     * @param float $seconds
     * @param float $factor
     * @param float $increment
     * @return self
     * @codeCoverageIgnore
     */
    public function delayingFor(float $seconds, float $factor = 1., float $increment = 0.): self
    {
        $time = new Delay\Linear(
            new Delay\Time\Second($seconds),
            $factor,
            new Delay\Time\Second($increment)
        );

        $interrupt = new Interrupt\BySleepFunction($time, new Interrupt\Usleep());

        $this->delay = new Problem\Delay($interrupt);

        return $this;
    }

    /**
     * @param mixed ...$arguments
     * @return mixed
     */
    public function with(...$arguments)
    {
        $resolver = new ResolverChain($this->sieve, $this->delay);

        $attempt = new Attempt($resolver);

        return $attempt($this->action, $this->times)(...$arguments);
    }
}
