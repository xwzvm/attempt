<?php declare(strict_types=1);

namespace Tamer\Problem;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Chain
{
    /**
     * @param ChainCapture $next
     * @return Chain
     */
    public function before(ChainCapture $next): Chain;
}
