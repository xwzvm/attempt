<?php declare(strict_types=1);

namespace Tamer\Delay\Time;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Addible
{
    /**
     * @param InMicroseconds $time
     * @return InMicroseconds
     */
    public function add(InMicroseconds $time): InMicroseconds;
}
