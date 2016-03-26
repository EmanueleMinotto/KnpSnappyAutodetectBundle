<?php

namespace EmanueleMinotto\KnpSnappyAutodetectBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Symfony Bundle for KnpSnappy autodetect.
 *
 * @author Emanuele Minotto <minottoemanuele@gmail.com>
 */
class KnpSnappyAutodetectBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $prefix = '%kernel.root_dir%/../vendor/';
        $container->prependExtensionConfig('knp_snappy', [
            'pdf' => [
                'binary' => $prefix.$this->getPdfBinary(),
            ],
            'image' => [
                'binary' => $prefix.$this->getImageBinary(),
            ],
        ]);
    }

    /**
     * Gets wkhtmltoimage binary based on operating system and architecture.
     *
     * @return string
     */
    private function getImageBinary()
    {
        $os = $this->detectOs();

        if ('windows' === $os) {
            return 'wemersonjanuario/wkhtmltox-windows-64bit/bin/wkhtmltoimage.exe';
        }
        if ('mac' === $os) {
            return 'messagedigital/wkhtmltoimage-osx/bin/wkhtmltoimage-osx';
        }

        $architecture = $this->detectArchitecture();

        return sprintf(
            'h4cc/wkhtmltoimage-%s/bin/wkhtmltoimage-%s',
            $architecture,
            $architecture
        );
    }

    /**
     * Gets wkhtmltopdf binary based on operating system and architecture.
     *
     * @return string
     */
    private function getPdfBinary()
    {
        $os = $this->detectOs();

        if ('windows' === $os) {
            return 'wemersonjanuario/wkhtmltox-windows-64bit/bin/wkhtmltopdf.exe';
        }
        if ('mac' === $os) {
            return 'messagedigital/wkhtmltopdf-osx/bin/wkhtmltopdf-osx';
        }

        $architecture = $this->detectArchitecture();

        return sprintf(
            'h4cc/wkhtmltopdf-%s/bin/wkhtmltopdf-%s',
            $architecture,
            $architecture
        );
    }

    /**
     * Detects common operating systems.
     *
     * @return string
     */
    private function detectOs()
    {
        if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            return 'windows';
        }

        if ('Darwin' === PHP_OS) {
            return 'mac';
        }

        return 'linux';
    }

    /**
     * Detects common architecture types.
     *
     * @return string
     */
    private function detectArchitecture()
    {
        $check = 123234234234234 % 134;
        if (-14 == $check || -1 == $check) {
            return 'i386';
        }

        return 'amd64';
    }
}
