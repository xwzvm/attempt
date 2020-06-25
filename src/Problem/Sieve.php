<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Problem;

use InvalidArgumentException;
use Throwable;

/**
 * Checks a \Throwable for acceptability.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Sieve implements Resolver
{
    /**
     * @var class-string<\Throwable>[]
     */
    private array $problems;

    /**
     * @param class-string<\Throwable> ...$acceptable
     * @throws InvalidArgumentException if $acceptable contains not \Throwable.
     */
    public function __construct(string ...$acceptable)
    {
        foreach ($acceptable as $problem) {
            if (!is_a($problem, Throwable::class, true)) {
                throw new InvalidArgumentException($problem . ' must implement ' . Throwable::class . '.');
            }
        }

        $this->problems = $acceptable;
    }

    /**
     * @inheritDoc
     */
    public function pass(Throwable $problem): void
    {
        foreach ($this->problems as $acceptable) {
            if (is_a($problem, $acceptable, true)) {
                return;
            }
        }

        throw $problem;
    }
}
