=== External Media ===

Contributors: haraldwalker
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Plugin for the Sell Media wordpress plugin (http://graphpaperpress.com/plugins/sell-media/) to allow some items to be disabled for sales or link to an external site.

=== Features ===
Disable purchase option for indivisual items (or link to external site if set)
Set an external purchase link for an item
Set an agency to be used in the purchase button/link. (Purchase from X)

== Installation ==
1. Download and place in Wordpress plugin folder
2. Activate the plugin.
3. Modify theme template for single sell media item and call external_media_item_buy_button instead of sell_media_item_buy_button

=== Theme pages to modify or override in sell-photo theme ===
single-sell_media_item.php
taxonomy-collection.php
taxonomy-keywords.php
taxonomy-licenses.php
archive-sell_media_item.php
author.php
