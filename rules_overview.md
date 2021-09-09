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
