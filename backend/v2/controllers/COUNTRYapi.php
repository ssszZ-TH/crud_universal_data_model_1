<?php

require __DIR__ . '/../config/db.php'; // ดึง config ของ database


/**
 * @access public
 * @author ssszz
 */
class COUNTRYmodel {
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