<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
mapyandeximport( 'mapyandex.render.renderinfo' );
mapyandeximport( 'mapyandex.render.renderadmin' );

class MapYandexViewMapYandex extends JViewLegacy
{
	public function display($tpl = null) {
		
		$tmpl = array();
		JHtml::stylesheet( 'administrator/components/com_mapyandex/assets/mapyandex.css' );
		
		// prepare the cSS
			$css = '.icon-48-mapyandex {
				background: url("'.JURI::root(true).'/media/com_mapyandex/colorpicker/images/icon-48-mapyandex.png") 0 0 no-repeat;
			}';
			// add the CSS to the document
		$doc =JFactory::getDocument();
		$doc->addStyleDeclaration($css);
		$tmpl['version'] = MapYandexRenderInfo::getYndexMapVersion();
		
		$MapYandexRenderAdmin = new MapYandexRenderAdmin();
		
		$this->assignRef('tmpl',	$tmpl);
		$this->assignRef('MapYandexRenderAdmin',	$MapYandexRenderAdmin);
		$this->addToolbar();
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'mapyandex.php';

		$state	= $this->get('State');
		$canDo	= MapYandexHelper::getActions();
		JToolBarHelper::title( JText::_( 'COM_MAPYANDEX' ), 'mapyandex.png' );
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_mapyandex');
			JToolBarHelper::divider();
		}
		
		JToolBarHelper::help( 'screen.mapyandexhelp', true );
	}
}
?>