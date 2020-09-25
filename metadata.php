<?php
/**
 * @author Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 */


/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'           => 'fp/oxid-videos',
    'title'        => '<span style="color:#d35400;font-weight:bold;">{</span>FP<span style="color:#d35400;font-weight:bold;">}</span> OXID Videos',
    'description'  => 'Ermöglicht die Integration von Videos an verschiedensten Stellen, an welcher sonst nur Bilder eingebunden werden können.',
    'thumbnail'    => 'logo.png',
    'version'      => '1.0.1',
    'author'       => 'Florian Palme',
    'url'          => 'http://www.florian-palme.de',
    'email'        => 'info@florian-palme.de',
    'extend'       => [
        \OxidEsales\Eshop\Core\UtilsFile::class
            =>  \FlorianPalme\OXIDVideos\Core\UtilsFile::class,

        \OxidEsales\Eshop\Application\Controller\Admin\CategoryMain::class
            => \FlorianPalme\OXIDVideos\Application\Controller\Admin\CategoryMain::class,

        \OxidEsales\Eshop\Application\Controller\Admin\ActionsMain::class
            => \FlorianPalme\OXIDVideos\Application\Controller\Admin\ActionsMain::class,

        \OxidEsales\Eshop\Application\Model\Category::class
            => \FlorianPalme\OXIDVideos\Application\Model\Category::class,

        \OxidEsales\Eshop\Application\Model\Actions::class
            => \FlorianPalme\OXIDVideos\Application\Model\Actions::class,

        \OxidEsales\Eshop\Core\Config::class
            => \FlorianPalme\OXIDVideos\Core\Config::class
    ],
    'controllers' => [
    ],
    'events'       => [
        'onActivate' => '\FlorianPalme\OXIDVideos\Core\Events::onActivate',
    ],
    'templates'   => [
        'fp/oxidvideos/category_video.block.tpl' => 'fp/oxid-videos/Application/views/tpl/custom/category_video.block.tpl',
        'fp/oxidvideos/category_video.tpl' => 'fp/oxid-videos/Application/views/tpl/custom/category_video.tpl',
        'fp/oxidvideos/actions_video.tpl' => 'fp/oxid-videos/Application/views/tpl/custom/actions_video.tpl',
        'fp/oxidvideos/azure/actions_video.tpl' => 'fp/oxid-videos/Application/views/azure/tpl/custom/actions_video.tpl',
        'fp/oxidvideos/shortcode.tpl' => 'fp/oxid-videos/Application/views/tpl/custom/shortcode.tpl',
    ],
    'blocks' => [
        [
            'template' => 'include/category_main_form.tpl',
            'block' => 'admin_category_main_form',
            'file' => '/Application/views/admin/include/category/main/form.tpl',
        ],

        [
            'template' => 'actions_main.tpl',
            'block' => 'admin_actions_main_product',
            'file' => '/Application/views/admin/actions/main/product.tpl',
        ],

        [
            'template' => 'page/list/list.tpl',
            'block' => 'page_list_listhead',
            'file' => '/Application/views/tpl/page/list/head.tpl',
        ],

        [
            'template' => 'widget/promoslider.tpl',
            'block' => 'fp_oxidvideos_widget_promoslider_list_item',
            'file' => '/Application/views/tpl/widget/promoslider/list_item.tpl',
        ],

        [
            'template' => 'widget/promoslider.tpl',
            'block' => 'fp_oxidvideos_widget_promoslider_list_item',
            'file' => '/Application/views/azure/tpl/widget/promoslider/list_item.tpl',
            'theme' => 'azure',
        ],
    ],
    'settings' => [
        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_autoplay',
            'type' => 'bool',
            'value' => false,
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_controls',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_loop',
            'type' => 'bool',
            'value' => false,
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_muted',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_width',
            'type' => 'str',
            'value' => '0',
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_height',
            'type' => 'str',
            'value' => '0',
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_preload',
            'type' => 'select',
            'value' => 'auto',
            'constraints' => 'auto|metadata|none',
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_poster',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_categories',
            'name' => 'fpoxidvideos_categories_playsinline',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_autoplay',
            'type' => 'bool',
            'value' => false,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_controls',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_loop',
            'type' => 'bool',
            'value' => false,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_muted',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_width',
            'type' => 'str',
            'value' => '0',
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_height',
            'type' => 'str',
            'value' => '0',
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_preload',
            'type' => 'select',
            'value' => 'auto',
            'constraints' => 'auto|metadata|none',
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_poster',
            'type' => 'bool',
            'value' => true,
        ],

        [
            'group' => 'fpoxidvideos_actions',
            'name' => 'fpoxidvideos_actions_playsinline',
            'type' => 'bool',
            'value' => true,
        ],
    ],
];
