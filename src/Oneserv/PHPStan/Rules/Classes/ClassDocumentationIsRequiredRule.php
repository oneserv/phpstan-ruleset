<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Rules\Classes;

use Oneserv\PHPStan\Services\ClassHelper;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;

use function Safe\preg_replace;
use function Safe\sprintf;

/**
 * Class ClassDocumentationIsRequiredRule
 *
 * @see \Oneserv\PHPStan\Rules\Classes\ClassDocumentationIsRequiredRuleTest
 * @implements Rule<Class_>
 */
final class ClassDocumentationIsRequiredRule implements Rule
{
    private ClassHelper $classHelper;

    /**
     * ClassDocumentationIsRequiredRule constructor.
     *
     * @param ClassHelper $classHelper
     */
    public function __construct(ClassHelper $classHelper)
    {
        $this->classHelper = $classHelper;
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
        $docComment = str_replace('/**', '', $docComment);
        $docComment = str_replace('*/', '', $docComment);
        $docComment = str_replace('*', '', $docComment);
        try {
            // replace any whitespace/line breaks
            $docComment = preg_replace('/[\r\n]+/', '', $docComment);
            $docComment = preg_replace('/[ \t]+/', '', $docComment);
        } catch (PcreException $exception) {
            throw new ShouldNotHappenException(
                'An error occurred while processing the doc comment:' . $exception->getMessage()
            );
        }

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
