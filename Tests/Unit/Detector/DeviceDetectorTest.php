<?php

namespace Yan\Bundle\DeviceDetectorBundle\Tests\Unit\Detector;

use Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetector;

class DeviceDetectorTest extends \PHPUnit_Framework_TestCase
{
    public function getConfigurationMock()
    {
        $configurationMock = $this->getMockBuilder('Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetectorConfiguration')
            ->disableOriginalConstructor()
            ->getMock();

        return $configurationMock;
    }
    
    public function getBooleanData()
    {
        return array(
            array(true, true),
            array(false, false)
        );
    }

    public function getBooleanDataForAllowTabletRouting()
    {
        return array(
            array(true, true, false),
            array(true, false, true),
            array(false, false, false),
            array(false, true, false)
        );    
    }

    public function getBooleanDataForIsRouteListed()
    {
        return array(
            array('test_route', array('test_route', 'test_route_2', 'test_route_2'), true),
            array('test_route', array('test_route_3', 'test_route_2', 'test_route_2'), false),
            array('', array('test_route', 'test_route_2', 'test_route_2'), false)
        );    
    }

    public function getBooleanDataForIsControllerRoutable()
    {
        return array(
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController', 
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend', 
                true
            ),
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Backend\DefaultController', 
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend', 
                false
            ),
            array(
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction', 
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend', 
                true
            ),
        );    
    }

    public function getIsMobileTabletAsMobileTrue()
    {
        return array(
            array(
                false, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36'
            ),
            // MyPhone
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            // Cherry Mobile
            array(
                true, 'Opera/9.80 (Android; Opera Mini/7.5.31657/31.1475; U; en) Presto/2.8.119 Version/11.10'
            ),
            array(
                true, 'Mozilla/5.0 (Linux; U; Android 4.1.2; en-us; Flare2X Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'
            ),
            array(
                true, 'Mozilla/5.0 (Linux; Android 4.1.2; Flare2X Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.82 Mobile Safari/537.36'
            ),
            array(
                true, 'OneBrowser/4.2.0/Adr(Linux; U; Android 4.1.2; en-us; Flare2X Build/JZO54K) AppleWebKit/533.1 (KHTML, like Gecko) Mobile Safari/533.1'
            ),
            array(
                true, 'Opera/9.80 (Android; Opera Mini/7.5.31657/31.1475; U; en) Presto/2.8.119 Version/11.10'
            ),
            array(
                true, 'Mozilla/5.0 (Linux; Android 4.3; Nexus 10 Build/JWR66Y) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36'
            ),
            array(
                true, 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'
            )
            // 
        );
    }

    public function getIsMobileTabletAsMobileFalse()
    {
        return array(
            array(
                false, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36'
            ),
            // MyPhone
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            array(
                true, 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
            ),
            // Cherry Mobile
            array(
                true, 'Opera/9.80 (Android; Opera Mini/7.5.31657/31.1475; U; en) Presto/2.8.119 Version/11.10'
            ),
            array(
                true, 'Mozilla/5.0 (Linux; U; Android 4.1.2; en-us; Flare2X Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'
            ),
            array(
                true, 'Mozilla/5.0 (Linux; Android 4.1.2; Flare2X Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.82 Mobile Safari/537.36'
            ),
            array(
                true, 'OneBrowser/4.2.0/Adr(Linux; U; Android 4.1.2; en-us; Flare2X Build/JZO54K) AppleWebKit/533.1 (KHTML, like Gecko) Mobile Safari/533.1'
            ),
            array(
                true, 'Opera/9.80 (Android; Opera Mini/7.5.31657/31.1475; U; en) Presto/2.8.119 Version/11.10'
            ),
            array(
                false, 'Mozilla/5.0 (Linux; Android 4.3; Nexus 10 Build/JWR66Y) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36'
            ),
            array(
                false, 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'
            )
            // 
        );
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isMobile
     * @dataProvider getIsMobileTabletAsMobileTrue
     */
    public function testIsMobileTrue($expected, $userAgent)
    {
        $configurationMock = $this->getConfigurationMock();
        $configurationMock->expects($this->any())
            ->method('treatTabletDevicesAsMobile')
            ->will($this->returnValue(true));
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->isMobile($userAgent), 'Test fails when tablet is treated as a mobile device');
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isMobile
     * @dataProvider getIsMobileTabletAsMobileFalse
     */
    public function testIsMobileFalse($expected, $userAgent)
    {
        $configurationMock = $this->getConfigurationMock();
        $configurationMock->expects($this->any())
            ->method('treatTabletDevicesAsMobile')
            ->will($this->returnValue(false));
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->isMobile($userAgent), 'Test fails when tablet is NOT treated as a mobile device');
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::allowMobileRouting
     * @dataProvider getBooleanData
     */
    public function testAllowMobileRouting($value, $expected)
    {
        $configurationMock = $this->getConfigurationMock();
        $configurationMock->expects($this->any())
            ->method('isMobileDeviceRoutingEnabled')
            ->will($this->returnValue($value));
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->allowMobileRouting());
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::allowTabletRouting
     * @dataProvider getBooleanDataForAllowTabletRouting
     */
    public function testAllowTabletRouting($value1, $value2, $expected)
    {
        $configurationMock = $this->getConfigurationMock();
        $configurationMock->expects($this->any())
            ->method('isTabletDeviceRoutingEnabled')
            ->will($this->returnValue($value1));

        $configurationMock->expects($this->any())
            ->method('treatTabletDevicesAsMobile')
            ->will($this->returnValue($value2));
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->allowTabletRouting());
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isRouteListed
     * @dataProvider getBooleanDataForIsRouteListed
     */
    public function testIsRouteListed($value1, $value2, $expected)
    {
        $configurationMock = $this->getConfigurationMock();
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->isRouteListed($value1, $value2));
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Detector/DeviceDetector::isControllerRoutable
     * @dataProvider getBooleanDataForIsControllerRoutable
     */
    public function testIsControllerRoutable($value1, $value2, $expected)
    {
        $configurationMock = $this->getConfigurationMock();
        
        $sut = new DeviceDetector($configurationMock);
        
        $this->assertEquals($expected, $sut->isControllerRoutable($value1, $value2));
    }


}
