<?php declare(strict_types=1);

namespace Tamer\Delay;

use Tamer\Time;

/**
 * Represents linearly varying delay.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Linear extends Variable
{
    /**
     * @var float
     */
    private float $factor;

    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $increment;

    /**
     * @param Time\InMicroseconds $time
     * @param float $factor
     * @param Time\InMicroseconds|null $increment
     */
    public function __construct(Time\InMicroseconds $time, float $factor = 1., Time\InMicroseconds $increment = null)
    {
        parent::__construct($time);

        $this->factor = $factor;
        $this->increment = $increment ?? new Time\Microsecond(0);
    }

    /**
     * @inheritDoc
     */
    protected function vary(): void
    {
        $amount = $this->time->microseconds() * $this->factor + $this->increment->microseconds();

        $this->time = new Time\Microsecond($amount);
    }
}
