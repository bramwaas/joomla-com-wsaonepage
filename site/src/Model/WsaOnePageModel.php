<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 20200901 component modules at position-7 and 8 added
 * 20210806 adaptations for Joomla 4.0
 */
namespace WaasdorpSoekhan\Component\WsaOnePage\Site\Model;
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel; // of ItemModel;  ItemModel is almost the same as BaseDatabaseModel; it just has an extra getStoreId() method which is relevant when you have a component and/or several modules sharing the same model and you want to distinguish between data sets relevant to each.
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;


JLoader::register('WsaOnePageHelperRoute', JPATH_ROOT . '/components/com_wsaonepage/helpers/route.php');


/**
 * One Page Model
 *
 * @since  0.5.0
 */
class WsaOnePageModel extends BaseDatabaseModel
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
	 * @var array $positions
	 */
	protected $positions = "'position-7','position-8'";
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
	    $jinput = Factory::getApplication()->input;
	    $this->setState('wsaonepage.id', $jinput->get('id', 1, 'INT'));  
	    
	    // Load the parameters.
	    $this->setState('params', Factory::getApplication()->getParams());
	    parent::populateState();
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
	    return Table::getInstance($type, $prefix, $config);
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
	        $db    = Factory::getDbo();
	        $query = $db->getQuery(true);
	        $query->select('h.id, h.asset_id, h.created, h.created_by, h.title, h.alias, h.language, h.description, h.menutype, h.description, h.published, h.params, c.title as category')
	        ->from('#__wsaonepage as h')
	        ->leftJoin('#__categories as c ON h.catid=c.id')
	        ->where('h.id=' . (int)$id);
	        
	        if (JLanguageMultilang::isEnabled())
	        {
	            $lang = Factory::getLanguage()->getTag();
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
	 * Get the menuitems
	 *
	 * @return  array of menuitems  
	 */
	public function getMenuitems()
	{
	    if (!isset($this->menuitems))
	    {
	        // Get the menuitems
	        $app = Factory::getApplication();
	        $sitemenu = $app->getMenu();
	        $menuItems = $sitemenu->getItems(array('menutype', 'language'),array($this->item->menutype, array('*', $item->language)) );
	        $this->menuitems = $menuItems;
	    }
	    
	    return $this->menuitems;
	}
	
	/**
	 * Module list
	 *
	 * @return  array
	 * from ModuleHelper getModuleList but with selection on array of menuid's
	 * and only position-7 and position-8
	 * positive menuid include only this, negative menuid exclude this include all others, 0 include all menuid's
	 * getMenuitems should be executed before this method to fill the menuitems.
	 * only components and components refered to by an alias can have modules.
	 * 
	 */
	public function getModulelist()
	{
	    
	    $app = Factory::getApplication();
	    $menuIds = array();
	    foreach ($this->menuitems as $menuitem)
	    {
	        if ($menuitem->type == 'component') {$menuIds[] = $menuitem->id;}
	        elseif ($menuitem->type == 'alias')
	        {       $aliasToId = $menuitem->params->get('aliasoptions');
	        $mItm = $app->getMenu()->getItem($aliasToId);
	        $menuIds[] = $mItm->id;
	        }
	        
	    }
	    if ($menuIds == array()) 
	    {
	        return array();
	    }
	    $idlist = implode(',' , $menuIds);
	    $groups = implode(',', Factory::getUser()->getAuthorisedViewLevels());
	    $lang = Factory::getLanguage()->getTag();
	    $clientId = (int) $app->getClientId();
	    
	    // Build a cache ID for the resulting data object
	    $cacheId = $groups . $clientId . $idlist;
	    
	    $db = Factory::getDbo();
	    
	    $query = $db->getQuery(true)
	    ->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid')
	    ->from('#__modules AS m')
	    ->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id')
	    ->where('m.published = 1')
	    ->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id')
	    ->where('e.enabled = 1');
	    
	    $date = Factory::getDate();
	    $now = $date->toSql();
	    $nullDate = $db->getNullDate();
	    $query->where('(m.publish_up = ' . $db->quote($nullDate) . ' OR m.publish_up <= ' . $db->quote($now) . ')')
	    ->where('(m.publish_down = ' . $db->quote($nullDate) . ' OR m.publish_down >= ' . $db->quote($now) . ')')
	    ->where('m.access IN (' . $groups . ')')
	    ->where('m.client_id = ' . $clientId)
	    ->where('m.position IN (' . $this->positions . ')')
	    ->where('(mm.menuid IN (' . $idlist . ') OR mm.menuid <= 0)');
	    
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
	        $cache = Factory::getCache('com_modules', 'callback');
	        
	        $modules = $cache->get(array($db, 'loadObjectList'), array(), md5($cacheId), false);
	    }
	    catch (\RuntimeException $e)
	    {
	        \JLog::add(\Text::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), \JLog::WARNING, 'jerror');
	        
	        return array();
	    }
	    
	    return $this->cleanModuleList($modules, $menuIds);
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
	    // Apply negative selections and eliminate duplicates
	    $clean = array();
	    $dupes = array();
	    
	    foreach ($modules as $i => $module)
	    {
	        $module->position = strtolower($module->position);
	        $module->name = substr($module->module, 4);
	        $module->style = null;

	        if ($module->menuid > 0)
	        {
	            if (!isset($dupes[$module->menuid][$module->position][$module->id]))
	            {
	                $clean[$module->menuid][$module->position][$module->id] = $module;
	                $dupes[$module->menuid][$module->position][$module->id] = true;
	            }
	        }
	        else // ($module->menuid <= 0)
	        {
	            foreach ($menuIds as $menuId)
	            {
	                if (-(int) $module->menuid != $menuId)
	                {
	                    if (!isset($dupes[$menuId][$module->position][$module->id]))
	                   {
	                       $clean[$menuId][$module->position][$module->id] = $module;
	                       $dupes[$menuId][$module->position][$module->id] = true;
	                   }
	                } else 
	                {
	                    unset($clean[$menuId][$module->position][$module->id]);
	                    $dupes[$menuId][$module->position][$module->id] = true;
	                }
	                
	            } // end foreach ($menuIds
	        }
	        
	    } // end end foreach ($modules
	    
	    unset($dupes);
	    return $clean;
	}
	
}
