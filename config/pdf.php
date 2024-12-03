<?php

return [
    'mode'                     => '',
    'format'                   => 'A4',
    'default_font_size'        => '12',
    'default_font'             => 'sans-serif',
    'margin_left'              => 10,
    'margin_right'             => 10,
    'margin_top'               => 10,
    'margin_bottom'            => 10,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => '',
    'watermark'                => '',
    'useOTL'                   => true,
    'show_watermark'           => false,
    'show_watermark_image'     => false,
    'watermark_font'           => 'sans-serif',
    'display_mode'             => 'fullpage',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'custom_font_dir'          => storage_path('fonts'),
    'custom_font_data'         => ['calibri' => [
                                        'R' => 'calibri.ttf' // regular font
                                    ]
                                ],
    'auto_language_detection'  => true,
    'temp_dir'                 => storage_path('app'),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,
    'fonts' => [
    'calibri' => [
        'R' => 'public/fonts/calibri.ttf', // Regular
        'I' => 'public/fonts/calibrii.ttf', // Italic
        'B' => 'public/fonts/calibrib.ttf', // Bold
        'BI' => 'public/fonts/calibriib.ttf', // Bold Italic
    ],
    'amiri' => [
        'R' => 'public/fonts/amiri.ttf', // Regular
        'I' => 'public/fonts/amirii.ttf', // Italic
        'B' => 'public/fonts/amirib.ttf', // Bold
        'BI' => 'public/fonts/amiriib.ttf', // Bold Italic
    ],
],
];
