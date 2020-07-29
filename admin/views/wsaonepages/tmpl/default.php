<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\Registry\Registry;

JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_wsaonepage&view=wsaonepages" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
	<div id="j-main-container" class="span10">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_WSAONEPAGE_WSAONEPAGES_FILTER'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_WSAONEPAGE_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="45%">
				<?php echo JHtml::_('searchtools.sort', 'COM_WSAONEPAGE_WSAONEPAGE_TITLE', 'title', $listDirn, $listOrder); ?>
			</th>
			<th width="30%">
				<?php echo JHtml::_('searchtools.sort', 'COM_WSAONEPAGE_WSAONEPAGES_MENUTYPE', 'menutype', $listDirn, $listOrder); ?>
			</th>
                <th width="15%">
                    <?php echo JHtml::_('searchtools.sort', 'COM_WSAONEPAGE_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                </th>
			<th width="5%">
				<?php echo JHtml::_('searchtools.sort', 'COM_WSAONEPAGE_PUBLISHED', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('searchtools.sort', 'COM_WSAONEPAGE_ID', 'id', $listDirn, $listOrder); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
				$link = JRoute::_('index.php?option=com_wsaonepage&task=wsaonepage.edit&id=' . $row->id);
				?>

					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_WSAONEPAGE_EDIT_WSAONEPAGE'); ?>">
							<?php echo $row->title; ?>
							</a>
						</td>
						<td>
							<?php echo $row->menutype; ?>
						</td>
                            <td align="center">
                                <?php echo JLayoutHelper::render('joomla.content.language', $row); ?>
                            </td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->published, $i, 'wsaonepages.', true, 'cb'); ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>