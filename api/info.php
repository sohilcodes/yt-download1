<?php
header('Content-Type: application/json');

if (!isset($_GET['url'])) {
  echo json_encode(["error" => "URL missing"]);
  exit;
}

$url = $_GET['url'];
$videoInfo = shell_exec("yt-dlp -j \"$url\"");

if (!$videoInfo) {
  echo json_encode(["error" => "Failed to fetch info"]);
  exit;
}

$info = json_decode($videoInfo, true);
$downloadLinks = [];

foreach ($info['formats'] as $format) {
  if (isset($format['format_id']) && isset($format['format'])) {
    $itag = $format['format_id'];
    $label = $format['format'];
    $downloadUrl = "/api/download.php?url=" . urlencode($url) . "&itag=" . $itag;
    $downloadLinks[] = [
      "url" => $downloadUrl,
      "label" => $label
    ];
  }
}

echo json_encode([
  "title" => $info['title'],
  "thumbnail" => $info['thumbnail'],
  "downloadLinks" => $downloadLinks
]);

