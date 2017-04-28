<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute 必须接受。',
    'active_url'           => ':attribute 不是有效的链接。',
    'after'                => ':attribute 必须选择 :date 之后的时间。',
    'alpha'                => ':attribute 只能包含字母。',
    'alpha_dash'           => ':attribute 只能包含字母，数字以及- 。',
    'alpha_num'            => ':attribute 只能包含字母以及数字。',
    'array'                => ':attribute 必须是一个数组。',
    'before'               => ':attribute 必须选择 :date 之前的时间。',
    'between'              => [
        'numeric' => ':attribute 必须在:min ~ :max 之间。',
        'file'    => ':attribute 必须在 :min ~ :max 个字节大小。',
        'string'  => ':attribute 必须在 :min ~ :max 个字符长度。',
        'array'   => ':attribute 必须有 :min ~ :max 个元素。',
    ],
    'boolean'              => ':attribute 只能是true 或者 false。',
    'confirmed'            => ':attribute 必须匹配相符。',
    'date'                 => ':attribute 不是一个有效时间格式。',
    'date_format'          => ':attribute 必须符合 :format 格式。',
    'different'            => ':attribute 和 :other 必须不同。',
    'digits'               => ':attribute 必须含有 :digits 个数字。',
    'digits_between'       => ':attribute 必须在 :min ~ :max 个数字。',
    'email'                => ':attribute 必须是一个有效的Email地址。',
    'filled'               => ':attribute 必填。',
    'exists'               => '所选的 :attribute 无效。',
    'image'                => ':attribute 必须是一个图片文件。',
    'in'                   => '所选的 :attribute 无效。',
    'integer'              => ':attribute 必须是一个整数。',
    'ip'                   => ':attribute 必须是一个有效IP地址。',
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max。',
        'file'    => ':attribute 不能大于 :max 个千字节。',
        'string'  => ':attribute 不能大于 :max 个字符。',
        'array'   => ':attribute 不能超过 :max 个元素。',
    ],
    'mimes'                => ':attribute 必须是: :values。',
    'min'                  => [
        'numeric' => ':attribute 必须不小于 :min。',
        'file'    => ':attribute 必须不小于 :min 个千字节。',
        'string'  => ':attribute 必须不小于 :min 个字符。',
        'array'   => ':attribute 必须不少于 :min 个元素.',
    ],
    'not_in'               => '所选的 :attribute 无效。',
    'numeric'              => ':attribute 必须是一个数字。',
    'regex'                => ':attribute 的格式错误。',
    'required'             => ':attribute 必填。',
    'required_if'          => ':attribute 当存在 :other 且值是 :value 的时候必填。',
    'required_with'        => ':attribute 当包含 :values 时必填。',
    'required_with_all'    => ':attribute 当包含 :values 时必填。',
    'required_without'     => ':attribute 当包含 :values 时不必填。',
    'required_without_all' => ':attribute 当不包含 :values 时必填。',
    'same'                 => ':attribute 和 :other 必须相同。',
    'size'                 => [
        'numeric' => ':attribute 必须是 :size 。',
        'file'    => ':attribute 必须是 :size 个千字节。',
        'string'  => ':attribute 必须是 :size 个字符。',
        'array'   => ':attribute 必须包含 :size 个元素。',
    ],
    'string'               => ':attribute 必须是一个字符串',
    'timezone'             => ':attribute 必须是一个有效时区。',
    'unique'               => ':attribute 已经被使用。',
    'url'                  => ':attribute 格式不正确。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'phone' => [
            'required' => '手机号码必填。',
            'regex' => '手机号码格式不正确。',
            'unique' => '该手机已经被注册。',
        ],
        'username' => [
            'required' => '用户名必填。',
            // 'max' => 
        ],
        'vercode' => [
            'required' => '验证码必填。',
            'check' => '验证码错误',
        ],
        'agreement' => [
            'accepted' => '必须接受该条款。'
        ],
        'rec_user' => [
            'exists' => '推荐人不存在',
        ],
        'password_confirmation' => [
            'confirmed' => '两次密码填写必须相同。',
        ],
        'idno' =>[
            'required' => '身份证号必填',
            'unique' => '身份证号不能重复,该用户已经注册',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
