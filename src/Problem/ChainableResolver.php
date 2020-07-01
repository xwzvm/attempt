<?php declare(strict_types=1);

namespace Tamer\Problem;

/**
 * Must be implemented by chainable resolvers.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
interface ChainableResolver extends Resolver
{
    /**
     * @param Resolver $next
     * @return Resolver $next
     */
    public function before(Resolver $next): Resolver;
}
