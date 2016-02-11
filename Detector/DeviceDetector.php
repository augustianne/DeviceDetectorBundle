<?php

/*
 * This file is part of DeviceDetectorBundle.
 *
 * Yan Barreta <augustianne.barreta@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yan\Bundle\DeviceDetectorBundle\Detector;

use Detection\MobileDetect;

use Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetectorConfiguration;

/**
* Detects device using MobileDetect
*
* @author  Yan Barreta
* @version dated: Dec 1, 2014 4:56:36
* @see https://github.com/serbanghita/Mobile-Detect
*/
class DeviceDetector extends MobileDetect
{

    private $configuration;

    public function __construct(DeviceDetectorConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Checks if device is mobile
     * Note: Mobile_Detect treats tablets as mobile
     * @return boolean
     */
    public function isMobile($userAgent = null, $httpHeaders = null)
    {
        $isMobile = parent::isMobile($userAgent, $httpHeaders);
        $isTablet = $this->isTablet($userAgent, $httpHeaders);
        
        if (!$this->configuration->treatTabletDevicesAsMobile()) {
            if ($isTablet) {
                return false;
            }
        }

        return $isMobile;
    }

    /**
     * Checks config if mobile routing is allowed.
     * Note: Mobile routing is allowed if mobile is enabled in config
     *
     * @param void
     * @return boolean
     */
    public function allowMobileRouting()
    {
        return $this->configuration->isMobileDeviceRoutingEnabled();
    }

    /**
     * Checks config if tablet routing is allowed.
     * Note: Tablet routing is allowed if tablet is enabled and tablet devices 
     *       are NOT treated as mobile
     *
     * @param void
     * @return boolean
     */
    public function allowTabletRouting()
    {
        return $this->configuration->isTabletDeviceRoutingEnabled() && 
            !$this->configuration->treatTabletDevicesAsMobile();
    }

    /**
     * Checks parameters passed if route is listed under reroutable routes
     *
     * @param String $route - current route of the request
     * @param Array $routes - list of routes allowed for rerouting
     * @return boolean
     */
    public function isRouteListed($route, $routes)
    {
        if (empty($route)) {
            return false;
        }

        return in_array($route, $routes);
    }

    /**
     * Checks parameters passed if controller can be rerouted
     *
     * @param String $controller - current controller of the request
     * @param String $path - pth of the controller to be rerouted
     * @return boolean
     */
    public function isControllerRoutable($controller, $path)
    {
        return (strpos($controller, $path) === 0);
    }

    /**
     * Checks if controller should override mobile detection and treat as desktop
     *
     * @param void
     * @return boolean
     */
    public function isOverrideMobile()
    {
        return $this->configuration->hasOverrideCookie();
    }
}
