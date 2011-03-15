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
class Piwik_AdminOverview_Controller extends Piwik_Controller
{
	public function index()
	{
        $view = Piwik_View::factory('AdminOverview');
        
        $users = array();
        if(Zend_Registry::get('access')->isSuperUser())
        {
            $usersAccess = Piwik_AdminOverview_API::getInstance()->getAccessCountByLogin();
        }
        
        $view->usersAccess = $usersAccess;
        $view->sitesCount = Piwik_AdminOverview_API::getInstance()->getTotalSitesCount();
        $view->usersCount = Piwik_AdminOverview_API::getInstance()->getTotalUsersCount();
        $this->setBasicVariablesView($view);
        $view->menu = Piwik_GetAdminMenu();
        echo $view->render();
	}
    
    public function getUserSites()
    {
        $view = Piwik_View::factory('UserSitesRow');
        $users = array();
        $login = Piwik_Common::getRequestVar('login', '');
        if(empty($login)) return;
        
        if(Zend_Registry::get('access')->isSuperUser())
        {
            $userSites = Piwik_AdminOverview_API::getInstance()->getUserSites($login);
        }
        $view->userSites = $userSites;
        $this->setBasicVariablesView($view);
        echo $view->render();
    }
	
}