<?php
/*
 * @package Joomla 3.0
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
// import the JView class
jimport('joomla.application.component.view');

/**
* Foobar View
*/
class MapYandexViewMapYandexAllMaps extends JViewLegacy
{
	/**
	 * Hellos view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		// prepare the cSS
			$css = '.icon-48-mapyandexallmaps {
				background: url(\'../media/com_mapyandex/colorpicker/images/icon-48-mapyandex.png\') 0 0 no-repeat;
			}
			.icon-48-allmaps {
				background: url(\'../media/com_mapyandex/colorpicker/images/icon-48-allmaps.png\') 0 0 no-repeat;
			}';
			
			// add the CSS to the document
		$doc =JFactory::getDocument();
		$doc->addStyleDeclaration($css);
		$this->form	= $this->get('Form');
		$this->state = $this->get('State');

		$data['layout'] = JRequest::getVar('layout');
		$data['task'] = JRequest::getVar('task');
		
		if($data['layout'] == 'form') {
		JToolBarHelper::title(   JText::_( 'COM_MAPYANDEX_YANDEXNEWMAP' ), 'mapyandexallmaps' );
			JToolBarHelper::save('mapyandexallmaps.save', 'COM_MAPYANDEX_SAVE_NEW_MAP');
			JToolBarHelper::cancel('mapyandexallmaps.cancel');
		}
		else {
			JToolBarHelper::title(   JText::_( 'COM_MAPYANDEX_NAMECOMPONENT' ), 'allmaps' );
			JToolBarHelper::preferences('com_mapyandex', '460');
			JToolBarHelper::addNew('mapyandexallmaps.add');
			
			JToolBarHelper::deleteList(JText::_( 'COM_MAPYANDEX_DELETE_CONFIRM' ),'mapyandexallmaps.remove');
		}
		// interrogate the model
		$this->foobar = $this->get('Foobar');
		
		if($data['layout'] == 'form' && $data['task'] != 'add' && !empty($this->foobar)) $this->foobar = $this->foobar[0];
		
		if(empty($this->foobar) && $data['layout'] == 'form') {
			
			$this->foobar = $this->get('DefaultSettings');
			
		}
		
		
		
		$pageNav = $this->get('Reviews');
		$this->assignRef('pageNav', $pageNav);
		
		$params = JComponentHelper::getParams( 'com_mapyandex' );
				
		$tmpl['apikey'] = $params->get( 'yandex_maps_api_key', '' );


		$this->assignRef( 'tmpl', $tmpl );
		
		
		parent::display($tpl);
	}
}

?>
