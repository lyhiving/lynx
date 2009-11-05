<?php
/**
 * @since 11/3/09
 * @package lynx
 * 
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */ 

require_once('CAS.php');

/**
 * <##>
 * 
 * @since 11/3/09
 * @package lynx
 * 
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */
class Lynx_Model_Manager_Authenticated
	extends Lynx_Model_Manager_Abstract
{
		
	/**
	 * Constructor
	 * 
	 * @return void
	 * @access public
	 * @since 11/3/09
	 */
	public function __construct () {
		parent::__construct();
		
		// Authenticate
		phpCAS::forceAuthentication();
		
		$config = Zend_Registry::get('config');
		
		if (isset($config->resources->cas->attras->first_name) && isset($config->resources->cas->attras->last_name))
			$displayName = phpCAS::getAttribute($config->resources->cas->attras->first_name).' '.phpCAS::getAttribute($config->resources->cas->attras->last_name);
		else
			$displayName = phpCAS::getUser();
		$this->userId = $this->getUserId(phpCAS::getUser(), $displayName);
		$this->userDisplayName = $displayName;
	}
	
	private $userId;
	private $userDisplayName;
	
	/**
	 * Add a restriction to a particular user.
	 * 
	 * @param Zend_Db_Select $select
	 * @return Zend_Db_Select
	 * @access protected
	 * @since 11/4/09
	 */
	protected function addUserRestriction (Zend_Db_Select $select) {
		return $select->where('mark.fk_user = ?', $this->userId);
	}
	
}

?>