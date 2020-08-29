<?php declare(strict_types=1);

namespace Tamer\Problem;

use Tamer\Time;
use Throwable;
use Tamer\Interrupt\Interrupt;

/**
 * Pauses between attempts.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Wait extends AbstractCapture
{
    /**
     * @var Interrupt
     */
    private Interrupt $interrupt;

    /**
     * @var Time\InMicroseconds
     */
    private Time\InMicroseconds $duration;

    /**
     * @param Interrupt $interrupt
     * @param Time\InMicroseconds $duration
     */
    public function __construct(Interrupt $interrupt, Time\InMicroseconds $duration)
    {
        parent::__construct();

        $this->interrupt = $interrupt;
        $this->duration = $duration;
    }

    /**
     * {@inheritdoc}
     */
    protected function process(Throwable $problem): void
    {
        $this->interrupt->for($this->duration);
    }
}
