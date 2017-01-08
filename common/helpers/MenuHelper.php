<?php

namespace common\helpers;

use yii;

/**
 * MenuHelper for left side menu render
 *
 * @author Nadeem AKhtar <nadeemakhtar.se@gmail.com>
 * @since 1.0
 */
class MenuHelper {

    /**
     * get Admin menu
     * this function will create admin menu with permission and return it back,
     * @return array $menuItems this is left side menu
     * */
    public static function getMenu()
    {

        return $menuItems = [

            [
                'label' => '<i class="ti-panel"></i><p>Dashboard</p>',
                'url' => ['/site/index'],
                'template' => '<a href="{url}">{label}</a>',
                'options'=>[ 'class' => (Yii::$app->controller->id == 'site' ? 'active' : '') ]
            ],

            [
                'label' => ' <i class="ti-view-list-alt"></i><p>Catalog</p>',
                'url' => '#catalog-page',
                'items' => [

                    [
                        'label' => 'Categories',
                        'url' => ['/category'],
                        'visible' => \Yii::$app->user->can("categories")
                    ],
                    [
                        'label' => 'Items',
                        'url' => ['/item'],
                        'visible' => \Yii::$app->user->can("catalog-items")
                    ]

                ],
                'template' => '<a href="{url}" data-toggle="collapse" aria-expanded="true" class="">{label}</a>',
                'submenuTemplate' => "\n<div class='collapse' id='catalog-page'><ul class='nav'>\n{items}\n</ul></div>\n",
                'options'=> [ 'class' => ( Yii::$app->controller->id == 'category' ? 'active' : '') ]
            ],

            [
                'label' => ' <i class="ti-user"></i><p>Accounts</p>',
                'url' => '#accounts',
                'items' => [

                    [
                        'label' => 'Accounts',
                        'url' => ['/account'],
                        'visible' => \Yii::$app->user->can("accounts")
                    ],
                    [
                        'label' => 'Packages',
                        'url' => ['/package'],
                        'visible' => \Yii::$app->user->can("packages")
                    ]

                ],
                'template' => '<a href="{url}" data-toggle="collapse" aria-expanded="true" class="">{label}</a>',
                'submenuTemplate' => "\n<div class='collapse' id='accounts'><ul class='nav'>\n{items}\n</ul></div>\n",
                'options'=> [ 'class' => ( Yii::$app->controller->id == 'account' ? 'active' : '') ]
            ],


            [
                'label' => ' <i class="ti-gift"></i><p>Information</p>',
                'url' => '#information-page',
                'items' => [

                    [
                        'label' => 'Menu Manager',
                        'url' => ['/menu'],
                        'visible' => \Yii::$app->user->can("menu-manager")
                    ],

                    [
                        'label' => 'CMS pages',
                        'url' => ['/cms-page'],
                        'visible' => \Yii::$app->user->can("cms-pages")
                    ],

                    [
                        'label' => '<i class="ti-gift"></i><p>Banners</p>',
                        'url' => ['/banner']
                    ]

                ],
                'template' => '<a href="{url}" data-toggle="collapse" aria-expanded="true" class="">{label}</a>',
                'submenuTemplate' => "\n<div class='collapse' id='information-page'><ul class='nav'>\n{items}\n</ul></div>\n",
                'options'=> [ 'class' => ( Yii::$app->controller->id == 'cms-page' ? 'active' : '') ]
            ],

            [
                'label' => ' <i class="ti-user"></i><p>Permissions</p>',
                'url' => '#permission',
                'items' => [
                    [
                        'label' => 'Users',
                        'url' => ['/user']
                    ],
                    [
                        'label' => 'Rule Assignment',
                        'url' => ['/admin/assignment']
                    ],
                    [
                        'label' => 'Routes',
                        'url' => ['/admin/route']
                    ],
                    [
                        'label' => 'Permission',
                        'url' => ['/admin/permission']
                    ],
                    [
                        'label' => '<i class="  md-business"></i> Roles',
                        'url' => ['/admin/role']
                    ]

                ],
                'template' => '<a href="{url}" data-toggle="collapse" aria-expanded="true" class="">{label}</a>',
                'submenuTemplate' => "\n<div class='collapse' id='permission'><ul class='nav'>\n{items}\n</ul></div>\n",
                'options'=>[ 'class' => (Yii::$app->controller->id == 'user' ? 'active' : '') ]
            ],

            [
                'label' => ' <i class="ti-settings"></i><p>Settings Master</p>',
                'url' => '#settings',
                'items' => [
                    [
                        'label' => ' <i class="ti-zoom-in"></i> Settings',
                        'url' => ['/settings'],
                    ],
                    [
                        'label' => ' <i class="ti-zoom-in"></i> Countries ',
                        'url' => ['/country'],
                        'visible' => \Yii::$app->user->can("country")
                    ],
                    [
                        'label' => ' <i class="ti-zoom-in"></i> Cities ',
                        'url' => ['/city'],
                        'visible' => \Yii::$app->user->can("cities-management")
                    ],
                    [
                        'label' => ' <i class="ti-zoom-in"></i> Areas ',
                        'url' => ['/area'],
                        'visible' => \Yii::$app->user->can("area-management")
                    ]

                ],
                'template' => '<a href="{url}" data-toggle="collapse" aria-expanded="true" class="">{label}</a>',
                'submenuTemplate' => "\n<div class='collapse' id='settings'><ul class='nav'>\n{items}\n</ul></div>\n",
                'options'=>[ 'class' => (Yii::$app->controller->id == 'user' ? 'active' : '') ]
            ],

            [
                'label' => ' <i class="ti-export"></i><p>Logout</p>',
                'url' => ['/site/logout']
            ]

        ];
    }
}
