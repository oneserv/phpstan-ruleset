<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Classes;

use Oneserv\PHPStan\Services\ClassHelper;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

/**
 * Class ClassDocumentationIsRequiredRule
 *
 * @see \Tests\Oneserv\PHPStan\Rules\Classes\ClassDocumentationIsRequiredRuleTest
 * @implements Rule<Class_>
 */
class ClassDocumentationIsRequiredRule implements Rule
{
    private ClassHelper $classHelper;

    private DocCommentHelper $docCommentHelper;

    /**
     * ClassDocumentationIsRequiredRule constructor.
     *
     * @param ClassHelper $classHelper
     * @param DocCommentHelper $docCommentHelper
     */
    public function __construct(ClassHelper $classHelper, DocCommentHelper $docCommentHelper)
    {
        $this->classHelper = $classHelper;
        $this->docCommentHelper = $docCommentHelper;
    }

    /**
     * @inheritDoc
     */
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @inheritDoc
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        /** @var Class_ $node */
        if (!$this->classHelper->shouldClassBeAnalysed($node)) {
            return [];
        }

        if ($node->name === null) {
            throw new ShouldNotHappenException();
        }

        $docComment = (string)$node->getDocComment();
        $docComment = $this->docCommentHelper->removeCommentDelimiters($docComment);
        $docComment = $this->docCommentHelper->cleanUpDocComment($docComment);

        if ($docComment === '') {
            try {
                return [
                    sprintf(
                        'Class %s has no/an empty doc comment.',
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
