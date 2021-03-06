<?php

declare(strict_types=1);

namespace Oneserv\PHPStan\Services;

use PHPStan\ShouldNotHappenException;
use Safe\Exceptions\PcreException;

use function Safe\preg_replace;

/**
 * Class DocCommentHelper
 *
 * @see \Tests\Oneserv\PHPStan\Services\DocCommentHelperTest
 */
class DocCommentHelper
{
    /**
     * Removes every whitespace and line breaks from the given doc comment.
     *
     * @param string $docComment
     * @return string
     * @throws ShouldNotHappenException
     */
    public function cleanUpDocComment(string $docComment): string
    {
        try {
            // replace any whitespace/line breaks
            $docComment = preg_replace('/[\r\n]+/', '', $docComment);
            return preg_replace('/[ \t]+/', '', $docComment);
        } catch (PcreException $exception) {
            throw new ShouldNotHappenException(
                'An error occurred while processing the doc comment:' . $exception->getMessage()
            );
        }
    }

    /**
     * @param string $docComment
     * @return string
     */
    public function removeCommentDelimiters(string $docComment): string
    {
        $docComment = str_replace('/**', '', $docComment);
        $docComment = str_replace('*/', '', $docComment);
        return str_replace('*', '', $docComment);
    }
}
