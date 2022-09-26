<?php
// $url = $argv[1];
$url = $_GET['url'];
$ck = 'ea.txt';
$res = shell_exec("curl -ls {$url} -c {$ck}");
while (true) {
    if (str_contains($res, 'x-token') && str_contains($res, '_token') && !str_contains($res, "Redirecting to")) {
        preg_match_all('/(?<=_token"\stype\="hidden"\svalue\=")([^"]+)/', $res, $token);
        $token = $token[0][0];
        preg_match_all('/(?<=action\=")(http[^"]+)/', $res, $url);
        $url = $url[0][0];
        // post
        $res = shell_exec('curl ' . $url . ' -sd "_token=' . $token . '&x-token=&v-token=" -b ' . $ck);
    } elseif (str_contains($res, "Redirecting to")) {
        preg_match_all('/(?<=content\="1;url\=)([^"]+)/', $res, $res_url);
        $res_url = $res_url[0][0];
        if (str_contains($res_url, 'mirror')) {
            echo $res_url;
            header("Location: " . $res_url);
            return;
        }
    } else {
        echo "fck off";
        header("Location: " . $url);
        return;
    }
}
// https://ouo.io/LRLlqF