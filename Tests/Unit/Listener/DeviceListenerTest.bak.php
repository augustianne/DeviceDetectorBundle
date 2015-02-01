<?php

namespace Site\UtilityBundle\Tests\Unit\Listener;

use Yan\Bundle\DeviceDetectorBundle\Listener\DeviceListener;
use Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class DeviceListenerTestBAK extends \PHPUnit_Framework_TestCase
{
	private $sut;

    public function setSut($config)
    {
    	$extension = new DeviceDetectorExtension();
        $container = new ContainerBuilder();

        $extension->load($config, $container);
        
        $this->sut = new DeviceListener($container);
    }

    public function testIsMobileRoutingEnabledTrue()
    {
    	$config = array('device_detector' => array(
            'mobile' => array(
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createMobileRequest());
    	$this->assertTrue($this->sut->isMobileRoutingEnabled($event), 'Mobile routing disabled');
    }

    public function testIsMobileRoutingEnabledFalseDisabled()
    {
    	$config = array('device_detector' => array(
            'mobile' => array(
            	'enabled' => false,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createMobileRequest());
    	$this->assertFalse($this->sut->isMobileRoutingEnabled($event), 'Mobile routing is disabled.');
    }

    public function testIsMobileRoutingEnabledFalseTablet()
    {
    	$config = array('device_detector' => array(
            'mobile' => array(
            	'enabled' => false,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
    	$this->assertFalse($this->sut->isMobileRoutingEnabled($event), 'Device is not mobile');
    }

    public function testIsTabletRoutingEnabledTrue()
    {
    	$config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => true,
            	'treat_as_mobile' => false,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
    	$this->assertTrue($this->sut->isTabletRoutingEnabled($event), 'Tablet routing disbaled');
    }

    public function testIsTabletRoutingEnabledFalseDisabled()
    {
    	$config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => false,
            	'treat_as_mobile' => false,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
    	$this->assertFalse($this->sut->isTabletRoutingEnabled($event), 'Tablet routing enabled');
    }

    public function testIsTabletRoutingEnabledFalseTreatAsMobile()
    {
    	$config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => true,
            	'treat_as_mobile' => true,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
    	$this->assertFalse($this->sut->isTabletRoutingEnabled($event), 'Tablet is treated as is');
    }

    public function testIsTabletRoutingEnabledFalseMobile()
    {
    	$config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => true,
            	'treat_as_mobile' => false,
            	'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));

        $this->setSut($config);

        $controller = new DefaultController();
    	$event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createMobileRequest());
    	$this->assertFalse($this->sut->isTabletRoutingEnabled($event), 'Tablet is treated as is');
    }

    public function testOnKernelControllerMobile()
    {
        $config = array('device_detector' => array(
            'mobile' => array(
                'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));
        
        $this->setSut($config);

        $controller = new DefaultController();
        
        $event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createMobileRequest());
        $this->sut->onKernelController($event);

        $controller = $event->getController();
        $newController = $controller[0];
        
        $this->assertEquals(
        	'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController', 
        	get_class($newController)
    	);
    }

    public function testOnKernelControllerTablet()
    {
        $config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => true,
            	'treat_as_mobile' => false,
                'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));
        
        $this->setSut($config);

        $controller = new DefaultController();
        
        $event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
        $this->sut->onKernelController($event);

        $controller = $event->getController();
        $newController = $controller[0];
        
        $this->assertEquals(
        	'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController', 
        	get_class($newController)
    	);
    }

    public function testOnKernelControllerNoMatch()
    {
        $config = array('device_detector' => array(
            'tablet' => array(
            	'enabled' => false,
            	'treat_as_mobile' => false,
                'controllers' => array(
                	array(
                		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
                		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        				'routes' => array('test_frontend_homepage')
            		)
            	)
            )
        ));
        
        $this->setSut($config);

        $controller = new DefaultController();
        
        $event = $this->getFilterControllerEvent(array($controller, 'indexAction'), $this->createTabletRequest());
        $this->sut->onKernelController($event);

        $this->assertEquals(null, $event, 'Event returned should be null');
    }

    public function testAllowRerouteTrue()
    {
    	$sut = new DeviceListener(null);
        $this->assertTrue($sut->allowReroute(
        	'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
        	'test_frontend_homepage',
        	array(
        		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
        		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        		'routes' => array('test_frontend_homepage')
    		)
    	), 'Check route and controller');
    }

    public function testAllowRerouteFalse()
    {
    	$sut = new DeviceListener(null);

    	$allow = $sut->allowReroute(
        	'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\NewController::indexAction',
        	'test_frontend_homepage',
        	array(
        		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
        		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        		'routes' => array('test_frontend_homepage')
    		)
    	);
    	$this->assertFalse($allow, 'Wrong controller');

    	$allow = $sut->allowReroute(
        	'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController::indexAction',
        	'test_frontend_homepage',
        	array(
        		'from_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\Frontend\DefaultController',
        		'to_controller_path' => 'Yan\Bundle\DeviceDetectorBundle\Tests\Fixture\Controller\MobileFrontend\DefaultController',
        		'routes' => array('test_frontend_homepages')
    		)
    	);
    	$this->assertFalse($allow, 'Route not in list');
    }

    private function createMobileRequest()
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

    private function createTabletRequest()
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
}
