<?php declare(strict_types=1);

namespace Tamer\Time;

/**
 * Current time.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class Now implements InMicroseconds
{
    /**
     * @inheritDoc
     */
    public function microseconds(): float
    {
        return (new Second((float) time()))->microseconds();
    }
}
