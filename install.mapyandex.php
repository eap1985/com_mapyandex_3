<?php
/*
 * @package Joomla 3.0
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
function com_install()
{
	$document	= JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/components/com_mapyandex/assets/mapyandex.css');
	$lang 		= JFactory::getLanguage();
	$lang->load('com_mapyandex.sys');
	$lang->load('com_mapyandex');
	
		
	

?>
<div class="header"><p>Поздравляю Вы установили компонент "Яндекс карт" от сайта slyweb.ru!</p></div>
<p>
Компонент "Яндекс карты" упрощает размещение на ваших сайтах карт от яндекс. При этом доступны многие настройки карты, - цвет, размер, элементы управления и т.д.
Последнии версии компонента Вы можете получить на сайте <a target="_blank" href="http://slyweb.ru/yandexmap/">slyweb.ru</a>.</p>


<?php
}
?>