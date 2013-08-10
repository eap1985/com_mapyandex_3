<?php 
/*
 * @package Joomla 3.x
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
?>
<?php 
$document = JFactory::getDocument();
$script ='
	Joomla.submitbutton = function(task)
	{
	
			var form = document.adminForm;
			
			if (task == "mapyandexallmaps.cancel") {
				submitform( task );
				return;
			}
			// do field validation
			if (form.name_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_NAME_MAP", true ).'" );
			}
			else if (form.city_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_CITY", true ).'" );
			
			} else if (form.street_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_STREET", true ).'" );
			}
			else {
				Joomla.submitform(task, document.getElementById("adminForm"));
			}
	}
';
$document->addScriptDeclaration($script);
?>
  	<form action="index.php" method="post" name="adminForm" id="adminForm">	





	<?php $document->addStyleSheet(JURI::root(true).'/media/com_mapyandex/colorpicker/css/colorpicker.css');?>
	<?php $document->addStyleSheet(JURI::root(true).'/media/com_mapyandex/colorpicker/css/layout.css');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/colorpicker.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/eye.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/utils.js');?>
	<?php $document->addScript(JURI::root(true).'/media/com_mapyandex/colorpicker/js/layout.js?ver=1.0.2');
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


		if (!empty($this->foobar->id_map_yandex)) {
			$this->foobar->id_map_yandex = $this->foobar->id_map_yandex;
		} else  {
			$this->foobar->id_map_yandex = $this->tmpl['apikey'];
		}


	
	?>

<?php

if($this->foobar->yandexcoord == 1) {
	$stylecoo='style="display:none;"';
	$valone = 'var valone = "'.$this->foobar->city_map_yandex.', '.$this->foobar->street_map_yandex.'"';
	$latitude = '';
	$longitude = '';
} else if ($this->foobar->yandexcoord == 2){
	$stylead = 'style="display:none;"';
	$parsejson = json_decode($this->foobar->lng);
	$longitude = $parsejson->longitude_map_yandex;
	$latitude = $parsejson->latitude_map_yandex;
	$valone = 'var valone = "'.$longitude.', '.$latitude.'"';
} else {
	$stylecoo='style="display:none;"';
	$valone = 'var valone = "'.$this->foobar->city_map_yandex.', '.$this->foobar->street_map_yandex.'"';
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
});
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
			alert(form);
			if (pressbutton == "cancel") {

				return;
			}
			// do field validation
			if (form.name_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_NAME_MAP", true ).'" );
			}
			  else if (form.id_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_ID", true ).'" );
			} else if (form.city_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_CITY", true ).'" );
			
			} else if (form.street_map_yandex.value == "") {
				alert( "'.JText::_( "COM_MAPYANDEX_ERROR_STREET", true ).'" );
			}
	
			else {
				submitform( pressbutton );
			}
		}
		//-->';
	
$document->addScriptDeclaration($script);
?>

		<div class="span12">
<div class="span12 fltlft">

			
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MAPYANDEX_NEWYMAP' ); ?></legend>
				
	<div class="span5 fltlft">
		<table class="admintable">

		<tr>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_NAMEMAP' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
			 <input type="text" name="name_map_yandex" id="keyword" value="" />
			</td>
		</tr>
					
		<tr>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_YMZOOM' ); ?>:
				</label>
			</td>
			<td align="left">


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
			</td>
		</tr>
				
			
		<tr>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_YMELIS' ); ?>:
				</label>
			</td>
			<td align="left">


			<?php 
			
				$stateb[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$stateb[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $stateb, $name = 'yandexbutton', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexbutton, $idtag = false, $translate = false );
			?>
			</td>
		</tr>
		<?php

		if($this->foobar->yandexbutton == 2) {
			$styleel = 'style="display:none;"';
		}
		?>
		<tr class="elyandex" <?php echo $styleel;?>>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_WHATEL' ); ?>:
				</label>
			</td>
			<td align="left">

			<?php 
				$el = array(1,2,3,4,5);
				$attribs	= 'multiple="multiple"';
				$statem[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_SCALE' ) );
				$statem[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_MINIMAP' ) );
				$statem[] = JHTML::_('select.option','3', JText::_( 'COM_MAPYANDEX_SPUTNIC' ) );
				$statem[] = JHTML::_('select.option','4', JText::_( 'COM_MAPYANDEX_SEARCH' ) );
				$statem[] = JHTML::_('select.option','5', JText::_( 'COM_MAPYANDEX_ZOOM' ) );
				
			
				
				echo JHTML::_('select.genericlist',  $statem, $name = 'yandexel[]', $attribs, $key = 'value', $text = 'text', $selected = $el, $idtag = false, $translate = false );
			?>
			</td>
		<tr class="elyandex">
					<td align="left">
						<label for="foobar" style="min-width:100%;">
							<?php echo JText::_( 'COM_MAPYANDEX_DEFAULT_TYPE_MAP' ); ?>:
						</label>
					</td>
					<td align="left">
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
					</td>
			</tr>
			
														<tr>
					<td  align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_WIDTHMAP' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
				 <input type="text" name="width_map_yandex" value="<?php echo $this->foobar->width_map_yandex;?>">
			</td>
			</tr>
																	<tr>
					<td align="left" class="key">
				<label for="foobar" style="min-width:100%;" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_HEIGHTMAP' ); ?>:
				</label>
			</td>
								<td align="left">
				 <input type="text" name="height_map_yandex" value="<?php echo $this->foobar->height_map_yandex;?>">
			</td>
			</tr>
			</table>
	</div>
	<div class="span5 fltlft">
		<table class="admintable">	
			<tr>
					<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_MAPTAG' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
				 <input type="text" name="oblako_width_map_yandex" value="100">
			</td>
			</tr>

						<tr>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_AUTOZOOM' ); ?>:
				</label>
			</td>
			<td align="left">

			<?php 
			
				$statecoord[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$statecoord[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $statecoord, $name = 'autozoom', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->autozoom, $idtag = false, $translate = false );
			?>
			</td>
		</tr>

		<tr>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_METHOD_SEARCH' ); ?>:
				</label>
			</td>
			<td align="left">

			<?php 
			
				$search[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_ADRESS' ) );
				$search[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_COORD' ) );
				echo JHTML::_('select.genericlist',  $search, $name = 'yandexcoord', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexcoord, $idtag = false, $translate = false );
			?>
			</td>
		</tr>

		<tr class="dispadres" <?php echo $stylead;?>>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_CITY' ); ?>:
				</label>
			</td>
			<td align="left">
				 <input type="text" name="city_map_yandex" value="<?php echo $this->foobar->city_map_yandex;?>">
			</td>
		</tr>
			
			
		<tr class="dispadres" <?php echo $stylead;?>>
			<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_STREET' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
				 <input type="text" name="street_map_yandex" value="<?php echo $this->foobar->street_map_yandex;?>">
			</td>
		</tr>
		
			<tr class="dispcoords" <?php echo $stylecoo;?>>
					<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_COORDINATES' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
				<?php
					// define modal options
					$modalOptions = array (
					'size' => array('x' => 500, 'y' => 500)
					
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
				
			</td>
			</tr>
			
			

			<tr class="dispcoords" <?php echo $stylecoo;?>>
					<td align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_LNG' ); ?>:
				</label>
			</td>
								<td width="100" align="left">
				 <input type="text" id="latitude" name="latitude_map_yandex" value="<?php echo $latitude;?>">
				 <input type="text" id="longitude" name="longitude_map_yandex" value="<?php echo $longitude;?>">
			</td>
			</tr>
	

						
		
	</table>
	</div>
		</fieldset>
		

</div>

	<div class="span12 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MAPYANDEX_NEWYMAP' ); ?></legend>
				

		<table class="admintable" style="width:100%;">
			<tr>
			<td align="left">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_TEXTATG' ); ?>:
				</label>
				<div class="clr"></div>

			<textarea name="misil" rows="5" cols="50"></textarea>

			</td>
		</tr>
				<tr>
			<td align="left">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_TEXTTAGONCLICK' ); ?>:
				</label>
			<div class="clr"></div>

			<textarea name="misilonclick" rows="5" cols="50"><?php echo $this->foobar->misilonclick;?></textarea>

			</td>
		</tr>
		


								<tr>
			<td width="100" align="left" class="key">
				<label for="foobar" style="min-width:100%;">
					<?php echo JText::_( 'COM_MAPYANDEX_WHERE_TEXT_MAP_YANDEX' ); ?>:
				</label>


			<?php 
			
				$statet[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_NOT_USE' ) );
				$statet[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_BEFORE_MAP' ) );
				$statet[] = JHTML::_('select.option','3', JText::_( 'COM_MAPYANDEX_AFTER_MAP' ) );
				echo JHTML::_('select.genericlist',  $statet, $name = 'where_text', $attribs = null, $key = 'value', $text = 'text', $selected = 1, $idtag = false, $translate = false );
			?>
			</td>
		</tr>
		</table>		

	</div>

	<div class="span12 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MAPYANDEX_NEWYMAP' ); ?></legend>
				

		<table class="admintable" style="width:100%;">
			<tr>
				<td>
			<?php echo $this->form->getInput('text_map_yandex'); ?>
				</td>
			</tr>
		</table>		

	</div>

	<div class="span12 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_MAPYANDEX_NEWYMAP' ); ?></legend>
				

		<table class="admintable" style="width:100%;">
<tr>
			<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_YMISBORDER' ); ?>:
				</label>
			</td>
			<td align="left">

			<?php 
			
				$state[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$state[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $state, $name = 'yandexborder', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->yandexborder, $idtag = false, $translate = false );
			?>
			</td>
		</tr>
						<tr>
			<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_YMCOLORBORDER' ); ?>:
				</label>
			</td>
			<td align="left">
			<div id="colorSelector"><div style="background-color: #<?php echo $this->foobar->color_map_yandex;?>"></div>
			<input type="text" name="color_map_yandex" value="" style="margin-left: 50px;">
			</td>

		</tr>
		
								<tr>
			<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_CBORDER' ); ?>:
				</label>
			</td>
			<td align="left">


			<?php 
			
				$statec[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$statec[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $statec, $name = 'bradius', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->bradius, $idtag = false, $translate = false );
			?>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="left" class="key">
				<label for="foobar">
					<?php echo JText::_( 'COM_MAPYANDEX_CENTERBORDER' ); ?>:
				</label>
			</td>
			<td align="left">


			<?php 
			
				$statecen[] = JHTML::_('select.option','1', JText::_( 'COM_MAPYANDEX_YES' ) );
				$statecen[] = JHTML::_('select.option','2', JText::_( 'COM_MAPYANDEX_NO' ) );
				echo JHTML::_('select.genericlist',  $statecen, $name = 'center_map_yandex', $attribs = null, $key = 'value', $text = 'text', $selected = $this->foobar->center_map_yandex, $idtag = false, $translate = false );
			?>
			</td>
		</tr>
		</table>		

	</div>

</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_mapyandex" /> 
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="savenew" />
<input type="hidden" name="controller" value="mapyandexallmaps" />
</form>