<?php
/*
 * @package Joomla 3.x
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class MapYandexViewMapyandexdoc extends JViewLegacy
{
	function display($tpl = null) {
		
		$tmpl		= array();
		$css = '.icon-48-mapyandexdoc {
				background: url(\'../media/com_mapyandex/colorpicker/images/icon-48-mapyandexdoc.png\') 0 0 no-repeat;
		}';
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration($css);
		JToolBarHelper::title(   JText::_( 'COM_MAPYANDEX_INSTRUCTION' ), 'mapyandexdoc' );

		

		$this->assignRef('tmpl',	$tmpl);
		
		parent::display($tpl);
	}
}
?>