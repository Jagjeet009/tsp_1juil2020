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
	var td=editorfield.closest('td');
	var v=editorfield.val();
	td.focus();
	td.html(v);
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
	/*var f_td=$('#reportTable tbody tr:first-child td:first-child');
	console.log(f_td);
	f_td.focus();*/
	
	//only for input fields
    /*$('#reportTable td').keypress(function(event) {
		console.log($(this));
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
				//var cellindex = $(this).index()
				//var rowindex = $(this).parents('tr').index() + 1
				//$(this).parents('table').find('tr:eq('+rowindex+') td:eq('+cellindex+')').focus()
			}
			if(code == 113){		//113 for  fn+f2
				//alert("Edit Generating");
				tdToInput(e_td);
			}
			if(code==13){		//13 for enter
				inputToTd(ele);
			}
		}
    });*/
	
    $('#reportTable td').on( 'blur', 'input.editor-field', function (e) {
		inputToTd($(this));
    } );	
	
    // Activate a selected on click of a table cell
    $('#reportTable').on( 'focus', 'tbody td', function (e) {
		console.log("getting focus on: "+$(this));
        $('#reportTable td').removeClass('selected');
		$(this).addClass('selected');
    } );
	
	//stopped dont want
    // Activate an inline edit on double click of a table cell
    /*$('#reportTable').on( 'dblclick', 'tbody td', function (e) {
        tdToInput($(this));
    } );*/

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
		dom: '<"row"<"col-lg-4"l><"col-lg-4"B><"col-lg-4"f>>rtip',
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
					echo '<td>'.$qd[$field].'</td>';
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
