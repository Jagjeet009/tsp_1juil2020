<?php
//print_r($data['indicators']);
$question_options=array();
$q=$this->db->query("select json_data from survey_data where survey_id in (select title_url from survey_section where survey_id='".$data['survey_id']."') ");
if($q->num_rows()>0){
	$q=$q->result_array();
	foreach($q as $sqvt){
		$sqvt=(array) json_decode($sqvt['json_data']);
		if(array_key_exists("answer",$sqvt)){
			$q="answer_".strtolower($sqvt['question_no']);
			$options=array();			
			for($i=0;$i<count($sqvt['answer']);$i++){
				$sqvt_a=explode("|",$sqvt['answer'][$i]);
				preg_match("#<English>(.*?)</English>#", trim($sqvt_a[1]), $matches);
				$sqvt_a[1]=$matches[1];						
				$sqvt_a[1]=strip_tags($sqvt_a[1]);				
				$options[$sqvt_a[0]]=$sqvt_a[1];
			}
			$question_options[$q]=$options;
		}else{
			if(array_key_exists("rows",$sqvt) && array_key_exists("columns",$sqvt)){
				$sqvt_combine='';
				$sqvt_rows=$sqvt['rows'];
				$sqvt_columns=$sqvt['columns'];							
				for($i=0;$i<count($sqvt_rows);$i++){
					for($j=0;$j<count($sqvt_columns);$j++){
						if(isset($sqvt['type'][$j])){
							if($sqvt['type'][$j]=="Select" || $sqvt['type'][$j]=="Checkbox" || $sqvt['type'][$j]=="Radio" ){
							$q="answer_".strtolower($sqvt['question_no']."_".$i.$j);
							$options=array();								
								for($k=0;$k<count($sqvt['dropdown_choices'][$j]);$k++){
									$sqvt_a=explode("|",$sqvt['answer'][$i]);
									preg_match("#<English>(.*?)</English>#", trim($sqvt_a[1]), $matches);
									$sqvt_a[1]=$matches[1];						
									$sqvt_a[1]=strip_tags($sqvt_a[1]);				
									$options[$sqvt_a[0]]=$sqvt_a[1];									
								}	
							$question_options[$q]=$options;
							}
						}
					}
				}
			}
		}
	}
}
//print_r($data['rows'][0]);
if(isset($data['rows'][0])){
	$data_rows_temp="answer_".$data['rows'][0];		
	$data_rows_temp=strtolower($data_rows_temp);
	if(isset($question_options[$data_rows_temp])){
		$question_options=$question_options[$data_rows_temp];
	}
	if(isset($data['indicators'][$data['rows'][0]])){
		$indicator=$data['indicators'][$data['rows'][0]];
		//print_r($indicators);
	}	
	//print_r($data_rows_temp);
	//print_r($question_options);
	//die;
}
function GetCenterFromDegrees($data){
    if (!is_array($data)) return FALSE;

    $num_coords = count($data);

    $X = 0.0;
    $Y = 0.0;
    $Z = 0.0;

    foreach ($data as $coord)
    {
        $lat = $coord[0] * pi() / 180;
        $lon = $coord[1] * pi() / 180;

        $a = cos($lat) * cos($lon);
        $b = cos($lat) * sin($lon);
        $c = sin($lat);

        $X += $a;
        $Y += $b;
        $Z += $c;
    }

    $X /= $num_coords;
    $Y /= $num_coords;
    $Z /= $num_coords;

    $lon = atan2($Y, $X);
    $hyp = sqrt($X * $X + $Y * $Y);
    $lat = atan2($Z, $hyp);

    return array($lat * 180 / pi(), $lon * 180 / pi());
}
function random_color(){
	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
$q0=$this->Survey_model->get_survey_by_title_url($data['survey_id']);
$colors=array();
if($q0[0]['gps_enabled']==1 && sizeof($data['rows'])>0){
	$q=$this->db->query("select ".$data['rows'][0].",".$q0[0]['gps_lat_col'].",".$q0[0]['gps_long_col']." from analytics_".$data['survey_id']);
	//echo $this->db->last_query();
	$total=$q->num_rows();
	$coordinates=array();
	if($total>0){
		$q=$q->result_array();
		//print_r($q);
		foreach($q as $qq){
			//echo "`"."".$qq[$data['rows'][0]]."";
			//if(array_key_exists("".$qq[$data['rows'][0]]."",$colors)){
				$colors["".$qq[$data['rows'][0]].""]=random_color();
			//}
		}
		//print_r($colors);
		$json = '{
			"type": "FeatureCollection",
			"features": [';
			$i=0;
			foreach($q as $qq){
				//print_r($qq[$data['rows'][0]]);
				array_push($coordinates,array($qq[$q0[0]['gps_lat_col']],$qq[$q0[0]['gps_long_col']]));
				$i++;
				$json.= '{
							"type": "Feature",
							"geometry": {
								"type": "Point",
								"coordinates": ['.$qq[$q0[0]['gps_long_col']].', '.$qq[$q0[0]['gps_lat_col']].']
							},
							"properties": {
								"name": "'.$qq[$data['rows'][0]].'",
								"color": "'.$colors[$qq[$data['rows'][0]]].'",
								"location": ['.$qq[$q0[0]['gps_lat_col']].', '.$qq[$q0[0]['gps_long_col']].']
							}
						}';
				if($i!=$total){
					$json.=',';		
				}
			}
		$json.= '	
		]
		}';
	$result = json_decode($json);
	$bounds = GetCenterFromDegrees($coordinates);
	//print_r($coordinates);	
	//print_r(GetCenterFromDegrees($coordinates));	
	//echo $json;
	//$marker='';
	//$map=array("lat"=>"28.207609","long"=>"79.826660","zoom"=>"10","marker"=>$result);
	$map=array("lat"=>$bounds[0],"long"=>$bounds[1],"zoom"=>"10","marker"=>$result,"legend"=>$colors,"legendLabels"=>$question_options,"indicator"=>$indicator);	
	}else{
	$map=array("lat"=>$bounds[0],"long"=>$bounds[1],"zoom"=>"10","marker"=>array());	
	}
}else{
	$map=array("lat"=>21.0000,"long"=>78.0000,"zoom"=>"5","marker"=>array());		
}
echo json_encode($map);	
?>
