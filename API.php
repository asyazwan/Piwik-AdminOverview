<?php
/**
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * 
 * @category Piwik_Plugins
 * @package Piwik_AdminOverview
 */

/**
 *
 * @package Piwik_AdminOverview
 */
class Piwik_AdminOverview_API 
{
	static private $instance = null;
	static public function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function getAccessCountByLogin() {
        Piwik::checkUserIsSuperUser();
        
        $accesses = Piwik_Access::getListAccess();
        
        $db = Zend_Registry::get('db');
        
        $return = array();
        
        foreach($accesses as $access)
        {
            $users = $db->fetchAll("SELECT pu.login, IF(access IS NULL, 0, COUNT(*)) AS count
                                FROM ".Piwik_Common::prefixTable("access") . " pa"
                                ." RIGHT JOIN ".Piwik_Common::prefixTable("user") . " pu ON pa.login = pu.login"
                                ." WHERE access = ? OR access IS NULL"
                                ." GROUP BY login", $access);
            
            foreach($users as $user)
            {
                $return[$user['login']][$access] = $user['count'];
            }
        }
        return $return;
    }
    
    public function getTotalSitesCount() {
        $db = Zend_Registry::get('db');
        $row = $db->fetchRow("SELECT COUNT(*) as count FROM ".Piwik_Common::prefixTable("site"));
        return $row['count'];
    }
    
    public function getTotalUsersCount() {
        $db = Zend_Registry::get('db');
        $row = $db->fetchRow("SELECT COUNT(*) as count FROM ".Piwik_Common::prefixTable("user"));
        return $row['count'];
    }
    
    public function getUserSites($login) {
        $db = Zend_Registry::get('db');
        
        $tSite      = Piwik_Common::prefixTable("site");
        $tAccess    = Piwik_Common::prefixTable("access");
        $sites      = $db->fetchAll("SELECT s.name AS name, access"
                            ." FROM {$tSite} s"
                            ." LEFT JOIN {$tAccess} a ON s.idsite = a.idsite"
                            ." WHERE login = ?"
                            ." ORDER BY access, s.idsite", $login);
        return $sites;
    }
}
