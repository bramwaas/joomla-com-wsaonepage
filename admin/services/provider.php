<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_wsaonepage
 *
 * @copyright   (C) 2021 A.H.C. Waasdorp. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Association\AssociationExtensionInterface;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
//use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\Service\Provider\CategoryFactory;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\HTML\Registry;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use WaasdorpSoekhan\Component\Wsaonepage\Administrator\Extension\WsaonepageComponent;
// use WaasdorpSoekhan\Component\Wsaonepage\Administrator\Helper\AssociationsHelper;

/**
 * The content service provider.
 *
 * @since  0.5.1  (J4.0.0)
 */
return new class implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   0.5.1
     */
    public function register(Container $container): void {
        $container->registerServiceProvider(new CategoryFactory('\\WaasdorpSoekhan\\Component\\Wsaonepage'));
        $container->registerServiceProvider(new MVCFactory('\\WaasdorpSoekhan\\Component\\Wsaonepage'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\WaasdorpSoekhan\\Component\\Wsaonepage'));
        $container->registerServiceProvider(new RouterFactory('\\WaasdorpSoekhan\\Component\\Wsaonepage'));
        
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new WsaonepageComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setRegistry($container->get(Registry::class));
//                $component->setCategoryFactory($container->get(CategoryFactoryInterface::class));
// TODO work needed to define WsaonepageComponent::setCategoryFactory()
//                $component->setAssociationExtension($container->get(AssociationExtensionInterface::class));
// TODO work needed to define WsaonepageComponent::setAssociationExtension()
                
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));
                
                
                
                
                return $component;
            }
        );
    }
};
