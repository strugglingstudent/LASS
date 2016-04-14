<?php
$id = trim($_GET["id"]);
$sensors = trim($_GET["sensors"]);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="tw">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="120" >
<title>[凌陽創新] 環境偵測系統</title>

<script src="../RGraph/libraries/RGraph.common.core.js"></script>
<script src="../RGraph/libraries/RGraph.common.dynamic.js"></script>
<script src="../RGraph/libraries/RGraph.gauge.js"></script>

<style type="text/css">    
/*General styles*/
body
{
	margin: 0;
	padding: 0;
	background: white url(http://www.red-team-design.com/wp-content/themes/redv2/images/back.jpg) no-repeat left top;
	overflow-y: hidden;
	overflow-x: hidden;
}

a:hover, a:visited, a:link, a:active
{
    text-decoration: none;
}

#main
{
	width: 780px;
	margin: 0 auto 0 auto;
	background: white;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	padding: 10px;
	border: 1px solid #adaa9f;
	-moz-box-shadow: 0 2px 2px #9c9c9c;
	-webkit-box-shadow: 0 2px 2px #9c9c9c;
}
</style>
<script>
    window.onload = function ()
    {
	RGraph.AJAX('rgraph_ajax.php?min=<?php echo $min; ?>&type=<?php echo $type; ?>', myCallback);

	setTimeout(window.onload, 60000); // 2000 milliseconds = 2 seconds
    }
</script>

<script>
    function myCallback ()
    {
       	dataJSON = JSON.parse(this.responseText);
        //alert(dataJSON.labels.length);

        /**
        * Start by resetting the canvas. Note that this also resets the antialiasing fix - but as the chart is being
        * recreated entirely each call - this is OK.
        */
        RGraph.reset(document.getElementById('cvs'));

	if(dataJSON.labels.length>10) {
		xLine = false;
	}else{
		xLine = true;
	}

	var labels = dataJSON.labels;

        var line = new RGraph.Line({
            id: 'cvs',
            data: dataJSON.data,
            options: {
		title: dataJSON.title + ' ' + dataJSON.sensortype,
		titleY: 15,
                spline: true,
                labels: labels,
		labelsAbove: false,
		labelsAboveUnitsPost: dataJSON.unit,
		labelsIngraph: dataJSON.display,
                tooltips: labels,
                gutterBottom: 35,
                hmargin: 35,
                tickmarks: 'endcircle',
                linewidth: 2,
                noaxes: false,
                ylabels: true,
		ylabelsInside: true,
		ymin: dataJSON.minv,
		ymax: dataJSON.maxv,
                backgroundGridBorder: true,
                backgroundGridVlines: xLine,
                titleYaxis: dataJSON.unit,
		titleYaxisX: 10,
                textColor: '#666'
            }
        }).trace2()
        
        var yaxis = new RGraph.Drawing.YAxis({
            id: 'cvs',
            x: 20,
            options: {
                gutterTop: 15,
                gutterBottom: 45,
                max: 10,
                align: 'right',
                textColor: '#666',
                unitsPost: dataJSON.unit,
                colors: ['rgba(0,0,0,0)']
            }
        }).draw();

    }

</script>

</head>
<body>
	<div id="main">
		<a href="index.php"><img src="header.png" border="0"></a>
		<table class="features-table">
				<thead><tr><td align='center'>
					<canvas id="cvs" width="780" height="450">
					[No canvas support]
					</canvas>
				</td></tr></thead>
		</table>		
		<img src="footer.png">
	</div>
</body>
</html>

