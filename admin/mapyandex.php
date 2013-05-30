<?php
/*
 * @package Joomla 1.5
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access');

if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
// get the controller
require_once(JPATH_COMPONENT.DS.'controller.php');
// Require specific controller if requested

if (! class_exists('MapYandexLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mapyandex'.DS.'libraries'.DS.'loader.php');
}

require_once( JPATH_COMPONENT.DS.'controller.php' );

mapyandeximport('mapyandex.render.renderadmin');
mapyandeximport('mapyandex.render.renderadminview');
 
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('MapYandex');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();


?>