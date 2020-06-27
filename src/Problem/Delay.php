<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Problem;

use Throwable;
use Xwzvm\Attempt\Interrupt\Interrupt;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Delay implements Resolver
{
    /**
     * @var Interrupt
     */
    private Interrupt $interrupt;

    /**
     * @var Resolver
     */
    private Resolver $next;

    /**
     * @param Interrupt $interrupt
     * @param Resolver|null $next
     */
    public function __construct(Interrupt $interrupt, Resolver $next = null)
    {
        $this->interrupt = $interrupt;

        $this->next = $next ?? new Blank();
    }

    /**
     * @inheritDoc
     */
    public function pass(Throwable $problem): void
    {
        $this->interrupt->halt();

        $this->next->pass($problem);
    }

    /**
     * @inheritDoc
     */
    public function before(Resolver $next): Resolver
    {
        return $this->next = $next;
    }
}
