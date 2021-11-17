<style type="text/css">
/*html {background-color: #eee;}
body {-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;color: #444;background-color: #fff;font-size: 13px;font-family: Freesans, sans-serif;padding: 2em 4em;width: 860px;margin: 15px auto;box-shadow:				1px 1px 8px #444;-mox-box-shadow:		1px 1px 8px #444;-webkit-box-shadow:		1px -1px 8px #444;}
a, a:visited {color: #4183C4;text-decoration: none;}
a:hover {text-decoration: underline;}
pre, code {font-size: 12px;}
pre {width: 100%;overflow: auto;}
small {font-size: 90%;}
small code {font-size: 11px;}*/
.placeholder {outline: 1px dashed #4183C4;/*-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;margin: -1px;*/}
.mjs-nestedSortable-error {background: #fbe3e4;border-color: transparent;}
ol {margin: 0;padding: 0;padding-left: 30px;}
ol.sortable, ol.sortable ol {margin: 0 0 0 25px;padding: 0;list-style-type: none;}
/*ol.sortable {margin: 4em 0;}*/
.sortable li {margin: 5px 0 0 0;padding: 0;}
.sortable li div  {border: 1px solid #d4d4d4;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;border-color: #D4D4D4 #D4D4D4 #BCBCBC;padding: 6px;margin: 0;cursor: move;background: #f6f6f6;background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );text-transform:capitalize;}
.sortable li div a{float:right;}
.sortable li.mjs-nestedSortable-branch div {background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);width:600px;}
.sortable li.mjs-nestedSortable-leaf div {background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);width:600px;}
li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {border-color: #999;background: #fafafa;}
.disclose {cursor: pointer;width: 20px;display: none;font-size:18px;}
.sortable li.mjs-nestedSortable-collapsed > ol {display: none;}
.sortable li.mjs-nestedSortable-branch > div > .disclose {display: inline-block;}
.sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {content: '+ ';}
.sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {content: '- ';}
/*h1 {font-size: 2em;margin-bottom: 0;}
h2 {font-size: 1.2em;font-weight: normal;font-style: italic;margin-top: .2em;margin-bottom: 1.5em;}
h3 {font-size: 1em;margin: 1em 0 .3em;;}
p, ol, ul, pre, form {margin-top: 0;margin-bottom: 1em;}
dl {margin: 0;}
dd {margin: 0;padding: 0 0 0 1.5em;}
code {background: #e5e5e5;}
input {vertical-align: text-bottom;}*/
.notice {color: #c33;}
</style>
<!--<script type="text/javascript" src="http://mjsarfatti.com/sandbox/nestedSortable/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://mjsarfatti.com/sandbox/nestedSortable/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="http://mjsarfatti.com/sandbox/nestedSortable/jquery.mjs.nestedSortable.js"></script>-->
<script type="text/javascript" src="<?php echo base_url()."theme/js/jquery-3.2.1.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."theme/js/jquery-ui-1.11.0.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."theme/js/jquery.mjs.nestedSortable.js"; ?>"></script>
<script>
var jns=$.noConflict();
	jns(document).ready(function(){
		jns('ol.sortable').nestedSortable({
			disableNesting: 'no-nest',
			protectRoot: false,
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 150,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 10,
			isTree: true,
			expandOnHover: 700,
			startCollapsed: true,
			update:function(event, ui){
				list = jns('ol.sortable').nestedSortable('serialize', {startDepthCount: 0});
				$.ajax({
					url: '<?php echo base_url();?>admin/category/display', // url where to submit the request
					type : "POST", // type of action POST || GET
					data : list,
					success : function(result) {
						console.log(result);
					},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
				})		
			}			
		});
		jns('.disclose').on('click', function() {
			jns(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		})
		/*jns('#serialize').click(function(){
			serialized = jns('ol.sortable').nestedSortable('serialize');
			jns('#serializeOutput').text(serialized+'\n\n');
		})
		jns('#toHierarchy').click(function(e){
			hiered = jns('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
			hiered = dump(hiered);
			(typeof(jns('#toHierarchyOutput')[0].textContent) != 'undefined') ?
			jns('#toHierarchyOutput')[0].textContent = hiered : jns('#toHierarchyOutput')[0].innerText = hiered;
		})
		jns('#toArray').click(function(e){
			arraied = jns('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
			arraied = dump(arraied);
			(typeof(jns('#toArrayOutput')[0].textContent) != 'undefined') ?
			jns('#toArrayOutput')[0].textContent = arraied : jns('#toArrayOutput')[0].innerText = arraied;
		})*/
});
	function dump(arr,level) {
		var dumped_text = "";
		if(!level) level = 0;

		//The padding given at the beginning of the line.
		var level_padding = "";
		for(var j=0;j<level+1;j++) level_padding += "    ";

		if(typeof(arr) == 'object') { //Array/Hashes/Objects
			for(var item in arr) {
				var value = arr[item];

				if(typeof(value) == 'object') { //If it is an array,
					dumped_text += level_padding + "'" + item + "' ...\n";
					dumped_text += dump(value,level+1);
				} else {
					dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
				}
			}
		} else { //Strings/Chars/Numbers etc.
			dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
		}
		return dumped_text;
	}
</script>
  <div id="page-wrapper">
	<div class="row">
      <div class="col-lg-12">
       <?php echo $category_list;?>
      </div>
    </div>
  </div>
