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
	 * Instead of a CamelCase suffix, a "_" based function name will be understood as well, allowing
	 * suffixes following the pattern "with_non_..._values". Each word's first letter can be either
	 * upper or lower case. "..." can also be all upper case.
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

		$_W = self::regExUcOr_( 'W' );
		$_N = self::regExUcOr_( 'N' );
		$_V = self::regExUcOr_( 'V' );
		$_AtoZ = self::regExUcOr_( 'A-Z' );

		preg_match(
			"/^.+{$_W}ith{$_N}on({$_AtoZ}[a-zA-Z]+){$_V}alues$/",
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
				throw new DifferentTypesValuesUnknownTypeException( $typeString );
			}
		}

		return $cases;
	}

	private static function regExUcOr_( $letter ) {
		$lcLetter = strtolower( $letter );
		$ucLetter = strtoupper( $letter );
		return "(?:_?[$ucLetter]|_[{$lcLetter}])";
	}
}
