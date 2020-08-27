<?php declare(strict_types=1);

namespace Tamer;

use InvalidArgumentException;
use Throwable;
use Tamer\Problem;

/**
 * Wraps a callable.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Attempt implements Repeater
{
    /**
     * @var Problem\Resolver
     */
    private Problem\Resolver $resolver;

    /**
     * @param Problem\Resolver $resolver
     */
    public function __construct(Problem\Resolver $resolver)
    {
        $this->resolver = $resolver;
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
                    $this->resolver->pass($problem);
                }
            } while (--$times > 0);

            throw $problem;
        };
    }
}
