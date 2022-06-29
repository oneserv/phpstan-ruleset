<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Methods;

use Oneserv\PHPStan\Rules\Methods\MethodDocumentationIsRequiredRule;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Class MethodDocumentationIsRequiredRuleTest
 *
 * @extends RuleTestCase<MethodDocumentationIsRequiredRule>
 * @see MethodDocumentationIsRequiredRule
 */
class MethodDocumentationIsRequiredRuleTest extends RuleTestCase
{
    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new MethodDocumentationIsRequiredRule(new DocCommentHelper());
    }

    /**
     * @see MethodDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldPassWithValidDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/MethodWithValidDocComment.php'],
            []
        );
    }

    /**
     * @see MethodDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldFailPassWithEmptyDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/MethodWithEmptyDocComment.php'],
            [
                [
                    'Method test has no/an empty doc comment.',
                    15,
                ],
            ]
        );
    }

    /**
     * @see MethodDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldFailPassWithoutDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/MethodWithoutDocComment.php'],
            [
                [
                    'Method test has no/an empty doc comment.',
                    12,
                ],
            ]
        );
    }
}
