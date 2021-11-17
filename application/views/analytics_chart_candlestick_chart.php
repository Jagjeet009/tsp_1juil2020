<html>
	<body>
	
		<h1>candlestick chart for multiple data-set</h1>
		<p>only 1st column input can be string</p>
		<div name="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			//google.charts.load('current', {packages: ['corechart']});
			google.charts.setOnLoadCallback(drawMultSeries5);

			function drawMultSeries5() {
				var data = google.visualization.arrayToDataTable([
					['Element', 6,2,8,5],
					['jhon', 8.94,20,4,10],
					['rey', 10.49,43,7,8],
					['heinc', 19.30,23,10,6],
					['patric', 21.45,45,8,4],
				],true);

				var options = {
					title: 'Motivation and Energy Level Throughout the Day',
					//bar: { groupWidth: '100%' }, // Remove space between bars.
					hAxis: {
						title: 'Time of Day'
					},
					vAxis: {
						title: 'level'
					},
					candlestick: {
						fallingColor: { strokeWidth: 0, fill: '#a52714' }, // red
						risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
					}
				};
				var c=document.getElementsByName('columnchart_values')[0];
				var chart = new google.visualization.CandlestickChart(c);

				chart.draw(data, options);
				c.innerHTML=c.innerHTML+'<img style="display:none" src="' + chart.getImageURI() + '">';
			}
		</script>
	</body>
</html>