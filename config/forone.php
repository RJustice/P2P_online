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
        '权限设置' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin','employee_m'],
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
            'permission' => ['admin','editor','employee_m'],
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
        '操作审核' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin','employee_m'],
            'children'   => [
                '全部审核项目' => [
                    'uri' => 'check/list',
                ],
                '快速扣款待审核'  => [
                    'uri' => 'check/debit',
                ],
                '线下订单待审核' => [
                    'uri' => 'check/offline',
                ],
                '快速充值待审核' => [
                    'uri' => 'check/recharge',
                ],
                '冻结资金待审核' => [
                    'uri' => 'check/freeze',
                ],
            ],
        ],
        '用户管理' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin','editor','employee'],
            'children'   => [
                '会员管理'  => [
                    'uri' => 'members',
                ],
                '员工管理'  => [
                    'uri' => 'employee',
                ],
            ],
        ],
        '项目管理' => [            
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin'],
            'children'   => [
                '项目列表'  => [
                    'uri' => 'deals',
                ],
                // '借款人列表'  => [
                //     'uri' => 'borrower',
                // ],
            ],  
        ],        
        '订单管理' => [            
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin'],
            'children'   => [
                '投资列表'  => [
                    'uri' => 'dealorders/order',
                ],
                '充值列表' => [
                    'uri' => 'dealorders/recharge'
                ]
            ],  
        ],
        // '资金管理' => [
        //     'icon'       => 'mdi-toggle-radio-button-on',
        //     'permission' => ['admin'],
        //     'children'   => [
        //         '提现申请'  => [
        //             'uri' => 'carrys',
        //         ],
        //         '资金日志' => [
        //             'uri' => 'moneys',
        //         ],
        //         '红包管理' => [
        //             'uri' => 'giftmoney',
        //         ]
        //     ],
        // ],
        '手动操作' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin'],
            'children'   => [
                '快速充值'  => [
                    'uri' => 'hand/new/recharge',
                ],
                '冻结资金'  => [
                    'uri' => 'hand/new/freeze',
                ],
                '快速扣款' => [
                    'uri' => 'hand/new/debit',
                ],
                '线下订单' => [
                    'uri' => 'hand/new/offline',
                ]
            ],
        ],
        '系统设置' => [
            'icon'       => 'mdi-toggle-radio-button-on',
            'permission' => ['admin'],
            'children'   => [
                '分公司'  => [
                    'uri' => 'company',
                ],
                // '系统设置'  => [
                //     'uri' => 'sys',
                // ]
            ],
        ]
    ],

    'qiniu'                       => [
        'host'       => 'http://share.u.qiniudn.com/', //your qiniu host url
        'access_key' => '-S31BNj77Ilqwk5IN85PIBoGg8qlbkqwULiraG0x', //for test
        'secret_key' => 'QoVdaBFZITDp9hD7ytvUKOMAgohKaB8oa11FJdxN', //for test
        'bucket'     => 'share'
    ]
];