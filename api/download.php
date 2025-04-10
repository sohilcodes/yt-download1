<?php
if (!isset($_GET['url']) || !isset($_GET['itag'])) {
  echo "Missing parameters.";
  exit;
}

$url = $_GET['url'];
$itag = $_GET['itag'];

// Download via yt-dlp
$cmd = "yt-dlp -f $itag -o - \"$url\"";

header("Content-Disposition: attachment; filename=\"video.mp4\"");
passthru($cmd);
