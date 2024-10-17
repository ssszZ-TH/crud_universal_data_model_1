<?php
require_once(realpath(dirname(__FILE__)) . '/COUNTRY.php');
require_once(realpath(dirname(__FILE__)) . '/PASSPORT.php');
require_once(realpath(dirname(__FILE__)) . '/PERSON.php');

use COUNTRY;
use PASSPORT;
use PERSON;

/**
 * @access public
 * @author ssszz
 */
class CITIZENSHIP {
	/**
	 * @AttributeType int
	 */
	private $_citizenshipid;
	/**
	 * @AttributeType Date
	 */
	private $_fromdate;
	/**
	 * @AttributeType Integer
	 */
	private $_thrudate;
	/**
	 * @AttributeType COUNTRY
	 * /**
	 *  * @AssociationType COUNTRY
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_cOUNTRYcountry;
	/**
	 * @AttributeType PASSPORT
	 * /**
	 *  * @AssociationType PASSPORT
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_pASSPORTpassport;
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