<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Functions;

use Oneserv\PHPStan\Services\DocCommentHelper;
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

/**
 * Class FunctionDocumentationIsRequiredRule
 *
 * @implements Rule<Function_>
 * @see \Tests\Oneserv\PHPStan\Rules\Functions\FunctionDocumentationIsRequiredRuleTest
 */
final class FunctionDocumentationIsRequiredRule implements Rule
{
    private DocCommentHelper $docCommentHelper;

    /**
     * FunctionDocumentationIsRequiredRule constructor.
     *
     * @param DocCommentHelper $docCommentHelper
     */
    public function __construct(DocCommentHelper $docCommentHelper)
    {
        $this->docCommentHelper = $docCommentHelper;
    }

    /**
     * @inheritDoc
     */
    public function getNodeType(): string
    {
        return Function_::class;
    }

    /**
     * @inheritDoc
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        /** @var Function_ $node */
        $docComment = (string)$node->getDocComment();
        $docComment = $this->docCommentHelper->removeCommentDelimiters($docComment);
        $docComment = $this->docCommentHelper->cleanUpDocComment($docComment);
        if ($docComment === '') {
            try {
                return [
                    sprintf(
                        'Function %s has no/an empty doc comment.',
                        $node->name->name
                    ),
                ];
            } catch (StringsException $exception) {
                throw new ShouldNotHappenException();
            }
        }
        return [];
    }
}