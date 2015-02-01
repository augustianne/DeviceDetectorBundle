<?php

/*
 * This file is part of DeviceDetectorBundle.
 *
 * Yan Barreta <augustianne.barreta@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yan\Bundle\DeviceDetectorBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetector;
use Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetectorConfiguration;
use Yan\Bundle\DeviceDetectorBundle\Utility\ControllerUtility;

/**
* Listener for switching to mobile controllers
*
* @author  Yan Barreta
* @version dated: Dec 1, 2014 4:56:36
*/
class DeviceListener
{
    private $utility;
    private $detector;
    private $configuration;
    private $container;

    public function __construct(DeviceDetector $detector, DeviceDetectorConfiguration $configuration, ControllerUtility $utility, ContainerInterface $container)
    {
        $this->utility = $utility;
        $this->detector = $detector;
        $this->configuration = $configuration;
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $userAgent = $request->headers->get('user-agent');

        if ($this->detector->allowMobileRouting() && $this->detector->isMobile($userAgent)) {
            $this->reroute($event, $this->configuration->getMobileControllers());
        }

        if ($this->detector->allowTabletRouting($event) && $this->detector->isTablet($userAgent)) {
            $this->reroute($event, $this->configuration->getTabletControllers());
        }
    }

    public function reroute(FilterControllerEvent $event, $params)
    {
        $request = $event->getRequest();
        
        $route = $request->get('_route');
        $controller = $request->get('_controller');

        foreach ($params as $param) {
            $fromControllerPath = $param['from_controller_path'];
            $toControllerPath = $param['to_controller_path'];
            $routes = $param['routes'];

            if (
                $this->detector->isRouteListed($route, $routes) && 
                $this->detector->isControllerRoutable($controller, $fromControllerPath)
            ) {
                
                $controllerAction = $this->utility->getControllerAction($controller);
                $controllerClass = $this->utility->getControllerClass($controller);
                $newControllerClass = $this->utility->getNewController(
                    $controllerClass, $fromControllerPath, $toControllerPath
                );

                $newController = new $newControllerClass();
                $newController->setContainer($this->container);

                $event->setController(array($newController, $controllerAction));
            }
        }
    }
}