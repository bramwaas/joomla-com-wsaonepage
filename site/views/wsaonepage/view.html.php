<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\MVC\View\HtmlView;

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class WsaOnePageViewWsaOnePage extends HtmlView
{
	/**
	 * Display the One Page view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
	    $this->menutype = $this->get('Menutype');
	    
	    // Check for errors.
	    if (count($errors = $this->get('Errors')))
	    {
	        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
	        
	        return false;
	    }
	    
	    
		// Display the view
		parent::display($tpl);
	}
}