<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 20-8-2021 copied from com_banners and adapted after mywalks component.
 */

namespace WaasdorpSoekhan\Component\WsaOnePage\Administrator\Extension;

\defined('JPATH_PLATFORM') or die;

//use Joomla\CMS\Categories\CategoryServiceInterface;
//use Joomla\CMS\Categories\CategoryServiceTrait;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
//use Joomla\CMS\Tag\TagServiceInterface;
//use Joomla\CMS\Tag\TagServiceTrait;
//use WaasdorpSoekhan\Component\WsaOnePage\Administrator\Service\Html\AdministratorService;
use Psr\Container\ContainerInterface;  // TODO find a way to solve this eclipse error

/**
 * Component class for com_wsaonepage
 *
 * @since  0.7.1  (Joomla 4.0.0)
 */
class WsaOnePageComponent extends MVCComponent implements BootableExtensionInterface,  RouterServiceInterface
{
	use HTMLRegistryAwareTrait;
	use RouterServiceTrait;
	
	/**
	 * Booting the extension. This is the function to set up the environment of the extension like
	 * registering new class loaders, etc.
	 *
	 * If required, some initial set up can be done from services of the container, eg.
	 * registering HTML services.
	 *
	 * @param   ContainerInterface  $container  The container
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function boot(ContainerInterface $container)
	{
	  //  $this->getRegistry()->register('wsaonepageadministrator', new AdministratorService);
	}

}
