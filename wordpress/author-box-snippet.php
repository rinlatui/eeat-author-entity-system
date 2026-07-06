<?php
/**
 * Simple author box snippet for WordPress.
 * Add to functions.php or a small custom plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function eeat_render_author_box( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    $author_id = get_the_author_meta( 'ID' );
    $name      = get_the_author_meta( 'display_name', $author_id );
    $bio       = get_the_author_meta( 'description', $author_id );
    $url       = get_author_posts_url( $author_id );
    $github    = get_user_meta( $author_id, 'github_url', true );

    ob_start();
    ?>
    <section class="eeat-author-box" aria-label="Article author">
        <div class="eeat-author-avatar">
            <?php echo get_avatar( $author_id, 80 ); ?>
        </div>
        <div class="eeat-author-info">
            <p class="eeat-author-label">Written by</p>
            <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $name ); ?></a></h3>
            <?php if ( ! empty( $bio ) ) : ?>
                <p><?php echo esc_html( wp_trim_words( $bio, 35 ) ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $github ) ) : ?>
                <a href="<?php echo esc_url( $github ); ?>" target="_blank" rel="me noopener noreferrer">GitHub</a>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return $content . ob_get_clean();
}
add_filter( 'the_content', 'eeat_render_author_box', 20 );
