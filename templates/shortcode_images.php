

<!-- WPInstagram Images Widget / Shortcode -->
<?php if(isset($images) && is_array($images) && sizeof($images) > 0): ?>
<div class="wpinstagram-images-shortcode-box">
	<?php foreach($images as $item): ?>
		<?php
			$text    = esc_attr($item['text']);
			$link    = $item['link'];
			$image   = ( defined('WPINSTAGRAM_URL_CACHE') ? WPINSTAGRAM_URL_CACHE  : '' ) . $item['image'];
		?>
		<div class="wp-instagram-images-shortcode-image">
			<a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
				<img src="<?php echo $image; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo  $text ; ?>"/>
				<?php if($show_description == true): ?>
					<p>
						<?php echo $text; ?>
					</p>
				<?php endif; ?>
			</a>
		</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
