<?php

/*
 * This file is part of the GifExceptionBundle project.
 *
 * (c) JoliCode <coucou@jolicode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\DoNotExposeYourSymfony\DependencyInjection;

use Pyrech\DoNotExposeYourSymfony\DependencyInjection\Form\RepeatedType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType as SymfonyRepeatedType;

class DoNotExposeYourSymfonyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Change the field naming for repeted type
        // Default was "first" and "second"
        // Changed to "1" and "2"
        $repeatedTypeDefinition = new Definition();
        $repeatedTypeDefinition->setClass(RepeatedType::class);
        $repeatedTypeDefinition->setDecoratedService(SymfonyRepeatedType::class);
        $repeatedTypeDefinition->setPublic(false);

        $container->setDefinition('decorated_repeated_type', $repeatedTypeDefinition);
    }
}
