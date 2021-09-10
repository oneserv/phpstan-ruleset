<?php

declare(strict_types=1);

namespace Tests\Oneserv\PHPStan\Rules\Methods\data;

/**
 * Class ClassWithValidConstructDocComment
 */
class ClassWithValidConstructDocComment
{
    /**
     * ClassWithValidConstructDocComment constructor.
     *
     * Blabla text.
     */
    public function __construct()
    {
    }
}
