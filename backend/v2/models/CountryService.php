<?php
require_once(realpath(dirname(__FILE__)) . '/CITIZENSHIP.php');


/**
 * @access public
 * @author ssszz
 */
class COUNTRY {
	/**
	 * @AttributeType int
	 */
	private $_countryid;
	/**
	 * @AttributeType String
	 */
	private $_isocode;
	/**
	 * @AttributeType String
	 */
	private $_countryname;
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