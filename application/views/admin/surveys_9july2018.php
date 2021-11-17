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
					<th>a01</th>
					<th>a02</th>
					<th>a03</th>
					<th>a04</th>
					<th>a05</th>
					<th>a06</th>
					<th>a07</th>
					<th>a08</th>
					<th>a09</th>
					<th>a10</th>
					<th>a11</th>
					<th>a12</th>
					<th>a13</th>
					<th>a14</th>
					<th>a15</th>
					<th>a16_0</th>
					<th>a16_1</th>
					<th>a17</th>
					<th>a17_oth</th>
					<th>a18</th>
					<th>a19_00</th>
					<th>a19_01</th>
					<th>a20</th>
					<th>a21</th>
					<th>a21_oth</th>
					<th>a22_00</th>
					<th>a22_10</th>
					<th>a22_20</th>
					<th>a23</th>
					<th>a24</th>
					<th>a24_oth</th>
					<th>a25_0</th>
					<th>a25_1</th>
					<th>a26</th>
					<th>a26_oth</th>
					<th>b01</th>
					<th>b01_oth</th>
					<th>b02_00</th>
					<th>b02_10</th>
					<th>b02_20</th>
					<th>b02_30</th>
					<th>b02_40</th>
					<th>b02_50</th>
					<th>b02_60</th>
					<th>b02_70</th>
					<th>b02_80</th>
					<th>b02_90</th>
					<th>c01</th>
					<th>c02</th>
					<th>c03_00</th>
					<th>c03_10</th>
					<th>c03_20</th>
					<th>c03_30</th>
					<th>c03_40</th>
					<th>c03_50</th>
					<th>c03_60</th>
					<th>c03_70</th>
					<th>c03a</th>
					<th>d01</th>
					<th>d01_oth</th>
					<th>d02</th>
					<th>d03</th>
					<th>d04_00</th>
					<th>d04_01</th>
					<th>d05_00</th>
					<th>d05_01</th>
					<th>d06_00</th>
					<th>d06_01</th>
					<th>d07_00</th>
					<th>d07_01</th>
					<th>d08_00</th>
					<th>d08_01</th>
					<th>d09</th>
					<th>d09_oth</th>
					<th>d10_00</th>
					<th>d10_01</th>
					<th>d10_02</th>
					<th>d10_03</th>
					<th>d10_04</th>
					<th>d10_10</th>
					<th>d10_11</th>
					<th>d10_12</th>
					<th>d10_13</th>
					<th>d10_14</th>
					<th>d10_20</th>
					<th>d10_21</th>
					<th>d10_22</th>
					<th>d10_23</th>
					<th>d10_24</th>
					<th>d10_30</th>
					<th>d10_31</th>
					<th>d10_32</th>
					<th>d10_33</th>
					<th>d10_34</th>
					<th>d10a</th>
					<th>d11</th>
					<th>d12</th>
					<th>d12a</th>
					<th>d13</th>
					<th>d14</th>
					<th>d15_00</th>
					<th>d15_01</th>
					<th>d15_10</th>
					<th>d15_11</th>
					<th>d15_20</th>
					<th>d15_21</th>
					<th>d15_30</th>
					<th>d15_31</th>
					<th>d15_40</th>
					<th>d15_41</th>
					<th>d15_50</th>
					<th>d15_51</th>
					<th>d16_00</th>
					<th>d16_01</th>
					<th>d17_00</th>
					<th>d17_01</th>
					<th>d18_00</th>
					<th>d18_01</th>
					<th>d18_02</th>
					<th>d18_10</th>
					<th>d18_11</th>
					<th>d18_12</th>
					<th>d18_20</th>
					<th>d18_21</th>
					<th>d18_22</th>
					<th>d18_30</th>
					<th>d18_31</th>
					<th>d18_32</th>
					<th>d18_40</th>
					<th>d18_41</th>
					<th>d18_42</th>
					<th>d18_50</th>
					<th>d18_51</th>
					<th>d18_52</th>
					<th>d18_60</th>
					<th>d18_61</th>
					<th>d18_62</th>
					<th>d18a</th>
					<th>d18b</th>
					<th>d19</th>
					<th>d20</th>
					<th>d20_oth</th>
					<th>h_d21a</th>
					<th>m_d21a</th>
					<th>h_d21b</th>
					<th>m_d21b</th>
					<th>d22</th>
					<th>d23</th>
					<th>d24</th>
					<th>d25</th>
					<th>d26_1</th>
					<th>d26_2</th>
					<th>d26_3</th>
					<th>d26_4</th>
					<th>d26_5</th>
					<th>d26_6</th>
					<th>d26_7</th>
					<th>d26_8</th>
					<th>d26_9</th>
					<th>d26_10</th>
					<th>d26_11</th>
					<th>d26_12</th>
					<th>d26_99</th>
					<th>d27</th>
					<th>d27_oth</th>
					<th>d28</th>
					<th>d29a</th>
					<th>d29a_oth</th>
					<th>d29b</th>
					<th>d29b_oth</th>
					<th>d29c</th>
					<th>d29d_0</th>
					<th>d29e_1</th>
					<th>d29e_2</th>
					<th>d29e_3</th>
					<th>d29f_1</th>
					<th>d29f_2</th>
					<th>d29f_3</th>
					<th>d29f_4</th>
					<th>d29f_5</th>
					<th>d29f_99</th>
					<th>d29f_88</th>
					<th>d29f_oth</th>
					<th>d29g</th>
					<th>d29h</th>
					<th>d29i</th>
					<th>d29j_0</th>
					<th>d29j_1</th>
					<th>d29j_2</th>
					<th>d30a</th>
					<th>d30b</th>
					<th>d30b_oth</th>
					<th>d30c</th>
					<th>d30d</th>
					<th>d30e</th>
					<th>d30f</th>
					<th>d30f_oth</th>
					<th>d30g</th>
					<th>d30h_00</th>
					<th>d30h_01</th>
					<th>d30i</th>
					<th>d31a</th>
					<th>d31b</th>
					<th>d31b_oth</th>
					<th>d31c</th>
					<th>d31d</th>
					<th>d31e</th>
					<th>d31f</th>
					<th>d31g_00</th>
					<th>d31g_10</th>
					<th>d31h</th>
					<th>d31i</th>
					<th>d31j</th>
					<th>d32a</th>
					<th>d32b</th>
					<th>d32c</th>
					<th>d32c_oth</th>
					<th>d32d</th>
					<th>d32e</th>
					<th>dd_d32f1</th>
					<th>mm_d32f1</th>
					<th>yyyy_d32f1</th>
					<th>d32f2</th>
					<th>d32g</th>
					<th>d32h</th>
					<th>d32i</th>
					<th>d32i_oth</th>
					<th>d32j</th>
					<th>d32j_oth</th>
					<th>d32k</th>
					<th>d32k_oth</th>
					<th>d32l</th>
					<th>d32m</th>
					<th>d32n</th>
					<th>d32o</th>
					<th>d32p_1</th>
					<th>d32p_2</th>
					<th>d32p_3</th>
					<th>d32p_4</th>
					<th>d32p_5</th>
					<th>d32p_6</th>
					<th>d32p_7</th>
					<th>d32p_88</th>
					<th>d32p_oth</th>
					<th>e01</th>
					<th>e02_1</th>
					<th>e02_2</th>
					<th>e02_3</th>
					<th>e02_4</th>
					<th>e02_5</th>
					<th>e02_88</th>
					<th>e02_oth</th>
					<th>e03</th>
					<th>e03_oth</th>
					<th>e04</th>
					<th>e04_oth</th>
					<th>e05</th>
					<th>e06</th>
					<th>e06_oth</th>
					<th>e07</th>
					<th>e08</th>
					<th>f01_00</th>
					<th>f01_01</th>
					<th>f01_02</th>
					<th>f01_10</th>
					<th>f01_11</th>
					<th>f01_12</th>
					<th>f01_20</th>
					<th>f01_21</th>
					<th>f01_22</th>
					<th>f01_30</th>
					<th>f01_31</th>
					<th>f01_32</th>
					<th>f01_40</th>
					<th>f01_41</th>
					<th>f01_42</th>
					<th>f01_50</th>
					<th>f01_51</th>
					<th>f01_52</th>
					<th>f01_60</th>
					<th>f01_61</th>
					<th>f01_62</th>
					<th>f01a</th>
					<th>f01b</th>
					<th>f02_00</th>
					<th>f02_10</th>
					<th>f02_20</th>
					<th>f02_30</th>
					<th>f02_40</th>
					<th>f02_50</th>
					<th>f03</th>
					<th>f04_1</th>
					<th>f04_2</th>
					<th>f04_3</th>
					<th>f04_88</th>
					<th>f04_oth</th>
					<th>f05</th>
					<th>f06_1</th>
					<th>f06_2</th>
					<th>f06_3</th>
					<th>f06_4</th>
					<th>f06_5</th>
					<th>f06_6</th>
					<th>f06_7</th>
					<th>f06_88</th>
					<th>f06_oth</th>
					<th>g01_00</th>
					<th>g01_01_1</th>
					<th>g01_01_2</th>
					<th>g01_01_3</th>
					<th>g01_01_4</th>
					<th>g01_01_5</th>
					<th>g01_01_99</th>
					<th>g01_01_88</th>
					<th>g01_01_oth</th>
					<th>g02_00</th>
					<th>g02_01_1</th>
					<th>g02_01_2</th>
					<th>g02_01_3</th>
					<th>g02_01_4</th>
					<th>g02_01_5</th>
					<th>g02_01_99</th>
					<th>g02_01_88</th>
					<th>g02_01_oth</th>
					<th>g03_00</th>
					<th>g03_01_1</th>
					<th>g03_01_2</th>
					<th>g03_01_3</th>
					<th>g03_01_4</th>
					<th>g03_01_5</th>
					<th>g03_01_99</th>
					<th>g03_01_88</th>
					<th>g03_01_oth</th>
					<th>g04_00</th>
					<th>g04_01_1</th>
					<th>g04_01_2</th>
					<th>g04_01_3</th>
					<th>g04_01_4</th>
					<th>g04_01_5</th>
					<th>g04_01_99</th>
					<th>g04_01_88</th>
					<th>g04_01_oth</th>
					<th>g05_00</th>
					<th>g05_01_1</th>
					<th>g05_01_2</th>
					<th>g05_01_3</th>
					<th>g05_01_4</th>
					<th>g05_01_5</th>
					<th>g05_01_99</th>
					<th>g05_01_88</th>
					<th>g05_01_oth</th>
					<th>g06_00</th>
					<th>g06_01_1</th>
					<th>g06_01_2</th>
					<th>g06_01_3</th>
					<th>g06_01_4</th>
					<th>g06_01_5</th>
					<th>g06_01_99</th>
					<th>g06_01_88</th>
					<th>g06_01_oth</th>
					<th>g07_00</th>
					<th>g07_01_1</th>
					<th>g07_01_2</th>
					<th>g07_01_3</th>
					<th>g07_01_4</th>
					<th>g07_01_5</th>
					<th>g07_01_99</th>
					<th>g07_01_88</th>
					<th>g07_01_oth</th>
					<th>g07a</th>
					<th>g08_00_1</th>
					<th>g08_00_2</th>
					<th>g08_00_3</th>
					<th>g08_00_4</th>
					<th>g08_00_5</th>
					<th>g08_00_6</th>
					<th>g08_00_88</th>
					<th>g08_00_oth</th>
					<th>g08_10_1</th>
					<th>g08_10_2</th>
					<th>g08_10_3</th>
					<th>g08_10_4</th>
					<th>g08_10_5</th>
					<th>g08_10_6</th>
					<th>g08_10_88</th>
					<th>g08_10_oth</th>
					<th>g08_20_1</th>
					<th>g08_20_2</th>
					<th>g08_20_3</th>
					<th>g08_20_4</th>
					<th>g08_20_5</th>
					<th>g08_20_6</th>
					<th>g08_20_88</th>
					<th>g08_20_oth</th>
					<th>g08_30_1</th>
					<th>g08_30_2</th>
					<th>g08_30_3</th>
					<th>g08_30_4</th>
					<th>g08_30_5</th>
					<th>g08_30_6</th>
					<th>g08_30_88</th>
					<th>g08_30_oth</th>
					<th>g08_40_1</th>
					<th>g08_40_2</th>
					<th>g08_40_3</th>
					<th>g08_40_4</th>
					<th>g08_40_5</th>
					<th>g08_40_6</th>
					<th>g08_40_88</th>
					<th>g08_40_oth</th>
					<th>g08_50_1</th>
					<th>g08_50_2</th>
					<th>g08_50_3</th>
					<th>g08_50_4</th>
					<th>g08_50_5</th>
					<th>g08_50_6</th>
					<th>g08_50_88</th>
					<th>g08_50_oth</th>
					<th>g08_60_1</th>
					<th>g08_60_2</th>
					<th>g08_60_3</th>
					<th>g08_60_4</th>
					<th>g08_60_5</th>
					<th>g08_60_6</th>
					<th>g08_60_88</th>
					<th>g08_60_oth</th>
					<th>g08a</th>
					<th>g09_00</th>
					<th>g09_10</th>
					<th>g09_20</th>
					<th>g09_30</th>
					<th>g09_40</th>
					<th>g09_50</th>
					<th>g09_60</th>
					<th>g09_70</th>
					<th>g10</th>
					<th>g10_oth</th>
					<th>g11_00</th>
					<th>g11_00_oth</th>
					<th>g11_10</th>
					<th>g11_10_oth</th>
					<th>g11_20</th>
					<th>g11_20_oth</th>
					<th>g11_30</th>
					<th>g11_30_oth</th>
					<th>g11_40</th>
					<th>g11_40_oth</th>
					<th>g11_50</th>
					<th>g11_50_oth</th>
					<th>g11a</th>
					<th>g12</th>
					<th>g12_oth</th>
					<th>g13_1</th>
					<th>g13_2</th>
					<th>g13_3</th>
					<th>g13_4</th>
					<th>g13a</th>
					<th>g13b</th>
					<th>g14</th>
					<th>g15_1</th>
					<th>g15_2</th>
					<th>g15_3</th>
					<th>g15_4</th>
					<th>g15_5</th>
					<th>g15_88</th>
					<th>g15_oth</th>
					<th>g16_00</th>
					<th>g16_01_1</th>
					<th>g16_01_2</th>
					<th>g16_01_3</th>
					<th>g16_01_4</th>
					<th>g16_01_5</th>
					<th>g17_00</th>
					<th>g17_01_1</th>
					<th>g17_01_2</th>
					<th>g17_01_3</th>
					<th>g17_01_4</th>
					<th>g17_01_5</th>
					<th>g18_00</th>
					<th>g18_01_1</th>
					<th>g18_01_2</th>
					<th>g18_01_3</th>
					<th>g18_01_4</th>
					<th>g18_01_5</th>
					<th>g19_00</th>
					<th>g19_01_1</th>
					<th>g19_01_2</th>
					<th>g19_01_3</th>
					<th>g19_01_4</th>
					<th>g19_01_5</th>
					<th>g20_00</th>
					<th>g20_01_1</th>
					<th>g20_01_2</th>
					<th>g20_01_3</th>
					<th>g20_01_4</th>
					<th>g20_01_5</th>
					<th>g21_00</th>
					<th>g21_01_1</th>
					<th>g21_01_2</th>
					<th>g21_01_3</th>
					<th>g21_01_4</th>
					<th>g21_01_5</th>
					<th>g22_00</th>
					<th>g22_01_1</th>
					<th>g22_01_2</th>
					<th>g22_01_3</th>
					<th>g22_01_4</th>
					<th>g22_01_5</th>
					<th>g22a</th>
					<th>g23</th>
					<th>g24</th>
					<th>g25</th>
					<th>g26</th>
					<th>g27</th>
					<th>g28</th>
					<th>g29</th>
					<th>g30</th>
					<th>g31</th>
					<th>g31_oth</th>
					<th>g32</th>
					<th>g33</th>
					<th>h01</th>
					<th>h02</th>
					<th>h03</th>
					<th>h04</th>
					<th>h05</th>
					<th>h06</th>
					<th>h07</th>
					<th>mm_h08</th>
					<th>yyyy_h08</th>
					<th>h09</th>
					<th>h10</th>
					<th>h11_00</th>
					<th>h11_01</th>
					<th>h12</th>
					<th>h13_1</th>
					<th>h13_2</th>
					<th>h13_3</th>
					<th>h13_88</th>
					<th>h13_oth</th>
					<th>h14</th>
					<th>h14_oth</th>
					<th>h15_1</th>
					<th>h15_2</th>
					<th>h15_3</th>
					<th>h15_4</th>
					<th>h15_5</th>
					<th>h15_111</th>
					<th>h16</th>
					<th>h_h16a</th>
					<th>m_h16a</th>
					<th>h_h16b</th>
					<th>m_h16b</th>
					<th>h17</th>
					<th>h17_oth</th>
					<th>h18</th>
					<th>i01</th>
					<th>i01_oth</th>
					<th>i02</th>
					<th>i03</th>
					<th>i03_oth</th>
					<th>i04_00</th>
					<th>i04_10</th>
					<th>i04_20</th>
					<th>i04_30</th>
					<th>i04_40</th>
					<th>i04_50</th>
					<th>i05</th>
					<th>i05_oth</th>
					<th>i06_00</th>
					<th>i06_01</th>
					<th>i07_1</th>
					<th>i07_2</th>
					<th>i07_3</th>
					<th>i07_88</th>
					<th>i07_oth</th>
					<th>j01</th>
					<th>j02</th>
					<th>j03</th>
					<th>j03_oth</th>
					<th>j04</th>
					<th>k01</th>
					<th>k02</th>
					<th>k03</th>
					<th>k04</th>
					<th>k05_1</th>
					<th>k05_2</th>
					<th>k05_3</th>
					<th>k05_4</th>
					<th>k05_5</th>
					<th>k05_6</th>
					<th>k05_88</th>
					<th>k05_oth</th>
					<th>k06</th>
					<th>k07_1</th>
					<th>k07_2</th>
					<th>k07_3</th>
					<th>k07_88</th>
					<th>k07_oth</th>
					<th>k08_1</th>
					<th>k08_2</th>
					<th>k08_3</th>
					<th>k08_4</th>
					<th>k08_5</th>
					<th>k08_6</th>
					<th>k08_88</th>
					<th>k08_oth</th>
					<th>k09_1</th>
					<th>k09_2</th>
					<th>k09_3</th>
					<th>k09_88</th>
					<th>k09_oth</th>
					<th>k10</th>
					<th>k11</th>
					<th>k12</th>
					<th>k13</th>
					<th>k14_1</th>
					<th>k14_2</th>
					<th>k14_3</th>
					<th>k14_4</th>
					<th>k14_5</th>
					<th>k14_6</th>
					<th>k14_7</th>
					<th>k14_8</th>
					<th>k14_9</th>
					<th>k14_10</th>
					<th>k14_88</th>
					<th>k14_oth</th>
					<th>k15</th>
					<th>k16_1</th>
					<th>k16_2</th>
					<th>k16_3</th>
					<th>k16_4</th>
					<th>k16_5</th>
					<th>k16_6</th>
					<th>k16_7</th>
					<th>k16_8</th>
					<th>k16_9</th>
					<th>k16_10</th>
					<th>k16_88</th>
					<th>k16_oth</th>
					<th>k17</th>
					<th>k17_oth</th>
			  </tr>
	</thead>
	<tbody>  
		<tr><td>Uttar Pradesh</td><td>28</td><td>Kushinagar</td><td>6</td><td>Kasya</td><td>4</td><td>Jaura Manrakhan</td><td>556</td><td>2</td><td></td><td>Abc</td><td>2</td><td></td><td>007</td><td>11</td><td></td><td></td><td>7</td><td></td><td>1</td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>8</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>200</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>1</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2000</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>150</td><td></td><td></td><td></td><td></td><td></td><td>50</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td>1</td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>2</td><td>took them to a new place</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td>2</td><td></td><td></td><td></td><td>1</td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>uttar pradesh</td><td>10</td><td>lakhimpur</td><td>11</td><td>atrauli</td><td>12</td><td>rampur</td><td>13</td><td>2</td><td></td><td>ramcharan verma</td><td>2</td><td></td><td>mini grid</td><td>200</td><td></td><td></td><td>6</td><td></td><td>1</td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>5</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>2</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2000</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>100</td><td></td><td></td><td></td><td></td><td></td><td>20</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td>1</td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td>2</td><td></td><td></td><td></td><td>1</td><td>1</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>25</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>4</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td>2</td><td></td><td></td><td></td><td>1</td><td>1</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>kjhjhjhj</td><td></td><td>,.m,n,mm.</td><td></td><td></td><td>jj</td><td>hhjhh</td><td>hghj</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>24</td><td>88</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>Uttar Pradesh</td><td>305</td><td>Kushinagar</td><td>274401</td><td>Kasya</td><td>25</td><td>Jaura</td><td>274401</td><td>5</td><td>Krishna Mohan Yadav</td><td>007</td><td>XYZ</td><td></td><td>2</td><td>321</td><td>28</td><td>77</td><td>1</td><td></td><td>1994</td><td>1</td><td>23</td><td>3</td><td>3</td><td></td><td>23</td><td>24</td><td>88</td><td>1</td><td></td><td></td><td>80</td><td>77</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>5</td><td></td><td>2</td><td>3</td><td>2</td><td>23</td><td>2</td><td>20</td><td>2</td><td>600</td><td>2</td><td>22</td><td>2</td><td>660</td><td>1</td><td></td><td>xyz</td><td>2</td><td>2</td><td>2</td><td>22</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td>2</td><td></td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>400</td><td></td><td>5</td><td>23</td><td>12</td><td>14</td><td>22</td><td>14</td><td>20</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>3</td><td>16</td><td>20</td><td>30</td><td>3</td><td>5</td><td></td><td></td><td></td><td>General Stores</td><td></td><td>1</td><td></td><td></td><td>14</td><td>00</td><td>15</td><td>30</td><td>6</td><td>1</td><td>2</td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td>8</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td>Sapan and co</td><td>200</td><td></td><td>2</td><td></td><td></td><td></td><td>3</td><td></td><td></td><td></td><td></td><td></td><td>20</td><td>18</td><td>2</td><td></td><td></td><td></td><td>1</td><td>2</td><td></td><td>2</td><td>25</td><td>2</td><td>1</td><td></td><td>23</td><td>1</td><td>300</td><td>30</td><td>23</td><td>2</td><td></td><td>2</td><td>1</td><td>5000</td><td>2</td><td></td><td></td><td>23</td><td>2</td><td></td><td>1</td><td>2</td><td>2</td><td></td><td>2</td><td>1</td><td></td><td></td><td></td><td></td><td>1</td><td>1</td><td></td><td></td><td>2</td><td></td><td>1</td><td></td><td>1</td><td>2</td><td>1</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>225</td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td>1400</td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>4</td><td></td><td>4</td><td></td><td>4</td><td></td><td>4</td><td></td><td>4</td><td></td><td>4</td><td></td><td>4</td><td></td><td>power loom</td><td>2</td><td></td><td></td><td></td><td>3</td><td>4</td><td></td><td></td><td>12</td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>100</td><td>2</td><td>12000</td><td>24000</td><td>2100</td><td>15000</td><td>20</td><td>3200</td><td>1</td><td></td><td>2</td><td></td><td>2</td><td>2</td><td></td><td></td><td>21</td><td>2</td><td></td><td></td><td></td><td>2</td><td>1</td><td>1</td><td>30</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>3</td><td>4</td><td></td><td></td><td>1</td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>1</td><td>3</td><td></td><td>2</td><td>2</td><td></td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td></td><td>2</td><td>14</td><td>1</td><td>2</td><td>3</td><td></td><td></td><td>2</td><td>1</td><td></td><td></td><td>1</td><td>1</td><td>1</td><td>1</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>1</td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td>2</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td>1</td><td>2</td><td></td><td></td><td>1</td><td>1</td><td>2</td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>fdssa</td><td>34</td><td>fds</td><td>432</td><td>fds</td><td>43</td><td>fds</td><td>434</td><td>53</td><td>fs</td><td>64</td><td>thf</td><td>htf</td><td>1</td><td>576yuh</td><td>677</td><td>7</td><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>gvdf</td><td>terw</td><td>rwed</td><td>feqw</td><td>grfeq</td><td>rfeq</td><td>tgrfewq</td><td>trfeqt</td><td>fchgvj</td><td>gvb</td><td>gvhj</td><td>gvh</td><td>nm</td><td>2</td><td>fchvjbh</td><td>54</td><td></td><td>1</td><td></td><td>2019</td><td>1</td><td>20000</td><td>3</td><td>7</td><td></td><td>23</td><td>4</td><td>42</td><td>1</td><td></td><td></td><td>23</td><td>678</td><td>4</td><td></td><td>4</td><td></td><td>4</td><td>3</td><td>1</td><td>4</td><td>2</td><td>2</td><td>3</td><td>5</td><td>4</td><td>4</td><td>2</td><td>1</td><td>1</td><td>2</td><td>2</td><td>1</td><td>3</td><td>4</td><td>4</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>	<tbody>  
	<tfoot>  
	  <tr>
					<th>a01</th>
					<th>a02</th>
					<th>a03</th>
					<th>a04</th>
					<th>a05</th>
					<th>a06</th>
					<th>a07</th>
					<th>a08</th>
					<th>a09</th>
					<th>a10</th>
					<th>a11</th>
					<th>a12</th>
					<th>a13</th>
					<th>a14</th>
					<th>a15</th>
					<th>a16_0</th>
					<th>a16_1</th>
					<th>a17</th>
					<th>a17_oth</th>
					<th>a18</th>
					<th>a19_00</th>
					<th>a19_01</th>
					<th>a20</th>
					<th>a21</th>
					<th>a21_oth</th>
					<th>a22_00</th>
					<th>a22_10</th>
					<th>a22_20</th>
					<th>a23</th>
					<th>a24</th>
					<th>a24_oth</th>
					<th>a25_0</th>
					<th>a25_1</th>
					<th>a26</th>
					<th>a26_oth</th>
					<th>b01</th>
					<th>b01_oth</th>
					<th>b02_00</th>
					<th>b02_10</th>
					<th>b02_20</th>
					<th>b02_30</th>
					<th>b02_40</th>
					<th>b02_50</th>
					<th>b02_60</th>
					<th>b02_70</th>
					<th>b02_80</th>
					<th>b02_90</th>
					<th>c01</th>
					<th>c02</th>
					<th>c03_00</th>
					<th>c03_10</th>
					<th>c03_20</th>
					<th>c03_30</th>
					<th>c03_40</th>
					<th>c03_50</th>
					<th>c03_60</th>
					<th>c03_70</th>
					<th>c03a</th>
					<th>d01</th>
					<th>d01_oth</th>
					<th>d02</th>
					<th>d03</th>
					<th>d04_00</th>
					<th>d04_01</th>
					<th>d05_00</th>
					<th>d05_01</th>
					<th>d06_00</th>
					<th>d06_01</th>
					<th>d07_00</th>
					<th>d07_01</th>
					<th>d08_00</th>
					<th>d08_01</th>
					<th>d09</th>
					<th>d09_oth</th>
					<th>d10_00</th>
					<th>d10_01</th>
					<th>d10_02</th>
					<th>d10_03</th>
					<th>d10_04</th>
					<th>d10_10</th>
					<th>d10_11</th>
					<th>d10_12</th>
					<th>d10_13</th>
					<th>d10_14</th>
					<th>d10_20</th>
					<th>d10_21</th>
					<th>d10_22</th>
					<th>d10_23</th>
					<th>d10_24</th>
					<th>d10_30</th>
					<th>d10_31</th>
					<th>d10_32</th>
					<th>d10_33</th>
					<th>d10_34</th>
					<th>d10a</th>
					<th>d11</th>
					<th>d12</th>
					<th>d12a</th>
					<th>d13</th>
					<th>d14</th>
					<th>d15_00</th>
					<th>d15_01</th>
					<th>d15_10</th>
					<th>d15_11</th>
					<th>d15_20</th>
					<th>d15_21</th>
					<th>d15_30</th>
					<th>d15_31</th>
					<th>d15_40</th>
					<th>d15_41</th>
					<th>d15_50</th>
					<th>d15_51</th>
					<th>d16_00</th>
					<th>d16_01</th>
					<th>d17_00</th>
					<th>d17_01</th>
					<th>d18_00</th>
					<th>d18_01</th>
					<th>d18_02</th>
					<th>d18_10</th>
					<th>d18_11</th>
					<th>d18_12</th>
					<th>d18_20</th>
					<th>d18_21</th>
					<th>d18_22</th>
					<th>d18_30</th>
					<th>d18_31</th>
					<th>d18_32</th>
					<th>d18_40</th>
					<th>d18_41</th>
					<th>d18_42</th>
					<th>d18_50</th>
					<th>d18_51</th>
					<th>d18_52</th>
					<th>d18_60</th>
					<th>d18_61</th>
					<th>d18_62</th>
					<th>d18a</th>
					<th>d18b</th>
					<th>d19</th>
					<th>d20</th>
					<th>d20_oth</th>
					<th>h_d21a</th>
					<th>m_d21a</th>
					<th>h_d21b</th>
					<th>m_d21b</th>
					<th>d22</th>
					<th>d23</th>
					<th>d24</th>
					<th>d25</th>
					<th>d26_1</th>
					<th>d26_2</th>
					<th>d26_3</th>
					<th>d26_4</th>
					<th>d26_5</th>
					<th>d26_6</th>
					<th>d26_7</th>
					<th>d26_8</th>
					<th>d26_9</th>
					<th>d26_10</th>
					<th>d26_11</th>
					<th>d26_12</th>
					<th>d26_99</th>
					<th>d27</th>
					<th>d27_oth</th>
					<th>d28</th>
					<th>d29a</th>
					<th>d29a_oth</th>
					<th>d29b</th>
					<th>d29b_oth</th>
					<th>d29c</th>
					<th>d29d_0</th>
					<th>d29e_1</th>
					<th>d29e_2</th>
					<th>d29e_3</th>
					<th>d29f_1</th>
					<th>d29f_2</th>
					<th>d29f_3</th>
					<th>d29f_4</th>
					<th>d29f_5</th>
					<th>d29f_99</th>
					<th>d29f_88</th>
					<th>d29f_oth</th>
					<th>d29g</th>
					<th>d29h</th>
					<th>d29i</th>
					<th>d29j_0</th>
					<th>d29j_1</th>
					<th>d29j_2</th>
					<th>d30a</th>
					<th>d30b</th>
					<th>d30b_oth</th>
					<th>d30c</th>
					<th>d30d</th>
					<th>d30e</th>
					<th>d30f</th>
					<th>d30f_oth</th>
					<th>d30g</th>
					<th>d30h_00</th>
					<th>d30h_01</th>
					<th>d30i</th>
					<th>d31a</th>
					<th>d31b</th>
					<th>d31b_oth</th>
					<th>d31c</th>
					<th>d31d</th>
					<th>d31e</th>
					<th>d31f</th>
					<th>d31g_00</th>
					<th>d31g_10</th>
					<th>d31h</th>
					<th>d31i</th>
					<th>d31j</th>
					<th>d32a</th>
					<th>d32b</th>
					<th>d32c</th>
					<th>d32c_oth</th>
					<th>d32d</th>
					<th>d32e</th>
					<th>dd_d32f1</th>
					<th>mm_d32f1</th>
					<th>yyyy_d32f1</th>
					<th>d32f2</th>
					<th>d32g</th>
					<th>d32h</th>
					<th>d32i</th>
					<th>d32i_oth</th>
					<th>d32j</th>
					<th>d32j_oth</th>
					<th>d32k</th>
					<th>d32k_oth</th>
					<th>d32l</th>
					<th>d32m</th>
					<th>d32n</th>
					<th>d32o</th>
					<th>d32p_1</th>
					<th>d32p_2</th>
					<th>d32p_3</th>
					<th>d32p_4</th>
					<th>d32p_5</th>
					<th>d32p_6</th>
					<th>d32p_7</th>
					<th>d32p_88</th>
					<th>d32p_oth</th>
					<th>e01</th>
					<th>e02_1</th>
					<th>e02_2</th>
					<th>e02_3</th>
					<th>e02_4</th>
					<th>e02_5</th>
					<th>e02_88</th>
					<th>e02_oth</th>
					<th>e03</th>
					<th>e03_oth</th>
					<th>e04</th>
					<th>e04_oth</th>
					<th>e05</th>
					<th>e06</th>
					<th>e06_oth</th>
					<th>e07</th>
					<th>e08</th>
					<th>f01_00</th>
					<th>f01_01</th>
					<th>f01_02</th>
					<th>f01_10</th>
					<th>f01_11</th>
					<th>f01_12</th>
					<th>f01_20</th>
					<th>f01_21</th>
					<th>f01_22</th>
					<th>f01_30</th>
					<th>f01_31</th>
					<th>f01_32</th>
					<th>f01_40</th>
					<th>f01_41</th>
					<th>f01_42</th>
					<th>f01_50</th>
					<th>f01_51</th>
					<th>f01_52</th>
					<th>f01_60</th>
					<th>f01_61</th>
					<th>f01_62</th>
					<th>f01a</th>
					<th>f01b</th>
					<th>f02_00</th>
					<th>f02_10</th>
					<th>f02_20</th>
					<th>f02_30</th>
					<th>f02_40</th>
					<th>f02_50</th>
					<th>f03</th>
					<th>f04_1</th>
					<th>f04_2</th>
					<th>f04_3</th>
					<th>f04_88</th>
					<th>f04_oth</th>
					<th>f05</th>
					<th>f06_1</th>
					<th>f06_2</th>
					<th>f06_3</th>
					<th>f06_4</th>
					<th>f06_5</th>
					<th>f06_6</th>
					<th>f06_7</th>
					<th>f06_88</th>
					<th>f06_oth</th>
					<th>g01_00</th>
					<th>g01_01_1</th>
					<th>g01_01_2</th>
					<th>g01_01_3</th>
					<th>g01_01_4</th>
					<th>g01_01_5</th>
					<th>g01_01_99</th>
					<th>g01_01_88</th>
					<th>g01_01_oth</th>
					<th>g02_00</th>
					<th>g02_01_1</th>
					<th>g02_01_2</th>
					<th>g02_01_3</th>
					<th>g02_01_4</th>
					<th>g02_01_5</th>
					<th>g02_01_99</th>
					<th>g02_01_88</th>
					<th>g02_01_oth</th>
					<th>g03_00</th>
					<th>g03_01_1</th>
					<th>g03_01_2</th>
					<th>g03_01_3</th>
					<th>g03_01_4</th>
					<th>g03_01_5</th>
					<th>g03_01_99</th>
					<th>g03_01_88</th>
					<th>g03_01_oth</th>
					<th>g04_00</th>
					<th>g04_01_1</th>
					<th>g04_01_2</th>
					<th>g04_01_3</th>
					<th>g04_01_4</th>
					<th>g04_01_5</th>
					<th>g04_01_99</th>
					<th>g04_01_88</th>
					<th>g04_01_oth</th>
					<th>g05_00</th>
					<th>g05_01_1</th>
					<th>g05_01_2</th>
					<th>g05_01_3</th>
					<th>g05_01_4</th>
					<th>g05_01_5</th>
					<th>g05_01_99</th>
					<th>g05_01_88</th>
					<th>g05_01_oth</th>
					<th>g06_00</th>
					<th>g06_01_1</th>
					<th>g06_01_2</th>
					<th>g06_01_3</th>
					<th>g06_01_4</th>
					<th>g06_01_5</th>
					<th>g06_01_99</th>
					<th>g06_01_88</th>
					<th>g06_01_oth</th>
					<th>g07_00</th>
					<th>g07_01_1</th>
					<th>g07_01_2</th>
					<th>g07_01_3</th>
					<th>g07_01_4</th>
					<th>g07_01_5</th>
					<th>g07_01_99</th>
					<th>g07_01_88</th>
					<th>g07_01_oth</th>
					<th>g07a</th>
					<th>g08_00_1</th>
					<th>g08_00_2</th>
					<th>g08_00_3</th>
					<th>g08_00_4</th>
					<th>g08_00_5</th>
					<th>g08_00_6</th>
					<th>g08_00_88</th>
					<th>g08_00_oth</th>
					<th>g08_10_1</th>
					<th>g08_10_2</th>
					<th>g08_10_3</th>
					<th>g08_10_4</th>
					<th>g08_10_5</th>
					<th>g08_10_6</th>
					<th>g08_10_88</th>
					<th>g08_10_oth</th>
					<th>g08_20_1</th>
					<th>g08_20_2</th>
					<th>g08_20_3</th>
					<th>g08_20_4</th>
					<th>g08_20_5</th>
					<th>g08_20_6</th>
					<th>g08_20_88</th>
					<th>g08_20_oth</th>
					<th>g08_30_1</th>
					<th>g08_30_2</th>
					<th>g08_30_3</th>
					<th>g08_30_4</th>
					<th>g08_30_5</th>
					<th>g08_30_6</th>
					<th>g08_30_88</th>
					<th>g08_30_oth</th>
					<th>g08_40_1</th>
					<th>g08_40_2</th>
					<th>g08_40_3</th>
					<th>g08_40_4</th>
					<th>g08_40_5</th>
					<th>g08_40_6</th>
					<th>g08_40_88</th>
					<th>g08_40_oth</th>
					<th>g08_50_1</th>
					<th>g08_50_2</th>
					<th>g08_50_3</th>
					<th>g08_50_4</th>
					<th>g08_50_5</th>
					<th>g08_50_6</th>
					<th>g08_50_88</th>
					<th>g08_50_oth</th>
					<th>g08_60_1</th>
					<th>g08_60_2</th>
					<th>g08_60_3</th>
					<th>g08_60_4</th>
					<th>g08_60_5</th>
					<th>g08_60_6</th>
					<th>g08_60_88</th>
					<th>g08_60_oth</th>
					<th>g08a</th>
					<th>g09_00</th>
					<th>g09_10</th>
					<th>g09_20</th>
					<th>g09_30</th>
					<th>g09_40</th>
					<th>g09_50</th>
					<th>g09_60</th>
					<th>g09_70</th>
					<th>g10</th>
					<th>g10_oth</th>
					<th>g11_00</th>
					<th>g11_00_oth</th>
					<th>g11_10</th>
					<th>g11_10_oth</th>
					<th>g11_20</th>
					<th>g11_20_oth</th>
					<th>g11_30</th>
					<th>g11_30_oth</th>
					<th>g11_40</th>
					<th>g11_40_oth</th>
					<th>g11_50</th>
					<th>g11_50_oth</th>
					<th>g11a</th>
					<th>g12</th>
					<th>g12_oth</th>
					<th>g13_1</th>
					<th>g13_2</th>
					<th>g13_3</th>
					<th>g13_4</th>
					<th>g13a</th>
					<th>g13b</th>
					<th>g14</th>
					<th>g15_1</th>
					<th>g15_2</th>
					<th>g15_3</th>
					<th>g15_4</th>
					<th>g15_5</th>
					<th>g15_88</th>
					<th>g15_oth</th>
					<th>g16_00</th>
					<th>g16_01_1</th>
					<th>g16_01_2</th>
					<th>g16_01_3</th>
					<th>g16_01_4</th>
					<th>g16_01_5</th>
					<th>g17_00</th>
					<th>g17_01_1</th>
					<th>g17_01_2</th>
					<th>g17_01_3</th>
					<th>g17_01_4</th>
					<th>g17_01_5</th>
					<th>g18_00</th>
					<th>g18_01_1</th>
					<th>g18_01_2</th>
					<th>g18_01_3</th>
					<th>g18_01_4</th>
					<th>g18_01_5</th>
					<th>g19_00</th>
					<th>g19_01_1</th>
					<th>g19_01_2</th>
					<th>g19_01_3</th>
					<th>g19_01_4</th>
					<th>g19_01_5</th>
					<th>g20_00</th>
					<th>g20_01_1</th>
					<th>g20_01_2</th>
					<th>g20_01_3</th>
					<th>g20_01_4</th>
					<th>g20_01_5</th>
					<th>g21_00</th>
					<th>g21_01_1</th>
					<th>g21_01_2</th>
					<th>g21_01_3</th>
					<th>g21_01_4</th>
					<th>g21_01_5</th>
					<th>g22_00</th>
					<th>g22_01_1</th>
					<th>g22_01_2</th>
					<th>g22_01_3</th>
					<th>g22_01_4</th>
					<th>g22_01_5</th>
					<th>g22a</th>
					<th>g23</th>
					<th>g24</th>
					<th>g25</th>
					<th>g26</th>
					<th>g27</th>
					<th>g28</th>
					<th>g29</th>
					<th>g30</th>
					<th>g31</th>
					<th>g31_oth</th>
					<th>g32</th>
					<th>g33</th>
					<th>h01</th>
					<th>h02</th>
					<th>h03</th>
					<th>h04</th>
					<th>h05</th>
					<th>h06</th>
					<th>h07</th>
					<th>mm_h08</th>
					<th>yyyy_h08</th>
					<th>h09</th>
					<th>h10</th>
					<th>h11_00</th>
					<th>h11_01</th>
					<th>h12</th>
					<th>h13_1</th>
					<th>h13_2</th>
					<th>h13_3</th>
					<th>h13_88</th>
					<th>h13_oth</th>
					<th>h14</th>
					<th>h14_oth</th>
					<th>h15_1</th>
					<th>h15_2</th>
					<th>h15_3</th>
					<th>h15_4</th>
					<th>h15_5</th>
					<th>h15_111</th>
					<th>h16</th>
					<th>h_h16a</th>
					<th>m_h16a</th>
					<th>h_h16b</th>
					<th>m_h16b</th>
					<th>h17</th>
					<th>h17_oth</th>
					<th>h18</th>
					<th>i01</th>
					<th>i01_oth</th>
					<th>i02</th>
					<th>i03</th>
					<th>i03_oth</th>
					<th>i04_00</th>
					<th>i04_10</th>
					<th>i04_20</th>
					<th>i04_30</th>
					<th>i04_40</th>
					<th>i04_50</th>
					<th>i05</th>
					<th>i05_oth</th>
					<th>i06_00</th>
					<th>i06_01</th>
					<th>i07_1</th>
					<th>i07_2</th>
					<th>i07_3</th>
					<th>i07_88</th>
					<th>i07_oth</th>
					<th>j01</th>
					<th>j02</th>
					<th>j03</th>
					<th>j03_oth</th>
					<th>j04</th>
					<th>k01</th>
					<th>k02</th>
					<th>k03</th>
					<th>k04</th>
					<th>k05_1</th>
					<th>k05_2</th>
					<th>k05_3</th>
					<th>k05_4</th>
					<th>k05_5</th>
					<th>k05_6</th>
					<th>k05_88</th>
					<th>k05_oth</th>
					<th>k06</th>
					<th>k07_1</th>
					<th>k07_2</th>
					<th>k07_3</th>
					<th>k07_88</th>
					<th>k07_oth</th>
					<th>k08_1</th>
					<th>k08_2</th>
					<th>k08_3</th>
					<th>k08_4</th>
					<th>k08_5</th>
					<th>k08_6</th>
					<th>k08_88</th>
					<th>k08_oth</th>
					<th>k09_1</th>
					<th>k09_2</th>
					<th>k09_3</th>
					<th>k09_88</th>
					<th>k09_oth</th>
					<th>k10</th>
					<th>k11</th>
					<th>k12</th>
					<th>k13</th>
					<th>k14_1</th>
					<th>k14_2</th>
					<th>k14_3</th>
					<th>k14_4</th>
					<th>k14_5</th>
					<th>k14_6</th>
					<th>k14_7</th>
					<th>k14_8</th>
					<th>k14_9</th>
					<th>k14_10</th>
					<th>k14_88</th>
					<th>k14_oth</th>
					<th>k15</th>
					<th>k16_1</th>
					<th>k16_2</th>
					<th>k16_3</th>
					<th>k16_4</th>
					<th>k16_5</th>
					<th>k16_6</th>

					<th>k16_7</th>
					<th>k16_8</th>
					<th>k16_9</th>
					<th>k16_10</th>
					<th>k16_88</th>
					<th>k16_oth</th>
					<th>k17</th>
					<th>k17_oth</th>
			  </tr>
	</foot>
</table>
</div>
