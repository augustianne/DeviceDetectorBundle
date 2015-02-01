<?php

namespace Yan\Bundle\DeviceDetectorBundle\Tests\Unit\Utility;

use \Exception;

use Yan\Bundle\DeviceDetectorBundle\Utility\ControllerUtility;

class ControllerUtilityTest extends \PHPUnit_Framework_TestCase
{

    public function getDataForGetControllerAction()
    {
        return array(
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
                'indexAction'
            ),
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                'InvalidArgumentException'
            ),
            array(
                'DefaultController::indexAction',
                'indexAction'
            ),
        );    
    }

    public function getDataForGetControllerClass()
    {
        return array(
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController'
            ),
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                'InvalidArgumentException'
            ),
            array(
                'DefaultController::indexAction',
                'DefaultController'
            ),
        );    
    }

    public function getDataForGetNewController()
    {
        return array(
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController::indexAction'
            ),
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Backend\DefaultController::indexAction',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Backend\DefaultController::indexAction'
            )
        );    
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Utility/ControllerUtility::getControllerAction
     * @dataProvider getDataForGetControllerAction
     */
    public function testGetControllerAction($value1, $expected)
    {
        $sut = new ControllerUtility();

        try {
            $this->assertEquals($expected, $sut->getControllerAction($value1));
        } catch (\Exception $e) {
            $this->assertEquals($expected, get_class($e));
        }
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Utility/ControllerUtility::getControllerClass
     * @dataProvider getDataForGetControllerClass
     */
    public function testGetControllerClass($value1, $expected)
    {
        $sut = new ControllerUtility();

        try {
            $this->assertEquals($expected, $sut->getControllerClass($value1));
        } catch (\Exception $e) {
            $this->assertEquals($expected, get_class($e));
        }
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Utility/ControllerUtility::getNewController
     * @dataProvider getDataForGetNewController
     */
    public function testGetNewController($value1, $value2, $value3, $expected)
    {
        $sut = new ControllerUtility();

        $this->assertEquals($expected, $sut->getNewController($value1, $value2, $value3));
    }
    
}
