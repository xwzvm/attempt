<?php declare(strict_types=1);

namespace Xwzvm\Attempt\Interrupt;

/**
 * Must be implemented by classes that pause between attempts.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Interrupt
{
    /**
     * @return void
     */
    public function halt(): void;
}
