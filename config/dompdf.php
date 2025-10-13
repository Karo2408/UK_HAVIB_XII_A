<?php

return [

    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,

    'options' => [
        'isPhpEnabled' => true,
        'isRemoteEnabled' => true,  
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
    ],

    'font_dir' => storage_path('fonts'),
    'font_cache' => storage_path('fonts'),
    'temp_dir' => sys_get_temp_dir(),

    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',
    'dpi' => 96,
    'default_font' => 'sans-serif',
];
