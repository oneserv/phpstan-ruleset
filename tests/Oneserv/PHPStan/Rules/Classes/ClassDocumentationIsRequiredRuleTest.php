<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Classes;

use Oneserv\PHPStan\Rules\Classes\ClassDocumentationIsRequiredRule;
use Oneserv\PHPStan\Services\ClassHelper;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Class ClassDocumentationIsRequiredRuleTest
 *
 * @see ClassDocumentationIsRequiredRule
 * @extends RuleTestCase<ClassDocumentationIsRequiredRule>
 */
final class ClassDocumentationIsRequiredRuleTest extends RuleTestCase
{
    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new ClassDocumentationIsRequiredRule(new ClassHelper(), new DocCommentHelper());
    }

    /**
     * @see ClassDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldPassWithAnonymousClass(): void
    {
        $this->analyse(
            [__DIR__ . '/data/AnonymousClass.php'],
            []
        );
    }

    /**
     * @see ClassDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldPassWithValidDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithValidDocComment.php'],
            []
        );
    }

    /**
     * @see ClassDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldFailPassWithEmptyDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/ClassWithEmptyDocComment.php'],
            [
                [
                    'Class ClassWithEmptyDocComment has no/an empty doc comment.',
                    12,
                ],
            ]
        );
    }
}
