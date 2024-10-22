<?php
require_once(realpath(dirname(__FILE__)) . '/PERSONNAME.php');

use PERSONNAME;

/**
 * @access public
 * @author ssszz
 */
class PERSONNAMETYPE {
	/**
	 * @AttributeType int
	 */
	private $_personnametypeid;
	/**
	 * @AttributeType String
	 */
	private $_description;
	/**
	 * @AttributeType PERSONNAME
	 * /**
	 *  * @AssociationType PERSONNAME
	 *  * @AssociationMultiplicity 0..*
	 *  * /
	 */
	public $_pERSONNAME = array();
}
?>