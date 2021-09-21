<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 *14-8-2021
 */

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<form action="<?php echo Route::_('index.php?option=com_wsaonepage&view=wsaonepages'); ?>" method="post" name="adminForm" id="adminForm">

	<div class="px-4 py-5 my-5 text-center">
		<span class="fa-8x icon-address-book contact mb-4" aria-hidden="true"></span>
		<h1 class="display-5 fw-bold"><?php echo Text::_('COM_WSAONEPAGE_EMPTYSTATE_TITLE'); ?></h1>
		<div class="col-lg-6 mx-auto">
			<p class="lead mb-4">
				<?php echo Text::_('COM_WSAONEPAGE_EMPTYSTATE_CONTACT'); ?>
			</p>
			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
				<a href="<?php echo Route::_('index.php?option=com_wsaonepage&view=wsaonepage&layout=edit'); ?>" class="btn btn-primary btn-lg px-4 me-sm-3"><?php echo Text::_('COM_WSAONEPAGE_EMPTYSTATE_BUTTON_ADD'); ?></a>
				<a href="https://docs.joomla.org/Special:MyLanguage/Help4.x:Contacts" class="btn btn-outline-secondary btn-lg px-4"><?php echo Text::_('COM_WSAONEPAGE_EMPTYSTATE_BUTTON_LEARNMORE'); ?></a>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="">
	<input type="hidden" name="boxchecked" value="0">
</form>