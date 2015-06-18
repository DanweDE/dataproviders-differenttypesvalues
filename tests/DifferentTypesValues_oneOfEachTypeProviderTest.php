<?php
namespace Danwe\DataProviders\Tests;

use Danwe\DataProviders\DifferentTypesValues;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class DifferentTypesValues_oneOfEachTypeProviderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider functionNamesProvider
	 */
	public function testReturnsNonEmptyArray( $functionName ) {
		$cases = DifferentTypesValues::oneOfEachTypeProvider( $functionName );

		$this->assertInternalType( 'array', $cases );
		$this->assertGreaterThan( 0, count( $cases ) );
	}

	public function testDoubleAndFloatAreSynonyms() {
		$valuesDouble = DifferentTypesValues::oneOfEachTypeProvider( 'testWithNonDoubleValues' );
		$valuesFloat = DifferentTypesValues::oneOfEachTypeProvider( 'testWithNonFloatValues' );

		$this->assertEquals( $valuesDouble, $valuesFloat );
	}

	/**
	 * @dataProvider functionNamesAndExcludedTypesProvider
	 */
	public function testReturnsExpectedValues( $functionName, array $excludedTypes ) {
		$cases = DifferentTypesValues::oneOfEachTypeProvider( $functionName );

		foreach( $cases as $i => $case ) {
			list( $value, $valueType ) = $case;

			$this->assertSame( gettype( $value ), $valueType,
				'value is of type stated in 2nd parameter' );

				$this->assertFalse( in_array( $valueType, $excludedTypes ),
					"value with index $i returned with test function name set to "
					. "\"$functionName\" is not of type(s): \""
					. implode( '", "', $excludedTypes ) . '"' );
		}
	}

	/**
	 * @dataProvider functionNamesAndExcludedTypesProvider
	 */
	public function testReturnsOneOfEachIncludedType( $functionName, array $excludedTypes ) {
		$types = array(
			'boolean', 'integer', 'double', 'string', 'array', 'object', 'NULL'
		);
		$coveredTypes = array();

		$cases = DifferentTypesValues::oneOfEachTypeProvider( $functionName );

		foreach( $cases as $i => $case ) {
			list( $value, $valueType ) = $case;

			$this->assertFalse( in_array( $valueType, $coveredTypes ),
				"contains only one value of type \"$valueType\"" );

			if( in_array( $valueType, $types ) ) {
				$coveredTypes[] = $valueType;
			} else {
				$this->assertTrue( false, "contains value of unknown type \"$valueType\"" );
			}

		}
		$this->assertTrue(
			count( array_diff(
				array_diff( $types, $excludedTypes ),
				$coveredTypes
			) ) === 0,
			'contains one value of each included type'
		);
	}

	/**
	 * @return array( array( string $functionName, string[] $expectedExcludedTypes ), ... )
	 */
	public static function functionNamesAndExcludedTypesProvider() {
		return array(
			array( 'testWithNonBooleanValues', array( 'boolean' ) ),
			array( 'testWithNonIntegerValues', array( 'integer' ) ),
			array( 'testWithNonDoubleValues', array( 'double' ) ),
			array( 'testWithNonFloatValues', array( 'double' ) ),
			array( 'testWithNonStringValues', array( 'string' ) ),
			array( 'testWithNonArrayValues', array( 'array' ) ),
			array( 'test_with_non_array_values', array( 'array' ) ),
			array( 'test_with_non_ARRAY_values', array( 'array' ) ),
			array( 'test_With_non_Array_Values', array( 'array' ) ),
			array( 'test_With_Non_Array_Values', array( 'array' ) ),
			array( 'testWithNonARRAYValues', array( 'array' ) ),
			array( 'testWithNonObjectValues', array( 'object' ) ),
			array( 'testWithNonNullValues', array( 'NULL' ) ),
			array( 'testWithNonNULLValues', array( 'NULL' ) ),
		);
	}

	/**
	 * @return array( array( string|null $functionName ), ... )
	 */
	public static function functionNamesProvider() {
		$data = array_map( function( $value ) {
			return array( $value[ 0 ] );
		}, static::functionNamesAndExcludedTypesProvider() );

		$data[] = array( null );

		return $data;
	}
}

