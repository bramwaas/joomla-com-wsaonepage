<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   Copyright (C) 2005 - 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */
namespace WaasdorpSoekhan\Component\WsaOnePage\Administrator\Field;
// No direct access to this file
\defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\Utilities\ArrayHelper;

JFormHelper::loadFieldClass('list');

/**
 * wsaMenutype Form Field class for the WsaOnePage component
 *
 * @since  0.0.1
 */
class WsaMenutypeField extends ListField
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'WsaMenutype';

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
			    $options[] = JHtml::_('select.option', $menutype->menutype, $menutype->menutype . ' :' . $menutype->title . ' ' . $menutype->description );
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}