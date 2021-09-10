<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Classes;

use Oneserv\PHPStan\Services\ClassHelper;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Class ClassNameMustBeFirstInClassDocumentationRuleTest
 *
 * @see ClassNameMustBeFirstInClassDocumentationRule
 * @extends RuleTestCase<ClassNameMustBeFirstInClassDocumentationRule>
 */
final class ClassNameMustBeFirstInClassDocumentationRuleTest extends RuleTestCase
{
    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new ClassNameMustBeFirstInClassDocumentationRule(new ClassHelper(), new DocCommentHelper());
    }

    /**
     * @see ClassNameMustBeFirstInClassDocumentationRule::processNode()
     */
    public function testProcessNodeShouldPassWithAnonymousClass(): void
    {
        $this->analyse(
            [__DIR__ . '/data/AnonymousClass.php'],
            []
        );
    }

    /**
     * @see ClassNameMustBeFirstInClassDocumentationRule::processNode()
     */
    public function testProcessNodeShouldPassWithValidClassDoc(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithValidDocComment.php'],
            []
        );
    }

    /**
     * @see ClassNameMustBeFirstInClassDocumentationRule::processNode()
     */
    public function testProcessNodeShouldFailWithInvalidClassDoc(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithInvalidDocComment.php'],
            [
                [
                    // @phpcs:ignore Generic.Files.LineLength.TooLong
                    "The doc comment of class ClassWithInvalidDocComment must start with \"Class ClassWithInvalidDocComment\".",
                    10,
                ],
            ]
        );
    }
}
