<?php
if(isset($_GET['url'])) {
    $url = $_GET['url'];
    $url = preg_replace('/\s+/', '', $url);
    $results = array();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CONNECTTIMEOUT => 1,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36",
        CURLOPT_URL => $url
    ));
    if(curl_exec($curl) !== false) {
        $info = curl_getinfo($curl);
    }

    $ttfb = "-";
    if (!empty($info["starttransfer_time"])) {
        if ($info["starttransfer_time"] > 0.050 ) {
            $ttfb = "<span class=\"label label-danger\">" . $info["starttransfer_time"] . "</span>";
        } elseif ($info["starttransfer_time"] > 0.020 ) {
            $ttfb = "<span class=\"label label-warning\">" . $info["starttransfer_time"] . "</span>";
        } elseif ($info["starttransfer_time"] > 0.000 ) {
            $ttfb = "<span class=\"label label-success\">" . $info["starttransfer_time"] . "</span>";
        }
    }

    $results = array(
        "ndd" => "<span class=\"label label-info\">" . $url . "</span>",
        "url" => (empty($info["url"])) ? "<span class=\"label label-danger\">Error : " . curl_errno($curl) . " - " . curl_strerror(curl_errno($curl)) . "</span>" : "<a href=\"" . $info["url"] . "\" target=\"_blank\">" . $info["url"]  . "</a>",
        "nl" => (empty($info["namelookup_time"])) ? "-" : $info["namelookup_time"],
        "ttfb" => $ttfb,
        "host" => "-",
        "dns" => "-",
        "ttl" => "-"
    );
    curl_close($curl);

    header('Content-type: application/json');
    echo json_encode($results);
}