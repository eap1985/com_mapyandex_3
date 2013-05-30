<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die;
jimport('joomla.client.ftp');

class MapYandexHelper
{
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_mapyandex';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

	public static function canWrite()
	{
		$user	= JFactory::getUser();
		$result['perms'] = 0;
		$params = JComponentHelper::getParams( 'com_mapyandex' );	
				$userpath = $params->get('userpathtoimg');
				
				if(empty($userpath)) {

					$userpath = '/images/mapyandex/yandexmarkerimg/';
				}
			
				
				if(is_dir($_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath)) {


	
					//var_dump($ftp->mkdir($config->get('ftp_root').$userpath.'555'));


					
					$jp = JPath::getPermissions($_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
					$ch = JPath::canChmod($_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
					$jp = str_split($jp, 3);
			
				
					if(!is_writable($_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath)) {
						$result['notperms'] = JText::sprintf('COM_MAPYANDEX_NO_PERMS',$_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
					}
				
					if(!$jp) {
						$result['notperms'] = JText::sprintf('COM_MAPYANDEX_NO_PERMS',$_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
					}
					
					
					if(strpos($jp[0],'w') && is_writable($_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath)) {
					
						$result['perms'] = 1;
						
						
					} else {
						
						$result['notperms'] = JText::sprintf('COM_MAPYANDEX_NO_PERMS',$_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
						
					}
				} else {
					
					$result['notperms'] = JText::sprintf('COM_MAPYANDEX_NO_PERMS',$_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
				
				}

				if(JRequest::getVar('task') == 'add') {
					if(!empty($result['notperms'])) {
						$config = JFactory::getConfig($_SERVER['DOCUMENT_ROOT'].JURI::root(true).'configuration.php');
						$ftp = new JFtp(array());
						$ftp->connect($config->get('ftp_host'),$config->get('ftp_port'));
						
						$l = $ftp->login($config->get('ftp_user'),$config->get('ftp_pass'));
						if($l && $ftp->isConnected()) {
							$result['isconnectedftp'] = $ftp->isConnected();
						} else {
							$result['isconnectedftp']= false;	
							$result['noftp'] = JText::sprintf('COM_MAPYANDEX_NO_FTP',$_SERVER['DOCUMENT_ROOT'].JURI::root(true).$userpath);
						}
						
						$ftp->quit();

					}
				}

		return $result;
	}
}