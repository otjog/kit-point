<?php

    return [
        'site_url' => env('APP_URL'),
        'today' => date('Y-m-d'),
        'info' => [
            'email' => env('SITE_EMAIL'),
            'phone' => env('SITE_PHONE'),
            'address' => env('SITE_ADDRESS'),
            'company_name' => env('SITE_COMPANY_NAME'),
            'app_name' => env('APP_NAME'),
        ],
        'images' => [
            'models' => [
                'banner' => [
                    'size' => [
                        'main' => env('GENERAL_IMAGES_MODELS_BANNER_SIZE_MAIN')
                    ],
                    'original_folder' => env('GENERAL_IMAGES_MODELS_BANNER_ORIGINAL_FOLDER'), //со слешем, ex.: original/
                    'path_to_default_image'  => public_path(env('GENERAL_IMAGES_MODELS_BANNER_DEFAULT_IMAGES')),
                    'path_to_image_folder' => public_path(env('GENERAL_IMAGES_MODELS_BANNER_IMAGES_FOLDER')),
                    'change' => env('GENERAL_IMAGES_MODELS_BANNER_CHANGE'), //обрезать изо до заданного ихображения
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
                    'original_folder' => env('GENERAL_IMAGES_MODELS_PRODUCT_ORIGINAL_FOLDER'), //со слешем, ex.: original/
                    'path_to_default_image'  => public_path(env('GENERAL_IMAGES_MODELS_PRODUCT_DEFAULT_IMAGES')),
                    'path_to_image_folder' => public_path(env('GENERAL_IMAGES_MODELS_PRODUCT_IMAGES_FOLDER')),
                    'change' => env('GENERAL_IMAGES_MODELS_PRODUCT_CHANGE'), //пропорционально уменьшать и добавлять белые поля
                ],
                'category' => [
                    'size' => [
                        's'     => env('GENERAL_IMAGES_MODELS_CATEGORY_SIZE_S'),
                    ],
                    'original_folder' => env('GENERAL_IMAGES_MODELS_CATEGORY_ORIGINAL_FOLDER'), //со слешем, ex.: original/
                    'path_to_default_image'  => public_path(env('GENERAL_IMAGES_MODELS_CATEGORY_DEFAULT_IMAGES')),
                    'path_to_image_folder' => public_path(env('GENERAL_IMAGES_MODELS_CATEGORY_IMAGES_FOLDER')),
                    'change' => env('GENERAL_IMAGES_MODELS_CATEGORY_CHANGE'), //пропорционально уменьшать и добавлять белые поля
                ],
                'photo360' => [
                    'size' => [
                        'xxs'   => env('GENERAL_IMAGES_MODELS_PHOTO360_SIZE_XXS'),
                    ],
                    'original_folder' => env('GENERAL_IMAGES_MODELS_PHOTO360_ORIGINAL_FOLDER'), //со слешем, ex.: original/
                    'path_to_default_image'  => public_path(env('GENERAL_IMAGES_MODELS_PHOTO360_DEFAULT_IMAGES')),
                    'path_to_image_folder' => public_path(env('GENERAL_IMAGES_MODELS_PHOTO360_IMAGES_FOLDER')),
                    'change' => env('GENERAL_IMAGES_MODELS_PHOTO360_CHANGE'), //пропорционально уменьшать и добавлять белые поля
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
        ],
        'template' => [
            'name' => env('SITE_TEMPLATE')
        ]
    ];