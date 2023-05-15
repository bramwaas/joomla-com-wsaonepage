<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2021 - 2023 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 20210825     rewritten for Joomla 4 after example of contact. Joomla\Database\ParameterType replaced by \PDO
 * 20230515     removed most references to category.
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Site\Service;
\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\CMS\Language\Multilanguage;
use Joomla\Database\DatabaseInterface;

class Router extends RouterView
{
    /**
     * Flag to remove IDs
     *
     * @var    boolean
     */
    protected $noIDs = false;
    /**
     * The db
     *
     * @var DatabaseInterface
     *
     * @since  4.0.0
     */
    private $db;
    /**
     * Content Component router constructor
     *
     * @param   SiteApplication           $app              The application object
     * @param   AbstractMenu              $menu             The menu object to work with
     * @param   CategoryFactoryInterface  $categoryFactory  The category object
     * @param   DatabaseInterface         $db               The database object
     */
    public function __construct(SiteApplication $app, AbstractMenu $menu, CategoryFactoryInterface $categoryFactory, DatabaseInterface $db)
    {
        $this->db              = $db;
        
        $params = ComponentHelper::getParams('com_wsaonepage');
        $this->noIDs = (bool) $params->get('sef_ids');
        $onepage = new RouterViewConfiguration('wsaonepage');
        $onepage->setKey('id');
        $this->registerView($onepage);
        $form = new RouterViewConfiguration('form');
        $form->setKey('id');
        $this->registerView($form);
        
        parent::__construct($app, $menu);
        
        $this->attachRule(new MenuRules($this));
        $this->attachRule(new StandardRules($this));
        $this->attachRule(new NomenuRules($this));
    }
    /**
     * Method to get the segment(s) for a wsaonepage from id
     *
     * @param   string  $id     ID of the contact to retrieve the segments for
     * @param   array   $query  The request that is built right now
     *
     * @return  array|string  The segments of this item
     */
    public function getWsaonepageSegment($id, $query)
    {
        if (!strpos($id, ':')){
            $id = (int) $id;
            $dbquery = $this->db->getQuery(true);
            $dbquery->select($this->db->quoteName('alias'))
            ->from($this->db->quoteName('#__wsaonepage'))
            ->where($this->db->quoteName('id') . ' = :id')
            ->bind(':id', $id, \PDO::INTEGER);
            $this->db->setQuery($dbquery);
            
            $id .= ':' . $this->db->loadResult();
        }
        
        if ($this->noIDs){
            list($void, $segment) = explode(':', $id, 2);
            
            return array($void => $segment);
        }
        
        return array((int) $id => $id);
    }
    /**
     * Method to get the segment(s) for a form
     *
     * @param   string  $id     ID of the contact form to retrieve the segments for
     * @param   array   $query  The request that is built right now
     *
     * @return  array|string  The segments of this item
     *
     * @since   4.0.0
     */
    public function getFormSegment($id, $query)
    {
        return $this->getWsaonepageSegment($id, $query);
    }
    /**
     * Method to get the segment(s) for a Wsaonepage from alias.
     *
     * @param   string  $segment  Segment of the contact to retrieve the ID for
     * @param   array   $query    The request that is parsed right now
     *
     * @return  mixed   The id of this item or false
     */
    public function getWsaonepageId($segment, $query)
    {
        if ($this->noIDs){
            $dbquery = $this->db->getQuery(true);
            $dbquery->select($this->db->quoteName('id'))
            ->from($this->db->quoteName('#__wsaonepage'))
            ->where($this->db->quoteName('alias') . ' = :alias')
            ->bind(':alias', $segment);
            $this->db->setQuery($dbquery);
            return (int) $this->db->loadResult();
        }
        return (int) $segment;
    }
}