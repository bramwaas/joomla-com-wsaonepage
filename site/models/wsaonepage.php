<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\MVC\Model\BaseDatabaseModel;  // JModelLegacy
// use Joomla\CMS\MVC\Model\ItemModel; //JModelItem
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * One Page Model
 *
 * @since  0.0.1
 */
class WsaOnePageModelWsaOnePage extends BaseDatabaseModel
{
	/**
	 * @var string message
	 */
	protected $message;

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array())
	{
	    return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * Get the message
         *
	 * @return  string  The message to be displayed to the user
	 */
	public function getMsg()
	{
		if (!isset($this->message))
		{
		    $jinput = JFactory::getApplication()->input;
		    $id     = $jinput->get('id', 1, 'INT');
		    
		    switch ($id)
		    {
		        case 2:
		            $this->message = 'Good bye World!';
		            break;
		        default:
		        case 1:
		            $this->message = 'Hello World!';
		            break;
		    }
		}

		return $this->message;
	}
}