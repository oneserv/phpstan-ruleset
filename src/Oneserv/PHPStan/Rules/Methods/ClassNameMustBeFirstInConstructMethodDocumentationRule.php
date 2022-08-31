<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Methods;

use Oneserv\PHPStan\Services\ClassHelper;
use Oneserv\PHPStan\Services\DocCommentHelper;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

/**
 * Class ClassNameMustBeFirstInConstructMethodDocumentationRule
 *
 * @implements Rule<ClassMethod>
 * @see \Tests\Oneserv\PHPStan\Rules\Methods\ClassNameMustBeFirstInConstructMethodDocumentationRuleTest
 */
class ClassNameMustBeFirstInConstructMethodDocumentationRule implements Rule
{
    /**
     * ClassNameMustBeFirstInConstructMethodDocumentationRule constructor.
     *
     * @param ClassHelper $classHelper
     * @param DocCommentHelper $docCommentHelper
     */
    public function __construct(
        private readonly ClassHelper $classHelper,
        private readonly DocCommentHelper $docCommentHelper
    ) {
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
        if ($node->name->name !== '__construct') {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            throw new ShouldNotHappenException();
        }

        $className = $this->classHelper->getClassNameFromFqn($classReflection->getName());

        $docComment = (string)$node->getDocComment();
        $docComment = $this->docCommentHelper->cleanUpDocComment($docComment);
        if (!str_starts_with($docComment, '/***' . $className . 'constructor.')) {
            return [
                sprintf(
                    'The doc comment of the __construct method of class %s must start with "%s constructor.".',
                    $className,
                    $className,
                ),
            ];
        }

        return [];
    }
}
