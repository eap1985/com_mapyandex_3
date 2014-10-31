<?php 
/*
 * @package Joomla 3.x
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
?>

	<?php $document = JFactory::getDocument();?>


	<?php $document->addScript('http://api-maps.yandex.ru/2.0.10/?load=package.full&lang=ru-RU');?>


<?php
	$lineika 	= '';
	$minimap 	= '';
	$sputnik 	= '';
	$search 	= '';
	$scale 		= '';
	$styleel 	= '';
	$stylecoo 	= '';
	$stylead 	= '';
	$stylead 	= '';
	$element 	= '';
	$border		='';
	$borderradius = '';
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
}
';
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
$route = json_decode($this->foobar->route_map_yandex);
$ymaproute = '';
if($route) {
	$i = -1;
	$length = count($route)-1;
	foreach($route as $val) {
	$i++;
				  $textarray  .= '\''.$val.'\',';
				  if($i == 0) {
					$textbefore = 'Начало пути';
				  } else if($i == $length) {
					$textbefore = 'Конец пути';
				  }	
				  else {
					$textbefore = 'Пункт '.$i;
				  }
				  
				  $textarrayonput  .= '<li class="ui-state-default"><div width="100" align="left" class="key"><label for="foobar">'.$textbefore.'</label></div><div width="100" align="left"><input type="text" name="name_route_yandex[]" class="newroute" size="100" value="'.$val.'" /></div><div class="imgdeleteroute" rel="'.$i.'" data-idmap="'.$this->foobar->id.'">'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/iconfalse.png', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' )).'</div><div>'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/icon-loading2.gif', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' ),array('class'=>'imgyandexmaploader')).'</div><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>';
					

	}
	
	if($textarray != '') {
		$textarray = substr($textarray, 0, -1);
	}
	$ymaproute = 'ymaps.route([
					'.$textarray.'
				], {
					// Опции маршрутизатора
					mapStateAutoApply: true // автоматически позиционировать карту
				}).then(function (route) {
					map.geoObjects.add(route);
					
					   var points = route.getWayPoints();  
                    // Задаем стиль метки - иконки будут красного цвета, и
                    // их изображения будут растягиваться под контент

					points.options.set(\'preset\', \'twirl#redStretchyIcon\');
					route.options.set({ strokeColor: \''.$this->foobar->color_map_route.'\', opacity: '.$this->foobar->map_route_opacity.' });
					points.get(0).properties.set(\'iconContent\', \'Точка отправления\');
					for(i = 0; i <='.($length).';i++) {
						if(i == '.($length).') {		
							points.get('.($length).').properties.set(\'iconContent\', \'Точка прибытия\');
						}
					}
				}, function (error) {
					alert("Возникла ошибка: " + error.message);
				});';
} 
$script ='	


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

      
           // Добавление стандартного набора кнопок
			map.controls
			'.$element.'
			'.$metka.'
			
			'.$ymaproute.'
			
                });
			
			


			

			
			 


			
			
			
        });  
				$j(".imgdeleteroute").live("click", function(){
				$tr = $j(this).parent();
					var idmap = $j(this).attr("data-idmap");
					var id = $j(this).attr("rel");
			
					$j.ajax({
					url: "index.php?option=com_mapyandex&view=mapyandexajaxtask",
					data: {id:id,idmap:idmap},
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
		
				$j(".addnewroute").live("click",function(e){ 
				e.preventDefault();
				
				varnr = $j(\'.newroute\').length;
				if(varnr == 0) {
					var text = "Начало";
				} else if(varnr == 1) {
					var text = "Пункт "+varnr;
				} else {
					$j(".sort li:last").find("div:first").html("<label for=\"foobar\">Пункт "+(varnr-1)+"</label>");
					var text = "Конец пути";
				}
				
				var appnewroute = \'<li class="ui-state-default"><div width="100" align="left" class="key"><label for="foobar">\'+text+\':</label></div><div width="100" align="left"><input type="text" name="name_route_yandex[]" class="newroute" size="100" value="" /></div><div class="imgdeleteroute" data-idmap="'.$this->foobar->id.'">'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/iconfalse.png', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' )).'</div><div>'.JHTML::_( 'image', 'administrator/components/com_mapyandex/assets/images/icon-loading2.gif', JText::_( 'COM_MAPYANDEX_DELETE_ROUTE_ITEM' ),array('class'=>'imgyandexmaploader')).'</div><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>\';
				
				if(varnr == 0)  { 
					$j(".sort").append(appnewroute);
				} else {
					$j(".sort li:last").after(appnewroute);
				}
				
			});		
			<!--
	Joomla.submitbutton = function(task)
	{
			if (task == "mapyandexroute.cancel") {
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


$tabs = array (
'general' 		=> JText::_($OPT.'_GENERAL_OPTIONS'),
'publishing' 	=> JText::_($OPT.'_PUBLISHING_OPTIONS')
);

echo $r->navigation($tabs);

echo '<div class="tab-content">'. "\n";

echo '<div class="tab-pane active" id="general">'."\n";

?>



				

		<table class="admintable">

					<tr>
					<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_NAMEMAP' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
			 <input type="text" name="name_map_yandex" id="keyword" value="<?php echo $this->foobar->name_map_yandex;?>" />
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
	
	<button class="btn btn-small btn-success addnewroute"><i class="icon-apply icon-white"> </i><?php echo JText::_('COM_MAPYANDEX_ROUTE_PROCESS'); ?></button>


</div>

		
	

<?php

echo '<div class="tab-pane" id="publishing">'."\n";

?>

<div class="width-30 fltrt">
          <fieldset class="adminform">
          <legend><?php echo JText::_('COM_MAPYANDEX_MARKERSETTINGS'); ?></legend>



			<?php foreach($this->form->getFieldset('map_route_settings') as $field) {
				echo '<div class="control-group">';
				if (!$field->hidden) {
					echo '<div class="control-label">'.$field->label.'</div>';
				}
				echo '<div class="controls">'.$field->input.'</div>';
				echo '</div>';
			} ?>

		
			
		<div class="control-group">
				<div class="control-label">
				<?php echo JText::_('COM_MAPYANDEX_FIELD_COLOR_LABEL'); ?>
				</div>
				<div class="controls">

					<?php echo $this->form->getInput('color_map_route'); ?>
				

				</div>
			</div>	

		</fieldset>


        
        </div>

</div>

<input type="hidden" name="option" value="com_mapyandex" />
<input type="hidden" name="id" value="<?php echo $this->foobar->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="mapyandexroute" />
<input type="hidden" name="view" value="mapyandexroute" />
</form>