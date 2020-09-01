<?php declare(strict_types=1);

namespace Tamer;

use InvalidArgumentException;
use Throwable;

/**
 * Wraps a callable.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Attempt implements Repeat
{
    /**
     * @var Problem\Capture
     */
    private Problem\Capture $capture;

    /**
     * @param Problem\Capture $capture
     */
    public function __construct(Problem\Capture $capture)
    {
        $this->capture = $capture;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(callable $action, float $times): callable
    {
        $times = round($times);

        if ($times < 1) {
            throw new InvalidArgumentException('Argument $times must be at least 1.');
        }

        return function (...$arguments) use ($action, $times) {
            do {
                try {
                    return call_user_func_array($action, $arguments);
                } catch (Throwable $problem) {
                    $this->capture->take($problem);
                }
            } while (--$times > 0);

            throw $problem;
        };
    }
}
