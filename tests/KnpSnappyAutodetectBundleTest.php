<?php

namespace EmanueleMinotto\KnpSnappyAutodetectBundle;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Emanuele Minotto <minottoemanuele@gmail.com>
 *
 * @covers EmanueleMinotto\KnpSnappyAutodetectBundle\KnpSnappyAutodetectBundle
 */
class KnpSnappyAutodetectBundleTest extends PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $container = $this->getMock(ContainerBuilder::class);

        $container
            ->expects($this->once())
            ->method('prependExtensionConfig')
            ->will($this->returnCallback(function ($extension, $config) {
                $this->assertSame('knp_snappy', $extension);
            }));

        $bundle = new KnpSnappyAutodetectBundle();
        $bundle->build($container);
    }

    /**
     * @depends testBuild
     */
    public function testBuildPdf()
    {
        $container = $this->getMock(ContainerBuilder::class);

        $container
            ->expects($this->once())
            ->method('prependExtensionConfig')
            ->will($this->returnCallback(function ($extension, $config) {
                $this->assertArrayHasKey('pdf', $config);
                $this->assertArrayHasKey('binary', $config['pdf']);

                $this->assertFileExists(str_replace(
                    '%kernel.root_dir%',
                    __DIR__,
                    $config['pdf']['binary']
                ));
            }));

        $bundle = new KnpSnappyAutodetectBundle();
        $bundle->build($container);
    }

    /**
     * @depends testBuild
     */
    public function testBuildImage()
    {
        $container = $this->getMock(ContainerBuilder::class);

        $container
            ->expects($this->once())
            ->method('prependExtensionConfig')
            ->will($this->returnCallback(function ($extension, $config) {
                $this->assertArrayHasKey('image', $config);
                $this->assertArrayHasKey('binary', $config['image']);

                $this->assertFileExists(str_replace(
                    '%kernel.root_dir%',
                    __DIR__,
                    $config['image']['binary']
                ));
            }));

        $bundle = new KnpSnappyAutodetectBundle();
        $bundle->build($container);
    }
}
