<?php
namespace Danwe\DataProviders\Tests;

use Danwe\DataProviders\DifferentTypesValuesUnknownTypeException;
use InvalidArgumentException;

/**
 * @covers Danwe\DataProviders\DifferentTypesValuesUnknownTypeException
 *
 * @since 1.0.0
 *
 * @licence MIT License
 * @author Daniel A. R. Werner
 */
class DifferentTypesValuesUnknownTypeExceptionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider unknownTypesProvider
	 */
	public function testConstruction( $unknownType ) {
		$this->assertInstanceOf(
			'Danwe\DataProviders\DifferentTypesValuesUnknownTypeException',
			new DifferentTypesValuesUnknownTypeException( $unknownType )
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @dataProvider Danwe\DataProviders\DifferentTypesValues::oneOfEachTypeProvider
	 */
	public function testConstructionWithNonStringValues( $value ) {
		new DifferentTypesValuesUnknownTypeException( $value );
	}

	/**
	 * @dataProvider unknownTypesProvider
	 */
	public function testGetUnknownType( $unknownType ) {
		$e = new DifferentTypesValuesUnknownTypeException( $unknownType );

		$this->assertEquals( $unknownType, $e->getUnknownType() );
	}

	public static function unknownTypesProvider() {
		return array_chunk( array(
			'someUknownType', 'foo', 'bar'
		), 1 );
	}
}

