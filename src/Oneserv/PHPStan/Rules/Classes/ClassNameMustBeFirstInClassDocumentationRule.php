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
 * Class ClassNameMustBeFirstInClassDocumentationRule
 *
 * @see \Tests\Oneserv\PHPStan\Rules\Classes\ClassNameMustBeFirstInClassDocumentationRuleTest
 * @implements Rule<Class_>
 */
final class ClassNameMustBeFirstInClassDocumentationRule implements Rule
{
    private ClassHelper $classHelper;

    private DocCommentHelper $docCommentHelper;

    /**
     * ClassNameMustBeFirstInClassDocumentationRule constructor.
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

        $className = $node->name;
        if ($className === null) {
            throw new ShouldNotHappenException();
        }
        $className = $className->name;

        $docComment = (string)$node->getDocComment();
        $docComment = $this->docCommentHelper->cleanUpDocComment($docComment);
        if (!str_starts_with($docComment, "/***Class$className")) {
            try {
                return [
                    sprintf(
                        "The doc comment of class %s must start with \"Class %s\".",
                        $className,
                        $className,
                    ),
                ];
            } catch (StringsException $exception) {
                throw new ShouldNotHappenException();
            }
        }

        return [];
    }
}
