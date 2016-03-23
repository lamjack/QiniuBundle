<?php
/**
 * WizQiniuExtension.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-15/12/23 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */
namespace Wiz\QiniuBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class WizQiniuExtension
 * @package Wiz\QiniuBundle\DependencyInjection
 */
class WizQiniuExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $accessKey = $accessor->getValue($config, '[access_key]');
        $secretKey = $accessor->getValue($config, '[secret_key]');
        $domain = $accessor->getValue($config, '[domain]');

        if ($accessKey && $secretKey) {
            $definition = new Definition('Wiz\QiniuBundle\Client', array($accessKey, $secretKey));
            $container->setDefinition('wiz_qiniu.client', $definition);
        }

        $container->setParameter('wiz_qiniu.domain', $domain);
    }
}