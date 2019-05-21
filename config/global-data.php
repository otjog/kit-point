<?php

    return [
        'global_data' => [
            'site_url' => env('APP_URL'),
            'today' => date('Y-m-d'),
            'info' => [
                'email' => env('SITE_EMAIL'),
                'phone' => env('SITE_PHONE'),
                'address' => env('SITE_ADDRESS'),
                'company_name' => env('SITE_COMPANY_NAME'),
            ],
            'general' => [
                'images' => [
                    'path' => 'storage/img/',
                    'const_ext' => 2 //сохранять миниатюры в jpeg
                ]
            ], //????????? УДАЛИТЬ
            'images' => [
                'models' => [
                    'banner' => [
                        'size' => [
                            'main' => env('GENERAL_IMAGES_MODELS_BANNER_SIZE_MAIN')
                        ],
                        'original_folder' => '', //со слешем, ex.: original/
                        'path_to_default_image'  => public_path('storage/img/banners/default/no-image.jpg'),
                        'path_to_image_folder' => public_path('storage/img/banners/'),
                        'change' => 'fit', //обрезать изо до заданного ихображения
                    ],
                    'product' => [
                        'size' => [
                            'xxs'   => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_XXS'),
                            'xs'    => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_XS'),
                            's'     => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_S'),
                            's-1-17'=> env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_S-1-17'),
                            'm'     => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_M'),
                            'm-13'  => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_M-13'), //W*1 x H*1.3
                            'l'     => env('GENERAL_IMAGES_MODELS_PRODUCT_SIZE_L'),
                        ],
                        'original_folder' => '', //со слешем, ex.: original/
                        'path_to_default_image'  => public_path('storage/img/shop/product/default/no-image.jpg'),
                        'path_to_image_folder' => public_path('storage/img/shop/product/'),
                        'change' => 'resize', //пропорционально уменьшать и добавлять белые поля
                    ],
                    'category' => [
                        'size' => [
                            's'     => env('GENERAL_IMAGES_MODELS_CATEGORY_SIZE_S'),
                        ],
                        'original_folder' => '', //со слешем, ex.: original/
                        'path_to_default_image'  => public_path('storage/img/shop/category/default/no-image.jpg'),
                        'path_to_image_folder' => public_path('storage/img/shop/category/'),
                        'change' => 'resize', //пропорционально уменьшать и добавлять белые поля
                    ],
                    'photo360' => [
                        'size' => [
                            'xxs'   => env('GENERAL_IMAGES_MODELS_PHOTO360_SIZE_XXS'),
                        ],
                        'original_folder' => '', //со слешем, ex.: original/
                        'path_to_default_image'  => public_path('storage/img/photo360/default/icon.jpg'),
                        'path_to_image_folder' => public_path('storage/img/photo360/'),
                        'change' => 'fit', //пропорционально уменьшать и добавлять белые поля
                    ]
                ],
            ],
            'components' => [
                'shop' => [
                    'currency' => '',
                    'price' => '',
                    'pagination' => env('GENERAL_COMPONENTS_SHOP_PAGINATION'),
                    'chunk_products' => env('GENERAL_COMPONENTS_SHOP_CHUNK_PRODUCTS'),
                    'chunk_categories' => env('GENERAL_COMPONENTS_SHOP_CHUNK_CATEGORIES'),
                    'filter_prefix' => 'p_',
                ]
            ]
        ]
    ];