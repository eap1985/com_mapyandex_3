<?php 
/*
 * @package Joomla 3.0
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('jquery.framework',false);
JHtml::_('jquery.ui', array('core', 'sortable'));
$r 			=  new MapYandexRenderAdminView();
$app		= JFactory::getApplication();
$option 	= $app->input->get('option');
$OPT		= strtoupper($option);
echo '<form action="index.php" method="post" name="adminForm" id="adminForm">';
echo '<div class="row-fluid">';
echo '<div class="span10 form-horizontal">';
echo '<fieldset>';



$tabs = array (
'general' 		=> JText::_($OPT.'_GENERAL_OPTIONS'),
'publishing' 	=> JText::_($OPT.'_PUBLISHING_OPTIONS')
);

echo $r->navigation($tabs);

echo '<div class="tab-content">'. "\n";

echo '<div class="tab-pane active" id="general">'."\n";


?>

	
		<div class="width-70 fltlft">
		
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_MAPYANDEX_NAMECOMPONENT') : JText::sprintf('COM_MAPYANDEX_NAMECOMPONENT', $this->item->id); ?></legend>
	<?php $document = JFactory::getDocument();?>


	<?php $document->addScript('http://api-maps.yandex.ru/2.0.10/?load=package.full,util.json&lang=ru-RU');?>

<?php
	$lineika = '';
	$minimap = '';
	$sputnik = '';
	$search = '';
	$scale = '';
	$styleel = '';
	$stylecoo = '';
	$stylead = '';
	$stylead = '';
	$element = '';
	
	if($this->foobar->bradius == 1) {
		$borderradius = 'border-radius: 6px 6px 6px 6px;';
	}
	if($this->foobar->yandexborder == 1) {
		$border = 'border: 1px solid #'.$this->foobar->color_map_yandex.';';
	}
$style = '.YMaps-b-balloon-wrap td {
padding:0!important;
}
#YMapsID {

	margin:0; 
	box-shadow: 4px 4px 4px #'.$this->foobar->color_map_yandex.';  
	background: -moz-linear-gradient(center top , #'.$this->foobar->color_map_yandex.', #F1F1F1) repeat scroll 0 0 #F1F1F1;

    color: #333333;
    font-weight: bold;
	'.$borderradius.'
    '.$border.'

	}
.YMaps-b-balloon-content {
width:'.$this->foobar->oblako_width_map_yandex.'px !important;
}	
.imginmap {
	margin:0 5px 0 0;
}';
$document->addStyleDeclaration($style);
?>

<?php 
//всё шиворот на выворот
if($this->foobar->yandexcoord == 1) {

	$stylecoo='style="display:none;"';
	$valone = 'var valone = "'.$this->foobar->city_map_yandex.', '.$this->foobar->street_map_yandex.'"';
	$address = $this->foobar->city_map_yandex.', '.$this->foobar->street_map_yandex;
} else {
	$stylead = 'style="display:none;"';
	$parsejson = json_decode($this->foobar->lng);
	$longitude = $parsejson->longitude_map_yandex;
	$latitude = $parsejson->latitude_map_yandex;
	$valone = 'var valone = "'.$latitude.', '.$longitude.'"';

}

	
	$el = json_decode($this->foobar->yandexel);


	if($el) {
	
			if(in_array(1,$el)) {
			$lineika = '.add("mapTools")';
		}
			if(in_array(2,$el)) {
			$minimap = '.add("miniMap")';
		}
			if(in_array(3,$el)) {
			$sputnik = '.add("typeSelector")';
		}
			if(in_array(4,$el)) {
			$search = '.add("searchControl")';
		}
			if(in_array(5,$el)) {
			$scale = '.add("zoomControl")';
		}
	} else {

		$lineika = '.add("mapTools")';
		$minimap = '.add("miniMap")';
		$sputnik = '.add("typeSelector")';
		$search	 = '.add("searchControl")';
		$scale 	 = '.add("zoomControl")';
	}
if($this->foobar->yandexbutton == 1){
$element = "
			// Добавление элементов управления
            ".$lineika."
            ".$sputnik ."
			".$minimap." 
			".$scale."
			".$search."";
			}



$metka = '';

$userpath = $this->params->get('userpathtoimg');
		
if(empty($userpath)) {

	$userpath = '/images/mapyandex/yandexmarkerimg/';
}

foreach($this->metka as $val) {

	if(!empty($val->userimg)) {
		$imgarr = json_decode($val->userimg);
			$startfile = '<img align="left" class="imginmap" src="'.JURI::root(true).$userpath.$imgarr->startfile.'">';
			$smallfile = '<img align="left" class="imginmap" src="'.JURI::root(true).$userpath.$imgarr->smallfile.'">';
	} else {
		$startfile = '';
		$smallfile = '';
	}
if($this->params->get('draggable_placemark')) {
		$draggable_placemark = 'draggable: true, // Метку можно перетаскивать, зажав левую кнопку мыши.';
}
if($this->params->get('new_placemark')) {
    $op = 'options = { balloonCloseButton: true, 
               preset: \'twirl#'.$val->deficon.'\'
                },';
} else {
		if(!preg_match('@Stretchy@s',$val->deficon,$m)) {
			if(!$this->params->get('new_placemark')) {
					$smallfile = '';
			}
				$op = 'options = {balloonCloseButton: true, 
					'.$draggable_placemark.'
                    iconImageHref: \''.JURI::base(true).'/administrator/components/com_mapyandex/assets/images/deficon/'.$val->deficon.'.png\', // картинка иконки
					iconImageSize: [27, 26], // размеры картинки
                    iconImageOffset: [-3, -26] // смещение картинки
                }';
		} else {
			$op = '
				options = { balloonCloseButton: true, 
				'.$draggable_placemark.'
				preset: \'twirl#'.$val->deficon.'\'
                }';
		}
}

	$wih = json_decode($val->wih);
	if(count($wih) == 0 || !$wih) {
			$wih[0] = 250;
			$wih[1] = 250;
	}
	if($val->yandexcoord == 1) {

		$metka .= '
					/* После того, как поиск вернул результат, вызывается*/
    ymaps.geocode(\''.$val->city_map_yandex.', '.$val->street_map_yandex.'\', {results: 100}).then(function (res) {
                    
	var point = res.geoObjects.get(0).geometry.getCoordinates();

	var properties = {
        balloonContent: "'.addslashes($startfile).'<br />'.addslashes($val->misil).'",
		iconContent: "<div>'.addslashes($smallfile).'<div style=\"width:'.$wih[0].'px;height:'.$wih[1].'px;\">'.addslashes($val->misilonclick).'</div></div>",
        hintContent: "<div>'.addslashes($startfile).addslashes($val->misilonclick).'</div>",

    },
	'.$op.'
    placemark = new ymaps.Placemark(point, properties, options);

	map.geoObjects.add(placemark);
			
		});	';
		
	} else {

		$lng = json_decode($val->lng);
		
		$metka .= '
	var properties = {
        balloonContent: "'.addslashes($startfile).'<br />'.addslashes($val->misil).'",
		iconContent: "<div>'.addslashes($smallfile).'<div style=\"width:'.$wih[0].'px;height:'.$wih[1].'px;\">'.addslashes($val->misilonclick).'</div></div>",
        hintContent: "<div>'.addslashes($startfile).addslashes($val->misilonclick).'</div>",

    },
	'.$op.'
    placemark = new ymaps.Placemark(['.$lng->latitude_map_yandex.', '.$lng->longitude_map_yandex.'], properties, options);

	map.geoObjects.add(placemark);
			
			';
	}
	
}

$textarray = '';
$textarrayonput = ''; 
$region = json_decode($this->foobar->region_map_yandex);
$map_region_style = array();
$map_region_style[1] = '#0000FF';
$region_border_color = '#FFFF00';

$map_region_style = json_decode($this->foobar->map_region_style);


if(!is_array($map_region_style) || empty($map_region_style)) {
$styleoption = '											
		strokeWidth: 6,
		strokeColor: \''.$map_region_style_default.'\', // синий
		opacity: \'0.5\', // синий
		fillColor: \''.$region_border_color.'\', // желтый
		draggable: true      // объект можно перемещать, зажав левую кнопку мыши';
} else {
$styleoption = '											
		strokeWidth: 6,
		strokeColor: \''.$map_region_style[1].'\', // синий
		opacity: \''.$map_region_style[0].'\', // синий
		fillColor: \''.$region_border_color.'\', // желтый
		draggable: true      // объект можно перемещать, зажав левую кнопку мыши';
}
$ymapregion = '';
if($region) {

	$gi = -1;
	$length = count($region)-1;
$ymapregion = '
myGeoobject = [];';
	foreach($region as $val) {
	$gi++;
				$textbefore = 'Регион № '.$gi;
				  
				  $textarrayonput  .= '<li class="ui-state-default"><div width="100" align="left" class="key"><label for="foobar">'.$textbefore.'</label></div><div width="100" align="left"><input type="text" class="acpro_inp_'.($gi+1).' newroute" name="name_region_yandex[]" size="100" value="'.$val.'" /></div><div class="imgdeleteroute" rel="'.($gi+1).'" data-region="'.$this->foobar->id.'">'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/iconfalse.png', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' )).'</div><div>'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/icon-loading2.gif', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' ),array('class'=>'imgyandexmaploader')).'</div><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>';
					
					if($textarray != '') {
						$textarray = substr($textarray, 0, -1);
					}
		
					$c = 0;
					$jsarr = '';
					foreach(explode(',',$val) as $item) {
						
						if($c%2==0) {
							$jsarr .= '[';
						}
						if($c%2!==0) {
							$jsarr .= $item.'],';
						} else {
							$jsarr .= $item.',';
						}
						++$c;
					}

					$ymapregion .= '
					myGeometry = {
											type: \'Polygon\',
											coordinates: [
												[
												
													'.$jsarr.'

												]
											]
										},
										myOptions = {
											'.$styleoption.'
										};

									// Создаем геообъект с определенной (в switch) геометрией.
									myGeoobject['.($gi+1).'] = new ymaps.GeoObject({geometry: myGeometry}, myOptions);

									// При визуальном редактировании геообъекта изменяется его геометрия.
									// Тип геометрии измениться не может, однако меняются координаты.
									// При изменении геометрии геообъекта будем выводить массив его координат.
									myGeoobject['.($gi+1).'].events.add(\'geometrychange\', function (event) {
										printGeometry(myGeoobject['.($gi+1).'].geometry.getCoordinates(),'.($gi+1).');
									});

									// Размещаем геообъект на карте
									map.geoObjects.add(myGeoobject['.($gi+1).']);
									myGeoobject['.($gi+1).'].editor.startEditing();

								// Выводит массив координат геообъекта в <div id="geometry">
					
					';
	}
	
$ymapregion .= '
				function printGeometry (coords,getinput) {
				   $j(\'#geometry\').html(\'Координаты: \' + stringify(coords));

					
					without = stringify(coords).replace(/\\]|\s/ig,"");
					without = without.replace(/\\[/ig,"");
					
					$j("input.acpro_inp_"+getinput).val(without);
					function stringify (coords) {
						var res = \'\';
						if ($j.isArray(coords)) {
							res = \'[ \';
							for (var i = 0, l = coords.length; i < l; i++) {
								if (i > 0) {
									res += \', \';
								}
								res += stringify(coords[i]);
							}
							res += \' ]\';
						} else if (typeof coords == \'number\') {
							res = coords.toPrecision(6);
						} else if (coords.toString) {
							res = coords.toString();
						}

						return res;
					}
				}
				$j(".imgdeleteroute").live("click", function(){

					$tr = $j(this).parent();
					var idmap = $j(this).attr("data-region");
					var id = $j(this).attr("rel");
					
					map.geoObjects.remove(myGeoobject[id]);
			
					
					$j.ajax({
					url: "index.php?option=com_mapyandex&view=mapyandexajaxtask",
					data: {id:id,idmapforregion:idmap},
					success: function(data){
						$j(\'.imgyandexmaploader\',$tr).hide();
						$tr.fadeOut("slow",function(){
							$j(this).remove();
						});
					},
					beforeSend: function(data){
						$j(\'.imgyandexmaploader\',$tr).show();
					}
					});
				});


				$j(".adminformlist select").change(function(){
					var val = $j(this).val();

						myGeoobject.each(function (geoObject) {

						});

					

					

				});
				
				$j(\'input[name="color_map_region"]\').change(function(){
					var val = $j(this).val();

						myGeoobject.each(function (geoObject) {


						});

					

					

				});
			
';
} 
$script ='	
$.noConflict();

	$j = jQuery;
	$j(function(){
	
	$j(\'[name="yandexcoord"]\').change(function(){
		v = $j(this).children("option:selected").val()
		if(v == 2) {
			$j(".dispcoords").fadeIn("slow",function(){
				$j(".dispadres").fadeOut("slow");
			});
			
		}
		else {
			$j(".dispadres").fadeIn("slow",function(){
				$j(".dispcoords").fadeOut("slow");
			});
		}
	});
		$j(\'[name="yandexbutton"]\').change(function(){
		
		v = $j(this).children("option:selected").val()
		if(v == 2) {

			$j(".elyandex").fadeOut("slow");
			
		}
		else {
			$j(".elyandex").fadeIn("slow");
		}
	});

	
	ymaps.ready(function () { 
	
			var map;

	  
          
			'.$valone.'

			if(valone == "") {
				valone = "Москва, ул. Ленина, 50";
			}

			/* После того, как поиск вернул результат, вызывается*/
              ymaps.geocode(valone, {results: 100}).then(function (res) {
                    
					var point = res.geoObjects.get(0).geometry.getCoordinates();
					// Добавление полученного элемента на карту
		
					// Создание экземпляра карты и привязка его к контейнеру div
					map = new ymaps.Map("YMapsID", {
					// Центр карты
					center: res.geoObjects.get(0).geometry.getCoordinates(),
					// Коэффициент масштабирования
					zoom: '.$this->foobar->yandexzoom.'
		
				}
				);	
			
				
				myCollection = new ymaps.GeoObjectCollection();
				startPlacemark = new ymaps.Placemark(point, {
							// Свойства
							// Текст метки
							iconContent: \''.addslashes($this->foobar->misil).'\',
							hintContent: "<div>'.addslashes($this->foobar->misilonclick).'</div>",
							balloonContentHeader: "<div>'.addslashes($this->foobar->misilonclick).'</div>"
             
						}, {
							// Опции
							// Иконка метки будет растягиваться под ее контент
							preset: \'twirl#blueStretchyIcon\'
						});
				
				
				map.geoObjects.add(startPlacemark);

				$j(\'.addnewroute\').click(function(e){

				
				map.geoObjects.each(function (geoObject) {
					
	
					if (geoObject.properties.get(\'id\') == \'some id\') {
						// do something
						//...
						return false;
					}
				});
				
						myGeoobjectdinamic = [];
						e.preventDefault()
						varnr = $j(\'.newroute\').length;
						found = [];
						var gc = map.getCenter();
						
						lang = gc[0].toString();
						lat = gc[1].toString();
						re = /[0-9\.]{5}/i
		
						found[0] = parseFloat(lang.substring(0,5))-0.015;
						found[1] = parseFloat(lat.substring(0,5))-0.015;
						
						found[2] = found[0] +0.015;
						found[3] = found[1] +0;
						found[4] = found[0] +0.015;
						found[5] = found[1] +0.045;
						found[6] = found[0] +0;
						found[7] = found[1] +0.045;

		
						myGeometry = {
							type: \'Polygon\',
							coordinates: [
								[
									[found[0],found[1]],
									[found[2], found[3]],
									[found[4], found[5]],
									[found[6], found[7]],

								]
							]
						},
						myOptions = {
							strokeWidth: 6,
							strokeColor: \'#0000FF\', // синий
							opacity: \'0.5\', // синий
							fillColor: \'#FFFF00\', // желтый
							draggable: true      // объект можно перемещать, зажав левую кнопку мыши
						};

					// Создаем геообъект с определенной (в switch) геометрией.
					myGeoobjectdinamic[varnr] = new ymaps.GeoObject({geometry: myGeometry}, myOptions);

					// При визуальном редактировании геообъекта изменяется его геометрия.
					// Тип геометрии измениться не может, однако меняются координаты.
					// При изменении геометрии геообъекта будем выводить массив его координат.
					myGeoobjectdinamic[varnr].events.add(\'geometrychange\', function (event) {
						changeGeometry(myGeoobjectdinamic[varnr].geometry.getCoordinates(),varnr);
					});

					// Размещаем геообъект на карте
					map.geoObjects.add(myGeoobjectdinamic[varnr]);
					// ... и выводим его координаты.
					changeGeometry(myGeoobjectdinamic[varnr].geometry.getCoordinates());
					// Подключаем к геообъекту редактор, позволяющий
					// визуально добавлять/удалять/перемещать его вершины.
					myGeoobjectdinamic[varnr].editor.startEditing();
				// Выводит массив координат геообъекта в <div id="geometry">

				var text = "Регион №"+varnr;
				
				var appnewroute = \'<li class="ui-state-default"><div width="100" align="left" class="key"><label for="foobar">\'+text+\':</label></div><div width="100" align="left"><input type="text" name="name_region_yandex[]" class="acpro_inp_\'+(varnr+1)+\' newroute" size="100" value="\'+myGeoobjectdinamic[varnr].geometry.getCoordinates()+\'" /></div><div class="imgdeleterouteactive" rel="\'+(varnr+1)+\'" data-region="'.$this->foobar->id.'">'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/iconfalse.png', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' )).'</div><div>'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/icon-loading2.gif', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' ),array('class'=>'imgyandexmaploader')).'</div><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>\';
				
				if(varnr == 0)  { 
					$j(".sort").append(appnewroute);
				} else {
					$j(".sort li:last").after(appnewroute);
				}
				
				
					$j(".imgdeleterouteactive").live("click", function(){

					$tr = $j(this).parent();
					var idmap = $j(this).attr("data-region");
					var id = $j(this).attr("rel");
	
					idc = id-1;
	
					map.geoObjects.remove(myGeoobjectdinamic[idc]);
		
					
					$j.ajax({
					url: "index.php?option=com_mapyandex&view=mapyandexajaxtask",
					data: {id:id,idmapforregion:idmap},
					success: function(data){
						$j(\'.imgyandexmaploader\',$tr).hide();
						$tr.fadeOut("slow",function(){
							$j(this).remove();
						});
					},
					beforeSend: function(data){
						$j(\'.imgyandexmaploader\',$tr).show();
					}
					});
				});
				
				});
				
				function changeGeometry(coords,getinput) {
				   $j(\'#geometry\').html(\'Координаты: \' + stringify(coords));
					without = stringify(coords).replace(/\\]|\s/ig,"");
					without = without.replace(/\\[/ig,"");
		
					getinput = getinput+1;

					$j("input.acpro_inp_"+getinput).val(without);
					
					function stringify (coords) {
						var res = \'\';
						if ($j.isArray(coords)) {
							res = \'[ \';
							for (var i = 0, l = coords.length; i < l; i++) {
								if (i > 0) {
									res += \', \';
								}
								res += stringify(coords[i]);
							}
							res += \' ]\';
						} else if (typeof coords == \'number\') {
							res = coords.toPrecision(6);
						} else if (coords.toString) {
							res = coords.toString();
						}

						return res;
					}
				}
				
           // Добавление стандартного набора кнопок
			map.controls
			'.$element.'
			'.$metka.'
			
			'.$ymapregion.'
			
                });
			
			


			

			 


			
			
			
        });  

		
		
			<!--
	Joomla.submitbutton = function(task)
	{
			if (task == "mapyandexrregion.cancel") {
				submitform( task );
				return;
			}
			var serialize = $j(\'.newroute\').serialize();
		
			$j("#adminForm").append(\'<input type="hidden" name="allroutemap">\');
			$j(\'#adminForm input[name="allroutemap"]\').val(serialize);
			
			submitform( task );
	}
		//-->	

$j( ".sort" ).sortable({  items: ".ui-state-default", stop: function(event, ui) {


// 
 le = $j(this).find("li").length - 1;
 $j.each($j(this).find("li"),function(i,e){

 				if(i == 0) {
					var text = "Начало";
				} else if(i == le) {
					var text = "Конец пути";
				} else {
					var text = "Пункт "+i;
				}
				$j(this).find(".key label").text(text);
 
 });
 
 
 
 },handle:\'.ui-icon\'});
	
});';
	
$document->addScriptDeclaration($script);
?>
<div class="col100">


				

		<table class="admintable">

					<tr>
					<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_NAMEMAP' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
			 <input type="text" readonly="true" name="name_map_yandex" id="keyword" value="<?php echo $this->foobar->name_map_yandex;?>" />
			</td>
			</tr>
			
		<tr>
					<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_EXMAP' ); ?>:
				</label>
			</td>
			<td width="100" align="left">
<div id="editcell">







    <div id="YMapsID" style="height:<?php echo $this->foobar->height_map_yandex;?>px; width:<?php echo $this->foobar->width_map_yandex;?>px;"></div>
	
    <div id="info"></div>

	


</div>
			</td></tr>
			

		
	</table>
	<div style="clear:both;">
	<ul class="sort" >
	<?php echo $textarrayonput;?>
	</ul>
	</div>
	<div id="geometry"></div>
	<button class="addnewroute btn btn-small btn-success"><?php echo JText::_('COM_MAPYANDEX_ROUTE_PROCESS'); ?></button>


<div class="clr"></div>
		</fieldset>
</div>
</div>

		
<?php

echo '<div class="tab-pane" id="publishing">'."\n";

?>

<div class="width-30 fltrt">
          <fieldset class="adminform">
          <legend><?php echo JText::_('COM_MAPYANDEX_MARKERSETTINGS'); ?></legend>

		<fieldset class="adminform">
	
			<?php
			$map_region_style = json_decode($this->foobar->map_region_style);
			foreach($this->form->getFieldset('map_region_settings') as $field) {
				echo '<div class="control-group">';
				if (!$field->hidden) {
					echo '<div class="control-label">'.$field->label.'</div>';
				}
				echo '<div class="controls">'.$field->input.'</div>';
				echo '</div>';
			} 
			

			?>

		
			<div class="control-group">
				<div class="control-label">
				<?php echo JText::_('COM_MAPYANDEX_COLOR_MAP_REGION'); ?>
				</div>
				<div class="controls">

				<?php echo $this->form->getInput('color_map_region'); ?>
			
				
				
				</div>
			</div>
	
		</fieldset>
		
</div>
</div>

          </fieldset>
        </div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_mapyandex" />
<input type="hidden" name="id" value="<?php echo $this->foobar->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="mapyandexregion" />
<input type="hidden" name="controller" value="mapyandexregion" />
</form>