<?php
/*
 * This file is part of the GifExceptionBundle project.
 *
 * (c) JoliCode <coucou@jolicode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pyrech\DoNotExposeYourSymfony;

use Pyrech\DoNotExposeYourSymfony\DependencyInjection\HideYourSymfonyCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PyrechDoNotExposeYourSymfonyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new HideYourSymfonyCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
