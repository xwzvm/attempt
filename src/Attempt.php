<?php declare(strict_types=1);

namespace Xwzvm\Attempt;

use InvalidArgumentException;
use Throwable;
use Xwzvm\Attempt\Problem;

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
     * @inheritDoc
     */
    public function __invoke(callable $action, int $times): callable
    {
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
