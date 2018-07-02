<?php
//    content("content-type:text/html;charset:utf8");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://github.com/kisa002");
    $web = curl_exec($ch);
    curl_close($ch);

//    echo $web;

    $count = explode('data-count="', $web);
    
    $max = count($count);

    $cont = 0;

    for($i=1; $i<$max; $i++)
    {
        $count[$i] = explode('"', $count[$i]);
        $count[$i] = $count[$i][0];
        
        if($i == $max - 1)
        {
            if($count[$i] >= 0)
                $cont ++;
        }
        else
        {   
            if($count[$i] == 0)
                $cont = 0;
            else
                $cont ++;
        }
        
        // echo $count[$i]."<br>";
    }

    // echo "<$cont>";
?>

<html>
    <head>
        <title>Git-Day</title>
        <meta charset="UTF-8">
    </head>

    <body>
        <div>당신의 1일 1커밋은 <b><?php echo $cont ?>일</b> 간 지속되었습니다!</div>
    </body>
</html>