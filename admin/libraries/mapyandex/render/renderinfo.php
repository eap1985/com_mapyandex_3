<?php defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.filesystem.folder' );

class MapYandexRenderInfo { function getPhocaIc($output){
	
	$v = MapYandexRenderInfo::getYndexMapVersion(); $i = str_replace('.', '',substr($v, 0, 3)); $n = '<p>&nbsp;</p>'; $l = 'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'s'.'l'.'y'.'w'.'e'.'b'.'.'.'r'.'u'.'/'; $p = 'S'.'l'.'y'.'w'.'e'.'b'; $im = 'i'.'c'.'o'.'n'.'-'.'s'.'l'.'y'.'w'.'e'.'b'.'-'.'l'.'o'.'g'.'o'.'-'.'s'.'m'.'a'.'l'.'l'.'.'.'p'.'n'.'g'; $s = 's'.'t'.'y'.'l'.'e'.'='.'"'.'t'.'e'.'x'.'t'.'-'.'d'.'e'.'c'.'o'.'r'.'a'.'t'.'i'.'o'.'n'.':'.'n'.'o'.'n'.'e'.'"'; $b = 't'.'a'.'r'.'g'.'e'.'t'.'='.'"'.'_'.'b'.'l'.'a'.'n'.'k'.'"'; $im2 = 'i'.'c'.'o'.'n'.'-'.'s'.'l'.'y'.'w'.'e'.'b'.'-'.'l'.'o'.'g'.'o'.'-'.'s'.'e'.'a'.'l'.'.'.'p'.'n'.'g'; $i = (int)$i * (int)$i; $lg = ''; if ($output != $i) {
		$lg .= $n; $lg .= '<div style="text-align:center">';
	} if ($output == 1) {
		$lg .= '<a href="'.$l.'" '.$s.' '.$b.' title="'.$p.'">'. JHTML::_('image', 'components/com_mapyandex/assets/images/'.$im, $p). '</a>'; $lg .= ' <a href="http://www.slyweb.ru/" '.$s.' '.$b.' title="'.$p.'">'. $v .'</a>';
	} else if ($output == 2 || $output == 3) {
		$lg .= '<a  href="'.$l.'" '.$s.' '.$b.' title="'.$p.'">'. JHTML::_('image', 'components/com_mapyandex/assets/images/'.$im, $p). '</a>';
	} else if ($output == 4) {
		$lg .= ' <a href="'.$l.'" '.$s.' '.$b.' title="'.$p.'">Phoca Gallery</a>';
	} else if ($output == 5) {
		$lg .= ' <a href="'.$l.'" '.$s.' '.$s.' '.$b.' title="'.$p.'">'.$p.' '.$v.'</a>';
	} else if ($output == 6) {
		$lg .= ' <a href="'.$l.'" '.$s.' '.$b.' title="'.$p.'">'. JHTML::_('image', 'components/com_phocagallery/assets/images/'.$im2, $p). '</a>';
	} else if ($output == $i) {
		$lg .= '<!-- <a href="'.$l.'">site: www.slyweb.ru | version: '.$v.'</a> -->';
	} else { $lg .= '<a href="'.$l.'" '.$s.' '.$b.' title="'.$p.'">'. JHTML::_('image', 'components/com_mapyandex/assets/images/'.$im, $p). '</a>'; $lg .= ' <a href="http://www.slyweb.ru/" '.$s.' '.$b.' title="'.$p.'">'. $v .'</a>';
	} if ($output != $i) {
		$lg .= '</div>' . $n;
	} return $lg;
} 

static function getYndexMapVersion() {
	$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_mapyandex'; if (JFolder::exists($folder)) {
		$xmlFilesInDir = JFolder::files($folder, '.xml$');
	} else { $folder = JPATH_SITE .DS. 'components'.DS.'com_mapyandex'; if (JFolder::exists($folder)) {
		$xmlFilesInDir = JFolder::files($folder, '.xml$');
	} else { $xmlFilesInDir = null;
	}
	} $xml_items = array(); if (count($xmlFilesInDir)) {
		foreach ($xmlFilesInDir as $xmlfile) {
			if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
				foreach($data as $key => $value) {
					$xml_items[$key] = $value;
				}
			}
		}
	} if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
		return $xml_items['version'];
	} else { return '';
	}
}
}

?>