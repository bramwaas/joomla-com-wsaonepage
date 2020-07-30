<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\MVC\Model\BaseDatabaseModel;  // JModelLegacy
// use Joomla\CMS\MVC\Model\ItemModel; //JModelItem
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::register('WsaOnePageHelperRoute', JPATH_ROOT . '/components/com_wsaonepage/helpers/route.php');


/**
 * One Page Model
 *
 * @since  0.0.1
 */
class WsaOnePageModelWsaOnePage extends BaseDatabaseModel
{
    /**
     * @var object item
     */
    protected $item;
    /**
	 * @var string message
	 */
	protected $message;
	/**
	 * @var array menutypes
	 */
	protected $menutypes;
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	2.5
	 */
	protected function populateState()
	{
	    // Get the message id
	    $jinput = JFactory::getApplication()->input;
	    $this->setState('wsaonepage.id', $jinput->get('id', 1, 'INT'));  
	    
	    // Load the parameters.
	    $this->setState('params', JFactory::getApplication()->getParams());
	    parent::populateState();
	}
	/**
	 * Get the wsaonepage Item
	 * @return object The message to be displayed to the user
	 */
	public function getItem()
	{
	    if (!isset($this->item))
	    {
	        $id    = $this->getState('wsaonepage.id');
	        $db    = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        $query->select('h.id, h.asset_id, h.created, h.created_by, h.title, h.alias, h.language, h.description, h.menutype, h.description, h.published, h.params, c.title as category')
	        ->from('#__wsaonepage as h')
	        ->leftJoin('#__categories as c ON h.catid=c.id')
	        ->where('h.id=' . (int)$id);
	        
	        if (JLanguageMultilang::isEnabled())
	        {
	            $lang = JFactory::getLanguage()->getTag();
	            $query->where('h.language IN ("*","' . $lang . '")');
	        }
	        
	        $db->setQuery((string)$query);
	        
	        if ($this->item = $db->loadObject())
	        {
	            // Load the JSON string
	            $params = new JRegistry;
	            $params->loadString($this->item->params, 'JSON');
	            $this->item->params = $params;
	            
	            // Merge global params with item params
	            $params = clone $this->getState('params');
	            $params->merge($this->item->params);
	            $this->item->params = $params;
	            
	        }
	        else
	        {
	            throw new Exception('WsaOnePage id not found', 404);
	        }
	    }
	    return $this->item;
	}
	
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
	public function getTable($type = 'WsaOnePage', $prefix = 'WsaOnePageTable', $config = array())
	{
	    return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Get the Menutype
	 *
	 * @param   integer  $id   Id of the menutype
	 * 
	 * @return  string  Fetched String from Table for relevant Id
	 */
	public function getMenutype($id = 1 )
	{
	    if (!is_array($this->menutypes))
	    {
	        $this->menutypes = array();
	    }
	    
	    if (!isset($this->menutypes[$id]))
	    {
	        // Request the selected id
	        $jinput = JFactory::getApplication()->input;
	        $id     = $jinput->get('id', 1, 'INT');
	        
	        // Get a WsaOnePage instance
	        $table = $this->getTable();
	        
	        // Load the menutype
	        $table->load($id);
	        
	        // Assign the menutype
	        $this->menutypes[$id] = $table->menutype;
	    }
	    
	    return $this->menutypes[$id];
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