<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Delay;

use InvalidArgumentException;
use Xwzvm\Attempt\Delay\Time;

/**
 * Represents linearly varying delay.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Linear extends VariableDelay
{
    /**
     * @var int
     */
    private int $factor;

    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $addition;

    /**
     * @param Time\InMicroseconds $time
     * @param int $factor
     * @param Time\InMicroseconds $addition
     */
    public function __construct(Time\InMicroseconds $time, int $factor = 1, Time\InMicroseconds $addition = null)
    {
        if ($factor === 0) {
            throw new InvalidArgumentException('Argument $factor cannot be 0.');
        }

        parent::__construct($time);

        $this->factor = $factor;
        $this->addition = $addition ?? new Time\Microsecond(0);
    }

    /**
     * @inheritDoc
     */
    protected function vary(): void
    {
        $amount = $this->factor > 0
            ? $this->time->microseconds() * $this->factor
            : round($this->time->microseconds() / -$this->factor);

        $amount += $this->addition->microseconds();

        $this->time = new Time\Microsecond($amount);
    }
}
