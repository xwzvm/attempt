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
     * @var int
     */
    private int $amount;

    /**
     * Returns a number of microseconds in a time unit.
     *
     * @return int
     */
    abstract protected function factor(): int;

    /**
     * @param int $amount
     * @throws InvalidArgumentException if $amount < 0.
     */
    final public function __construct(int $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Argument $amount must be at least 0.');
        }

        $this->amount = $amount;
    }

    /**
     * @inheritDoc
     */
    final public function microseconds(): int
    {
        return $this->amount * $this->factor();
    }
}
