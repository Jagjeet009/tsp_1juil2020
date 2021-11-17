<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<?php 
$real_indicator=array();
$indi=array();					
$indicators=(array) json_decode($survey['indicator']);
foreach($indicators as $k=>$v){
	if($v!='' && strstr($k,"indicator_")!=false){
		$indi[$k]=$v;
	}
}
$real_indicator[$key]=$indi[$key];
//print_r($real_indicator);

$key=str_replace('indicator_','',$key);
$query=$this->db->query("select json_data from survey_data where json_data like '%".$key."%' && survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
$query=$query->result_array();
$real_options=array();
if(sizeof($query)<2 && sizeof($query)>0){
	$o=(array) json_decode($query[0]['json_data']);
	if(isset($o['answer'])){
		$o=$o['answer'];
		if(sizeof($o)>1){
			foreach($o as $oo){
				$oo=explode('|',$oo);
				$real_options[$oo[0]]=$oo[1];
			}
		}
	}
}
//print_r($real_options);

$query=$this->db->query("select json_data from survey_values where survey_id='".$survey_id."' ");
$query=$query->result_array();
$real_values=array();
foreach($real_options as $key=>$val){
	$matches='';
	preg_match("#<English>(.*?)</English>#", $val, $matches);
	if(sizeof($matches)>0){
		$val=$matches[1];
	}	
	$real_values[$val]=0;
}
foreach($query as $q){
	$v=(array) json_decode($q['json_data']);
	//print_r($v);
	$a_key=str_replace('indicator_','answer_',key($real_indicator));
	if(array_key_exists($a_key,$v)){
		$a_val=$v[$a_key];
		foreach($real_options as $key=>$val){
			if($a_val==$key){
				$matches='';
				preg_match("#<English>(.*?)</English>#", $val, $matches);
				if(sizeof($matches)>0){
					$val=$matches[1];
				}				
				$real_values[$val]=$real_values[$val]+1;
			}
		}
	}
}
//print_r($real_values);
?>
<style type="text/css">
.google-visualization-table-div-page [role="button"]{font-size:20px;}
.headerRow{font-size:13px;font-weight:bold;text-transform: uppercase;color:#fff;background-color:#d66100;}
.tableRow{font-size:13px;}
.oddTableRow{font-size:13px;}
.selectedTableRow{font-size:13px;}
.hoverTableRow{font-size:13px;}
.headerCell{font-size:13px;}
.tableCell{font-size:13px;}
.rowNumberCell{font-size:13px;}
</style>
<script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
		  var cssClassNames = {
			'headerRow': 'headerRow',
			'tableRow': 'tableRow',
			'oddTableRow': 'oddTableRow',
			'selectedTableRow': 'selectedTableRow',
			'hoverTableRow': 'hoverTableRow',
			'headerCell': 'headerCell',
			'tableCell': 'tableCell',
			'rowNumberCell': 'rowNumberCell'
		  };
		  
        var data = new google.visualization.DataTable();
		  
        data.addColumn('string', 'Options');
        data.addColumn('number', 'Count');
        data.addRows([
		<?php 
		$i=-1;foreach($real_values as $k=>$v){$i++;
			if($i==sizeof($real_values)-1){
				echo "['".$k."',     ".$v."]\r\n";
			}else{
				echo "['".$k."',     ".$v."],\r\n";
			}
		}
		?>
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        var options = {
          	//title: '<?php echo $real_indicator[key($real_indicator)]; ?>',
			width: '100%', 
			height: 'auto',
			showRowNumber: true,
			page: 'enable',
			pageSize: 2,
			fontSize: 25,
			/*pagingSymbols: {
				prev: '<',
				next: '>'
			},*/
			pagingButtonsConfiguration: 'auto',
			cssClassNames: cssClassNames
        };

        table.draw(data,options);
      }
    </script>
<div id="table_div" style="width:770px;height:400px;"></div>    