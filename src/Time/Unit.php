<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Base class for time units.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
abstract class Unit implements InMicroseconds, Addible
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
     */
    final public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @inheritDoc
     */
    final public function microseconds(): float
    {
        return $this->amount * $this->factor();
    }

    /**
     * @inheritDoc
     */
    final public function add(InMicroseconds $time): InMicroseconds
    {
        return new static(static::microseconds() + $time->microseconds());
    }
}
