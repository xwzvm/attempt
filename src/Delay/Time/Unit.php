<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay\Time;

use InvalidArgumentException;

/**
 * Base class for time units.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
abstract class Unit implements InMicroseconds
{
    /**
     * @var float
     */
    private float $amount;

    /**
     * Returns a number of microseconds in a time unit.
     *
     * @return int
     */
    abstract protected function factor(): int;

    /**
     * @param float $amount
     * @throws InvalidArgumentException if $amount < 0.
     */
    final public function __construct(float $amount)
    {
        if ($amount < PHP_FLOAT_EPSILON) {
            throw new InvalidArgumentException('Argument $amount must be at least 0.');
        }

        $this->amount = $amount;
    }

    /**
     * @inheritDoc
     */
    final public function microseconds(): float
    {
        return $this->amount * $this->factor();
    }
}
