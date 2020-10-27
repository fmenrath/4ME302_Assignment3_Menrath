<p class="heading">PD research news <i class="las la-rss"></i> </p>
<p class="h3">This RSS feed shows the latest news regarding PD research.</p>

<div class="rss-feed">
    <?php 
    $rss = simplexml_load_file('https://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx');

    //Output XML file
    foreach ($rss->channel->item as $item) {
        //Get timestamp and modify it
        $timestamp = $item->pubDate;
        $timestamp = substr($timestamp, 0, -9);
        $timestamp = substr_replace($timestamp, '- ', 17, 0);

        //Display the feed item
        echo '<h4 class="feed-item-title"><a href="'. $item->link .'">' . $item->title . "</a></h2>";
        echo '<p class="pub-date">' . $timestamp . "</p>";
        echo '<p class="feed-item-desc">' . $item->description . "</p>";
    }
    ?>
</div>



