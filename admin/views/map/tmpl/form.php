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
JHtml::_('jquery.framework');
JHtml::_('formbehavior.chosen', 'select');
$r 			=  new MapYandexRenderAdminView();
$app		= JFactory::getApplication();
$option 	= $app->input->get('option');
$OPT		= strtoupper($option);
?>
<?php $document = JFactory::getDocument();?>

	
	<?php 

	$document->addScript('http://api-maps.yandex.ru/2.0.10/?load=package.full&lang=ru-RU');?>

	<?php $document->addStyleSheet(JURI::root(true).'/media/com_mapyandex/colorpicker/css/colorpicker.css');?>
	<?php $document->addStyleSheet(JURI::root(true).'/media/com_mapyandex/colorpicker/css/layout.css');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/colorpicker.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/eye.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/utils.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/layout.js?ver=1.0.2');?>

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
	$border = '';
	
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
$autozoom = 'var autozoom = '.$this->foobar->autozoom.';';
if($this->foobar->autozoom) {
	$autozoomflag = 10;
} else {
	$autozoomflag = $this->foobar->yandexzoom;
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

$script ='	
		<!--
		function changeDisplayImage() {
			if (document.adminForm.imageurl.value !="") {
				document.adminForm.imagelib.src="../images/banners/" + document.adminForm.imageurl.value;
			} else {
				document.adminForm.imagelib.src="images/blank.png";
			}
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == "cancel") {
				submitform( pressbutton );
				return;
			}
			// do field validation
			if (form.name_map_yandex.value == "") {
				alert( "'.JText::_( "ERROR_NAME_MAP", true ).'" );
			}
			  else if (form.id_map_yandex.value == "") {
				alert( "'.JText::_( "ERROR_ID", true ).'" );
			} else if (form.city_map_yandex.value == "") {
				alert( "'.JText::_( "ERROR_CITY", true ).'" );
			
			} else if (form.street_map_yandex.value == "") {
				alert( "'.JText::_( "ВERROR_STREET", true ).'" );
			}
			else if (form.oblako_width_map_yandex.value == "" || form.oblako_width_map_yandex.value == 0) {
				alert( "'.JText::_( "ERROR_WIDTH_BALLUN", true ).'" );
			}
	
			else {
				submitform( pressbutton );
			}
		}
		//-->';
	
$document->addScriptDeclaration($script);

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
		iconContent: "<div>'.addslashes($smallfile).'<br /><div style=\"width:'.$wih[0].'px;height:'.$wih[1].'px;\">'.addslashes($val->misilonclick).'</div></div>",
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


$ymaproute = $this->addRouteToMap($route);

($this->foobar->map_baloon_autopan) ? $autopan = 'true' : $autopan = 'false';  
($this->foobar->map_centering) ? $map_centering = 'true' : $map_centering = 'false'; 
if(!$this->foobar->map_baloon_or_placemark) {

	$balloonorplacemark = 'startPlacemark = new ymaps.Placemark(point, {
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
						map.geoObjects.add(startPlacemark);';

} else {



	$balloonorplacemark = 'map.balloon.open(
						// Координаты балуна
						point, {
							/* Свойства балуна:
							   - контент балуна */
							content: \''.addslashes($this->foobar->misil).'\'
						}, {
							/* Опции балуна:
							   - балун имеет копку закрытия */ 
							closeButton: true,
							minWidth: '.$this->foobar->map_baloon_minwidth.',
							minHeight: '.$this->foobar->map_baloon_minheight.',
							autoPan: '.$map_centering.',
							autoPanDuration: '.$this->foobar->map_baloon_autopanduration.'
						}
					);';

}
			

$defaultmap = ($this->foobar->defaultmap) ? $this->foobar->defaultmap : 'publicMap';

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

	  
			'.$autozoom.'
			'.$valone.'

			if(valone == "") {
				valone = "Москва, ул. Ленина, 50";
			}

			/* После того, как поиск вернул результат, вызывается*/
              ymaps.geocode(valone, {results: 100}).then(function (res) {
                    
					var point = res.geoObjects.get(0).geometry.getCoordinates();
			// Добавление полученного элемента на карту
			
			
				map = new ymaps.Map("YMapsID", {
					// Центр карты
					center: res.geoObjects.get(0).geometry.getCoordinates(),
					// Коэффициент масштабирования
					zoom: '.$autozoomflag.',
					type: "yandex#'.$defaultmap.'"
					
				});
			
				if(autozoom) {

					map.setCenter(point, '.$this->foobar->yandexzoom.', {
						checkZoomRange: true,
						duration: 1000,
						callback: function(){
	
							'.$metka.'
						}
					});
				} else {
	
	
				map.zoomRange.get(
					/* Координаты точки, в которой определяются 
					   значения коэффициентов масштабирования */ 
					point)
					.then(function (zoomRange, err) {
					
					var userzoom = '.$this->foobar->yandexzoom.';
						if (!err) {
						
							// zoomRange[0] - минимальный масштаб
							// zoomRange[1] - максимальный масштаб
							if(userzoom > zoomRange[1]) {
								userzoom = zoomRange[1];
																
									map.setCenter(point, userzoom,{duration:500,callback:function(){
										'.$metka.'
									}
									});
								
							} else {
										'.$metka.'
							}
						
							
						}
					}
				)	
			}
			
			map.zoomRange.get(
					/* Координаты точки, в которой определяются 
					   значения коэффициентов масштабирования */ 
					point)
					.then(function (zoomRange, err) {
					
					var userzoom = '.$this->foobar->yandexzoom.';
						if (!err) {
						
							// zoomRange[0] - минимальный масштаб
							// zoomRange[1] - максимальный масштаб
							if(userzoom > zoomRange[1]) {
								userzoom = zoomRange[1];
									$j("#autozoom span:eq(0),#autozoom span:eq(1),#autozoom span:eq(3)").text(zoomRange[1]);							
									$j("#autozoom span:eq(2)").text($j("#yandexzoom").val());							
									$j("#autozoom").fadeIn("slow");
								
							} else if($j("#yandexzoom").val() <= zoomRange[1] && $j("#jform_autozoom").val() == 1) {
									$j("#autozoomno").fadeIn("slow");
							}
						
							
						}
					}
				);		

      
           // Добавление стандартного набора кнопок
			map.controls
			'.$element.'
		
			'.$ymaproute.'
			
			'.$balloonorplacemark.'
			
			
			
			map.events.add("click", function (e) {
			var type = $j("#yandexcoord").val();
			
			
                if (!map.balloon.isOpen() && type == 2) {
                    var coords = e.get("coordPosition");
									
					document.forms.adminForm.getElementById("longitude").value = coords[1].toPrecision(6);
					document.forms.adminForm.getElementById("latitude").value = coords[0].toPrecision(6);	
						
                    map.balloon.open(coords, {
                        contentHeader: "Поиск координат!",
                        contentBody: "<p>Координаты будут использоваться для центрирования основной метки.</p>" +
                            "<p>Координаты: " + [
                                coords[0].toPrecision(6),
                                coords[1].toPrecision(6)
                            ].join(", ") + "</p>",
                        contentFooter: "<sup>Они будут использоваться для метки</sup>"
                    });
                } else {
                    map.balloon.close();
                }
            });
                });
			
			


			 


			
			
			
        });  
});';
	
$document->addScriptDeclaration($script);




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


	<fieldset class="adminform">
	<legend><?php echo empty($this->item->id) ? JText::_('COM_MAPYANDEX_EDITINFO') : JText::sprintf('COM_MAPYANDEX_EDITINFO', $this->item->id); ?></legend>
	
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_NAMEMAP' ); ?>
				</div>
				<div class="controls">
					 <input type="text" name="name_map_yandex" id="keyword" value="<?php echo $this->foobar->name_map_yandex;?>" />
				</div>
			</div>
			
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_WIDTHMAP' ); ?>
				</div>
				<div class="controls">
				 <input type="text" name="width_map_yandex" value="<?php echo $this->foobar->width_map_yandex;?>">
				</div>
			</div>

			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_HEIGHTMAP' ); ?>
				</div>
				<div class="controls">
				<input type="text" name="height_map_yandex" value="<?php echo $this->foobar->height_map_yandex;?>">
				</div>
			</div>

			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_SEACRHMETHOD' ); ?>
				</div>
				<div class="controls">

				<?php 
				
					$statecoord[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_ADRESS' ) );
					$statecoord[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_COORDINATES' ) );
					echo JHTML::_('select.genericlist',  $statecoord, $name = 'yandexcoord', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexcoord, $idtag = false, $translate = false );
				?>
				</div>
			</div>
			
			
			<div class="control-group dispadres" <?php echo $stylead;?>>
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_CITY' ); ?>
				</div>
				<div class="controls">
					<input type="text" name="city_map_yandex" value="<?php echo $this->foobar->city_map_yandex;?>">
				</div>
			</div>

			<div class="control-group dispadres" <?php echo $stylead;?>>
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_ADRESS' ); ?>
				</div>
				<div class="controls">
					 <input type="text" name="street_map_yandex" value="<?php echo $this->foobar->street_map_yandex;?>">
				</div>
			</div>

			<div class="control-group dispcoords" <?php echo $stylecoo;?>>
				<div class="control-label">
						<?php echo JText::_( 'COM_MAPYANDEX_COORDINATES' ); ?>
				</div>
				<div class="controls">

				<?php
					// define modal options
					$modalOptions = array (
					'size' => array('x' => 580, 'y' => 590)
					
					);
					// load modal JavaScript
					JHTML::_('behavior.modal', 'a.modal', $modalOptions);
				?>
				<div style="display:inline" class="button2-left"><div class="image"><a href="<?php echo 'index.php?option=com_mapyandex&view=mapyandexajax&tmpl=component&cid[]='.$this->foobar->id; ?>" class="modal"
				rel = "{
						handler: 'iframe'
						
						}">
						<?php echo JText::_( 'COM_MAPYANDEX_OPENMODAL' ); ?>
						</a></div></div>
				</div>
			</div>
			

			
			<div class="control-group dispcoords" <?php echo $stylecoo;?>>
				<div class="control-label">
				<?php echo JHTML::tooltip(JText::_( 'COM_MAPYANDEX_COORDS_DESCRIPTION' ), JText::_( 'COM_MAPYANDEX_LNG_AND_LAT' ), '', JText::_( 'COM_MAPYANDEX_LNG_AND_LAT' ), 
               false);?>
				</div>
				<div class="controls">
			 <input type="text" id="latitude" name="latitude_map_yandex" value="<?php echo $latitude;?>">
				 <input type="text" id="longitude" name="longitude_map_yandex" value="<?php echo $longitude;?>">
				</div>
			</div>
			
			
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_YMZOOM' ); ?>
				</div>
				<div class="controls">
						<?php 
					
						$statez[] = JHTML::_('select.option','1', JText::_( '1' ) );
						$statez[] = JHTML::_('select.option','2', JText::_( '2' ) );
						$statez[] = JHTML::_('select.option','3', JText::_( '3' ) );
						$statez[] = JHTML::_('select.option','4', JText::_( '4' ) );
						$statez[] = JHTML::_('select.option','5', JText::_( '5' ) );
						$statez[] = JHTML::_('select.option','6', JText::_( '6' ) );
						$statez[] = JHTML::_('select.option','7', JText::_( '7' ) );
						$statez[] = JHTML::_('select.option','8', JText::_( '8' ) );
						$statez[] = JHTML::_('select.option','9', JText::_( '9' ) );
						$statez[] = JHTML::_('select.option','10', JText::_( '10' ) );
						$statez[] = JHTML::_('select.option','11', JText::_( '11' ) );
						$statez[] = JHTML::_('select.option','12', JText::_( '12' ) );
						$statez[] = JHTML::_('select.option','13', JText::_( '13' ) );
						$statez[] = JHTML::_('select.option','14', JText::_( '14' ) );
						$statez[] = JHTML::_('select.option','15', JText::_( '15' ) );
						$statez[] = JHTML::_('select.option','16', JText::_( '16' ) );
						$statez[] = JHTML::_('select.option','17', JText::_( '17' ) );
						echo JHTML::_('select.genericlist',  $statez, $name = 'yandexzoom', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexzoom, $idtag = false, $translate = false );
					?>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
						<?php echo JText::_( 'COM_MAPYANDEX_YMELIS' ); ?>:
				</div>
				<div class="controls">
					<?php 
					
						$stateb[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
						$stateb[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
						echo JHTML::_('select.genericlist',  $stateb, $name = 'yandexbutton', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexbutton, $idtag = false, $translate = false );
					?>
				</div>
			</div>
			
		<?php
		if($this->foobar->yandexbutton == 2) {
			$styleel = 'style="display:none;"';
		}
		?>
			<div class="control-group elyandex" <?php echo $styleel;?>>
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_WHATEL' ); ?>
				</div>
				<div class="controls">

					<?php 
						$attribs	= 'multiple="multiple"';
						$statem[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_TOOLS' ) );
						$statem[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_MINIMAP' ) );
						$statem[] = JHTML::_('select.option','3', JText::_( 'COM_MAPYANDEX_TYPEOFMAP' ) );
						$statem[] = JHTML::_('select.option','4', JText::_( 'COM_MAPYANDEX_SEARCH' ) );
						$statem[] = JHTML::_('select.option','5', JText::_( 'COM_MAPYANDEX_ZOOM' ) );
						
					
						
						echo JHTML::_('select.genericlist',  $statem, $name = 'yandexel[]', $attribs, $key = 'value', $text = 'text', $selected = $el, $idtag = false, $translate = false );
					?>
				</div>
			</div>
			
			
			<div class="control-group">
				<div class="control-label">
							<?php echo JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_MAP' ); ?>
				</div>
				<div class="controls">
					<?php 
						$attribs	= '';
						$defmap = array();
						$defmap[] = JHTML::_('select.option','map', JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_SCHEME' ) );
						$defmap[] = JHTML::_('select.option','satellite', JText::_( 'COM_MAPYANDEX_SPUTNIC' ) );
						$defmap[] = JHTML::_('select.option','hybrid', JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_GYBRID' ) );
						$defmap[] = JHTML::_('select.option','publicMap', JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_PEOPLE' ) );
						$defmap[] = JHTML::_('select.option','publicMapHybrid', JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_SPUTNIC_PEOPLE' ) );

					
						
						echo JHTML::_('select.genericlist',  $defmap, $name = 'defaultmap', $attribs, $key = 'value', $text = 'text', $selected = $this->foobar->defaultmap, $idtag = false, $translate = false );
					?>
				</div>
			</div>
			
			
	<!-- Map Here-->
			<div class="control-group">

				
		<div id="editcell">
			<div id="YMapsID" style="height:<?php echo $this->foobar->height_map_yandex;?>px; width:<?php echo $this->foobar->width_map_yandex;?>px;"></div>
			
			<div id="info"></div>

		</div>
			
			</div>
			
			

				<!-- TEXT AND STYLE OF MAP-->
			<div class="control-group">

					<?php echo $this->form->getInput('text_map_yandex'); ?>
		
			</div>

	
				<!-- TEXT AND STYLE OF MAP-->
			<div class="control-group">
				<div class="control-label">
				<?php echo JText::_( 'COM_MAPYANDEX_WHERE_TEXT_MAP_YANDEX' ); ?>:		
				</div>
				<div class="controls">

			<?php 
			
				$statet[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_NO' ) );
				$statet[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_BEFOREMAP' ) );
				$statet[] = JHTML::_('select.option','3', JText::_( 'COM_MAPYANDEX_AFTERMAP' ) );
				echo JHTML::_('select.genericlist',  $statet, $name = 'where_text', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->where_text, $idtag = false, $translate = false );
			?>
				</div>
			</div>


			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_TEXTATG' ); ?>:	
				</div>
				<div class="controls">

<textarea name="misil" rows="5"><?php echo $this->untextnl($this->foobar->misil);?></textarea>
				</div>
			</div>

			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_TEXTTAGONCLICK' ); ?>:
				</div>
				<div class="controls">

			<textarea name="misilonclick" rows="5"><?php echo $this->untextnl($this->foobar->misilonclick);?></textarea>
				</div>
			</div>

			<div class="control-group">
				<div class="control-label">
				<?php echo JText::_( 'COM_MAPYANDEX_YMISBORDER' ); ?>:
				</div>
				<div class="controls">

			
			<?php 
			
				$state[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$state[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $state, $name = 'yandexborder', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexborder, $idtag = false, $translate = false );
			?>
				</div>
			</div>
	
	
			<div class="control-group">
				<div class="control-label">
				<?php echo JText::_( 'COM_MAPYANDEX_YMCOLORBORDER' ); ?>:
				</div>
				<div class="controls">

			
			<input type="text" name="color_map_yandex" value="<?php echo $this->foobar->color_map_yandex;?>" style="margin:0 0 10px 0px;">
			<div class="clr"></div>
			<div id="colorSelector"><div style="background-color: #<?php echo $this->foobar->color_map_yandex;?>"></div></div>
				</div>
			</div>
			
			
				
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'COM_MAPYANDEX_CBORDER' ); ?>:
				</div>
				<div class="controls">


					<?php 
					
						$statec[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
						$statec[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
						echo JHTML::_('select.genericlist',  $statec, $name = 'bradius', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->bradius, $idtag = false, $translate = false );
					?>
				</div>
			</div>
			
			<div class="control-group">
				<div class="control-label">
						<?php echo JText::_( 'COM_MAPYANDEX_CENTERBORDER' ); ?>:
				</div>
				<div class="controls">


			<?php 
			
				$statecen[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$statecen[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $statecen, $name = 'center_map_yandex', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->center_map_yandex, $idtag = false, $translate = false );
			?>
				</div>
			</div>

			
			</fieldset>


<?php

echo '</div>'. "\n";
?>
  	

	
<?php
echo '<div class="tab-pane" id="publishing">'."\n"; 

?>



			<?php foreach($this->form->getFieldset('map_settings') as $field) {

				echo '<div class="control-group">';
				if (!$field->hidden) {
					echo '<div class="control-label">'.$field->label.'</div>';
				}
			echo '<div class="controls">';
	echo $field->input;
	echo '</div></div>';

			} ?>


			<?php foreach($this->form->getFieldset('map_settings_baloon') as $field) {

				echo '<div class="control-group">';
				if (!$field->hidden) {
					echo '<div class="control-label">'.$field->label.'</div>';
				}
			echo '<div class="controls">';
	echo $field->input;
	echo '</div></div>';

			} ?>
		

			<?php foreach($this->form->getFieldset('map_settings_user') as $field) {

				echo '<div class="control-group">';
				if (!$field->hidden) {
					echo '<div class="control-label">'.$field->label.'</div>';
				}
			echo '<div class="controls">';
	echo $field->input;
	echo '</div></div>';

			} ?>
		


 
	<div id="autozoom"><p>Для данного участка карты максимальный масштаб - "<span></span>". Устанавливать масштаб больше чем "<span></span>" нет смысла! У Вас установлено "<span></span>". Если отключить опцию автоматического масштабирования и установить масштаб равный "<span></span>" или менье этого значения карта будет отображатся плавно и быстрее!</p></div>

	<div id="autozoomno"><p>Рекомендуется отключить опцию автоматического масштабирования для быстрого и плавного отображения карты! </p></div>
	




	
<?php

echo '</div>'. "\n";
?>

	<div class="clr" style="clear:both;"></div>
</div>
<input type="hidden" name="option" value="com_mapyandex" />
<input type="hidden" name="id" value="<?php echo $this->foobar->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="map" />

		</fieldset>
		</div>
	</div>
	<!-- End Sidebar -->
</form>