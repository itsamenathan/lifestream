<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.00">
<channel>
<title>My Lifestream</title>
<link>http://MY-URL.com/</link>
<description>YOUR_DESCRIPTION</description> 
<language>en-us</language> 

<?php
require_once('php/simplepie.inc');

$feed = new SimplePie();

$feed->set_feed_url(array(
	'http://del.icio.us/rss/greenfday6',
	'http://ws.audioscrobbler.com/1.0/user/greenfday6/recenttracks.rss',
	'http://feeds.feedburner.com/ThrowTheMind'
));

$feed->set_cache_duration (3600); // ONE HOUR
$feed->enable_xml_dump(isset($_GET['xmldump']) ? true : false);
$success = $feed->init();
$feed->handle_content_type();
?>

<?php if ($success): ?>
<? $itemlimit=0; ?>

<?php foreach($feed->get_items() as $item): ?>
<? if ($itemlimit==100) { break; } ?>

<item>
<title><?echo $item->get_title(); ?></title>
<link><? echo $item->get_permalink(); ?></link>
<description>
<? echo $item->get_description(); ?>
</description>
</item>

<? $itemlimit++ ?>
<?php endforeach; ?>

<?php endif; ?>

</channel>
</rss>
