<?php

namespace Yan\Bundle\DeviceDetectorBundle\Tests\Unit\DependencyInjection;

use Yan\Bundle\DeviceDetectorBundle\DependencyInjection\DeviceDetectorExtension;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\HttpFoundation\Request;

class DeviceDetectorExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $sut;
    private $container;
    private $root;
    
    protected function setUp()
    {
        $this->sut = new DeviceDetectorExtension();
        $this->container = new ContainerBuilder();
        $this->root = 'device_detector';
    }

    public function getConfigDefaultValues()
    {
        return array(
            array('tablet.treat_as_mobile', true)
        );
    }

    public function getConfigWithDefaultValues()
    {
        return array(
            array('tablet.treat_as_mobile', true),
            array('mobile', true),
            array('tablet', true)
        );
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/DependencyInjection/DeviceDetectorExtensionTest::load
     * @dataProvider getConfigDefaultValues
     */
    public function testGetConfigDefaultValues($config, $default)
    {
        $this->sut->load(array(), $this->container);

        $this->assertTrue($this->container->hasParameter($this->root.".".$config));
        $this->assertEquals($default, $this->container->getParameter($this->root.".".$config));
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/DependencyInjection/DeviceDetectorExtensionTest::load
     * @dataProvider getConfigWithDefaultValues
     */
    public function testGetConfigWithDefaultValues($config, $bool)
    {
        $this->sut->load(array(), $this->container);

        $this->assertEquals($bool, $this->container->hasParameter($this->root.".".$config));
    }

    /**
     * @covers Yan/Bundle/DeviceDetectorBundle/DependencyInjection/DeviceDetectorExtensionTest::load
     */
    public function testMobileValues()
    {
        $configs = array(
            'device_detector' => array(
                'mobile' => array(
                    'controllers' => array(
                        array(
                            'from_controller_path' => '/Path/To/Bundle/Controller/Frontend',
                            'to_controller_path' => '/Path/To/Bundle/Controller/MobileFrontend'
                        )
                    )
                )
            )
        );

        $this->sut->load($configs, $this->container);

        $this->assertTrue($this->container->hasParameter($this->root.".mobile"));
        $this->assertTrue($this->container->hasParameter($this->root.".mobile.controllers"));
        $this->assertTrue(is_array($this->container->getParameter($this->root.".mobile.controllers")));

        $controllers = $this->container->getParameter($this->root.".mobile.controllers");
        $controller = end($controllers);

        $this->assertTrue(isset($controller['from_controller_path']));
        $this->assertTrue(isset($controller['to_controller_path']));
    }

}
