<?php

namespace Yan\Bundle\DeviceDetectorBundle\Tests\Unit\Detector;

use Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetectorConfiguration;

class DeviceDetectorConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function getContainerMock()
    {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\Container');

        return $containerMock;
    }

    public function getBooleanData()
    {
        return array(
            array(true, true),
            array(false, false)
        );
    }

    public function getArrayData()
    {
        return array(
            array(
                array(
                    'from_controller_path' => 'Controller Path',
                    'to_controller_path' => 'Controller Path',
                    'routes' => array()
                ),
                array(
                    'from_controller_path' => 'Controller Path',
                    'to_controller_path' => 'Controller Path',
                    'routes' => array()
                ), true
            ),
            array(
                array(
                    'from_controller_path' => 'Controller Path',
                    'to_controller_path' => 'Controller Path',
                    'routes' => array()
                ),
                array(
                    'from_controller_path' => 'Controller Path',
                    'to_controller_paths' => 'Controller Path',
                    'routes' => array()
                ), false
            )
        );
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::isMobileDeviceRoutingEnabled
     * @dataProvider getBooleanData
     */
    public function testIsMobileDeviceRoutingEnabled($value, $expected)
    {
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.mobile.enabled')
            ->will($this->returnValue($value));
        
        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $this->assertEquals($expected, $sut->isMobileDeviceRoutingEnabled());
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::isTabletDeviceRoutingEnabled
     * @dataProvider getBooleanData
     */
    public function testIsTabletDeviceRoutingEnabled($value, $expected)
    {
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.tablet.enabled')
            ->will($this->returnValue($value));
        
        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $this->assertEquals($expected, $sut->isTabletDeviceRoutingEnabled());
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::isTabletDeviceRoutingEnabled
     * @dataProvider getBooleanData
     */
    public function testTreatTabletDevicesAsMobile($value, $expected)
    {
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.tablet.treat_as_mobile')
            ->will($this->returnValue($value));
        
        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $this->assertEquals($expected, $sut->treatTabletDevicesAsMobile());
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::getMobileControllers
     * @dataProvider getArrayData
     */
    public function testGetMobileControllers($value, $expected, $result)
    {
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.mobile.controllers')
            ->will($this->returnValue($value));

        $sut = new DeviceDetectorConfiguration($containerMock);

        $expectedResult = $expected === $sut->getMobileControllers();

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::getTabletControllers
     * @dataProvider getArrayData
     */
    public function testGetTabletControllers($value, $expected, $result)
    {
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.tablet.controllers')
            ->will($this->returnValue($value));

        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $expectedResult = $expected === $sut->getTabletControllers();

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetectorConfiguration::getTabletControllers
     */
    public function testGetOverrideCookieName()
    {
        $expected = 'DEVICE_DETECTOR_OVERRIDE';

        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.override_cookie')
            ->will($this->returnValue($expected));

        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $result = $sut->getOverrideCookieName();

        $this->assertEquals($expected, $result);
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isOverrideMobile
     */
    public function testIsOverrideMobileTrue()
    {
        $cookieName = 'CONFIGURED_NAME';

        $sessionMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionMock->expects($this->any())
            ->method('has')
            ->with($cookieName)
            ->will($this->returnValue(true));
        
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('get')
            ->with('session')
            ->will($this->returnValue($sessionMock));

        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.override_cookie')
            ->will($this->returnValue($cookieName));

        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $result = $sut->hasOverrideCookie();

        $this->assertTrue($result);
    } 

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isOverrideMobile
     */
    public function testIsOverrideMobileFalse()
    {
        $cookieName = 'CONFIGURED_NAME';

        $sessionMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionMock->expects($this->any())
            ->method('has')
            ->with($cookieName)
            ->will($this->returnValue(false));
        
        $containerMock = $this->getContainerMock();
        $containerMock->expects($this->any())
            ->method('get')
            ->with('session')
            ->will($this->returnValue($sessionMock));

        $containerMock->expects($this->any())
            ->method('getParameter')
            ->with('device_detector.override_cookie')
            ->will($this->returnValue($cookieName));

        $sut = new DeviceDetectorConfiguration($containerMock);
        
        $result = $sut->hasOverrideCookie();

        $this->assertFalse($result);
    } 
}
