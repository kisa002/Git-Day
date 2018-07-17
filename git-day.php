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

    $today = "멋져요! 오늘 커밋도 완료!";

    for($i=1; $i<$max; $i++)
    {
        $count[$i] = explode('"', $count[$i]);
        $count[$i] = $count[$i][0];
        
        if($i == $max - 1)
        {
            if($count[$i] > 0)
                $cont ++;
            else
                $today = "이런 아직 커밋을 안하셨네요!<br>커밋하시는 거 잊지 마세요!";
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

        <style>
            body
            {
                background-color: #25AAFF;
                color: #FFFFFF;

                display: table;
                margin: 0 auto;

                height: 100%;
            }
            
            .container
            {
                height: 100%;
                display: table-cell;
                vertical-align: middle;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div>당신의 1일 1커밋은 <b><?php echo $cont ?>일</b> 간 지속되었습니다!</div>
            <?php
                if($miss < 5)
                    echo "<div>아쉽게도 <b>$miss일</b>을 커밋하는데 실패하셨습니다 ㅠㅠ</div>";
                else if($miss < 10)
                    echo "<div>노력해 보셔야합니다! <b>$miss일</b>을 커밋하는데 실패하셨어요</div>";
                else
                    echo "<div>의지가 부족합니다.. <b>$miss일</b>을 커밋하는데 실패하셨습니다....</div>";
            ?>
            <br>
            <div>365일 커밋까지 <b><?php echo (365-$cont) ?>일</b> 남았습니다!</div>
            <br>
            <div>아름다운 잔디밭까지는 <b><?php echo($max - $cont - 1)?>일</b> 남았습니다:)</div>
            <br>
            <div><?php echo $today ?></div>
            <br>

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
        </div>
    </body>
</html>