<?php
require_once(realpath(dirname(__FILE__)) . '/PHYSICALCHARACTORISTICTYPE.php');
require_once(realpath(dirname(__FILE__)) . '/PERSON.php');

use PHYSICALCHARACTORISTICTYPE;
use PERSON;

/**
 * @access public
 * @author ssszz
 */
class PHYSICALCHARACTORISTIC {
	/**
	 * @AttributeType int
	 */
	private $_physicalcharactoristicid;
	/**
	 * @AttributeType Date
	 */
	private $_fromdate;
	/**
	 * @AttributeType Date
	 */
	private $_thrudate;
	/**
	 * @AttributeType float
	 */
	private $_value;
	/**
	 * @AttributeType PHYSICALCHARACTORISTICTYPE
	 * /**
	 *  * @AssociationType PHYSICALCHARACTORISTICTYPE
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_pHYSICALCHARACTORISTICTYPEcharactoristictype;
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