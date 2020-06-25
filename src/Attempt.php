<?php declare(strict_types=1);

namespace Xwzvm\Attempt;

use InvalidArgumentException;
use Throwable;
use Xwzvm\Attempt\Interrupt\Interrupt;
use Xwzvm\Attempt\Problem;

/**
 * Wraps a callable.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Attempt implements Proxy
{
    /**
     * @var Interrupt
     */
    private Interrupt $interrupt;

    /**
     * @var Problem\Resolver
     */
    private Problem\Resolver $sieve;

    /**
     * @param Interrupt $interrupt
     * @param Problem\Resolver $sieve
     */
    public function __construct(Interrupt $interrupt, Problem\Resolver $sieve)
    {
        $this->interrupt = $interrupt;
        $this->sieve = $sieve;
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
                    $this->sieve->pass($problem);
                    $this->interrupt->halt();
                }
            } while (--$times > 0);

            throw $problem;
        };

    }
}
