<?php declare(strict_types=1);

namespace Tamer;

use Closure;
use InvalidArgumentException;

/**
 * Provides a fluent interface.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Tamer implements Fluency
{
    /**
     * @var Closure
     */
    private Closure $action;

    /**
     * @var float
     */
    private float $times;

    /**
     * @var Problem\Filter
     */
    private Problem\Filter $filter;

    /**
     * @var Problem\Wait
     */
    private Problem\Wait $wait;

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

        $this->until(1);
        $this->retryingOn(\Throwable::class);
        $this->waitingFor(0);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(callable $action): self
    {
        $this->action = Closure::fromCallable($action);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function retryingOn(string ...$problems): self
    {
        $this->filter = new Problem\Filter(...$problems);

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function untilSucceeded(): self
    {
        $this->times = INF;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function waitingFor(float $seconds, float $factor = 1., float $increment = 0.): self
    {
        $time = new Time\Delay\Linear(
            new Time\Second($seconds),
            $factor,
            new Time\Second($increment)
        );

        $this->wait = new Problem\Wait(new Interrupt\Usleep(), $time);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function with(...$arguments)
    {
        $attempt = new Attempt($this->filter);

        $this->filter->before($this->wait);

        return $attempt($this->action, $this->times)(...$arguments);
    }
}
