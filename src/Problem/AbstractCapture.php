<?php declare(strict_types=1);

namespace Tamer\Problem;

use Throwable;

/**
 * Base class for problem handlers.
 * Encapsulates chaining.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
abstract class AbstractCapture implements ChainCapture
{
    /**
     * @var Capture
     */
    private Capture $next;

    /**
     * @param Throwable $problem
     * @throws Throwable
     */
    abstract protected function process(Throwable $problem): void;

    public function __construct()
    {
        $this->next = new class implements Capture {
            /**
             * {@inheritdoc}
             */
            public function take(Throwable $problem): void
            {
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    final public function take(Throwable $problem): void
    {
        $this->process($problem);

        $this->next->take($problem);
    }

    /**
     * {@inheritdoc}
     */
    final public function before(ChainCapture $next): Chain
    {
        return $this->next = $next;
    }
}
