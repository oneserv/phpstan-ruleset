# Rules Overview

## Foreword

Keywords in this file to indicate requirement levels are as defined in
the [RFC2119](https://www.ietf.org/rfc/rfc2119.txt):

"MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL".

These keywords MUST always be capitalized to emphasize their importance.

## ClassDocumentationIsRequiredRule

**Rule:** Every class MUST have a non empty top level documentation.\
**Error text:** Class %s has no/an empty doc comment.\
**Class:**
[`Oneserv\PHPStan\Rules\Classes\ClassDocumentationIsRequiredRule`](src/Oneserv/PHPStan/Rules/Classes/ClassDocumentationIsRequiredRule.php)

### Invalid :x:

```php
class SomeClass
{
    ...
}
```

### Valid :white_check_mark:

```php
/**
 * Doc
 */
class SomeClass
{
    ...
}
```

## ClassNameMustBeFirstInClassDocumentationRule

**Rule:** The top level documentation of a class MUST start with: "Class _classname_".\
**Error text:** The doc comment of class %s must start with "Class %s".\
**Class:**
[`Oneserv\PHPStan\Rules\Classes\ClassNameMustBeFirstInClassDocumentationRule`](src/Oneserv/PHPStan/Rules/Classes/ClassNameMustBeFirstInClassDocumentationRule.php)

### Invalid :x:

```php
/**
 * Some text 
 */
class SomeClass
{
    ...
}
```

### Valid :white_check_mark:

```php
/**
 * Class SomeClass
 */
class SomeClass
{
    ...
}
```

## ClassNameMustBeFirstInConstructMethodDocumentationRuleTest

**Rule:** The documentation of a __construct method MUST start with: "_classname_ constructor.".\
**Error text:** The doc comment of the __construct method of class %s must start with "%s constructor.".\
**Class:**
[`Oneserv\PHPStan\Rules\Methods\ClassNameMustBeFirstInConstructMethodDocumentationRule`](src/Oneserv/PHPStan/Rules/Methods/ClassNameMustBeFirstInConstructMethodDocumentationRule.php)

### Invalid :x:

```php
class SomeClass
{
    public function __construct() {
    
    }
}
```

### Valid :white_check_mark:

```php
class SomeClass
{
    /**
     * SomeClass constructor.
     */
    public function __construct() {
    
    }
}
```

## FunctionDocumentationIsRequiredRule

**Rule:** A documentation MUST be provided for functions.\
**Error text:** Function %s has no/an empty doc comment.\
**Class:**
[`Oneserv\PHPStan\Rules\Functions\FunctionDocumentationIsRequiredRule`](src/Oneserv/PHPStan/Rules/Functions/FunctionDocumentationIsRequiredRule.php)

### Invalid :x:

```php
function someFunction() {

}
```

### Valid :white_check_mark:

```php
/**
 * Some documentation.
 */
 function someFunction() {
 
 }
```

## MethodDocumentationIsRequiredRule

**Rule:** A documentation MUST be provided for methods.\
**Error text:** Method %s has no/an empty doc comment.\
**Class:**
[`Oneserv\PHPStan\Rules\Methods\MethodDocumentationIsRequiredRule`](src/Oneserv/PHPStan/Rules/Methods/MethodDocumentationIsRequiredRule.php)

### Invalid :x:

```php
class SomeClass
{
    function someFunction() {
    
    }
}
```

### Valid :white_check_mark:

```php
class SomeClass
{
    /**
     * Some documentation.
     */
     function someFunction() {
    
    }
}
```
