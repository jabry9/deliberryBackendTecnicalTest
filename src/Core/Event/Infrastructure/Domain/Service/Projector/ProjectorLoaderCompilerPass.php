<?php


namespace DeliberryAPI\Core\Event\Infrastructure\Domain\Service\Projector;


use DeliberryAPI\Core\Event\Application\Projector\Projector;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ProjectorLoaderCompilerPass implements CompilerPassInterface
{

    public const TAG_PROJECTOR = 'deliberryAPI.projector';

    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TAG_PROJECTOR);

        $projectorMapper = $container->getDefinition(ProjectorMapper::class);
        foreach ($taggedServices as $id => $tags) {
            $reflectionClass = new \ReflectionClass($id);

            $isProjector = $reflectionClass->implementsInterface(Projector::class);
            if ($isProjector) {
                foreach ($id::eventNameProjected() as $eventName) {
                    $projectorMapper->addMethodCall(
                        'addProjectorEvent',
                        [$eventName, $id]
                    );
                }
            }

            if (false === $isProjector) {
                throw new \RuntimeException("Class name $id is not projector.");
            }
        }

    }
}