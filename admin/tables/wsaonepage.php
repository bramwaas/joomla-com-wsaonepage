<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Table\Table;
/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class WsaOnePageTableWsaOnePage extends Table
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__wsaonepage', 'id', $db);
	}
}