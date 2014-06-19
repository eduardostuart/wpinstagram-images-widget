=== WPInstagram Images Widget ===
Tags: wordpress, instagram, crawler, widget, instagram widget, social, instagram platform, sidebar,shortcode
Requires at least: 3.5
Tested up to: 4.0-alpha-20140604
Stable tag: 2.0.1

Instagram Images Widget get your most recent activity at Instagram and display them in a Widget.

== Description ==

Instagram Images Widget get your most recent activity at Instagram and display them in a Widget.

No need to create an application on Instagram, just your username.


= Shortcode =

Parameters

1. username **(required)** - Your instagram username;
1. show     **(optional - default: 1)** - Number of images to show
1. show_description **(optional - default: 0)** - Turn on/off images description (Use: 0 to hide, 1 to show)
1. target **(optional - default: _blank)** Open images in new tab?
1. image_size **(optional - default: 100x100)** Image size (width x height)
1. horizontal_list **(optional - default: 0)** - Turn on/off inline photos

**Shortcode Examples**

Show only 1 image: *[wpinstagram_images username="@youusername"]*

Show 5 images: *[wpinstagram_images username="@youusername" show=5]*

Show 5 images and descriptions: *[wpinstagram_images username="@youusername" show=5 show_description=1]*

Show 5 images, descriptions and change the image size to 300 (width) x 300 (height): *[wpinstagram_images username="@youusername" show=5 show_description=1 image_size="300x300"]*

Show inline photos: *[wpinstagram_images username="@eduardostuart" show="2" horizontal_list=1]*

= CSS (Shortcode , Widget ) =

.wpinstagram{ }
.wpinstagram.wpinstagram-shortcode img, .wpinstagram.wpinstagram-widget img{ }

.wpinstagram.wpinstagram-shortcode--horizontal .wpinstagram-shortcode-item,
.wpinstagram.wpinstagram-widget--horizontal .wpinstagram-widget-item { }


= Supporting future development =

If you like the WPInstagram Images Widget plugin, please rate and review it here in the WordPress Plugin Directory, support it with your [donation](http://goo.gl/Kdkpag "donation") . Thank you!

= Thanks to... =

[jesstech](https://github.com/jesstech) - [Github pull](https://github.com/eduardostuart/wpinstagram-images-widget/pull/1)

= Need Support? =

Follow me on [Instagram](http://instagram.com/eduardostuart) or [Twitter](http://twitter.com/eduardostuart).


== Installation ==

You can either install it automatically from the WordPress admin, or do it manually:

1. Unzip the archive and put the `wpinstagram-images-widget` folder into your plugins folder (/wp-content/plugins/).
2. Activate the plugin from the Plugins menu.
3. Go to `Appearance` -> `Widgets` to see your new widget (Search for `WPInstagram Images Widget`)
4. That's it! You're ready to go!


== Screenshots ==

1. Example
2. Widget
3. Shortcode

== Changelog ==

v.2.0.1 - Bugfixes; New option to display inline photos; Better image load/download;

v.1.2.6 - Bugfix

v.1.2.5 - Bugfix

v.1.2.4 - [Bugfix](http://wordpress.org/support/topic/triggered-a-fatal-error-on-activation) when used with nextgen gallery

v.1.2.3 - Add the option to hide (widget) image description; Bugfixes

v1.2.1 - Portuguese-BR Translation

v1.2   - Bugfixes and new shortcodes;
