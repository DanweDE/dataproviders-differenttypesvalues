<?php
namespace Danwe\DataProviders;

use LogicException;
use InvalidArgumentException;

/**
 * Indicates that a data type used with DifferentTypesValues is unknown.
 *
 * @since 1.0.0
 * @author Daniel A. R. Werner
 */
class DifferentTypesValuesUnknownTypeException extends LogicException {

	/**
	 * @var string
	 */
	protected $unknownType;

	/**
	 * @param string $unknownType
	 */
	public function __construct( $unknownType ) {
		if( ! is_string( $unknownType ) ) {
			throw new InvalidArgumentException( '$unknownType has to be a string' );
		}
		parent::__construct(
			"unknown type $unknownType"
		);
		$this->unknownType = $unknownType;
	}

	/**
	 * @return string
	 */
	public function getUnknownType() {
		return $this->unknownType;
	}
}
