<?php
/**
 * Contact Form — Web3Forms + hCaptcha form with inline thank-you state and
 * side photo (Contact page style). Markup and inline JS mirror the legacy
 * hand-coded row exactly (see MIGRATION-PLAN.md).
 *
 * @package Blue_Raeven
 */

$heading      = get_field( 'heading' );
$subtitle     = get_field( 'subtitle' );
$access_key   = get_field( 'access_key' );
$sitekey      = get_field( 'sitekey' );
$subjects     = get_field( 'subjects' );
$button       = get_field( 'button' ) ?: 'Send Message';
$thanks_title = get_field( 'thanks_title' );
$thanks_text  = get_field( 'thanks_text' );
$image        = get_field( 'image' );

if ( ! $access_key ) {
    if ( is_admin() ) {
        echo '<p style="padding:1rem;background:#f5ead0;">Contact Form — add the Web3Forms access key.</p>';
    }
    return;
}
?>
<div class="form-section">
    <div class="form-section__form-wrap">
        <h3><?php echo esc_html( $heading ); ?></h3>
        <div class="subtitle"><?php echo esc_html( $subtitle ); ?></div>
        <form id="form" class="contact-form" action="https://api.web3forms.com/submit" method="POST">
            <input type="hidden" name="access_key" value="<?php echo esc_attr( $access_key ); ?>">
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
<?php if ( $subjects ) : ?>
            <div class="form-field">
                <label for="contact-subject">Subject</label>
                <select id="contact-subject" name="subject">
                    <option value="">Choose a topic&hellip;</option>
<?php foreach ( $subjects as $s ) : ?>
                    <option value="<?php echo esc_attr( $s['value'] ); ?>"><?php echo esc_html( $s['label'] ); ?></option>
<?php endforeach; ?>
                </select>
            </div>
<?php endif; ?>
            <div class="form-field">
                <label for="contact-message">Message</label>
                <textarea id="contact-message" name="message" placeholder="Tell us what's on your mind..." required></textarea>
            </div>
            <div class="h-captcha" data-sitekey="<?php echo esc_attr( $sitekey ); ?>"></div>
            <button type="submit" class="btn btn--primary" style="align-self:flex-start;"><?php echo esc_html( $button ); ?></button>
        </form>
        <div id="form-thanks" style="display:none; padding: 2rem 0; text-align: center;">
            <p style="font-family: var(--font-script); font-size: clamp(1.8rem, 3.5vw, 2.4rem); color: var(--aqua-light); margin-bottom: 0.5rem;"><?php echo esc_html( $thanks_title ); ?></p>
            <p style="color: rgba(250,243,230,0.85);"><?php echo esc_html( $thanks_text ); ?></p>
        </div>
        <script src="https://js.hcaptcha.com/1/api.js?recaptchacompat=off" async defer></script>
        <script>
        (function(){
            var form = document.getElementById('form');
            if (!form) return;
            var submitBtn = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', async function(e){
                e.preventDefault();
                var formData = new FormData(form);
                var originalText = submitBtn.textContent.trim();
                submitBtn.textContent = 'Sending...';
                submitBtn.disabled = true;
                try {
                    var response = await fetch('https://api.web3forms.com/submit', {
                        method: 'POST',
                        body: formData
                    });
                    var data = await response.json();
                    if (response.ok) {
                        form.style.display = "none";
                        document.getElementById("form-thanks").style.display = "block";
                    } else {
                        alert('Error: ' + (data.message || 'Submission failed.'));
                    }
                } catch (error) {
                    alert('Something went wrong. Please try again.');
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            });
        })();
        </script>
    </div>
    <div class="form-section__image">
        <img decoding="async" src="<?php echo esc_url( wp_make_link_relative( $image['url'] ) ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
    </div>
</div>
