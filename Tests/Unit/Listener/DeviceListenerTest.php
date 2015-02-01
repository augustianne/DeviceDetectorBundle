<?php

namespace Site\UtilityBundle\Tests\Unit\Listener;

use Yan\Bundle\DeviceDetectorBundle\Listener\DeviceListener;
use Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class DeviceListenerTest extends \PHPUnit_Framework_TestCase
{
	private $utilityMock;
    private $configurationMock;
    private $detectorMock;
    private $containerMock;

    public function setup()
    {
        $this->utilityMock = $this->getMock('Yan\Bundle\DeviceDetectorBundle\Utility\ControllerUtility');
        
        $this->configurationMock = $this->getMockBuilder('Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetectorConfiguration')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->detectorMock = $this->getMockBuilder('Yan\Bundle\DeviceDetectorBundle\Detector\DeviceDetector')
            ->disableOriginalConstructor()
            ->getMock();
    
        $this->containerMock = $this->getMock('Symfony\Component\DependencyInjection\Container');
    }

    public function getDataForReroute()
    {
        return array(
            array(
                array(
                    array(
                        'from_controller_path' => '',
                        'to_controller_path' => '',
                        'routes' => array()
                    )
                ),
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController'
            ),
            array(
                array(
                    array(
                        'from_controller_path' => '',
                        'to_controller_path' => '',
                        'routes' => array()
                    )
                ),
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
                'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController'
            )
        ); 
    }

    private function getMobileRequest()
    {
    	$request = new Request(array(), array(), array(
    		'_controller' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
    		'_route' => 'test_frontend_homepage'
    	));
		
		$request->headers = new HeaderBag(array(
    		'user-agent' => 'Mozilla/5.0 (0; U; Compatible; MSIE 10.0; Windows Phone OS 8.1; Trident/7.0; rv:11.0; IEMobile/11.0; ARM; Touch; MyPhone; A1-A© Macintosh; U; Intel Mac OS X10_9_1; U; X11; U; Linux x86_64; en=ID) MyWebkit/537.36+; U; (KHTML, like Gecko; U;) Chrome/33.0.17'
		));

		return $request;
    }

    private function getTabletRequest()
    {
    	$request = new Request(array(), array(), array(
    		'_controller' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
    		'_route' => 'test_frontend_homepage'
    	));
		
		$request->headers = new HeaderBag(array(
    		'user-agent' => 'Mozilla/5.0 (Linux; Android 4.3; Nexus 10 Build/JWR66Y) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36'
		));

		return $request;
    }

    private function getFilterControllerEvent($controller, Request $request)
    {
        $mockKernel = $this->getMockForAbstractClass('Symfony\Component\HttpKernel\Kernel', array('', ''));

        return new FilterControllerEvent($mockKernel, $controller, $request, HttpKernelInterface::MASTER_REQUEST);
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/Listener/DeviceListener::reroute
     * @dataProvider getDataForReroute
     */
    public function testReroute($value1, $value2, $expected)
    {
        $request = $this->getMobileRequest();
        
        $controller = new DefaultController();
        $controller->setContainer($this->containerMock);

        $event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $request);

        $this->utilityMock->expects($this->any())
            ->method('getControllerAction')
            ->will($this->returnValue('indexAction'));

        $this->utilityMock->expects($this->any())
            ->method('getControllerClass')
            ->will($this->returnValue(get_class($controller)));

        $this->utilityMock->expects($this->any())
            ->method('getNewController')
            ->will($this->returnValue($value2));

        $this->detectorMock->expects($this->any())
            ->method('isRouteListed')
            ->will($this->returnValue(true));

        $this->detectorMock->expects($this->any())
            ->method('isControllerRoutable')
            ->will($this->returnValue(true));
        
        $sut = new DeviceListener($this->detectorMock, $this->configurationMock, $this->utilityMock, $this->containerMock);
        $sut->reroute($event, $value1);

        $controller = $event->getController();
        $newController = $controller[0];

        $this->assertEquals($expected, get_class($newController));
    }

    
}
