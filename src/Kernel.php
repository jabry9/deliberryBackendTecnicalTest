<?php

namespace DeliberryAPI;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use DeliberryAPI\Core\Event\Infrastructure\Domain\Service\Projector\ProjectorLoaderCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/services.yaml')) {
            $container->import('../config/services.yaml');
            $container->import('../config/{services}_'.$this->environment.'.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }


        $container->import(
            $this->getProjectDir() . '/src/*/*/Infrastructure/Application/Service/{services}' . self::CONFIG_EXTS,
            'glob'
        );
        $container->import(
            $this->getProjectDir() . '/src/*/*/Infrastructure/Application/Command/{command_handlers}' . self::CONFIG_EXTS,
            'glob'
        );
        $container->import(
            $this->getProjectDir() . '/src/*/*/Infrastructure/Application/Query/{query_handlers}' . self::CONFIG_EXTS,
            'glob'
        );

        $container->import(
            $this->getProjectDir() . '/src/*/*/Infrastructure/Domain/Service/{services}' . self::CONFIG_EXTS,
            'glob'
        );

        $container->import(
            $this->getProjectDir() . '/src/*/*/Infrastructure/Application/Projector/{projectors}' . self::CONFIG_EXTS,
            'glob'
        );

        if ('dev' === $this->environment || 'prod' === $this->environment) {
            $container->import(
                $this->getProjectDir() . '/src/*/*/Infrastructure/Domain/QueryModel/{queries}' . self::CONFIG_EXTS,
                'glob'
            );
            $container->import(
                $this->getProjectDir() . '/src/*/*/Infrastructure/Domain/Persistence/{repositories}' . self::CONFIG_EXTS,
                'glob'
            );
        }

        if ('test' === $this->environment) {
            $container->import($this->getProjectDir() . '/src/*/*/Infrastructure/Domain/QueryModel/{queries_test}' . self::CONFIG_EXTS, 'glob');
            $container->import($this->getProjectDir() . '/src/*/*/Infrastructure/Persistence/{repositories_test}' . self::CONFIG_EXTS, 'glob');
        }



    }

    protected function build(ContainerBuilder $container): void
    {
        $container
            ->addCompilerPass(new ProjectorLoaderCompilerPass());

        $finder = new Finder();
        $mappingsDoctrine = [];

        $finder->directories()->in(__DIR__);
        $finder->depth('== 0');
        foreach ($finder as $dir) {
            $path = $dir->getRealpath();
            if (is_dir($path)) {
                $finderChild = new Finder();
                $finderChild->directories()->in($path);
                $finderChild->depth('== 0');
                foreach ($finderChild as $dirChild) {
                    $pathMapping = $dirChild->getRealpath() . '/Infrastructure/Domain/Persistence/Doctrine/Mapping';
                    if (is_dir($pathMapping) && file_exists($pathMapping)) {
                        $mappingsDoctrine[$pathMapping] = 'DeliberryAPI\\'
                            . $dir->getFilename()
                            . '\\'
                            . $dirChild->getFilename()
                            . '\Domain'
                            . '\Model';
                    }
                }
            }
        }

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createYamlMappingDriver(
                    $mappingsDoctrine,
                    [],
                    false,
                    []
                )
            );
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/{routes}/*.yaml');
        $routes->import('../src/*/*/Infrastructure/UI/API/Controller/{routing}' . self::CONFIG_EXTS);

        if (is_file(\dirname(__DIR__).'/config/routes.yaml')) {
            $routes->import('../config/routes.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }
}
