<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace WaasdorpSoekhan\Component\Wsaonepage\Administrator\Rule;

\defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;

/**
 * FormRule for com_wsaonepage to make sure the email address is not blocked.
 *
 * @since  0.5.8
 */
class WsamenutypeRule extends FormRule
{
		/**
	 * The regular expression. Necessary if you use the parent test function.
	 *
	 * @access	protected
	 * @var		string
	 * @since	2.5
	 */
	protected $regex = '^[^0-9]+$';

	/**
	 * Method to test override/extend, not necessary here, we use only the regular expression that is already tested by the parent.
	 *
	 * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed              $value    The form field value to validate.
	 * @param   string             $group    The field name group control value. This acts as an array container for the field.
	 *                                       For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                       full field name would end up being "bar[foo]".
	 * @param   Registry           $input    An optional Registry object with the entire data set to validate against the entire form.
	 * @param   Form               $form     The form object for which the field is being tested.
	 *
	 * @return  boolean  True if the value is valid, false otherwise.
	 */
	 /*
	public function test(\SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		if (!parent::test($element, $value, $group, $input, $form))
		{
			return false;
		}

		$params = ComponentHelper::getParams('com_contact');
		$banned = $params->get('banned_email');

		if ($banned)
		{
			foreach (explode(';', $banned) as $item)
			{
				if ($item != '' && StringHelper::stristr($value, $item) !== false)
				{
					return false;
				}
			}
		}

		return true;
	}
	*/
}
