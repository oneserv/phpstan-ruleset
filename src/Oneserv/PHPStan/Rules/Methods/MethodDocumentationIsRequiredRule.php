<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Methods;

use Oneserv\PHPStan\Services\DocCommentHelper;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

/**
 * Class MethodDocumentationIsRequiredRule
 *
 * @implements Rule<ClassMethod>
 * @see \Tests\Oneserv\PHPStan\Rules\Methods\MethodDocumentationIsRequiredRuleTest
 */
final class MethodDocumentationIsRequiredRule implements Rule
{
    private DocCommentHelper $docCommentHelper;

    /**
     * MethodDocumentationIsRequiredRule constructor.
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
        return ClassMethod::class;
    }

    /**
     * @inheritDoc
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        /** @var ClassMethod $node */
        $docComment = (string)$node->getDocComment();
        $docComment = $this->docCommentHelper->removeCommentDelimiters($docComment);
        $docComment = $this->docCommentHelper->cleanUpDocComment($docComment);
        if ($docComment === '') {
            try {
                return [
                    sprintf(
                        'Method %s has no/an empty doc comment.',
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
