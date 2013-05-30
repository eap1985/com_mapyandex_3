<?php
/*
 * @package Joomla 1.5
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Hello View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class MapYandexViewmapyandexroute extends JViewLegacy
{

	protected $state;
	protected $item;
	protected $form;
	protected $tmpl;

	function untextnl($text)
	{
		$text = str_replace("<br />","\r\n",$text);
		return $text;
	}
	
	function display($tpl = null)
	{
		$app	= JFactory::getApplication();
		$this->form	= $this->get('Form');
		$this->state = $this->get('State');
		$tmpl = array();
		$this->params = JComponentHelper::getParams( 'com_mapyandex' );

		$document = JFactory::getDocument();
		$jsLink = JURI::base(true);
		if (!$app->isAdmin()) {
			$tUri = JURI::base();

			$jsLink = JURI::base(true).'/administrator';
		}

		$uri		= JFactory::getURI();



		JHTML::stylesheet( 'administrator/components/com_mapyandex/assets/themes/base/jquery.ui.all.css' );
		JHTML::stylesheet( 'administrator/components/com_mapyandex/assets/mapyandex.css' );


		
		// prepare the cSS
			$css = '.icon-48-mapyandexe {
				background: url("'.JURI::root(true).'/media/com_mapyandex/colorpicker/images/icon-48-mapyandexroutes.png") 0 0 no-repeat;
			}';
			
			// add the CSS to the document

		$document->addStyleDeclaration($css);


		JToolBarHelper::title(   JText::_( 'COM_MAPYANDEX_ROUTES' ), 'mapyandexe' );
		
		$data['layout'] = JRequest::getVar('layout');
		
		if($data['layout'] == 'form') {
			JToolBarHelper::apply('mapyandexroute.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('mapyandexroute.save', 'JTOOLBAR_SAVE');
			
			JToolBarHelper::cancel( 'mapyandexroute.cancel','COM_MAPYANDEX_CANCEL' );
		}
		$this->foobar = $this->get('Foobar');
		
		$this->allroute = $this->get('AllRoute');

		$this->assignRef( 'tmpl', $tmpl );
		
		$this->metka = $this->get('Metka');
		
		$pageNav = $this->get('Reviews');
		$this->assignRef('pageNav', $pageNav);
		
		parent::display($tpl);
	}
}