<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 *23-8-2021
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
/**
 *  @var WaasdorpSoekhan\Component\Wsaonepage\Administrator\View\Wsaonepages\HtmlView; $this
 *  The class where this template is apart of
 */

// TODO replaced by code from com_contact mayby changes in HtmlView necessary  
//$listOrder     = $this->escape($this->filter_order);
//$listDirn      = $this->escape($this->filter_order_Dir);

HTMLHelper::_('behavior.multiselect');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$canEdit = TRUE; // TODO for later use
$canEditOwn= TRUE; // TODO for later use
// end TODO



?>
<form action="<?php echo Route::_('index.php?option=com_wsaonepage&view=wsaonepages'); ?>" method="post" id="adminForm" name="adminForm">
	<div class="row">
	<!-- div id="j-sidebar-container" class="span2" -->
		<?php //TODO removed in all examples echo JHtmlSidebar::render(); ?>
	<!-- /div -->
	<div id="j-main-container" class="col-md-12">
				<?php
				// Search tools bar
				echo LayoutHelper::render('joomla.searchtools.default', ['view' => $this]);
				?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-info">
						<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
						<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>

                	<table class="table" id="wsaonepageList">
                						<caption class="visually-hidden">
                							<?php echo Text::_('COM_WSAONEPAGE_N_TABLE_CAPTION'); ?>,
                							<span id="orderedBy"><?php echo Text::_('JGLOBAL_SORTED_BY'); ?> </span>,
                							<span id="filteredBy"><?php echo Text::_('JGLOBAL_FILTERED_BY'); ?></span>
                						</caption>
                		<thead>
                		<tr>
                			<th class="w-1 text-center">
                				<?php echo HTMLHelper::_('grid.checkall'); ?>
                			</th>
                			<th scope="col" class=" text-center d-none d-md-table-cell">
                				<?php echo HTMLHelper::_('searchtools.sort', 'COM_WSAONEPAGE_TITLE', 'title', $listDirn, $listOrder); ?>
                			</th>
                			<th scope="col" class="w-30 text-center d-none d-md-table-cell">
                				<?php echo HTMLHelper::_('searchtools.sort', 'COM_WSAONEPAGE_MENUTYPE', 'menutype', $listDirn, $listOrder); ?>
                			</th>
                                <th scope="col" class="w-15 text-center d-none d-md-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_WSAONEPAGE_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                                </th>
                			<th scope="col" class="w-5 text-center d-none d-md-table-cell">
                				<?php echo HTMLHelper::_('searchtools.sort', 'COM_WSAONEPAGE_PUBLISHED', 'published', $listDirn, $listOrder); ?>
                			</th>
                			<th scope="col" class="w-2 text-center d-none d-md-table-cell">
                				<?php echo HTMLHelper::_('searchtools.sort', 'COM_WSAONEPAGE_ID', 'id', $listDirn, $listOrder); ?>
                			</th>
                		</tr>
                		</thead>
                		<tbody>
                			<?php if (!empty($this->items)) : ?>
                				<?php foreach ($this->items as $i => $row) :
                				$link = Route::_('index.php?option=com_wsaonepage&task=wsaonepage.edit&id=' . $row->id);
                				?>
                
            					<tr>
            						<td>
            							<?php echo HTMLHelper::_('grid.id', $i, $row->id); ?>
            						</td>
            						<td class="text-center small d-none d-md-table-cell">
                    					<?php if ($canEdit || $canEditOwn) : ?>
    									<a href="<?php echo $link; ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($row->title); ?>">
    										<?php echo $this->escape($row->title); ?></a>
    									<?php else : ?>
    										<span title="<?php echo Text::sprintf('JFIELD_ALIAS_LABEL', $this->escape($row->alias)); ?>"><?php echo $this->escape($row->title); ?></span>
    									<?php endif; ?>
    									<div class="small break-word">
    										<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($row->alias)); ?>
    									</div>
                    							
                    							
                    				</td>
                					<td class="text-center d-none d-md-table-cell">
            							<?php echo $row->menutype; ?>
            						</td>
                                        <td class="small text-center d-none d-md-table-cell">
                                            <?php echo LayoutHelper::render('joomla.content.language', $row); ?>
                                        </td>
            						<td class="small text-center d-none d-md-table-cell">
            							<?php echo HTMLHelper::_('jgrid.published', $row->published, $i, 'wsaonepages.', true, 'cb'); ?>
            						</td>
            						<td class="small text-center d-none d-md-table-cell">
            							<?php echo $row->id; ?>
            						</td>
            					</tr>
                				<?php endforeach; ?>
                			<?php endif; ?>
                		</tbody>
            	</table>
					<?php // Load the pagination. ?>
					<?php echo $this->pagination->getListFooter(); ?>


				<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo HTMLHelper::_('form.token'); ?>
	</div>
	
	</div>
	
</form>