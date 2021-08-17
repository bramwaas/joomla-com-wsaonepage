<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

 namespace WaasdorpSoekhan\Component\WsaOnePage\Administrator\Controller;

// No direct access
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;

/**
 * WsaOnepage Table class
 *
 * @since  0.0.1
 */
class WsaOnePageTable extends Table
{
	/**
	 * Constructor
	 *
	 * @param   DatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db) // TODO why &
	{
		parent::__construct('#__wsaonepage', 'id', $db);
		
		$this->created = Factory::getDate()->toSql();
//		$this->setColumnAlias('published', 'state');
		
	
	}
	/**
	 * Overloaded bind function
	 *
	 * @param       array           named array
	 * @return      null|string     null is operation was satisfactory, otherwise returns an error
	 * @see Table:bind
	 * @since 1.5
	 */
	public function bind($array, $ignore = '')
	{
	    if (isset($array['params']) && is_array($array['params']))
	    {
	        // Convert the params field to a string.
	        $registry = new Registry($array['params']);
	        $array['params'] = (string) $registry;
	    }
	    return parent::bind($array, $ignore);
	}
}

