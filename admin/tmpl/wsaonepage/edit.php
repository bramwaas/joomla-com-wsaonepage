<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
  * @copyright   Copyright (C) 2005 - 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 11-8-2021 changed after similar changes J3.5 to J4 from com_banner and com_contact.
 */
// 
// No direct access
\defined('_JEXEC') or die('Restricted access');

//use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

// JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html'); seems not to be necessary in J4 
/**
 *  @var WaasdorpSoekhan\Component\WsaOnePage\Administrator\View\WsaOnePage\HtmlView; $this
 *  The class where this template is part of
 */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa 
 * seems to be used from J4 Beta1 29-6-2021 eg in com_banner replacing HTMLHelper::_('behavior.formvalidator'); HTMLHelper::_('behavior.keepalive') etc.;
 * */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

// TODO formbehavior.chosen changed in  ->enableAsset('choicesjs') at the moment unclear what happens to the arguments text::script ... ?
/* not found in com_banner looking for an other example incom_contact remove without replacement so replacement starred out
    HTMLHelper::_('formbehavior.chosen', '#jform_catid', null, array('disable_search_threshold' => 0 ));
    HTMLHelper::_('formbehavior.chosen', 'select');
 */
 /*   
    Text::script('JGLOBAL_SELECT_NO_RESULTS_MATCH');
    Text::script('JGLOBAL_SELECT_PRESS_TO_SELECT');
  
$wa->getWebAssetManager()->enableAsset('choicesjs');
    HTMLHelper::_('webcomponent', 'system/webcomponents/joomla-field-fancy-select.min.js', ['version' => 'auto', 'relative' => true]);
 */   
    

?>
<form action="<?php echo Route::_('index.php?option=com_wsaonepage&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="wsaonepage-form" class="form-validate">
	<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>
    <div class="main-card">
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_WSAONEPAGE_WSAONEPAGE_DETAILS')); ?>
            <div class="row">
                <div class="col-lg-9">
					<?php echo $this->form->renderFieldset('wsaonepagedetails'); ?>
                </div>
				<div class="col-lg-3">
					<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
				</div>
            </div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>





		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'params', Text::_('COM_WSAONEPAGE_GROUP_LABEL_WSAONEPAGE_DETAILS')); ?>
			<fieldset id="fieldset-params" class="options-form">
				<legend><?php echo Text::_('COM_WSAONEPAGE_GROUP_LABEL_WSAONEPAGE_DETAILS'); ?></legend>
				<div>
				<?php echo $this->form->renderFieldset('params'); ?>
				</div>
			</fieldset>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>
		
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>


    </div>
    <input type="hidden" name="task" value="wsaonepage.edit" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>