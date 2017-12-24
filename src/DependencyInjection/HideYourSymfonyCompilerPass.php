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

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class HideYourSymfonyCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Change the default public uri for sub requests (ESI, H-Includes)
        $this->changeDefaultParameter($container, 'fragment.path', '/_fragment', '/_sub');

        // Change the default name for CSRF tokens
        $this->changeDefaultParameter($container, 'form.type_extension.csrf.field_name', '_token', '_signature');

        // Change some default values for form login's firewall listener
        $this->changeDefaultSecurityFirewallListenerConfig($container);

        // warning to show: app_dev.php in prod, no custom error page, default validation message

        // Cannot change /bundles directory for asset:install command because
        // it's hardcoded here https://github.com/symfony/symfony/blob/v4.0.2/src/Symfony/Bundle/FrameworkBundle/Command/AssetsInstallCommand.php#L101
        // :'(
    }

    private function changeDefaultParameter(ContainerBuilder $container, string $key, $defaultValue, $newValue)
    {
        if ($container->hasParameter($key) && $container->getParameter($key) === $defaultValue) {
            $container->setParameter($key, $newValue);
        }
    }

    private function changeDefaultSecurityFirewallListenerConfig(ContainerBuilder $container)
    {
        $securityConfig = $container->getExtensionConfig('security');
        if ($securityConfig) {
            $firewalls = array_keys($securityConfig[0]['firewalls']);

            foreach ($firewalls as $firewall) {
                $listenerId = 'security.authentication.listener.form.' . $firewall;
                $successHandlerId = 'security.authentication.success_handler.' . $firewall . '.form_login';
                $failureHandlerId = 'security.authentication.failure_handler.' . $firewall . '.form_login';
                $rememberMeId = 'security.authentication.rememberme.services.simplehash.' . $firewall;

                if ($container->hasDefinition($listenerId)) {
                    $listenerDefinition = $container->getDefinition($listenerId);

                    $options = $listenerDefinition->getArgument(7);
                    $options = $this->changeDefaultArrayOption($options, 'username_parameter', '_username', 'identifier');
                    $options = $this->changeDefaultArrayOption($options, 'password_parameter', '_password', 'password');

                    $listenerDefinition->replaceArgument(7, $options);
                }

                if ($container->hasDefinition($successHandlerId)) {
                    $successHandlerDefinition = $container->getDefinition($successHandlerId);
                    if ($successHandlerDefinition->hasMethodCall('setOptions')) {
                        $options = $this->getArgumentsForMethodCallInDefinition($successHandlerDefinition, 'setOptions')[0];
                        $options = $this->changeDefaultArrayOption($options, 'target_path_parameter', '_target_path', 'login_success');

                        $successHandlerDefinition->removeMethodCall('setOptions');
                        $successHandlerDefinition->addMethodCall('setOptions', [$options]);
                    }
                }

                if ($container->hasDefinition($failureHandlerId)) {
                    $failureHandlerDefinition = $container->getDefinition($failureHandlerId);
                    if ($failureHandlerDefinition->hasMethodCall('setOptions')) {
                        $options = $this->getArgumentsForMethodCallInDefinition($failureHandlerDefinition, 'setOptions')[0];
                        $options = $this->changeDefaultArrayOption($options, 'failure_path_parameter', '_failure_path', 'login_failure');

                        $failureHandlerDefinition->removeMethodCall('setOptions');
                        $failureHandlerDefinition->addMethodCall('setOptions', [$options]);
                    }
                }

                if ($container->hasDefinition($rememberMeId)) {
                    $rememberMeDefinition = $container->getDefinition($rememberMeId);

                    $options = $rememberMeDefinition->getArgument(3);
                    $options = $this->changeDefaultArrayOption($options, 'remember_me_parameter', '_remember_me', 'rememberme');

                    $rememberMeDefinition->replaceArgument(3, $options);
                }
            }
        }
    }

    private function changeDefaultArrayOption(array $options, string $key, $defaultValue, $newValue): array
    {
        if (!array_key_exists($key, $options) || $options[$key] === $defaultValue) {
            $options[$key] = $newValue;
        }

        return $options;
    }

    private function getArgumentsForMethodCallInDefinition(Definition $definition, string $method)
    {
        foreach ($definition->getMethodCalls() as $i => $call) {
            if ($call[0] === $method) {
                return $call[1];
            }
        }

        throw new \LogicException(sprintf('No "%s" method call found for given definition.', $method));
    }
}
