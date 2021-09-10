<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Services;

use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\ShouldNotHappenException;
use PHPUnit\Framework\TestCase;

/**
 * Class DocCommentHelperTest
 *
 * @see DocCommentHelper
 */
final class DocCommentHelperTest extends TestCase
{
    private DocCommentHelper $docCommentHelper;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->docCommentHelper = new DocCommentHelper();
    }

    /**
     * @throws ShouldNotHappenException
     * @see DocCommentHelper::cleanUpDocComment()
     */
    public function testCleanUpDocCommentShouldReturnCleanDocComment(): void
    {
        self::assertSame(
            '/***test123**@seeClass*/',
            $this->docCommentHelper->cleanUpDocComment(
                '/** 
            * test 123
            *
            * @see Class
            */'
            )
        );
    }
}
