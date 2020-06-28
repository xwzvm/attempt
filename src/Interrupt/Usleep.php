<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

/**
 * Usleep wrapper.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Usleep implements SleepFunction
{
    public function execute(int $microseconds): void
    {
        usleep($microseconds);
    }
}
