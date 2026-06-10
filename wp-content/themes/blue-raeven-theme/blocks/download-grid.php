<?php
/**
 * Download Grid — file download cards with PDF/Excel icons (Wholesale &
 * Fundraising page style). Markup mirrors the legacy hand-coded rows
 * exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$cards = get_field( 'cards' );

if ( ! $cards ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Download Grid — add downloads.</p>';
    }
    return;
}

$icons = array(
    'pdf'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM8.5 13H10v4.5H8.5V13zm3 0c.83 0 1.5.67 1.5 1.5v1.5c0 .83-.67 1.5-1.5 1.5h-1V13h1zm3.5 0h2v1h-1.5v1H16v1h-1.5v1.5H13V13h2z"/></svg>',
    'excel' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM9.5 13l1.5 2.5L9.5 18h1.7l.8-1.5.8 1.5h1.7l-1.5-2.5 1.5-2.5h-1.7l-.8 1.5-.8-1.5H9.5z"/></svg>',
);
?>
<div class="download-grid">
<?php foreach ( $cards as $card ) :
    $icon = isset( $icons[ $card['icon'] ] ) ? $card['icon'] : 'pdf';
    ?>
    <a href="<?php echo esc_url( wp_make_link_relative( $card['file']['url'] ) ); ?>" class="download-card" target="_blank">
        <div class="download-card__icon download-card__icon--<?php echo $icon; ?>">
            <?php echo $icons[ $icon ] . "\n"; ?>
        </div>
        <div class="download-card__title"><?php echo esc_html( $card['title'] ); ?></div>
        <div class="download-card__desc"><?php echo esc_html( $card['desc'] ); ?></div>
    </a>
<?php endforeach; ?>
</div>
