<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timeout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    // 'pdf' => [
    //     'enabled' => true,
    //     'binary'  => env('WKHTML_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
    //     'timeout' => false,
    //     'options' => [],
    //     'env'     => [],
    // ],
    
    // 'image' => [
    //     'enabled' => true,
    //     'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
    //     'timeout' => false,
    //     'options' => [],
    //     'env'     => [],
    // ],


    'pdf' => [
        'enabled' => true,
        'binary'  => env('SNAPPY_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'timeout' => 1800,
        'options' => [
            'page-size' => 'A4',
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,
        ],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => env('SNAPPY_IMAGE_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => 1800,
        'options' => [],
    ],
];
