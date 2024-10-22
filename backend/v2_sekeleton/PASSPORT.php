<?php
require_once(realpath(dirname(__FILE__)) . '/CITIZENSHIP.php');

use CITIZENSHIP;

/**
 * @access public
 * @author ssszz
 */
class PASSPORT {
	/**
	 * @AttributeType int
	 */
	private $_passportid;
	/**
	 * @AttributeType String
	 */
	private $_pasportnum;
	/**
	 * @AttributeType Date
	 */
	private $_fromdate;
	/**
	 * @AttributeType Date
	 */
	private $_thrudate;
	/**
	 * @AttributeType CITIZENSHIP
	 * /**
	 *  * @AssociationType CITIZENSHIP
	 *  * @AssociationMultiplicity 0..*
	 *  * /
	 */
	public $_cITIZENSHIP = array();
}
?>