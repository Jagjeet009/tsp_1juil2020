<html>
	<body>
	
		<h1>bubble chart for min-3 column data-set and max-5 column data-set</h1>
		<p>2nd 3rd and 5th column input can't be string</p>
		<div name="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			//google.charts.load('current', {packages: ['corechart']});
			google.charts.setOnLoadCallback(drawMultSeries4);

			function drawMultSeries4() {
				var data = google.visualization.arrayToDataTable([
					['Element', 'energy','motivation','shade','size'],
					['jhon', 8.94,20,4,10],
					['rey', 10.49,43,7,8],
					['heinc', 19.30,23,10,6],
					['patric', 21.45,45,8,4],
				]);

				var options = {
					title: 'Motivation and Energy Level Throughout the Day',
					hAxis: {
						title: 'Time of Day'
					},
					vAxis: {
						title: 'level'
					},
					colorAxis: {colors: ['yellow','pink', 'red', '#0000ff']}
				};
				var c=document.getElementsByName('columnchart_values')[0];
				var chart = new google.visualization.BubbleChart(c);

				chart.draw(data, options);
				c.innerHTML=c.innerHTML+'<img style="display:none" src="' + chart.getImageURI() + '">';
			}
		</script>
	</body>
</html>