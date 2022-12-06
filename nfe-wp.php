<?php

/**
* Plugin Name: NF-e WP
* Plugin URI: 
* Description: Extensão de WooCommerce para geração de NF-e nos pedidos dos clientes.
* Version: 0.0.1
* Author: Erick Agostinho (@r4mpo)
* Author URI: https://github.com/r4mpo
**/

if (!defined('WPINC')) {
    wp_die();
}

if (!defined('NFE_WP_VERSION')) {
    define('NFE_WP_VERSION', '0.0.1');
}

if (!defined('NFE_WP_NAME')) {
    define('NFE_WP_NAME', 'NFE WP');
}

if (!defined('NFE_WP_PLUGIN_SLUG')) {
    define('NFE_WP_PLUGIN_SLUG', 'nfe-wp');
}

if (!defined('NFE_WP_BASE_NAME')) {
    define('NFE_WP_BASE_NAME', plugin_basename(__FILE__));
}

if (!defined('NFE_WP_PLUGIN_DIR')) {
    define('NFE_WP_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

if (is_admin())
    require_once NFE_WP_PLUGIN_DIR . 'includes/class-nfe-wp-admin.php';

    $nfe_wp_admin = new nfe_wp_admin
    (
    NFE_WP_BASE_NAME,
    NFE_WP_PLUGIN_SLUG,
    NFE_WP_VERSION
    );

    register_activation_hook(__FILE__, function () {
        $nfe_wp_admin = new nfe_wp_admin
        (
        NFE_WP_BASE_NAME,
        NFE_WP_PLUGIN_SLUG,
        NFE_WP_VERSION
        );
        $nfe_wp_admin->add_files_nfe();
    });

    register_deactivation_hook(__FILE__, function () {
        $nfe_wp_admin = new nfe_wp_admin
        (
        NFE_WP_BASE_NAME,
        NFE_WP_PLUGIN_SLUG,
        NFE_WP_VERSION
        );
        $nfe_wp_admin->desactived_nfwp();
    });
?>