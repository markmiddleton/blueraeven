<?php
/**
 * Title: Contact Form Split
 * Slug: blue-raeven/contact-form-split
 * Categories: blue-raeven-ctas
 * Description: Navy form section with image sidebar
 */
$uploads = wp_upload_dir();
$base_url = $uploads['baseurl'];
?>
<!-- wp:html -->
<div class="form-section">
    <div class="form-section__form-wrap">
        <h3>Drop Us a Line</h3>
        <div class="subtitle">for orders, events, or just to say hi</div>
        <form class="contact-form" action="#" method="post">
            <div class="form-row">
                <div class="form-field">
                    <label for="contact-name">Your Name</label>
                    <input type="text" id="contact-name" name="name" placeholder="Jane Doe" required>
                </div>
                <div class="form-field">
                    <label for="contact-email">Email</label>
                    <input type="email" id="contact-email" name="email" placeholder="jane@example.com" required>
                </div>
            </div>
            <div class="form-field">
                <label for="contact-subject">Subject</label>
                <select id="contact-subject" name="subject">
                    <option value="">Choose a topic...</option>
                    <option value="pie-order">Pie Order / Special Request</option>
                    <option value="event">Weddings &amp; Events</option>
                    <option value="other">General Question</option>
                </select>
            </div>
            <div class="form-field">
                <label for="contact-message">Message</label>
                <textarea id="contact-message" name="message" placeholder="Tell us what's on your mind..."></textarea>
            </div>
            <button type="submit" class="btn btn--primary" style="align-self:flex-start;">
                Send Message
            </button>
        </form>
    </div>
    <div class="form-section__image">
        <img src="<?php echo esc_url( $base_url ); ?>/2026/04/contact_pie_vertical.jpg" alt="Berry pie" style="width:100%;height:100%;object-fit:cover;">
    </div>
</div>
<!-- /wp:html -->
