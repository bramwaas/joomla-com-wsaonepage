<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * 19-8-2021
 */
namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Field;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\Utilities\ArrayHelper;


/**
 * wsamenutype Form Field class for the Wsaonepage component
 *
 * @since  0.0.1
 */
class WsamenutypeField extends ListField
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Wsamenutype';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
 		$db    = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,menutype,title,description');
		$query->from('#__menu_types');
		$db->setQuery((string) $query);
		$menutypes = $db->loadObjectList();
		$options  = array();
 
		if ($menutypes)
		{
		    foreach ($menutypes as $menutype)
			{
			    $options[] = HTMLHelper::_('select.option', $menutype->menutype, $menutype->menutype . ' :' . $menutype->title . ' ' . $menutype->description );
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}