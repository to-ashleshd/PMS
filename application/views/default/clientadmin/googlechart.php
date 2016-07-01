<!--
You are free to copy and use this sample in accordance with the terms of the
Apache license (http://www.apache.org/licenses/LICENSE-2.0.html)
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization2() {
        // Create and populate the data table.
		/**
        var data = google.visualization.arrayToDataTable([
          ['x', 'Cats', 'Blanket 1', 'Blanket 2'],
          ['A',   1,       1,           0.5],
          ['B',   2,       0.5,         1],
          ['C',   4,       1,           0.5],
          ['D',   8,       0.5,         1],
          ['E',   7,       1,           0.5],
          ['F',   7,       0.5,         1],
          ['G',   8,       1,           0.5],
          ['H',   4,       0.5,         1],
          ['I',   2,       1,           0.5],
          ['J',   3.5,     0.5,         1],
          ['K',   3,       1,           0.5],
          ['L',   3.5,     0.5,         1],
          ['M',   1,       1,           0.5],
          ['N',   1,       0.5,         1]
        ]);
		**/
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Corporate' ],
          ['FEE',   20,       14.29 ],
          ['EE',   25,       42.86 ],
          ['ME',   45,       42.86 ],
          ['NI',   10,       0 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 600, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Corporate' }
                );
      }      
      //google.setOnLoadCallback(drawVisualization);
	  
	function drawElectrical() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Electrical' ],
          ['FEE',   20,       20 ],
          ['EE',   25,       40 ],
          ['ME',   45,       30 ],
          ['NI',   10,       10 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('electrical')).
            draw(data, {curveType: "function",
                        width: 500, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Electrical' }
                );
      }      
      ////google.setOnLoadCallback(drawElectrical);	  
	  
	  function drawCorporate() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Corporate' ],
          ['FEE',   20,       14.29 ],
          ['EE',   25,       42.86 ],
          ['ME',   45,       42.86 ],
          ['NI',   10,       0 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('corporate')).
            draw(data, {curveType: "function",
                        width: 500, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Corporate' }
                );
      }      
      //google.setOnLoadCallback(drawCorporate);	  
	  
	  function drawMetallic() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Metallic' ],
          ['FEE',   5,       42.86 ],
          ['EE',   15,       28.57 ],
          ['ME',   70,       14.29 ],
          ['NI',   10,       14.29 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('metallic')).
            draw(data, {curveType: "function",
                        width: 500, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Metallic' }
                );
      }   
	  
	   function drawPantnagar() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Pantnagar' ],
          ['FEE',   20,       50 ],
          ['EE',   30,       50 ],
          ['ME',   50,       0 ],
          ['NI',   0,       0 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('pantnagar')).
            draw(data, {curveType: "function",
                        width: 500, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Pantnagar' }
                );
      }      
	  
	  function drawPolymer() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Polymer' ],
          ['FEE',   10,       28.57 ],
          ['EE',   20,       28.57 ],
          ['ME',   60,       28.57 ],
          ['NI',   10,       14.29 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('polymer')).
            draw(data, {curveType: "function",
                        width: 500, height: 500,
                        vAxis: {maxValue: 10},
						title: 'Polymer' }
                );
      }   
	  
	  function drawOverall() {
        // Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
          ['Definition', 'Actual', 'Overall' ],
          ['FEE',   15,       28.57 ],
          ['EE',   30,       37.14 ],
          ['ME',   45,       25.71 ],
          ['NI',   10,       8.57 ],
          ['BE',   0,       0 ]
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('overall')).
            draw(data, {curveType: "function",
                        width: 1100, height: 500,
                        vAxis: {maxValue: 100},
						title: 'Overall',
						vAxis: {4 : {gridlines: {color: '#DCDCDC', count: 3}}},
						vAxis: {minorGridlines: {color: '#DCDCDC', count: 10}},						
						vAxis: {5: {title: "Percentage %", titleTextStyle: {color: "green"}}} }
                );
      }      



	  function drawVisualization() {
	  	drawCorporate();
		drawElectrical();
		drawMetallic();
		drawPantnagar();
		drawPolymer();
		drawOverall();
	  }
	  
	  google.setOnLoadCallback(drawVisualization);
	  
    </script>
  </head>
<style>
	.graphbox { width:560px; height:520px; float:left; border:1px solid #CCCCCC; }
	.graphboxfull { width:1100px; height:520px; float:left; border:1px solid #CCCCCC; }
</style>  
  <body style="font-family: Arial;border: 0 none;">
	<div id="electrical" class="graphbox" ></div>
	<div id="corporate" class="graphbox"></div>
	<div id="metallic" class="graphbox"></div>
	<div id="pantnagar" class="graphbox"></div>
	<div id="polymer" class="graphbox"></div>
	<div style="clear:both; height:50px;"></div>
	<div id="overall" class="graphboxfull"></div>
  </body>
</html>
​