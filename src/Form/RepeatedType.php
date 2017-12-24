<?php

/*
 * This file is part of the GifExceptionBundle project.
 *
 * (c) JoliCode <coucou@jolicode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\DoNotExposeYourSymfony\DependencyInjection\Form;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType as SymfonyRepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepeatedType extends SymfonyRepeatedType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('first_name', '1');
        $resolver->setDefault('second_name', '2');
    }
}
