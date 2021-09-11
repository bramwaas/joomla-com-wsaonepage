<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Table;

// No direct access
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;

/**
 * WsaOnepage Table class
 *
 * @since  0.0.1
 */
class WsaonepageTable extends Table
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
	/**
	 * Stores a wsaonepage.
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success, false on failure.
	 *
	 * @since   0.9.0 
	 */
	public function store($updateNulls = true)
	{
	    $date   = Factory::getDate()->toSql();
	    $userId = Factory::getUser()->id;
	    
	    // Set created date if not set.
	    if (!(int) $this->created)
	    {
	        $this->created = $date;
	    }
	    
	    if ($this->id)
	    {
	        // Existing item
	        $this->modified_by = $userId;
	        $this->modified    = $date;
	    }
	    else
	    {
	        // Field created_by field can be set by the user, so we don't touch it if it's set.
	        if (empty($this->created_by))
	        {
	            $this->created_by = $userId;
	        }
	        
	        if (!(int) $this->modified)
	        {
	            $this->modified = $date;
	        }
	        
	        if (empty($this->modified_by))
	        {
	            $this->modified_by = $userId;
	        }
	    }
	    
	    // Verify that the alias is unique
	    $table = Table::getInstance('WsaonepageTable', __NAMESPACE__ . '\\', array('dbo' => $this->getDbo()));
	    
	    if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
	    {
	        $this->setError(Text::_('COM_WSAONEPAGE_ERROR_UNIQUE_ALIAS'));
	        
	        return false;
	    }
	    
	    return parent::store($updateNulls);
	}
	
}

