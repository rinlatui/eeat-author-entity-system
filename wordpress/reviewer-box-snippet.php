<?php
/**
 * Simple reviewer box snippet for WordPress.
 * Uses post meta: reviewer_name, reviewer_role, reviewer_url, reviewer_note.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function eeat_render_reviewer_box( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    $reviewer_name = get_post_meta( get_the_ID(), 'reviewer_name', true );
    $reviewer_role = get_post_meta( get_the_ID(), 'reviewer_role', true );
    $reviewer_url  = get_post_meta( get_the_ID(), 'reviewer_url', true );
    $reviewer_note = get_post_meta( get_the_ID(), 'reviewer_note', true );

    if ( empty( $reviewer_name ) ) {
        return $content;
    }

    ob_start();
    ?>
    <section class="eeat-reviewer-box" aria-label="Content reviewer">
        <p class="eeat-reviewer-label">Reviewed by</p>
        <h3>
            <?php if ( ! empty( $reviewer_url ) ) : ?>
                <a href="<?php echo esc_url( $reviewer_url ); ?>"><?php echo esc_html( $reviewer_name ); ?></a>
            <?php else : ?>
                <?php echo esc_html( $reviewer_name ); ?>
            <?php endif; ?>
        </h3>
        <?php if ( ! empty( $reviewer_role ) ) : ?>
            <p><strong><?php echo esc_html( $reviewer_role ); ?></strong></p>
        <?php endif; ?>
        <?php if ( ! empty( $reviewer_note ) ) : ?>
            <p><?php echo esc_html( $reviewer_note ); ?></p>
        <?php endif; ?>
    </section>
    <?php
    return $content . ob_get_clean();
}
add_filter( 'the_content', 'eeat_render_reviewer_box', 25 );
