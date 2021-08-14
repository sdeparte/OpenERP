<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/cache/'.$this->getMicroServiceName().'/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir().'/var/log/'.$this->getMicroServiceName().'/'.$this->environment;
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $defaultConfDir = $this->getProjectDir().'/config';
        $microServiceConfDir = $defaultConfDir.'/'.$this->getMicroServiceName();

        $container->import($defaultConfDir.'/{packages}/*.yaml');
        $container->import($defaultConfDir.'/{packages}/'.$this->environment.'/*.yaml');

        if (file_exists($microServiceConfDir)) {
            $container->import($microServiceConfDir.'/{packages}/*.yaml');
            $container->import($microServiceConfDir.'/{packages}/'.$this->environment.'/*.yaml');
        }

        if (is_file($defaultConfDir.'/services.yaml')) {
            $container->import($defaultConfDir.'/services.yaml');
            $container->import($defaultConfDir.'/{services}_'.$this->environment.'.yaml');
        } else {
            $container->import($defaultConfDir.'/{services}.php');
        }

        $container->import($defaultConfDir.'/parameters.php');

        if (file_exists($microServiceConfDir)) {
            if (is_file($microServiceConfDir.'/services.yaml')) {
                $container->import($microServiceConfDir.'/services.yaml');
                $container->import($microServiceConfDir.'/{services}_'.$this->environment.'.yaml');
            } else {
                $container->import($microServiceConfDir.'/{services}.php');
            }
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $defaultConfDir = $this->getProjectDir().'/config';
        $microServiceConfDir = $defaultConfDir.'/'.$this->getMicroServiceName();

        if (file_exists($microServiceConfDir)) {
            $routes->import($microServiceConfDir.'/{routes}/'.$this->environment.'/*.yaml');
            $routes->import($microServiceConfDir.'/{routes}/*.yaml');

            if (is_file($microServiceConfDir.'/routes.yaml')) {
                $routes->import($microServiceConfDir.'/routes.yaml');
            } else {
                $routes->import($microServiceConfDir.'/{routes}.php');
            }
        }

        $routes->import($defaultConfDir.'/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($defaultConfDir.'/{routes}/*.yaml');

        if (is_file($defaultConfDir.'/routes.yaml')) {
            $routes->import($defaultConfDir.'/routes.yaml');
        } else {
            $routes->import($defaultConfDir.'/{routes}.php');
        }
    }

    private function getMicroServiceName(): string
    {
        return getenv('MICRO_SERVICE_NAME');
    }
}
