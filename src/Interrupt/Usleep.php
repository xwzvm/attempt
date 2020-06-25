<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

use Xwzvm\Attempt\Delay\Time;

/**
 * Delays using the usleep function.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Usleep implements Interrupt
{
    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $delay;

    /**
     * @param Time\InMicroseconds $delay
     */
    public function __construct(Time\InMicroseconds $delay)
    {
        $this->delay = $delay;
    }

    /**
     * @inheritDoc
     */
    public function halt(): void
    {
        usleep($this->delay->microseconds());
    }
}
