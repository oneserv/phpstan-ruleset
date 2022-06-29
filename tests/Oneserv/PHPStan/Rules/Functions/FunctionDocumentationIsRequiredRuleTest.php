<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Functions;

use Oneserv\PHPStan\Rules\Functions\FunctionDocumentationIsRequiredRule;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Class FunctionDocumentationIsRequiredRuleTest
 *
 * @see FunctionDocumentationIsRequiredRule
 * @extends RuleTestCase<FunctionDocumentationIsRequiredRule>
 */
class FunctionDocumentationIsRequiredRuleTest extends RuleTestCase
{
    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new FunctionDocumentationIsRequiredRule(new DocCommentHelper());
    }

    /**
     * @see FunctionDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldPassWithValidDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/FunctionWithValidDocComment.php'],
            []
        );
    }

    /**
     * @see FunctionDocumentationIsRequiredRule::processNode()
     */
    public function testProcessNodeShouldFailPassWithEmptyDocComment(): void
    {
        $this->analyse(
            [__DIR__ . '/data/FunctionWithEmptyDocComment.php'],
            [
                [
                    'Function test has no/an empty doc comment.',
                    05,
                ],
            ]
        );
    }
}
