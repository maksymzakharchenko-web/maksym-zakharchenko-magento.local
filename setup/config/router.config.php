<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

return [
    'router' => [
        'frontend' => [
            'literal' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => \Magento\Setup\Controller\Index::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
];
