<?php
namespace Danwe\DataProviders;

use LogicException;

/**
 * Provides a data provider returning different type's values. Covers values of all of PHP's
 * built-in types documented on http://php.net/manual/en/function.gettype.php except for the
 * "resource" type and for "unknown type".
 *
 * NOTE: "resource" got excluded from this because creating a resource might fail depending on the
 *  PHP environment. It could also be considered a rather unconventional type not necessary for most
 *  test cases so we leave it alone for now.
 *
 * @since 1.0.0
 * @author Daniel A. R. Werner
 */
class DifferentTypesValues {

	/**
	 * Provides a value of some type per case. Will analyse the name of the test using the provider.
	 * If the test's name ends with "WithNon...Values" where "..." is the name of a type, e.g.
	 * "String", "Null" or "Object", then no case for that type will be returned.
	 *
	 * @since 1.0.0
	 *
	 * @param string $testName
	 * @return array( array( mixed $value, string $valuesType ), ... )
	 *
	 * @throws LogicException If the test function using this provider uses the "WithNon...Values"
	 *         suffix where "..." is an unknown type.
	 */
	public static function oneOfEachTypeProvider( $testName = null ) {
		$rawData = array( 'foo', 42, new \DateTime( '1980-01-01 1:00' ), 4.2, true, null, array() );
		$cases = array();

		foreach( $rawData as $data ) {
			$dataType = gettype( $data );
			$cases[ $dataType ] = array( $data, $dataType );
		}

		if( ! $testName ) {
			return $cases;
		}

		preg_match(
			'/^.+(?:W|_[Ww])ith(?:N|_[Nn])on((?:[A-Z]|_[a-zA-Z])[a-zA-Z]+)(?:V|_[Vv])alues$/',
			$testName,
			$matches
		);

		if( array_key_exists( 1, $matches ) ) {
			$typeString = strtolower( ltrim( $matches[ 1 ], '_' ) );
			if( $typeString === 'null' ) {
				$typeString = 'NULL';
			} else if( $typeString === 'float' ) {
				$typeString = 'double'; // see http://php.net/manual/en/function.gettype.php
			}

			if( array_key_exists( $typeString, $cases ) ) {
				unset( $cases[ $typeString ] );
			} else {
				throw new LogicException( __FUNCTION__ . " does not know of type \"$typeString\"");
			}
		}

		return $cases;
	}
}
