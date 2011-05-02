<?php

function googleAnalyticsBeacon($params, $template) {
	$beaconUrl = Configure::read('GoogleAnalytics.beaconUrl');
	$beaconId = Configure::read('GoogleAnalytics.beaconId');
	
	$url = "";
	$url .= $beaconUrl . "?";
	$url .= "utmac=" . $beaconId;
	$url .= "&utmn=" . rand(0, 0x7fffffff);
	$referer = $_SERVER["HTTP_REFERER"];
	$query = $_SERVER["QUERY_STRING"];
	$path = $_SERVER["REQUEST_URI"];
	if (empty($referer)) {
		$referer = "-";
	}
	$url .= "&utmr=" . urlencode($referer);
	if (!empty($path)) {
		$url .= "&utmp=" . urlencode($path);
	}
	$url .= "&guid=ON";
	
	return str_replace("&", "&amp;", $url);
}

