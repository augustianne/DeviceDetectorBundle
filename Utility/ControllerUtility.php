<?php

/*
 * This file is part of DeviceDetectorBundle.
 *
 * Yan Barreta <augustianne.barreta@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yan\Bundle\DeviceDetectorBundle\Utility;

use \InvalidArgumentException;

/**
* Class for bundle configuration
*
* @author  Yan Barreta
* @version dated: Jan 7, 2015 2:27:58 PM
*/
class ControllerUtility
{

    /**
     * Returns the controller action after parsing valid controller passed
     *
     * @param String - Valid controller
     * @return boolean
     */
    public function getControllerAction($controller)
    {
        $parts = explode('::', $controller);

        if (count($parts) != 2) {
            throw new InvalidArgumentException('Controller passed is not valid.');
        }

        return end($parts);
    }

    /**
     * Returns the controller action after parsing valid controller passed
     *
     * @param String - Valid controller
     * @return boolean
     */
    public function getControllerClass($controller)
    {
        $parts = explode('::', $controller);

        if (count($parts) != 2) {
            throw new InvalidArgumentException('Controller passed is not valid.');
        }

        return current($parts);
    }

    /**
     * Returns the new controller path given the old controller and the new path
     *
     * @param String - Valid controller
     * @return boolean
     */
    public function getNewController($controller, $fromControllerPath, $toControllerPath)
    {
        return str_replace($fromControllerPath, $toControllerPath, $controller);
    }
}