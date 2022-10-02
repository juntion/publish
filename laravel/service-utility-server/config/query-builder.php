<?php

return [

    /*
     * By default the package will use the `include`, `filter`, `sort` and `fields` query parameters.
     *
     * Here you can customize those names.
     */
    'parameters' => [
        'include' => 'include',

        'filter' => 'filter',

        'sort' => 'sort',

        'fields' => 'fields',

        'append' => 'append',

        'search' => 'search',// search[a,b]=123&search[c,d]=456%    and(a=123 or b=123) and (c like 456% or d like 456%)

        'must'   => 'must', // must[a,1]=123&must[a,2]=123      and a = 123 and a != 123; // 具体看enums 类

        'may'    => 'may' // 类似must
    ],

];
