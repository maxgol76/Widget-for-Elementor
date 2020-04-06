<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Group_Control_Image_Size;
?>

<?php  /*Adding div with "centered-box gem-image-centered-box" classes if the image position is center*/
if ( ! empty( $settings[ 'image_position' ] ) && $settings[ 'image_position' ] == 'gem-wrapbox-position-centered' ) : ?>
<div class="centered-box gem-image-centered-box">
   <?php endif; ?>

    <div class="gem-image gem-wrapbox <?php echo ! empty( $settings[ 'thegem_elementor_preset' ] ) ? esc_attr( $settings[ 'thegem_elementor_preset'] ) : ''?> <?php echo ! empty( $settings[ 'image_position' ] ) ? esc_attr( $settings[ 'image_position'] ) : ''?>">
        <div class="gem-wrapbox-inner">
            <?php  /*Adding link if lightbox is true*/
            if ( ! empty( $settings[ 'open_lightbox' ] ) && $settings[ 'open_lightbox' ] == 'yes' ) : ?>
                <a href="#" class="fancybox">
            <?php endif; ?>
            <?php
              /*Adding classes to the img*/
              $class = 'class="gem-wrapbox-element img-responsive"';
              echo substr_replace( Group_Control_Image_Size::get_attachment_image_html( $settings, 'content_choose_image' ), $class, 5, 0 ); ?>
            <?php  /*Adding link if lightbox is yes*/
            if ( ! empty( $settings[ 'open_lightbox' ] ) && $settings[ 'open_lightbox' ] == 'yes' ) : ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php
if ( ! empty( $settings[ 'image_position' ] ) && $settings[ 'image_position' ] == 'gem-wrapbox-position-centered' ) : ?>
</div>
<?php endif; ?>
