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
class Piwik_AdminOverview extends Piwik_Plugin
{
	public function getInformation()
	{
		return array(
			'description' => Piwik_Translate('AdminOverview_PluginDescription'),
			'author' => 'syaz',
			'author_homepage' => '',
            'translationAvailable'    => true,
			'version' => '0.1',
		);
	}

	public function getListHooksRegistered()
	{
		return array( 
			'AdminMenu.add' => 'addMenu',
		);
	}
	
	function addMenu()
	{
		Piwik_AddAdminMenu('AdminOverview_MenuOverview', 
							array('module' => 'AdminOverview', 'action' => 'index'),
							Piwik::isUserHasSomeAdminAccess(),
							$order = 0);
	}
	
}
