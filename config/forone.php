<?php
/**
 * User : YuGang Yang
 * Date : 7/27/15
 * Time : 15:26
 * Email: smartydroid@gmail.com
 */

return [
    'site_config'                 => [
        'site_name'   => 'your site name',
        'title'       => 'your site title',
        'description' => 'you site description',
        'logo'        => 'vendor/forone/images/logo.png'
    ],
    'RedirectAfterLoginPath'      => 'admin/roles', // 登录后跳转页面
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
    ],
];