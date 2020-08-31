<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\Factory;
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
	 * @var array menuitems
	 */
	protected $menuitems;
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
	    echo '<!-- getMenutype Table (menutype):', PHP_EOL;
	    print_r($table);
	    echo '-->', PHP_EOL;
	    return $this->menutypes[$id];
	}
	/**
	 * Module list
	 *
	 * @return  array
	 * from ModuleHelper getModuleList but with selection on array of Itemid's
	 * positive menuid include, negative menuid exclude, 0 for all menuid's
	 */
	public function getModulelist()
	{
	    
	    // Get the menuitems
	    $app = Factory::getApplication();
	    $sitemenu = $app->getMenu();
	    $menuItems = $sitemenu->getItems(array('menutype', 'language'),array($item->menutype, array('*', $item->language)) );
	    $this->menuitems = $menuItems;
	    $menuIds = array_column($this->menuitems, 'id');
    
	    if ($menuIds = array()) 
	    {
	        return array();
	    }
//	    $idlist = implode(',' , $menuIds) . ',0,-' . implode(',-' , $menuIds);
	    $idlist = implode(', ' , $menuIds) . ', 0';
	    $Itemid = $app->input->getInt('Itemid', 0);
	    $groups = implode(',', \JFactory::getUser()->getAuthorisedViewLevels());
	    $lang = \JFactory::getLanguage()->getTag();
	    $clientId = (int) $app->getClientId();
	    
	    // Build a cache ID for the resulting data object
	    $cacheId = $groups . $clientId . $Itemid;
	    
	    $db = \JFactory::getDbo();
	    
	    $query = $db->getQuery(true)
	    ->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid')
	    ->from('#__modules AS m')
	    ->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id')
	    ->where('m.published = 1')
	    ->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id')
	    ->where('e.enabled = 1');
	    
	    $date = \JFactory::getDate();
	    $now = $date->toSql();
	    $nullDate = $db->getNullDate();
	    $query->where('(m.publish_up = ' . $db->quote($nullDate) . ' OR m.publish_up <= ' . $db->quote($now) . ')')
	    ->where('(m.publish_down = ' . $db->quote($nullDate) . ' OR m.publish_down >= ' . $db->quote($now) . ')')
	    ->where('m.access IN (' . $groups . ')')
	    ->where('m.client_id = ' . $clientId)
	    ->where('(mm.menuid IN ' . $idlist . ')');
	    
	    // Filter by language
	    if ($app->isClient('site') && $app->getLanguageFilter())
	    {
	        $query->where('m.language IN (' . $db->quote($lang) . ',' . $db->quote('*') . ')');
	        $cacheId .= $lang . '*';
	    }
	    
	    if ($app->isClient('administrator') && static::isAdminMultilang())
	    {
	        $query->where('m.language IN (' . $db->quote($lang) . ',' . $db->quote('*') . ')');
	        $cacheId .= $lang . '*';
	    }
	    
	    $query->order('m.position, m.ordering');
	    
	    // Set the query
	    $db->setQuery($query);
	    
	    try
	    {
	        /** @var \JCacheControllerCallback $cache */
	        $cache = \JFactory::getCache('com_modules', 'callback');
	        
	        $modules = $cache->get(array($db, 'loadObjectList'), array(), md5($cacheId), false);
	    }
	    catch (\RuntimeException $e)
	    {
	        \JLog::add(\JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), \JLog::WARNING, 'jerror');
	        
	        return array();
	    }
	    
	    return $modules;
	}
	
	/**
	 * Clean the module list
	 *
	 * @param   array  $modules  Array with module objects
	 *
	 * @return  array without duplicates or excluded modules
	 * from ModuleHelper cleanModuleList but with selection on array of Itemid's
	 */
	public function cleanModuleList($modules, $menuIds = array())
	{
	    foreach ($menuIds as $Itemid)
	    {
	    // Apply negative selections and eliminate duplicates
	    $negId = $Itemid ? -(int) $Itemid : false;
	    $clean = array();
	    $dupes = array();
	    
	    foreach ($modules as $i => $module)
	    {
	        // The module is excluded if there is an explicit prohibition
	        $negHit = ($negId === (int) $module->menuid);
	        
	        if (isset($dupes[$module->id]))
	        {
	            // If this item has been excluded, keep the duplicate flag set,
	            // but remove any item from the modules array.
	            if ($negHit)
	            {
	                unset($clean[$Itemid][$module->id]);
	            }
	            
	            continue;
	        }
	        
	        $dupes[$module->id] = true;
	        
	        // Only accept modules without explicit exclusions.
	        if ($negHit)
	        {
	            continue;
	        }
	        
	        $module->name = substr($module->module, 4);
	        $module->style = null;
	        $module->position = strtolower($module->position);
	        
	        $clean[$Itemid][$module->id] = $module;
	    } // end end foreach ($modules
	    
	    unset($dupes);
	    } // end foreach ($menuIds
	    // Return to simple indexing that matches the query order.
	    return array_values($clean);
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
