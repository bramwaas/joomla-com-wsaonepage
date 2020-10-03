<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 28-9-2020
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('jquery.framework');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', '#jform_catid', null, array('disable_search_threshold' => 0 ));
JHtml::_('formbehavior.chosen', 'select');
// TODO from banners is this usefull?

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "wsaonepage.cancel" || document.formvalidator.isValid(document.getElementById("wsaonepage-form")))
		{
			Joomla.submitform(task, document.getElementById("wsaonepage-form"));
		}
	};
	jQuery(document).ready(function ($){
		$("#jform_type").on("change", function (a, params) {
    
			var v = typeof(params) !== "object" ? $("#jform_type").val() : params.selected;
    
			var img_url = $("#image, #url");
			var custom  = $("#custom");
    
			switch (v) {
				case "0":
					// Image
					img_url.show();
					custom.hide();
					break;
				case "1":
					// Custom
					img_url.hide();
					custom.show();
					break;
			}
		}).trigger("change");
	});
');

?>
<form action="<?php echo JRoute::_('index.php?option=com_wsaonepage&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="wsaonepage-form" class="form-validate">
    <div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_WSAONEPAGE_WSAONEPAGE_DETAILS')); ?>
            <div class="row-fluid">
                <div class="span9">
					<?php echo $this->form->renderFieldset('details'); ?>
                </div>
				<div class="span3">
					<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
				</div>
            </div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>





		<?php //echo JHtml::_('bootstrap.addTab', 'myTab', 'otherparams', JText::_('COM_WSAONEPAGE_GROUP_LABEL_WSAONEPAGE_DETAILS')); ?>
		<?php //echo $this->form->renderFieldset('otherparams'); ?>
		<?php //echo JHtml::_('bootstrap.endTab'); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
			<div class="span6">
				<?php echo $this->form->renderFieldset('metadata'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>


    </div>
    <input type="hidden" name="task" value="wsaonepage.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>