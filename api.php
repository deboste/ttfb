<?php
if(isset($_GET['url']) && !empty($_GET['url'])) {
    $url = $_GET['url'];
    $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $url = preg_replace('/\s+/', '', $url);
    $results = array();

    #CURL : URL finale et TTFB
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
    curl_close($curl);

    #TTFB
    $ttfb = "-";
    if (!empty($info["starttransfer_time"])) {
        $time = floor($info["starttransfer_time"] * 1000);
        if ($time > 30 ) {
            $ttfb = "<span class=\"label label-danger\" title=\"namelookup_time : " . $info["namelookup_time"] . " s / starttransfer_time : " . $info["starttransfer_time"] . " s\">" . $time . "</span>";
        } elseif ($time > 20 ) {
            $ttfb = "<span class=\"label label-warning\" title=\"namelookup_time : " . $info["namelookup_time"] . " s / starttransfer_time : " . $info["starttransfer_time"] . " s\">" . $time . "</span>";
        } elseif ($time > 0 ) {
            $ttfb = "<span class=\"label label-success\" title=\"namelookup_time : " . $info["namelookup_time"] . " s / starttransfer_time : " . $info["starttransfer_time"] . " s\">" . $time . "</span>";
        }
    }

    $url = (empty($info["url"])) ? $url : parse_url($info["url"], PHP_URL_HOST);

    #NS / TTL
    $output = shell_exec("./script.sh $url");
    $firstline = strtok($output, "\n");
    $nsttl=explode(":", $firstline);

    #NS
    $authnsndd = array("as44099", "clara", "artful", "claradns", "typhon");
    $dns = "-";
    if(!empty($nsttl)) {
        if (count(array_intersect($nsttl, $authnsndd)) > 0){
            $dns = "<span class=\"label label-success\">$nsttl[0]</span>";
        } else {
            $dns = "<span class=\"label label-warning\">$nsttl[0]</span>";
        }
    }

    #TTL
    $ttl = "-";
    if(!empty($nsttl)) {
        if ($nsttl[1] < 1800 ) {
            $ttl = "<span class=\"label label-danger\">" . $nsttl[1] . "</span>";
        } elseif ($nsttl[1] < 3600 ) {
            $ttl = "<span class=\"label label-warning\">" . $nsttl[1] . "</span>";
        } elseif ($nsttl[1] >= 3600 ) {
            $ttl = "<span class=\"label label-success\">" . $nsttl[1] . "</span>";
        }
    }

    #HOST
    $reverse_host = gethostbyaddr(gethostbyname($url));
    $host = "<span class=\"label label-danger\" title=\"$reverse_host\">Autre</span>";
    if (preg_match('/clara.net|artful.net/', $reverse_host)) {
        $host = "<span class=\"label label-success\" title=\"$reverse_host\">Claranet</span>";
    } elseif (preg_match('/typhon.net/', $reverse_host)) {
        $host = "<span class=\"label label-success\" title=\"$reverse_host\">Typhon</span>";
    } elseif (preg_match('/as44099.net/', $reverse_host)) {
        $host = "<span class=\"label label-success\" title=\"$reverse_host\">Runiso</span>";
    }

    #Resultats en JSON
    $results = array(
        "ndd" => "<span class=\"label label-info\">" . $url . "</span>",
        "url" => (empty($info["url"])) ? "<span class=\"label label-danger\">Error : " . curl_strerror(curl_errno($curl)) . "</span>" : "<a href=\"" . $info["url"] . "\" target=\"_blank\">" . $info["url"]  . "</a>",
        "ttfb (ms)" => $ttfb,
        "host" => $host,
        "dns" => $dns,
        "ttl (s)" => $ttl
    );

    header('Content-type: application/json');
    echo json_encode($results);
} else {
    header("HTTP/1.0 404 Not Found");
}