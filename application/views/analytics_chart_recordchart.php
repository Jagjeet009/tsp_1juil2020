<?php
$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$rand = '';
$i = 0;
$length = 5;
while ($i < $length) { // Loop until you have met the length
$num = rand() % strlen($salt);
$tmp = substr($salt, $num, 1);
$rand = $rand . $tmp;
$i++;
}
$start_record_data='';
$start_record=$this->db->query("select DISTINCT(DATE(FROM_UNIXTIME(add_date))) as d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second from survey where title_url='".$survey_id."'");
if($start_record->num_rows()>0){
        $start_record=$start_record->result_array();
        $start_record_data=$start_record[0];
}
//echo $rand;
$records=array();
$q=$this->db->query("select DISTINCT(DATE(FROM_UNIXTIME(add_date))) as d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second, count(*) as total from survey_values where survey_id='".$survey_id."' group by d");
//$q=$this->db->query("select DISTINCT(DATE_FORMAT(FROM_UNIXTIME(`add_date`), '%Y-%m-%d %H:%i:%s')) AS d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second, count(*) as total from survey_values where survey_id='".$survey_id."' group by d");
//echo $this->db->last_query();
if($q->num_rows()>0){
	$records=$q->result_array();
}

?>
<script type="text/javascript">
google.setOnLoadCallback(drawChart<?php echo $rand ?>);
function drawChart<?php echo $rand ?>() {
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'X');
    data.addColumn('number', 'Y1');
	data.addColumn({type: 'string', role: 'annotation'});

        data.addRow([new Date(<?php echo $start_record_data['Year']; ?>, <?php echo ($start_record_data['Month']-1); ?>, <?php echo $start_record_data['Day']; ?>, <?php echo $start_record_data['Hour']; ?>, <?php echo $start_record_data['Minute']; ?>, <?php echo $start_record_data['Second']; ?>), <?php echo "0"; ?>, "<?php echo "0"; ?>"]);
	<?php foreach($records as $rec){?>
	data.addRow([new Date(<?php echo $rec['Year']; ?>, <?php echo ($rec['Month']-1); ?>, <?php echo $rec['Day']; ?>, <?php echo $rec['Hour']; ?>, <?php echo $rec['Minute']; ?>, <?php echo $rec['Second']; ?>), <?php echo $rec['total']; ?>, "<?php echo $rec['total']; ?>"]);
	<?php } ?>
	/*data.addRow([new Date(2016, 0,1), 1, "1"]);
	data.addRow([new Date(2016, 1,1), 6, "6"]);
	data.addRow([new Date(2016, 2,1), 4, "4"]);
	data.addRow([new Date(2016, 3,1), 23, "23"]);
	data.addRow([new Date(2016, 4,1), 89, "89"]);
	data.addRow([new Date(2016, 5,1), 46, "46"]);
	data.addRow([new Date(2016, 6,1), 178, "178"]);
	data.addRow([new Date(2016, 7,1), 12, "12"]);
	data.addRow([new Date(2016, 8,1), 123, "123"]);
	data.addRow([new Date(2016, 9,1), 144, "144"]);
	data.addRow([new Date(2016, 10,1), 135, "135"]);
	data.addRow([new Date(2016, 11,1), 178, "178"]);*/

    var dash = new google.visualization.Dashboard(document.getElementById('dashboard_<?php echo $rand ?>'));
    var control = new google.visualization.ControlWrapper({
        controlType: 'ChartRangeFilter',
        containerId: 'control_div_<?php echo $rand ?>',
        options: {
            filterColumnIndex: 0,
            ui: {
                chartOptions: {
                    height: 40,
                    width: 1000,
                    chartArea: {
                        width: '98%'
                    },
					annotations: {
						highContrast: false,
						stem: {
							color: 'transparent',
							length: 0
						},
						textStyle: {
							color: 'transparent'
						}
					}
                }
            }
        }
    });
    var chart = new google.visualization.ChartWrapper({
        chartType: 'LineChart',
        containerId: 'chart_div<?php echo $rand ?>_<?php echo $rand ?>'
    });

    function setOptions (wrapper) {
        wrapper.setOption('width', 1000);
        wrapper.setOption('height', 300);		
        wrapper.setOption('chartArea.width', '98%');
		wrapper.setOption("pointSize",5);
		wrapper.setOption("pointsVisible",true);
		wrapper.setOption("colors",['#C35500']);
    }
    
    setOptions(chart);

    dash.bind([control], [chart]);
    dash.draw(data);
  	google.visualization.events.addListener(control, 'statechange', function () {
		var c=document.getElementById('dashboard_<?php echo $rand ?>');
		c.insertAdjacentHTML('beforeend', '<img style="display:none;" src="' + chart.getChart().getImageURI() + '">');
		//console.log(control);
        //var v = control.getState();
        //document.getElementById('dbgchart_<?php echo $rand ?>').innerHTML = v.range.start+ ' to ' +v.range.end;
        return 0;
    });
	
	google.visualization.events.addListener(chart, 'ready', function() {
		var c=document.getElementById('dashboard_<?php echo $rand ?>');
		c.insertAdjacentHTML('beforeend', '<img style="display:none;" src="' + chart.getChart().getImageURI() + '">');
	});
}

</script>
<div id="dashboard_<?php echo $rand ?>" class="columnchart_values">
    <div id="chart_div<?php echo $rand ?>_<?php echo $rand ?>"></div>
    <div id="control_div_<?php echo $rand ?>"></div>
<p><span id='dbgchart_<?php echo $rand ?>'></span></p>
</div>