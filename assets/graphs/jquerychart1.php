<html>
<head></head>
<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.jqplot.min.js"></script>
<script type="text/javascript" src="plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="plugins/jqplot.pointLabels.min.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.jqplot.min.css" />


<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>

<script class="code" type="text/javascript">
$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [[[2,5], [6,5], [7,5], [10,5], [7,5]]];
		var s1 = [400,300,200,50,50];
		var s2 = ['400%','300%','200%','50%','50%'];
		var line1 = [['Nissan', 4],['Porche', 6],['Acura', 2],['Aston Martin', 5],['Rolls Royce', 6]];
        var ticks = ['FEE<br>400', 'EE<br>300', 'ME<br>200', 'NI<br>50', 'BE<br>50'];
        var s3 = [[1,2,'10%'], [2,6,'20%'], [3,7,'30%'], [4,10,'20%'], [5,10,'20%']] ;
		
        plot1 = $.jqplot('chart1', [s3], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
    });</script>
</body>
</html>
