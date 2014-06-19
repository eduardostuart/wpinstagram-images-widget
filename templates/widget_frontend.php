
<?php echo $before_widget; ?>

<?php
$width = $height = 150;

if(isset($thumbnail_size) && is_array($thumbnail_size)){
	list($width,$height) = $thumbnail_size;
}

$target = "_self";
if(isset($new_tab) && $new_tab == true){
	$target = "_blank";
}
?>

<?php if(isset($title) && !empty($title)): ?>
	<?php echo $before_title . $title . $after_title; ?>
<?php endif; ?>

<?php if(isset($images) && is_array($images) && sizeof($images) > 0): ?>

<ul class="wpinstagram wpinstagram-widget <?php echo ( $horizontal_list ? 'wpinstagram-widget--horizontal' : '' ); ?>">
	<?php foreach($images as $item): ?>

		<?php
			$text    = esc_attr($item['text']);
			$link    = $item['link'];
			$image   = ( defined('WPINSTAGRAM_URL_CACHE') ? WPINSTAGRAM_URL_CACHE  : '' ) . $item['image'];
		?>
		<li class="wpinstagram-widget-item">
			<a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
				<img src="<?php echo $image; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo  $text ; ?>"/>
				<?php if($show_description): ?>
					<p>
						<?php echo $text; ?>
					</p>
				<?php endif; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

<?php else: ?>

	<p><?php _e('No Photos to show', WPINSTAGRAM_TXT_DOMAIN); ?></p>

<?php endif; ?>


<?php echo $after_widget; ?>