<?php
/*
 * @package Joomla 1.5
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
class mapyandexViewloadimg extends JViewLegacy
{
	/**
	 * Hellos view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		$app = JFactory::getApplication(); 
	

		$this->img = $this->get('LoadFile');
		$data = JRequest::get( 'post' );

		


		$this->metka = $this->get('Metka');

		parent::display($tpl);
	}
	
	

}

?>
