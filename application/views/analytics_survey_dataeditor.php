<?php
$survey_id=$survey[0]['title_url'];
$database=$this->db->database;
$tablename='analytics_'.$survey_id;
$comment_arr=array();
$query = $this->db->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$database}' AND TABLE_NAME = '{$tablename}'");
if($query->num_rows()>0){
	$query=$query->result_array();
	foreach($query as $q){
		if($q['COLUMN_COMMENT']!=''){
			$comment_arr[$q['COLUMN_NAME']]=$q['COLUMN_COMMENT'];
		}
	}
}
//print_r($comment_arr);
?>
<style type="text/css">
.report-survey{margin:0 1px !important;border:1px solid #000;}
#computeRecodeModal select{height:auto !important;}
.operator-panel td{margin:0 !important;padding:0 !important;}	
.operator-buttons{margin:0 !important;width:100% !important;font-weight:900 !important;text-align:center !important;font-size:20px !important;}
.operator-panel tbody,tr,td,th{background-color:#FFF;}	
.operator-panel tbody,tr,td,th:hover{background-color:#FFF;}
#reportTable_wrapper thead .New{border:2px solid green;}	
#reportTable_wrapper thead .Removed{border:2px solid red;}
#reportTable_wrapper thead .Computed{border:2px solid blue;}
	
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/dataTables.select.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>theme/js/buttons.print.min.js"></script>
<script type="text/javascript">
function tdToInput(td){
	var v=td.html();
	var i='<input class="editor-field" style="width:'+td.css('width')+'" value="'+v+'" />';
	td.html(i);
	$('.editor-field').focus();
}	
function inputToTd(editorfield){
	$('#comment').html('Saving...');
	var td=editorfield.closest('td');
	var v=editorfield.val();
	var row_id=td.data('row-id');
	var column_id=td.data('column-id');
	var survey_id=td.data('survey-id');
	td.focus();
	td.html(v);
	//console.log(row_id+" "+column_id+" "+v);
	$.ajax({
		url: "<?php echo base_url(); ?>survey/analytics/updateentry/"+survey_id+"/"+row_id+"/"+column_id+"/"+v, // url where to submit the request
		type : "GET", // type of action POST || GET
		success : function(result) {
			$('#comment').html('');
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})	
	//callAjaxGet("<?php echo base_url(); ?>survey/analytics/updateentry/"+survey_id+"/"+row_id+"/"+column_id+"/"+v,'');
}		
$(document).ready(function() {
	/*
	//can be done by php 
		//giving rowIDs to all rows
		var rowid=0;
		$('#reportTable tbody tr').each( function () {
			rowid++;
			$(this).attr('data-rowid',rowid);
		});

		// tabindexing all columns
		var tabindex=0;
		$('#reportTable tbody td').each( function () {
			//console.log($(this));
			tabindex++;
			$(this).attr('tabindex',tabindex);
		});
	//can be done by php 
	*/
	
	//initialize focus on first td of first row
	var f_td=$('#reportTable tbody tr:first-child td:first-child');
	//console.log(f_td);
	f_td.focus();
	f_td.addClass('selected');
	
	//only for input fields
    $('#reportTable td').keypress(function(event) {
		//console.log($(this));
		var e_td=$(this);
		var ele=$(this).find('input.editor-field');
		var e_row=$(this).closest('tr');
		if(e_td.hasClass('selected')){
			code=event.which || event.keyCode;
			if(code == 46) {	//46 for delete button
				if(ele.length!==1){
					event.preventDefault();
					e_row.hide();
				}
			}
			/*if(code == 113){		//113 for  fn+f2
				//alert("Edit Generating");
				tdToInput(e_td);
			}*/
			if(code==13){		//13 for enter
				ele.trigger('blur');
			}
		}
    });
	
    $('#reportTable td').on( 'blur', 'input.editor-field', function (e) {
		inputToTd($(this));
    } );	
	
    // Activate a selected on click of a table cell
    $('#reportTable').on( 'focus', 'td', function (e) {
		//console.log("getting focus on: "+$(this));
        $('#reportTable td').removeClass('selected');
		$(this).addClass('selected');
    } );
	
	//stopped dont want
    // Activate an inline edit on double click of a table cell
    $('#reportTable').on( 'dblclick', 'tbody td:not(.not-editable)', function (e) {
        tdToInput($(this));
    } );

	// Setup - add a text input to each footer cell
    $('#reportTable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'." />' );
    } );
	 
    // DataTable
    var table = $('#reportTable').DataTable( {
		"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'/*,
			{
                text: 'Delete',
                key: '1',
                action: function ( e, dt, node, config ) {
                    alert( 'delete button' );
                }
            }*/
        ],
		dom: '<"row"<"col-lg-4"l><"col-lg-4"B><"col-lg-4"f>>rt<"info"i<"#comment">>p',
		//select: true,
        /*select: {
            style: 'selected',
            items: 'cell'
        },*/		
		"scrollX": true,
		"scrollY": "400px",
		"scrollCollapse": true,
		"paging": false,
		"aaSorting": []
		//"stripeClasses": []
		/*'createdRow': function( row, data, dataIndex ) {
			console.log(row);
			console.log(data);
			console.log(data);
			//$(row).attr('id', 'someID');
		}*/		
	});
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
</script>    
<div class="report-survey">
	<table id="reportTable" class="display nowrap cell-border order-column stripe">
	<thead>  
	  <tr>
		<?php 
		$fields = $this->db->list_fields('analytics_'.$survey_id);
		foreach ($fields as $field){
			$real_comment='';
			if(isset($comment_arr[$field])){
				$real_comment=$comment_arr[$field];
			}
			if($real_comment!=="New" && $real_comment!="Removed" && $real_comment!=""){
				$real_comment="Computed";
			}
		?>
			<th title="<?php echo $real_comment; ?>" class="<?php echo $real_comment; ?>"><?php echo $field; ?></th>
		<?php } ?>
	  </tr>
	</thead>	
	<tbody> 
		<?php 
		$query_data = $this->db->query('SELECT * FROM analytics_'.$survey_id);
		if($query_data->num_rows()>0){
			$query_data=$query_data->result_array();
			foreach($query_data as $qd){
				echo '<tr>';
				/*foreach($qd as $qdd){
					echo '<td>'.$qdd.'</td>';
				}*/
				foreach ($fields as $field){
					if($field!='id' && $field!='survey_case_id' && $field!='username'){
						echo '<td data-survey-id="'.$survey_id.'" data-row-id="'.$qd['survey_case_id'].'" data-column-id="'.$field.'">'.$qd[$field].'</td>';
					}else{
						echo '<td class="not-editable">'.$qd[$field].'</td>';
					}
				}
				echo '</tr>';
			}
		}
		?>	
	</tbody>  
	<tfoot>  
	  <tr>
		<?php 
		$fields = $this->db->list_fields('analytics_'.$survey_id);
		foreach ($fields as $field){
		?>
			<th><?php echo $field; ?></th>
		<?php } ?>
	  </tr>
	</foot>
</table>
</div>
