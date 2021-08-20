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
 * wsaonepage Form Field class for the Wsaonepage component
 *
 * @since  0.0.1
 */
class WsaonepageField extends ListField
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Wsaonepage';

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
		$query->from('#__wsaonepage');
		$db->setQuery((string) $query);
		$wsaonepages = $db->loadObjectList();
		$options  = array();
 
		if (count($wsaonepages))
		{
		    foreach ($wsaonepages as $wsaonepage)
			{
			    $options[] = HTMLHelper::_('select.option', $wsaonepage->id,  $wsaonepage->title . ':' . $wsaonepage->description );
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}