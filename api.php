<?php
if(isset($_GET['url'])) {
    //$urls = explode("\n", unserialize($_POST['urls']));
    $url = $_GET['url'];
    $results = array();
    //$results["colums"] = array("data" => "url", "data" => "namelookup_time", "data" => "starttransfer_time");
    //foreach ($urls as $url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $url
        ));
        if(curl_exec($curl) !== false) {
            $info = curl_getinfo($curl);
        }
        $results = array("ndd" => $url, "url" => $info["url"], "nl" => $info["namelookup_time"], "ttfb" => $info["starttransfer_time"], "host" => "-", "dns" => "-", "ttl" => "-");

        curl_close($curl);
    //}
    echo json_encode($results);
}