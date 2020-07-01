<?php declare(strict_types=1);

namespace Tamer\Test\Problem;

use PHPUnit\Framework\TestCase;
use Tamer\Problem\ChainableResolver;
use Tamer\Problem\ResolverChain;

/**
 * @author Sergei Malyshev <xwzvm@yandex.ru>
 */
final class ResolverChainTest extends TestCase
{
    /**
     * @return void
     */
    public function testPass(): void
    {
        $problem = new \RuntimeException();

        $third = $this->createMock(ChainableResolver::class);

        $second = $this->createMock(ChainableResolver::class);
        $second->expects($this->once())->method('before')->with($third);

        $first = $this->createMock(ChainableResolver::class);
        $first->expects($this->once())->method('pass')->with($problem);
        $first->expects($this->once())->method('before')->with($second);

        $resolver = new ResolverChain($first, $second, $third);

        $resolver->pass($problem);
    }
}
