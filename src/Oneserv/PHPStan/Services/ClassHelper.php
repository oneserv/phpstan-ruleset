<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Services;

use PhpParser\Node\Stmt\Class_;

/**
 * Class ClassHelper
 *
 * @see \Tests\Oneserv\PHPStan\Services\ClassHelperTest
 */
final class ClassHelper
{
    /**
     * @param Class_ $node
     * @return bool
     */
    public function shouldClassBeAnalysed(Class_ $node): bool
    {
        if ($node->isAnonymous() || $node->namespacedName === null) {
            return false;
        }

        return true;
    }
}
