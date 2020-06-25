<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

/**
 * No delay.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 * @codeCoverageIgnore
 */
final class Blank implements Interrupt
{
    /**
     * @inheritDoc
     */
    public function halt(): void
    {

    }
}
