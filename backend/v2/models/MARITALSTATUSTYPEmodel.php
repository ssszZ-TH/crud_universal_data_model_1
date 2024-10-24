<?php
require_once(realpath(dirname(__FILE__)) . '/MARITALSTATUS.php');

use MARITALSTATUS;

/**
 * @access public
 * @author ssszz
 */
class MARITALSTATUSTYPE
{
  /**
   * @AttributeType int
   */
  private $_maritalstatustypeid;
  /**
   * @AttributeType String
   */
  private $_description;
  /**
   * @AttributeType MARITALSTATUS
   * /**
   *  * @AssociationType MARITALSTATUS
   *  * @AssociationMultiplicity 0..*
   *  * /
   */
  public $_mARITALSTATUS = array();
}
?>