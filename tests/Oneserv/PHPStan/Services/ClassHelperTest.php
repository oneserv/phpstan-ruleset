<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Services;

use Oneserv\PHPStan\Services\ClassHelper;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ClassHelperTest
 *
 * @see ClassHelper
 */
final class ClassHelperTest extends TestCase
{
    /** @var MockObject&Class_ */
    private MockObject $nodeMock;

    private ClassHelper $classHelper;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->nodeMock = $this->createMock(Class_::class);

        $this->classHelper = new ClassHelper();
    }

    /**
     * @see ClassHelper::shouldClassBeAnalysed()
     */
    public function testShouldClassBeAnalysedShouldReturnFalseWithAnonymousClass(): void
    {
        $this->nodeMock->expects(self::once())->method('isAnonymous')->willReturn(true);

        self::assertFalse($this->classHelper->shouldClassBeAnalysed($this->nodeMock));
    }

    /**
     * @see ClassHelper::shouldClassBeAnalysed()
     */
    public function testShouldClassBeAnalysedShouldReturnFalseClassWithEmptyNameSpacedName(): void
    {
        $this->nodeMock->expects(self::once())->method('isAnonymous')->willReturn(false);
        /** @phpstan-ignore-next-line */
        $this->nodeMock->namespacedName = null;

        self::assertFalse($this->classHelper->shouldClassBeAnalysed($this->nodeMock));
    }

    /**
     * @see ClassHelper::shouldClassBeAnalysed()
     */
    public function testShouldClassBeAnalysedShouldReturnTrueWithNormalClass(): void
    {
        $this->nodeMock->expects(self::once())->method('isAnonymous')->willReturn(false);
        $this->nodeMock->namespacedName = $this->createMock(Name::class);

        self::assertTrue($this->classHelper->shouldClassBeAnalysed($this->nodeMock));
    }
}
