<?php declare(strict_types=1);

namespace Tamer\Problem;

use Throwable;

/**
 * Chains resolvers in a certain order.
 *
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class ResolverChain implements Resolver
{
    /**
     * @var Resolver
     */
    private Resolver $chain;

    /**
     * @param ChainableResolver ...$resolvers
     */
    public function __construct(ChainableResolver ...$resolvers)
    {
        $this->chain = $resolvers[0] ?? new Tail();

        for ($i = 0; $i < count($resolvers) - 1; ++$i) {
            $resolvers[$i]->before($resolvers[$i + 1]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function pass(Throwable $problem): void
    {
        $this->chain->pass($problem);
    }
}
