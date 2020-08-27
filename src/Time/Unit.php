<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Base class for time units.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
abstract class Unit implements InMicroseconds, Addable
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
     * {@inheritdoc}
     */
    final public function microseconds(): float
    {
        return $this->amount * $this->factor();
    }

    /**
     * {@inheritdoc}
     */
    final public function add(InMicroseconds $time): InMicroseconds
    {
        return new Microsecond(static::microseconds() + $time->microseconds());
    }
}
