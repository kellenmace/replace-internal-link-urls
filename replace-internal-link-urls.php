<?php

/**
 * Plugin Name: Replace Internal Link URLs
 * Description: Replaces internal link URL domains with that of the decoupled frontend JS app.
 * Version:     0.1.1
 * Author:      Kellen Mace
 * Author URI:  https://kellenmace.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Modify internal link URLs to point to the decoupled frontend app.
 *
 * @param string $content Post content.
 *
 * @return string Post content, with internal link URLs possibly replaced.
 */
function replace_headless_content_link_urls(string $content): string
{
    if (!function_exists('is_graphql_request')) {
        return $content;
    }

    if (!is_graphql_request() && !defined('REST_REQUEST')) {
        return $content;
    }

    // TODO: Get this value from an environment variable or the database.
    // If you're using Faust.js, you can call wpe_headless_get_setting( 'frontend_uri' )
    $frontend_app_url = 'http://localhost:3000';
    $site_url         = site_url();

    return str_replace('href="' . $site_url, 'data-internal-link="true" href="' . $frontend_app_url, $content);
}
add_filter('the_content', 'replace_headless_content_link_urls');
