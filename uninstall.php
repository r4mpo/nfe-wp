<?php

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

if (!function_exists('nfe_wp_uninstall')) {

    function nfe_wp_uninstall()
    {
        delete_option('nfe_wp_dados');
    }

}

register_uninstall_hook(__FILE__, 'nfe_wp_uninstall');