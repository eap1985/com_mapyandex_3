<?php 
/*
 * @package Joomla 3.0
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @component Yandex Map Component
 * @copyright Copyright (C) Aleksandr Ermakov www.slyweb.ru
 */
defined('_JEXEC') or die('Restricted access'); 
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
?>

<form action="<?php JRoute::_('index.php?option=com_mapyandex'); ?>" method="post" name="adminForm">
	<div id="j-sidebar-container" class="span2">
<?php echo JHtmlSidebar::render(); ?>
</div>
<div id="j-main-container" class="span10">
<div class="adminform">
<div class="pga-cpanel">
	<div id="cpanel">
	<fieldset id="filter-bar">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_MAPYANDEX_SEARCH_IN_TITLE'); ?>" />
			</div>
		<div class="btn-group pull-left hidden-phone">
		<button class="btn tip hasTooltip" type="submit" title="<?php JText::_('COM_MAPYANDEX_SEARCH');?>"><i class="icon-search"></i></button>
		<button class="btn tip hasTooltip" type="button" onclick="document.id('filter_search').value='';this.form.submit();"
		 title="<?php JText::_('COM_MAPYANDEX_SUB');?>"><i class="icon-remove"></i></button>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<?php echo $this->pageNav->getLimitBox(); ?>
		</div>
	</fieldset>
<div id="editcell">
    <table class="table table-striped">
    <thead>
        <tr>
            <th width="5">
                <?php echo JText::_( 'COM_MAPYANDEX_ID' ); ?>
            </th>

            <th width="20">
                <input type="checkbox" name="checkall-toggle" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" value="" onclick="Joomla.checkAll(this);" />
            </th>
			<th width="200">
                <?php echo JText::_( 'COM_MAPYANDEX_NAMEMAP' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'COM_MAPYANDEX_DESCRIPTIONOFTAG' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'COM_MAPYANDEX_HITS' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'COM_MAPYANDEX_YMCODE' ); ?>
            </th>
			<th>
                <?php echo JText::_( 'COM_MAPYANDEX_REGIONS_COUNT' ); ?>
            </th>
        </tr>            
    </thead>
    <?php
    $k = 0;

    for ($i=0, $n=count( $this->allroute ); $i < $n; $i++)
    {
        $row =& $this->allroute[$i];
        $checked    = JHTML::_( 'grid.id', $i, $row->id );
        $link = JRoute::_( 'index.php?option=com_mapyandex&view=mapyandexregion&layout=form&id='. $row->id );
		
        ?>
        <tr class="<?php echo "row$k"; ?>">
		    <td>
                <?php echo $row->id; ?>
            </td>

            <td>
              <?php echo $checked; ?>
            </td>
			            <td>
               <a href="<?php echo $link; ?>"><?php echo $row->name_map_yandex; ?></a> 
            </td>
            <td>
                <a href="<?php echo $link; ?>"><?php echo (!empty($row->misil)) ? $row->misil : JText::_( 'COM_MAPYANDEX_NO_DESCRIPTION' ); ?></a>
            </td>
			<td>
                <?php echo $row->hits; ?>
            </td>
			<td>
                <?php echo '{mapyandex_id='.$row->id.'}' ?>
            </td>
			<td>
                <?php 
					
					$region = json_decode($row->region_map_yandex);
					echo (!empty($region)) ? count($region) : 0;
				
				?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
<tr>
	<td colspan="7"><?php echo $this->pageNav->getListFooter(); ?></td>
</tr>
    </table>

</div>
 
<input type="hidden" name="option" value="com_mapyandex" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="mapyandexallmaps" />
<input type="hidden" name="view" value="mapyandexregion" />
<?php echo JHtml::_('form.token'); ?>
</form>

