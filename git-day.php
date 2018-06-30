<?php
//    content("content-type:text/html;charset:utf8");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://github.com/kisa002");
    $web = curl_exec($ch);
    curl_close($ch);

//    echo $web;

    $count = explode('data-count="', $web);
    
    for($i=1; $i<=371; $i++)
    {
        echo $count[$i]."<br>";
    }
?>