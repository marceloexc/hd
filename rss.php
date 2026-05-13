<?php

include 'render_board.php';

// rss
// header( "content-type: application/xml; charset=UTF-8" );

$baseUrl = "https://hd.marceloexc.com";

$contentDir = __DIR__ . "/content";

$masterXml = new DOMDocument("1.0", "UTF-8");

$rss = $masterXml->createElement("rss");
$rss->setAttribute("version", "2.0");
$rss->setAttribute("xmlns:content", "http://purl.org/rss/1.0/modules/content/");

$masterXml->appendChild($rss);

$channel = $masterXml->createElement("channel");
$channel->appendChild($masterXml->createElement("title", "harddrive"));
$channel->appendChild($masterXml->createElement("link", $baseUrl));
$channel->appendChild($masterXml->createElement("description", "recent links"));
$channel->appendChild($masterXml->createElement("language", "en"));

$rss->appendChild($channel);


$b = new BoardListingsRenderer("content");
$hi = $b->populateBoards();
$boards = $b->getBoards();


foreach ($boards as $board) {

    $index = $board->path . "/index.html";

    if (!file_exists($index)) {
        continue;
    }

    // load html into a domdoc
    $html = file_get_contents($index);
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    libxml_clear_errors();

    // get metadata

    $title = $board->title;
    $link = $baseUrl . $board->getCleanPath();
    $guid = $link; // its the same for me, idc
    $description = $doc->getElementsByTagName("title")->item(0)->textContent;
    $date = date(DATE_RFC822, $board->date_unix);

    // echo file_get_contents($index);
    // echo '<pre>';
    // print_r($board);
    // echo '</pre>';

    // echo $title;
    // echo $link;
    // echo $description;

    $item = $masterXml->createElement("item");
    $item->appendChild($masterXml->createElement("title", $title));
    $item->appendChild($masterXml->createElement("link", $link));
    $item->appendChild($masterXml->createElement("guid", $guid));
    $item->appendChild($masterXml->createElement("description", $description));
    $item->appendChild($masterXml->createElement("pubDate", $date));

    $xpath = new DOMXPath($doc);

    $contentNode = $xpath
        ->query('//div[@id="content"]')
        ->item(0);

    $innerHtml = "";

    if ($contentNode) {
        foreach ($contentNode->childNodes as $child) {
            $innerHtml .= $doc->saveHTML($child);
        }
    }

    $innerHtml = preg_replace_callback(
        '/src="([^"]+)"/',
        function ($matches) use ($link) {
            $src = $matches[1];
            if (str_starts_with($src, "http")) {
                return $matches[0];
            }
            return 'src="' . $link . $src . '"';
        },
        $innerHtml
    );

    $content = $masterXml->createElement("content:encoded");
    $cdata = $masterXml->createCDATASection($innerHtml);
    $content->appendChild($cdata);
    $item->appendChild($content);
    $channel->appendChild($item);
}


$masterXml->formatOutput = true;

file_put_contents("rss.xml", $masterXml->saveXML());
echo "rss xml generated";
