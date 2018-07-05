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
    $miss = 0;

    $today = true;

    for($i=1; $i<$max; $i++)
    {
        $count[$i] = explode('"', $count[$i]);
        $count[$i] = $count[$i][0];
        
        if($i == $max - 1)
        {
            if($count[$i] > 0)
                $cont ++;
            else
                $today = false;
        }
        else
        {   
            if($count[$i] == 0)
            {
                $cont = 0;
                $miss ++;
            }
            else
                $cont ++;
        }

        $row .= "[$i, $count[$i]]";

        if($i != $max - 1)
            $row .= ",";
        
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

        <div>하지만, 아쉽게도 <b><?php echo $miss ?>일</b>을 커밋하는데 실패하셨습니다 ㅠㅠ</div>
        <br>
        <div>365일 커밋까지 <b><?php echo (365-$cont) ?>일</b> 남았습니다!</div>
        <br>
        <div>아름다운 잔디밭까지는 <b><?php echo($max - $cont - 1)?>일</b> 남았습니다:)</div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div"></div>
        
        <script>
            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('number', 'X');
                data.addColumn('number', 'Commit Count');

                data.addRows([<?php echo $row ?>]);

                var options = {
                    hAxis: {
                    title: 'Date'
                    },
                    vAxis: {
                    title: 'Commit'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

                chart.draw(data, options);
            }

            drawBasic();
        </script>
    </body>
</html>