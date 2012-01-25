<?php
header('Content-type:text/html; charset=utf-8');
require_once('php/simplepie.inc');

//////////////////////////////////////////////////////////////////
//Lets set some stuff up :P
//////////////////////////////////////////////////////////////////
$days = 7;
$feeds['feeds'] = array(
  'delicious' => 'http://del.icio.us/rss/greenfday6',
  'throwthemind' => 'http://feeds.feedburner.com/ThrowTheMind',
  'lastfm' => 'http://ws.audioscrobbler.com/1.0/user/greenfday6/recenttracks.rss',
  'reader' => 'http://www.google.com/reader/public/atom/user/11743205354558987835/state/com.google/broadcast',
  'flickr'=> 'http://api.flickr.com/services/feeds/photos_public.gne?id=97764086@N00&lang=en-us&format=rss_200',
  'twitter'=>'http://twitter.com/statuses/user_timeline/14393059.rss',
  'github'=>'https://github.com/JimShoe.atom',
);
$feeds['names'] = array(
  $feeds['feeds']['delicious'] => 'Del.icio.us',
  $feeds['feeds']['throwthemind'] => 'Throw The Mind',
  $feeds['feeds']['lastfm'] => 'Last.fm',
  $feeds['feeds']['reader'] => 'Google Reader',
  $feeds['feeds']['flickr'] => 'Flickr',
  $feeds['feeds']['twitter'] => 'Twitter',
  $feeds['feeds']['github'] => 'github',
  );
//////////////////////////////////////////////////////////////////
//This will murge all the feeds into a new SimplePie
//////////////////////////////////////////////////////////////////
$feed = new SimplePie($feeds['feeds'], 'cache');

//////////////////////////////////////////////////////////////////
// Lets parse through the feeds 
//////////////////////////////////////////////////////////////////
function get_feeds($feed, $feeds, $days)
{
  // Set up some variables we'll use.
  $stored_date = '';
  $list_open = false;
  echo '<div class="newBody">'; 
  foreach ($feed->get_items() as $item)
  {
	if($x < $days)
	{	 
		// What is the date of the current feed item?
		$item_date = $item->get_date('M jS');
		// Is the item's date the same as what is already stored?
		// - Yes? Don't display it again because we've already displayed it for this date.
		// - No? So we have something different.  We should display that.
		if ($stored_date != $item_date)
		{
			// If there was already a list open from a previous iteration of the loop, close it
			if ($list_open)
			{
				echo '</ol>' . "\r\n";
			}
			// Since they're different, let's replace the old stored date with the new one
			$stored_date = $item_date;
			// Display it on the page, and start a new list
			echo '<h2>' . $stored_date . '</h2>' . "\r\n";
			echo '<ol>';
			// Let the next loop know that a list is already open, so that it will know to close it.
			$list_open = true;
			$x++;
		}
		// Display the feed item however you want...
		echo '<div class="time">' . $item->get_date('g:i a') . '</div>';
		echo '<div class="base"> <a href="' . $item->get_base() . '">' . $feeds['names'][$item->get_feed()->subscribe_url()]. '</a></div>';
		echo '<div class="link"> <a href="' . $item->get_permalink() . '">' . $item->get_title() . '</a></div>';
		if($item->get_feed()->get_favicon())
		  echo '<div class="fav"> <img src="' . $item->get_feed()->get_favicon() . '" width="16" height="16" /> </div><br>';
		else
                  echo '<div class="fav"> <img src="feed-icon.png" width="16" height="16" /> </div><br>';
	}
  }
}
/////////////////////////////////////////////////////////////////////
//Lets do some html :(
//////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Throw the Mind</title>
<link href="style.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>
<?php 
  echo '<h1> Throw the Mind</h1>';
  echo '<div class="br">';
  echo '<a href="https://throwthemind.com/blog">Blog</a> <br>';
  echo '<a href="https://throwthemind.com/ip">Ip</a> <br>';
  echo '</div>';
// Go through all of the items in the feed
get_feeds($feed, $feeds, $days);
echo '</dev>';
?>
</ol>
</body>
</html>
