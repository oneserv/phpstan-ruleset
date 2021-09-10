<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Methods\data;

/**
 * Class ClassWithInvalidConstructDocComment
 */
class ClassWithInvalidConstructDocComment
{
    /**
     * Blabla text.
     *
     * ClassWithInvalidConstructDocComment constructor.
     */
    public function __construct()
    {
    }
}
