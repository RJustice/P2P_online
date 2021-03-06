<?php
/**
 * User : YuGang Yang
 * Date : 7/27/15
 * Time : 15:26
 * Email: smartydroid@gmail.com
 */

return [
    'disable_routes' => true, //禁用自带routes，默认启用
    'auth' => [
        'administrator_table' => 'users',
        'administrator_auth_controller' => '\Forone\Admin\Controllers\Auth\AuthController'
    ],
    'site_config'                 => [
        'site_name'   => '农发众诚',
        'title'       => '农发众诚',
        'description' => '农发众诚',
        'logo'        => 'vendor/forone/images/logo.png'
    ],
    'RedirectAfterLoginPath'      => 'admin/category', // 登录后跳转页面
    'RedirectIfAuthenticatedPath' => 'admin/roles', // 如果授权后直接跳转到指定页面

    'menus'                       => [
        '系统设置' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => 'admin',
            'children'   => [
                '角色管理'  => [
                    'uri' => 'roles',
                ],
                '权限管理'  => [
                    'uri' => 'permissions',
                ],
                '管理员管理' => [
                    'uri' => 'admins',
                ]
            ],
        ],
        '文章管理' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin','editor'],
            'children'   => [
                '分类管理'  => [
                    'uri' => 'category',
                ],
                '文章管理'  => [
                    'uri' => 'articles',
                ],
                '页面管理' => [
                    'uri' => 'pages',
                ],
                '招聘管理' => [
                    'uri' => 'recruit',
                ]
            ],
        ],
        // '用户管理' => [
        //     'icon'       => 'mdi-toggle-radio-button-on',
        //     'permission' => ['admin','editor'],
        //     'children'   => [
        //         '会员管理'  => [
        //             'uri' => 'users',
        //         ],
        //         '员工管理'  => [
        //             'uri' => 'employee',
        //         ],
        //     ],
        // ],
    ],

    'qiniu'                       => [
        'host'       => 'http://share.u.qiniudn.com/', //your qiniu host url
        'access_key' => '-S31BNj77Ilqwk5IN85PIBoGg8qlbkqwULiraG0x', //for test
        'secret_key' => 'QoVdaBFZITDp9hD7ytvUKOMAgohKaB8oa11FJdxN', //for test
        'bucket'     => 'share'
    ]
];