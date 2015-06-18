<?php
namespace Danwe\DataProviders\Tests;

use Danwe\DataProviders\DifferentTypesValuesUnknownTypeException;

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

