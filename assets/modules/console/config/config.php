<?php

return array(
    'viewsDir' => __DIR__ . '/../views/',

    // Класс проверки прав доступа
    'check_access_class' => 'AccessCheck',

    // Проверка прав доступа по IP
    'check_ip' => true,

    /*
    |--------------------------------------------------------------------------
    | Console filter
    |--------------------------------------------------------------------------
    |
    | Set filter used for managing access to the console. By default, filter
    | 'whitelist' allows only people from 'whitelist' array below.
    */

    'filter' => 'whitelist', // whitelist or blacklist

    /*
    |--------------------------------------------------------------------------
    | Enable console only for this locations
    |--------------------------------------------------------------------------
    |
    | Addresses allowed to access the console. This array is used in
    | 'whitelist' filter. Nevertheless, this bundle should never
    | get nowhere near your production servers, but who am I to tell you how
    | to live your life :)
    */

    'whitelist' => array(
        '127.0.0.1',
        '::1',
    ),

    'blacklist' => array(),
);
