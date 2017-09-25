<?php

namespace Application\Providers;

use Doctrine\ORM\Tools\Setup;
use Infrastructure\DatabaseConnection\EntityManager;
use Infrastructure\DatabaseConnection\Interfaces\EntityManagerInterface;
use Infrastructure\ServiceProvider\AbstractServiceProvider;

class DbServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EntityManagerInterface::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(EntityManagerInterface::class, function() use ($container) {
            $paths = array("/path/to/entity-files");
            $isDevMode = isDevEnv();

            // the connection configuration
            $dbParams = [
                'driver'   => getenv('DB_DRIVER'),
                'host'     => getenv('DB_HOST'),
                'port'     => getenv('DB_PORT'),
                'user'     => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
                'dbname'   => getenv('DB_DATABASE'),
            ];

            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
            $entityManager = EntityManager::create($dbParams, $config);

            return $entityManager;
        });
    }
}