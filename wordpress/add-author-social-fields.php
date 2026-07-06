<?php
/**
 * Add author social/profile fields.
 * Place in functions.php or a small custom plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter( 'user_contactmethods', function( $methods ) {
    $methods['github_url']   = 'GitHub URL';
    $methods['linkedin_url'] = 'LinkedIn URL';
    $methods['facebook_url'] = 'Facebook URL';
    $methods['author_main_profile'] = 'Main Author Profile URL';

    return $methods;
} );

function eeat_get_author_meta_url( $user_id, $key ) {
    $value = get_user_meta( $user_id, $key, true );

    if ( empty( $value ) ) {
        $value = get_the_author_meta( $key, $user_id );
    }

    $value = trim( wp_strip_all_tags( (string) $value ) );

    if ( ! empty( $value ) && false === strpos( $value, '://' ) && false !== strpos( $value, '.' ) ) {
        $value = 'https://' . ltrim( $value, '/' );
    }

    return esc_url_raw( $value );
}
