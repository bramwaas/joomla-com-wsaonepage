<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2021 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 17-8-2021
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Model;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');

//use Joomla\CMS\Component\ComponentHelper;
//use Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\ListModel;

/**
 * WsaonepageList Model
 *
 * @since  0.0.1
 */
class WsaonepagesModel extends ListModel
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     \Joomla\CMS\MVC\Controller\BaseController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id',
                'menutype',
                'title',
                'created',
                'language',
                'published'
            );
        }
        
        parent::__construct($config);
    }
    
    /**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);
//		$user  = Factory::getUser();
		
//		$params = ComponentHelper::getParams('com_wsaonepage');
		
		// Create the base select statement.
		$query->select('a.id as id, a.title as title, a.menutype as menutype, a.description as description,
                         a.published as published, a.created as created, a.alias as alias, a.language as language')
                ->from($db->quoteName('#__wsaonepage', 'a'));

/*                 // Join over the categories.
                $query->select($db->quoteName('c.title', 'category_title'))
                ->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.catid');
                
                // Join with users table to get the username of the author
                $query->select($db->quoteName('u.username', 'author'))
                ->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = a.created_by');
 */                
                // Join with languages table to get the language title and image to display
                // Put these into fields called language_title and language_image so that
                // we can use the little com_content layout to display the map symbol
                $query->select($db->quoteName('l.title', 'language_title') . "," .$db->quoteName('l.image', 'language_image'))
                ->join('LEFT', $db->quoteName('#__languages', 'l') . ' ON l.lang_code = a.language');
                
                // Filter: like / search
                $search = $this->getState('filter.search');
                
                if (!empty($search))
                {
                    $like = $db->quote('%' . $search . '%');
                    $query->where('menutype LIKE ' . $like);
                }
                
                // Filter by published state
                $published = $this->getState('filter.published');
                
                if (is_numeric($published))
                {
                    $query->where('a.published = ' . (int) $published);
                }
                elseif ($published === '')
                {
                    $query->where('(a.published IN (0, 1))');
                }
                // Filter by language, if the user has set that in the filter field
                $language = $this->getState('filter.language');
                if ($language)
                {
                    $query->where('a.language = ' . $db->quote($language));
                }
                
                // Add the list ordering clause.
                $orderCol	= $this->state->get('list.ordering', 'a.title');
                $orderDirn 	= $this->state->get('list.direction', 'asc');
                
                $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
                
                return $query;
	}
}