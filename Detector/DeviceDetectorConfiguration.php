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

/**
* Class for bundle configuration
*
* @author  Yan Barreta
* @version dated: Jan 7, 2015 2:27:58 PM
*/
class DeviceDetectorConfiguration
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Checks config if mobile is enabled
     *
     * @param void
     * @return boolean
     */
    public function isMobileDeviceRoutingEnabled()
    {
        return $this->container->getParameter('device_detector.mobile.enabled');
    }

    /**
     * Checks config if tablet device is to be treated as mobile device
     *
     * @param void
     * @return boolean
     */
    public function treatTabletDevicesAsMobile()
    {
        return $this->container->getParameter('device_detector.tablet.treat_as_mobile');
    }

    /**
     * Checks config if tablet is enabled
     *
     * @param void
     * @return boolean
     */
    public function isTabletDeviceRoutingEnabled()
    {
        return $this->container->getParameter('device_detector.tablet.enabled');
    }

    /**
     * Checks config for mobile controllers and returns them
     *
     * @param void
     * @return Array
     */
    public function getMobileControllers()
    {
        return $this->container->getParameter('device_detector.mobile.controllers');
    }

    /**
     * Checks config for tablet controllers and returns them
     *
     * @param void
     * @return Array
     */
    public function getTabletControllers()
    {
        return $this->container->getParameter('device_detector.tablet.controllers');
    }

    /**
     * Retrieves cookie name for override cookie 
     *
     * @param void
     * @return string
     */
    public function getOverrideCookieName()
    {
        return $this->container->getParameter('device_detector.override_cookie');
    }

    /**
     * Retrieves cookie name for override cookie 
     *
     * @param void
     * @return string
     */
    public function hasOverrideCookie()
    {
        $session = $this->container->get('session');

        return $session->has($this->getOverrideCookieName());
    }
       
}