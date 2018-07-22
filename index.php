<?php
//    content("content-type:text/html;charset:utf8");

    $username = $_GET['username'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://github.com/$username");
    $web = curl_exec($ch);
    curl_close($ch);

    $all = explode('<h2 class="f4 text-normal mb-2">', $web);
    $all = explode('contributions', $all[1]);
    $all = trim($all[0]);

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
                $today = "오늘도 커밋하는 것! 잊지말아주세요!";
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

            .continue_day
            {
                font-size: 150px;
                
                text-align: center;
            }

            .under
            {
                background-color: #FFFFFF;
                
                height: 0.5%;
                border: 0;
            }

            form
            {
                text-align: center;
            }

            form input
            {
                font-size: 50px;

                color: #FFFFFF;
                background: transparent;
                
                width: 80%;
                text-align: center;

                border: 0;
            }
            
            form input::placeholder
            {
                color: #FFFFFF;
            }

            form button
            {
                width: 40%;
                height: 40px;
            }
            
            form hr
            {
                width: 80%;
                height: 2px;
                
                background-color: rgba(255, 255, 255, 1);
                color: #FFFFFF;
            }

            a
            {
                color: #FFFFFF;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php
                if(empty($username))
                {
                    ?>
                    <form method='GET'>
                        <input type=text name='username' placeholder='username'><br>
                        <hr>
                        <!--<button type='subimit' >조회</button>-->
                    </form>
                    <?php
                }
                else
                {
                    ?>
                    <div class="continue_day"><?php echo $all ?></div>
                    <hr class="under">
                    <?php
                        if($miss == 0)
                            echo "<div>와우... 커밋을 안한 날이 하루도 없습니다! 최고에요!</div>";
                        else if($miss < 5)
                            echo "<div>아쉽게도 <b>{$miss}일</b>을 커밋하는데 실패하셨습니다 ㅠㅠ</div>";
                        else if($miss < 10)
                            echo "<div>노력해 보셔야합니다! <b>{$miss}일</b>을 커밋하는데 실패하셨어요</div>";
                        else
                            echo "<div>의지가 부족합니다.. <b>{$miss}일</b>을 커밋하는데 실패하셨습니다....</div>";
                    ?>
                    <br>
                    <?php
                        if($max - $cont - 2 == 0)
                            echo "<div>우와아아아... 아름다워요... 이런 아름다운 잔디밭은 처음 보아요...!</div>";
                        else
                            echo "<div>아름다운 잔디밭까지는 <b>".($max - $cont - 1)."일</b> 남았습니다 :)</div>";
                    ?>
                    <br>
                    <div><?php echo $today ?></div>
                    <br>
                    <div style="text-align:center;"><a href="index.php" style="text-align:center">프로필 이름 다시 입력하기</a></div>
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
                    <?php
                }
                ?>
        </div>
    </body>
</html>