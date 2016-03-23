<?php
/**
 * Configuration.php
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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Wiz\QiniuBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root('wiz_qiniu');

        $root
            ->children()
                ->scalarNode('access_key')
                    ->defaultNull()
                ->end()
                ->scalarNode('secret_key')
                    ->defaultNull()
                ->end()
                ->scalarNode('domain')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}