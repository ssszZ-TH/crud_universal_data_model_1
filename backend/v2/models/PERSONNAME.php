<?php
require_once(realpath(dirname(__FILE__)) . '/PERSONNAMETYPE.php');
require_once(realpath(dirname(__FILE__)) . '/PERSON.php');

use PERSONNAMETYPE;
use PERSON;

/**
 * @access public
 * @author ssszz
 */
class PERSONNAME {
	/**
	 * @AttributeType int
	 */
	private $_personnameid;
	/**
	 * @AttributeType Date
	 */
	private $_fromdate;
	/**
	 * @AttributeType Date
	 */
	private $_thrudate;
	/**
	 * @AttributeType String
	 */
	private $_fullname;
	/**
	 * @AttributeType PERSONNAMETYPE
	 * /**
	 *  * @AssociationType PERSONNAMETYPE
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_pERSONNAMETYPEpersonnametype;
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