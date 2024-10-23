<?php
require_once(realpath(dirname(__FILE__)) . '/MARITALSTATUS.php');
require_once(realpath(dirname(__FILE__)) . '/PHYSICALCHARACTORISTIC.php');
require_once(realpath(dirname(__FILE__)) . '/PERSONNAME.php');
require_once(realpath(dirname(__FILE__)) . '/CITIZENSHIP.php');
require_once(realpath(dirname(__FILE__)) . '/GENDERTYPE.php');

use MARITALSTATUS;
use PHYSICALCHARACTORISTIC;
use PERSONNAME;
use CITIZENSHIP;
use GENDERTYPE;

/**
 * @access public
 * @author ssszz
 */
class PERSON {
	/**
	 * @AttributeType int
	 */
	private $_personid;
	/**
	 * @AttributeType Date
	 */
	private $_birthdate;
	/**
	 * @AttributeType String
	 */
	private $_mothersmaidenname;
	/**
	 * @AttributeType String
	 */
	private $_socialsecurityno;
	/**
	 * @AttributeType Integer
	 */
	private $_totalyearworkexperience;
	/**
	 * @AttributeType String
	 */
	private $_comment;
	/**
	 * @AttributeType MARITALSTATUS
	 * /**
	 *  * @AssociationType MARITALSTATUS
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_mARITALSTATUSmaritalstatus;
	/**
	 * @AttributeType PHYSICALCHARACTORISTIC
	 * /**
	 *  * @AssociationType PHYSICALCHARACTORISTIC
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_pHYSICALCHARACTORISTICphysicalcharactoristic;
	/**
	 * @AttributeType PERSONNAME
	 * /**
	 *  * @AssociationType PERSONNAME
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_pERSONNAMEpersonname;
	/**
	 * @AttributeType CITIZENSHIP
	 * /**
	 *  * @AssociationType CITIZENSHIP
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_cITIZENSHIPcitizenship;
	/**
	 * @AttributeType GENDERTYPE
	 * /**
	 *  * @AssociationType GENDERTYPE
	 *  * @AssociationMultiplicity 1
	 *  * /
	 */
	public $_gENDERTYPEgendertype;
}
?>