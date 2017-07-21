<?php
/*
Plugin Name: UTM for Feeds
Plugin URI:  https://www.geeky.software/wordpress-plugins/utm-for-feeds/
Description: Adds utm_medium and utm_source parameters to links in feeds for integration with Google Analytics.
Version:     1.0.0
Author:      Geeky Software
Author URI:  https://www.geeky.software/
License:     GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if (!defined('ABSPATH')) {
    header('HTTP/1.1 403 Forbidden');
    exit(  'HTTP/1.1 403 Forbidden');
}

function utm_for_feeds_add_tracking_parameters($link) {
  // Skip tracking for Do-Not-Track requests (`DNT: 1`)
  if (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == '1')
    return $link;

  $utm_query = array();

  // User opted-in to additional tracking
  if (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == '0') {
    if ($_GET['utm_content'])
      $utm_content = esc_attr($_GET['utm_content']);
    elseif (isset($_SERVER['REQUEST_URI']))
      $utm_content = urlencode(esc_attr($_SERVER['REQUEST_URI']));
    if (isset($utm_content))
      $utm_query[] = "utm_content={$utm_content}";
  }

  $utm_query[] = 'utm_medium=' .
                 (isset($_GET['utm_medium']) ?
                  esc_attr($_GET['utm_medium']) : 'Feed');
  $utm_query[] = 'utm_source=' .
                 (isset($_GET['utm_source']) ?
                  esc_attr($_GET['utm_source']) : 'Syndication');
                 
  // Don't track if query is `?utm_medium=0&utm_source=0`
  if (in_array('utm_medium=0', $utm_query) && in_array('utm_medium=0', $utm_query))
    return $link;

  $url = explode('?', $link);
  
  // Merge query parameters
  $utm_query_str = implode('&amp;', $utm_query);
  if (count($url) > 1)
    $url_query = "${url[1]}&amp;{$utm_query_str}";
  else
    $url_query = $utm_query_str;

  $tracking_link = "${url[0]}?{$url_query}";
  return $tracking_link;
}

add_filter('the_permalink_rss', 'utm_for_feeds_add_tracking_parameters', 100);

// Add tracking to self-referencing links in the excerpt and content
function utm_for_feeds_rewrite_content_links($content, $feed_kind = NULL) {
  $link = get_permalink(get_the_ID());

  return str_replace($link,
                     utm_for_feeds_add_tracking_parameters($link),
                     $content);
}

add_filter('the_excerpt_rss',  'utm_for_feeds_rewrite_content_links', 200);
add_filter('the_content_feed', 'utm_for_feeds_rewrite_content_links', 200);

// Vary responses for the Do-Not-Track header
function utm_for_feeds_set_vary_header($headers) {

  // Set or append header value
  $vary_header = 'DNT';
  if (isset($headers['Vary'])) {
    $vary_header = "${headers['Vary']}, DNT";
  }

  $headers['Vary'] = $vary_header;

  return $headers;
}

// `is_feed()` is not available in `wp_headers` but we absolutely need to know
// this before before sending headers.
function utm_for_feeds_parse_request($query) {

  if (isset($query->query_vars['feed']) &&
      $query->query_vars['feed'] != '')
    add_action('wp_headers', 'utm_for_feeds_set_vary_header');
}

add_action('parse_request', 'utm_for_feeds_parse_request');

