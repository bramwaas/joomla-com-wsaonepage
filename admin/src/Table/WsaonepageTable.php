<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 20210919     several changes after com_tags.TagTable
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Table;

// No direct access
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Versioning\VersionableTableInterface;
use Joomla\Database\DatabaseDriver;
use Joomla\String\StringHelper;


/**
 * WsaOnepage Table class
 *
 * @since  0.0.1
 */
class WsaonepageTable extends Table implements VersionableTableInterface
{
    /**
     * An array of key names to be json encoded in the bind function (replaces overload bind function)
     *
     * @var    array
     * @since  4.0.0 (0.9.2)
     */
    protected $_jsonEncode = ['params', 'metadata', 'urls', 'images'];
    
    /**
     * Indicates that columns fully support the NULL value in the database
     *
     * @var    boolean
     * @since  4.0.0 (0.9.2)
     */
    protected $_supportNullValue = true;
       
	/**
	 * Constructor
	 *
	 * @param   DatabaseDriver  $db  A database connector object
	 */
	function __construct($db) // TODO why &db
	{
	    $this->typeAlias = 'com_wsaonepage.wsaonepage';
		parent::__construct('#__wsaonepage', 'id', $db);
//		JObserverMapper::addObserverClassToClass('TableObserverContenthistory', 'WsaonepageTable', array('typeAlias' => 'com_wsaonepage.wsaonepage'));
	
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
	    
	    if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0))
	    {
	        $this->setError(Text::_('COM_WSAONEPAGE_ERROR_UNIQUE_ALIAS'));
	        
	        return false;
	    }
	    
	    return parent::store($updateNulls);
	}
	/**
	 * Overloaded check function
	 *
	 * @return  boolean  True on success, false on failure
	 *
	 * @see     Table::check
	 * @since   1.5
	 */
	public function check()
	{
	    try
	    {
	        parent::check();
	    }
	    catch (\Exception $e)
	    {
	        $this->setError($e->getMessage());
	        
	        return false;
	    }
	    
	    $this->default_con = (int) $this->default_con;
	    
/*
 	    if (\JFilterInput::checkAttribute(array('href', $this->webpage)))
	    {
	        $this->setError(Text::_('COM_CONTACT_WARNING_PROVIDE_VALID_URL'));
	        
	        return false;
	    }
*/	 	    
	    // Check for valid title
	    if (trim($this->title) == '')
	    {
	        $this->setError(Text::_('COM_WSAONEPAGE_WARNING_PROVIDE_VALID_TITLE'));
	        
	        return false;
	    }
   
	    // Generate a valid alias
	    $this->generateAlias();
	    
	    // Sanity check for user_id
	    if (!$this->user_id)
	    {
	        $this->user_id = 0;
	    }
	    
	    // Check the publish down date is not earlier than publish up.
	    if ((int) $this->publish_down > 0 && $this->publish_down < $this->publish_up)
	    {
	        $this->setError(Text::_('JGLOBAL_START_PUBLISH_AFTER_FINISH'));
	        
	        return false;
	    }
	    
	    if (!$this->id)
	    {
	        // Hits must be zero on a new item
	        $this->hits = 0;
	    }
	    
	    // Clean up description -- eliminate quotes and <> brackets
	    if (!empty($this->metadesc))
	    {
	        // Only process if not empty
	        $badCharacters = array("\"", '<', '>');
	        $this->metadesc = StringHelper::str_ireplace($badCharacters, '', $this->metadesc);
	    }
	    else
	    {
	        $this->metadesc = '';
	    }
	    if (empty($this->hits))
	    {
	        $this->hits = 0;
	    }
	    
	    if (empty($this->params))
	    {
	        $this->params = '{}';
	    }
	    
	    if (empty($this->metadata))
	    {
	        $this->metadata = '{}';
	    }
	    
	    // Set publish_up, publish_down to null if not set
	    if (!$this->publish_up)
	    {
	        $this->publish_up = null;
	    }
	    
	    if (!$this->publish_down)
	    {
	        $this->publish_down = null;
	    }
	    
	    if (!$this->modified)
	    {
	        $this->modified = $this->created;
	    }
	    
	    if (empty($this->modified_by))
	    {
	        $this->modified_by = $this->created_by;
	    }
	    
	    return true;
	}
	
	/**
	 * Generate a valid alias from title / date.
	 * Remains public to be able to check for duplicated alias before saving
	 *
	 * @return  string
	 */
	public function generateAlias()
	{
	    if (empty($this->alias))
	    {
	        $this->alias = $this->title;
	    }
	    
	    $this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
	    
	    if (trim(str_replace('-', '', $this->alias)) == '')
	    {
	        $this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
	    }
	    
	    return $this->alias;
	}
	
	/**
	 * Get the type alias for the history table
	 *
	 * @return  string  The alias as described above
	 *
	 * @since   4.0.0
	 */
	public function getTypeAlias()
	{
	    return $this->typeAlias;
	}
	
}

