<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ResourceBundle\Tests\Unit\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Cmf\Bundle\ResourceRestBundle\DependencyInjection\CmfResourceRestExtension;
use Symfony\Cmf\Bundle\ResourceRestBundle\DependencyInjection\Compiler\EnhancerPass;

class CmfResourceRestExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(new CmfResourceRestExtension());
    }

    public function provideExtension()
    {
        return array(
            array(
                array(
                    'payload_alias_map' => array(
                        'article' => array(
                            'repository' => 'doctrine_phpcr_odm',
                            'type' => 'Article',
                        ),
                    ),
                    'enhancer_map' => array(
                        array(
                            'repository' => 'some_repo',
                            'enhancer' => 'payload',
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * @dataProvider provideExtension
     */
    public function testExtension($config)
    {
        $this->container->setParameter('kernel.bundles', array());
        $this->container->addCompilerPass(new EnhancerPass());
        $this->load($config);
        $this->compile();
    }
}
