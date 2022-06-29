<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Methods;

use Oneserv\PHPStan\Rules\Methods\ClassNameMustBeFirstInConstructMethodDocumentationRule;
use Oneserv\PHPStan\Services\ClassHelper;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Class ClassNameMustBeFirstInConstructMethodDocumentationRuleTest
 *
 * @see ClassNameMustBeFirstInConstructMethodDocumentationRule
 * @extends RuleTestCase<ClassNameMustBeFirstInConstructMethodDocumentationRule>
 */
class ClassNameMustBeFirstInConstructMethodDocumentationRuleTest extends RuleTestCase
{
    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new ClassNameMustBeFirstInConstructMethodDocumentationRule(new ClassHelper(), new DocCommentHelper());
    }

    /**
     * @see ClassNameMustBeFirstInConstructMethodDocumentationRule::processNode()
     */
    public function testProcessNodeShouldPassWithValidConstructDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithValidConstructDocComment.php'],
            []
        );
    }

    /**
     * @see ClassNameMustBeFirstInConstructMethodDocumentationRule::processNode()
     */
    public function testProcessNodeShouldPassWithClassWithoutConstructMethod(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithoutConstructMethod.php'],
            []
        );
    }

    /**
     * @see ClassNameMustBeFirstInConstructMethodDocumentationRule::processNode()
     */
    public function testProcessNodeShouldFailWithInvalidConstructDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithInvalidConstructDocComment.php'],
            [
                [
                    // @phpcs:ignore Generic.Files.LineLength.TooLong
                    'The doc comment of the __construct method of class ClassWithInvalidConstructDocComment must start with "ClassWithInvalidConstructDocComment constructor.".',
                    17,
                ],
            ]
        );
    }
}
