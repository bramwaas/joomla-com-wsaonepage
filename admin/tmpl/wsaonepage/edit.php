<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * included in class  WaasdorpSoekhan\Component\Wsaonepage\Administrator\View\Wsaonepage\HtmlView
 * 11-8-2021 changed after similar changes J3.5 to J4 from com_banner and com_contact.
 * 17-9-2021 changed after simlpifying the form after example of com_tags.
 * 17-5-2023 changes work after changing xml name in forms (and WsaonpageModel.php) to wsaonepage_4edit.xml
 */
//
// No direct access
\defined('_JEXEC') or die('Restricted access');

//use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;


/**
 *  @var WaasdorpSoekhan\Component\Wsaonepage\Administrator\View\Wsaonepage\HtmlView; $this
 *  The class where this template is part of
 */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa
 * seems to be used from J4 Beta1 29-6-2021 eg in com_banner replacing HTMLHelper::_('behavior.formvalidator'); HTMLHelper::_('behavior.keepalive') etc.;
 * */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
->useScript('form.validate');

// Fieldsets to not automatically render by /layouts/joomla/edit/params.php
$this->ignore_fieldsets = ['jmetadata', 'details','item_associations'];
$this->useCoreUI = true;



?>
<form action="<?php echo Route::_('index.php?option=com_wsaonepage&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="wsaonepage-form" class="form-validate">
	<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>
	
    <div class="main-card">
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'details', 'recall' => true, 'breakpoint' => 768]); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_WSAONEPAGE_DETAILS')); ?>
            <div class="row">
                <div class="col-lg-8">
					<fieldset class="form-vertical">
					<legend class="visually-hidden">Details</legend>
					<div class="control-group">
					<div class="control-label">
					<?php echo $this->form->getLabel('menutype'); ?>
					</div>
					<?php echo $this->form->getInput('menutype'); ?>
					</div>
					<div class="control-group">
					<div class="control-label">
					<?php echo $this->form->getLabel('description'); ?>
					</div>
					<?php echo $this->form->getInput('description'); ?>
					</div>
					</fieldset>
                </div>
				<div class="col-lg-4" data-class=" <?php echo get_class($this); ?>   ">
					<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
				</div>
            </div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php  echo LayoutHelper::render('joomla.edit.params', $this);   ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row">
			<div class="col-12 col-lg-6">
				<fieldset id="fieldset-publishingdata" class="options-form">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></legend>
				<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
				</fieldset>
			</div>
			<div class="col-12 col-lg-6">
				<fieldset id="fieldset-metadata" class="options-form">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></legend>
				<?php  echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
				</fieldset>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>


    </div>
    <input type="hidden" name="task" value="" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>