<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2022 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Attachment;

use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Package\PackageInstaller;
use Windwalker\Core\Renderer\RendererService;
use Windwalker\DI\Container;
use Windwalker\DI\ServiceProviderInterface;

/**
 * The AttachmentPackage class.
 */
class AttachmentPackage extends AbstractPackage implements
    ServiceProviderInterface

{
    public function register(Container $container): void
    {
        if ($container->has(RendererService::class)) {
            $container->extend(
                RendererService::class,
                function (RendererService $renderer) {
                    $renderer->addPath(dirname(__DIR__) . '/views');

                    return $renderer;
                }
            );
        }

        $container->mergeParameters(
            'renderer.aliases',
            [
                '@attachment-list' => 'attachment-list',
                '@attachment-uploader' => 'attachment-uploader',
            ]
        );

        $container->mergeParameters(
            'renderer.edge.components',
            [
                'attachment-list' => '@attachment-list',
                'attachment-uploader' => '@attachment-uploader',
            ]
        );
    }

    public function install(PackageInstaller $installer): void
    {
        $installer->installMigrations(static::path('resources/migrations/**/*'), 'migrations');

        $installer->installModules(
            [
                static::path("src/Entity/Attachment.php") => '@source/Entity',
            ],
            [
                'Lyrasoft\\Attachment\\Entity' => 'App\\Entity',
            ],
            ['entity']
        );

        $installer->installModules(
            [
                static::path("src/Repository/AttachmentRepository.php") => '@source/Repository',
            ],
            [
                'Lyrasoft\\Attachment\\Repository' => 'App\\Repository',
            ],
            ['attachment_model']
        );
    }
}
