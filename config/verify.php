<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Code generator configs
    |--------------------------------------------------------------------------
    */
    'code' => [

        /*
        |--------------------------------------------------------------------------
        | Length of codes
        |--------------------------------------------------------------------------
        */
        'length' => 6,

        /*
        |--------------------------------------------------------------------------
        | Is code checking case sensetive
        |--------------------------------------------------------------------------
        */
        'case_sensitive' => false,

        /*
        |--------------------------------------------------------------------------
        | Including number
        |--------------------------------------------------------------------------
        */
        'numbers' => true,

        /*
        |--------------------------------------------------------------------------
        | Including upper case letters
        |--------------------------------------------------------------------------
        */
        'upper_case' => false,

        /*
        |--------------------------------------------------------------------------
        | Including lower case letters
        |--------------------------------------------------------------------------
        */
        'lower_case' => false,

        /*
        |--------------------------------------------------------------------------
        | Including symbols
        |--------------------------------------------------------------------------
        */
        'symbols' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Resend delay between code sends in seconds.
    |--------------------------------------------------------------------------
    */
    'resend_delay' => 60,

    /*
    |--------------------------------------------------------------------------
    | Expire sent code after minutes.
    |--------------------------------------------------------------------------
    */
    'expire_in' => 10,

    /*
    |--------------------------------------------------------------------------
    | Max code check attempts.
    |--------------------------------------------------------------------------
    */
    'max_attemps' => 5,

    /*
    |--------------------------------------------------------------------------
    | Maximum resends in one hour.
    |--------------------------------------------------------------------------
    */
    'max_resends' => [

        /*
        |--------------------------------------------------------------------------
        | Maximum resends in one hour based on user session.
        |--------------------------------------------------------------------------
        */
        'per_session' => 3,

        /*
        |--------------------------------------------------------------------------
        | Maximum resends in one hour based on user ip.
        |--------------------------------------------------------------------------
        */
        'per_ip' => 10,
    ],
];
