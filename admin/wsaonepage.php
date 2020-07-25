<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-wsaonepage {background-image: url(../media/com_wsaonepage/images/Tux-16x16.png);}');


// Get an instance of the controller prefixed by WsaOnePage
$controller = JControllerLegacy::getInstance('WsaOnePage');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();