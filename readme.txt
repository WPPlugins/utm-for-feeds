=== UTM for Feeds ===
Contributors: geekysoft
Tags: google analytics, syndication, feeds, atom, rss, dnt
Requires at least: 4.7
Tested up to: 4.8
Stable tag: 1.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Adds `utm_medium` and `utm_source` parameters to links in feeds for better integration and tracking with Google Analytics.

== Description ==

Tired of seeing a lots of “Direct” traffic in Google Analytics that you don’t know where is coming from? UTM for Feeds can help you bring down that number by appending campaign parameters to the links in your syndication feeds!

Features include:

* Adds UTM parameters to links in feeds for tracking feed subscribers
* On-demand customizable `utm_medium` and `utm_source` parameters
* Support for Do-Not-Track (DNT) for privacy concious subscribers
* Works for all feeds including main, tag, category, and author feeds!
* Atom, RDF, and RSS feeds are all supported!
* Feeds remain usable as sitemaps for search engines

Check out the Frequently Asked Question section for usage tips and instructions.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/feed-utm/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the ‘Plugins’ screen in WordPress

There is no configuration, but see the FAQ section for usage tips!

Please note that you must install the Google Analytics tracking code in your WordPress theme using another plugin, or by following the instructions provided on the Google Analytics website. This plugin will not work properly if you haven’t installed the Google Analytics script properly.

== Frequently Asked Questions ==

= Can I get a feed with custom tracking parameters? =

Yes. You can define the `utm_medium` and `utm_source` parameters in the request. E.g. if you want to track a feed-to-email-newsletter campaign powered by [MailChimp](http://eepurl.com/bLaE-5), you could set the parameters as follows:

`https://www.example.com/feed?utm_medium=Email&utm_source=Email%20newsletter`

This allows you to customize the tracking of any uses you have for your own syndication feeds such as feed-to social-media, newsletters, blog post syndication networks, or even apps like Flipboard and Apple News.

= Can I get a feed without tracking parameters? (As a user.) =

Yes, of course. Enable the Do-Not-Track option in your web browser or feed reader preferences, and the plugin will respect your wishes to not be tracked. See also the next answer.

= Can I get a feed without tracking parameters for use as a sitemap? =

Yes, absolutely. Request the feed with `utm_medium` and `utm_source` set to `0`.

E.g. `https://www.example.com/feed?utm_medium=0&utm_source=0`

= What is up with the Vary: DNT header? =

Feed responses vary based on the DNT request header. See [Explaining the Vary HTTP response header](https://ctrl.blog/entry/http-vary-explained) for details.

= Does the plugin work with ugly URLs? and pretty ones too? =

Yes. Any URL type is supported as long as WordPress itself can identify that the URL points to a feed, it will work with any type of URL. No link discrimination.

= Do you make other plugins I can use to improve my syndication feeds? =

You, betcha! Check out the [Feed Delta Updates](https://ctrl.blog/entry/wordpress-feed-delta-updates) and [Cache-Control](https://ctrl.blog/entry/wordpress-cache-control-plugin).

= Does this plugin work with other web analytics platforms? =

This plugin only sets the UTM parameters used by Google Analytics. However, many other web analytics platforms support these parameters so there is a good chance it will still work with your analytics provider.

= The guid/id links doesn’t include the tracking parameters! =

No, that is meant to be a unique identifier and not a link. I mean, it happens to be a link to the post, but feed readers aren’t supposed to use it as a link. You can swap it out for a meaningless but still unique identifier using the [urn:uiuid as the_guid](https://wordpress.org/plugins/urn-uuid/) plugin.

== Changelog ==

= 1.0 =

* Initial public release.

= 0.9.0 =

* Here be dragons.
