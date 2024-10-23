<?php
require_once(realpath(dirname(__FILE__)) . '/PHYSICALCHARACTORISTIC.php');

use PHYSICALCHARACTORISTIC;

/**
 * @access public
 * @author ssszz
 */
class PHYSICALCHARACTORISTICTYPE {
	/**
	 * @AttributeType int
	 */
	private $_charactoristictypeid;
	/**
	 * @AttributeType String
	 */
	private $_description;
	/**
	 * @AttributeType PHYSICALCHARACTORISTIC
	 * /**
	 *  * @AssociationType PHYSICALCHARACTORISTIC
	 *  * @AssociationMultiplicity 0..*
	 *  * /
	 */
	public $_pHYSICALCHARACTORISTIC = array();
}
?>