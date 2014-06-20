<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<p>
	<label for="<?php echo $field['title']['id']; ?>"><?php _e( 'Title:' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
	<input class="widefat" id="<?php echo $field['title']['id']; ?>" name="<?php echo $field['title']['name']; ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo $field['instagram_username']['id']; ?>"><?php _e( 'Instagram Username:' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
	<input class="widefat" id="<?php echo $field['instagram_username']['id']; ?>" name="<?php echo $field['instagram_username']['name']; ?>" type="text" value="<?php echo esc_attr( $instagram_username ); ?>" />
</p>

<p>
	<label for="<?php echo $field['thumbnail_size']['id']; ?>"><?php _e( 'Thumbnail Size:' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
	<input placeholder="<?php _e('Ex.: 100x100',WPINSTAGRAM_TXT_DOMAIN); ?>" id="<?php echo $field['thumbnail_size']['id']; ?>" size="10" name="<?php echo $field['thumbnail_size']['name']; ?>" type="text" value="<?php echo esc_attr( $thumbnail_size ); ?>" />
</p>

<p>
	<label for="<?php echo $field['number_of_thumbs']['id']; ?>"><?php _e( 'How many images would you like to display?' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
	<select name="<?php echo $field['number_of_thumbs']['name']; ?>" id="<?php echo $field['number_of_thumbs']['id']; ?>" class="widefat">
		<?php for( $i=1; $i<=WPINSTAGRAM_MAX_IMAGES; $i++ ): ?>
			<option value="<?php echo $i; ?>"<?php echo ($i == $number_of_thumbs) ? ' selected ' : ''; ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
</p>

<p>
	<input type="checkbox" name="<?php echo $field['new_tab']['name']; ?>" id="<?php echo $field['new_tab']['id']; ?>" value="1"<?php echo ($new_tab == true ? ' checked ' : ''); ?>/>
	<label for="<?php echo $field['new_tab']['id']; ?>"><?php _e( 'Open image in new tab?' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
<br>
	<input type="checkbox" name="<?php echo $field['show_description']['name']; ?>" id="<?php echo $field['show_description']['id']; ?>" value="1"<?php echo ($show_description == true ? ' checked ' : ''); ?>/>
	<label for="<?php echo $field['show_description']['id']; ?>"><?php _e( 'Show Image Description?' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
<br>
	<input type="checkbox" name="<?php echo $field['horizontal_list']['name']; ?>" id="<?php echo $field['horizontal_list']['id']; ?>" value="1"<?php echo ($horizontal_list == true ? ' checked ' : ''); ?>/>
	<label for="<?php echo $field['horizontal_list']['id']; ?>"><?php _e( 'Horizontal list?' , WPINSTAGRAM_TXT_DOMAIN ); ?></label>
</p>


<p>
	<a href="http://twitter.com/eduardostuart" target="blank" class="button-secondary"><?php _e('Need support?',WPINSTAGRAM_TXT_DOMAIN); ?></a>
	<a href="https://github.com/eduardostuart/wpinstagram-images-widget/wiki" target="blank" class="button-secondary"><?php _e('FAQ',WPINSTAGRAM_TXT_DOMAIN); ?></a>
</p>