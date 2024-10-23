<?php
require_once(realpath(dirname(__FILE__)) . '/PERSON.php');

use PERSON;

/**
 * @access public
 * @author ssszz
 */
class GENDERTYPE {
	/**
	 * @AttributeType int
	 */
	private $_gendertypeid;
	/**
	 * @AttributeType char
	 */
	private $_gendercode;
	/**
	 * @AttributeType String
	 */
	private $_description;
	/**
	 * @AttributeType PERSON
	 * /**
	 *  * @AssociationType PERSON
	 *  * @AssociationMultiplicity 0..*
	 *  * /
	 */
	public $_pERSON = array();
}
?>