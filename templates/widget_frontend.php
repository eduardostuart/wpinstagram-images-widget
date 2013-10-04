
<?php echo $before_widget; ?>

<?php
$width = $height = 150;

if(is_array($thumbnail_size)){
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
<ul class="wp-instagram-images-widget wp-instagram-images-widget-list">
	<?php foreach($images as $item): ?>
		<?php

			$text    = esc_attr($item['text']);
			$link    = $item['link'];
			$image   = $item['image'];
		
		?>
		<li>
			<a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
				<img src="<?php echo $image; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo  $text ; ?>"/>
				<p>
					<?php echo $text; ?>
				</p>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>


<?php echo $after_widget; ?>