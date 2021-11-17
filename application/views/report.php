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
		foreach($excel_columns_array as $eca){
			$eca=str_replace('answer_','',$eca);
		?>
			<th><?php echo $eca; ?></th>
		<?php } ?>
	  </tr>
	</thead>
	<tbody>  
		<?php 
		foreach($survey_values as $sv){ 
			echo '<tr>';
			$json_data=(array) json_decode($sv['json_data']);
			foreach($excel_columns_array as $eca){
				if(array_key_exists($eca,$json_data)){
					if(!is_array($json_data[$eca])){
						echo '<td>'.$json_data[$eca].'</td>';
					}else{
						echo '<td>'.implode(',',$json_data[$eca]).'</td>';
					}
				}else{
					echo '<td></td>';
				}
			}
			echo '</tr>';			
		}?>
	<tbody>  
	<tfoot>  
	  <tr>
		<?php 
		foreach($excel_columns_array as $eca){
			$eca=str_replace('answer_','',$eca);
		?>
			<th><?php echo $eca; ?></th>
		<?php } ?>
	  </tr>
	</foot>
</table>
</div>
