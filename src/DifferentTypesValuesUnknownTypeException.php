<?php
namespace Danwe\DataProviders;

use LogicException;

/**
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
		parent::__construct(
			"unknown type $unknownType"
		);
		$this->unknownType = $unknownType;
	}

	public function getUnknownType() {
		return $this->unknownType;
	}
}
