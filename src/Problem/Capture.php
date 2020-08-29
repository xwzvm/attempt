<?php declare(strict_types=1);

namespace Tamer\Problem;

use Throwable;

/**
 * Must be implemented by problem handlers.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Capture
{
    /**
     * @param Throwable $problem
     * @throws Throwable
     */
    public function take(Throwable $problem): void;
}
