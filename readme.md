External Media
==============

Description
-----------

Plugin for the [Sell Media](http://graphpaperpress.com/plugins/sell-media/) wordpress plugin to allow some items to be disabled for sales or link to an external site.

Features
--------
* Disable purchase option for indivisual items (or link to external site if set)
* Set an external purchase link for an item
* Set an agency to be used in the purchase button/link. (Purchase from X)

<img width="50%" height="50%" alt="item settings" src="https://dl.dropboxusercontent.com/u/975141/external-media/external-media-plugin-item-settings.png"/>

Installation
------------
1. Download and place in Wordpress plugin folder
2. Activate the plugin.
3. Modify theme template (or create a child theme) for single sell media items and call external_media_item_buy_button instead of sell_media_item_buy_button.

Theme pages to modify or override in sell-photo theme
-----------------------------------------------------
* single-sell_media_item.php
* taxonomy-collection.php
* taxonomy-keywords.php
* taxonomy-licenses.php
* archive-sell_media_item.php
* author.php

Contributors
------------
* Please use the `dev` branch on GitHub when making pull request

License
-------
GPLv2 or later

