<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2020 - 2020 AHC Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use \Joomla\CMS\MVC\Model\ListModel;

/**
 * WsaOnePageList Model
 *
 * @since  0.0.1
 */
class WsaOnePageModelWsaOnePages extends ListModel
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
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
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')
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
                    $query->where('published = ' . (int) $published);
                }
                elseif ($published === '')
                {
                    $query->where('(published IN (0, 1))');
                }
                // Filter by language, if the user has set that in the filter field
                $language = $this->getState('filter.language');
                if ($language)
                {
                    $query->where('a.language = ' . $db->quote($language));
                }
                
                // Add the list ordering clause.
                $orderCol	= $this->state->get('list.ordering', 'title');
                $orderDirn 	= $this->state->get('list.direction', 'asc');
                
                $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
                
                return $query;
	}
}