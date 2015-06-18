# php-DataProviders-DifferentTypesValues
PhpUnit compatible data provider providing one value of each of PHP's built-in types per test case.
Allows to exclude types based on the name of the test using the data provider.

[![Latest Stable Version](https://poser.pugx.org/danwe/dataproviders-differenttypesvalues/version.png)](https://packagist.org/packages/danwe/dataproviders-differenttypesvalues)
[![Build Status](https://travis-ci.org/DanweDE/php-DataProviders-DifferentTypesValues.svg)](https://travis-ci.org/DanweDE/php-DataProviders-DifferentTypesValues)
[![Coverage Status](https://coveralls.io/repos/DanweDE/php-DataProviders-DifferentTypesValues/badge.svg)](https://coveralls.io/r/DanweDE/php-DataProviders-DifferentTypesValues)
[![Dependency Status](https://www.versioneye.com/user/projects/55834659363861001d00014f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55834659363861001d00014f)
[![Download count](https://poser.pugx.org/danwe/dataproviders-differenttypesvalues/d/total.png)](https://packagist.org/packages/danwe/dataproviders-differenttypesvalues)

## Usage
Consider the following example:

```php
<?php
class PersonTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @dataProvider Danwe\DataProviders\DifferentTypesValues::oneOfEachTypeProvider
	 */
	public function testConstructionWithNonStringValues( $personName ) {
		new Person( $personName );
	}

	// ...
	// further "Person" tests
	// ...
}
```

Due to the test's `WithNonStringValues` suffix, `DifferentTypesValues::oneOfEachTypeProvider` will
only provide non-string values.

## TODOs
* Excluding more than one type with a `WithNon<TYPE1>And<TYPE2>Values` test name suffix.
* `With<TYPE1>And<TYPE2>Values` test name suffix to only provide values of the mentioned types.
* `DifferentTypesValues::valuesProvider` to provide multiple different values for each type.
