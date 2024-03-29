<?php
/*
 * @package Joomla 3.0
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
 defined('_JEXEC') or die('Restricted access');


	$document	=  JFactory::getDocument();
	$document->addScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey='.$this->params->get('key'));

?>
   

<script type="text/javascript">
            var map, placemark;

            ymaps.ready(function () {

                ymaps.geocode("Moscow", {results: 100}).then(function (res) {
				//console.log( 123);
				//console.log( res.geoObjects.get(0));
				map = new ymaps.Map("YMapsID", {
					// Центр карты
					center: res.geoObjects.get(0).geometry.getCoordinates(),
					// Коэффициент масштабирования
					zoom: 15
		
				}
				);	
				map.controls.add("zoomControl");
				
                var point = res.geoObjects.get(0).geometry.getCoordinates();
				
				startPlacemark = new ymaps.Placemark(point, {
						draggable: true, hideIcon: false
             
						}, {
							// Опции
							// Иконка метки будет растягиваться под ее контент
							preset: 'islands#blueStretchyIcon'
						});
						
				map.geoObjects.add(startPlacemark);
				

            });
            

			});
			

			function showAddress (value) {
				ymaps.geocode(value, {results: 100}).then(
	
                function (res) {
					if (res.geoObjects.getLength()) {
						// point - первый элемент коллекции найденных объектов
						var point = res.geoObjects.get(0);
						// Добавление полученного элемента на карту
						map.geoObjects.add(point);

						document.getElementById('coords').value = point.geometry.getCoordinates()[0];
						document.getElementById('coords2').value = point.geometry.getCoordinates()[1];	
				
						window.top.document.forms.adminForm.getElementById('longitude').value = point.geometry.getCoordinates()[1];
						window.top.document.forms.adminForm.getElementById('latitude').value = point.geometry.getCoordinates()[0];	
						// Центрирование карты на добавленном объекте
						map.panTo(point.geometry.getCoordinates());
					}
				},
				// Обработка ошибки
				function (error) {
					alert("Возникла ошибка: " + error.message);
				}
                    
                );
            }
</script>

<div>
  <form action="#" onsubmit="showAddress(this.address.value);return false;">
    <table>
      <tr>
	   <td><?php echo JText::_('COM_MAPYANDEX_SAVE_COORDS_DESCRIPTION');?>:</td>
        <td><input name=""  type="text" id="address" value="" size="30" />
          </input></td>
        <td><input class="find-button" type="submit" value="<?php echo JText::_('COM_MAPYANDEX_SAVE_COORDS');?>">
          </input>
        </td>
      </tr>
      <tr>
        <td colspan="3">
        	<?php echo JText::_('COM_MAPYANDEX_SAVE_LATITUDE');?>:&nbsp;<input name="" type="text" id="coords" size="30"></input>
        </td>
      </tr>
	   <tr>
        <td colspan="3">
            <?php echo JText::_('COM_MAPYANDEX_SAVE_LONGITUDE');?>:&nbsp;<input name="" type="text" id="coords2" size="30" /></input>
        </td>
      </tr>
	  
    </table>

    <div style="margin:0;padding:0;text-align:center;">
      <div id="YMapsID" style="margin:0;padding:0;width:550px;height:500px;margin-bottom:5px;"></div>
    </div>
  </form>
  </td>
  <td><i></i></td>
  </tr>
  </table>
 </div>