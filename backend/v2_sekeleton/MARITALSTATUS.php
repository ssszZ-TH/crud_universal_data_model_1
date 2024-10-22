<?php
require_once(realpath(dirname(__FILE__)) . '/MARITALSTATUSTYPE.php');
require_once(realpath(dirname(__FILE__)) . '/PERSON.php');

use MARITALSTATUSTYPE;
use PERSON;

/**
 * @access public
 * @author ssszz
 */
class MARITALSTATUS {
	/**
	 * @AttributeType int
	 */
	private $_maritalstatusid;
	/**
	 * @AttributeType Date
	 */
	private $_fromdate;
	/**
	 * @AttributeType Date
	 */
	private $_thrudate;
	/**
	 * @AttributeType MARITALSTATUSTYPE
	 * /**
	 *  * @AssociationType MARITALSTATUSTYPE
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_mARITALSTATUSTYPEmaritalstatustype;
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