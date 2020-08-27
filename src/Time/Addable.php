<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Must be implemented by time classes that can be summarized.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface Addable
{
    /**
     * @param InMicroseconds $time
     * @return InMicroseconds
     */
    public function add(InMicroseconds $time): InMicroseconds;
}
