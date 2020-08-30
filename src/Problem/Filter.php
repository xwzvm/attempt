<?php declare(strict_types=1);

namespace Tamer\Problem;

use InvalidArgumentException;
use Throwable;

/**
 * Checks a \Throwable for acceptability.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Filter extends AbstractCapture
{
    /**
     * @var string[]
     */
    private array $problems;

    /**
     * @param string ...$acceptable
     * @throws InvalidArgumentException if $acceptable contains not \Throwable.
     */
    public function __construct(string ...$acceptable)
    {
        parent::__construct();

        foreach ($acceptable as $problem) {
            if (!is_a($problem, Throwable::class, true)) {
                throw new InvalidArgumentException($problem . ' must implement ' . Throwable::class . '.');
            }
        }

        $this->problems = $acceptable;
    }

    /**
     * {@inheritdoc}
     */
    protected function process(Throwable $problem): void
    {
        foreach ($this->problems as $acceptable) {
            if (is_a($problem, $acceptable, true)) {
                return;
            }
        }

        throw $problem;
    }
}
