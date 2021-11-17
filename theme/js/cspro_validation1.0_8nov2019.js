var system_event;
var system_array;
//var system_return;
var system_elements=[];
var system_log=0;
var process_log=1;
var last_function='';
var focus_by_setqtext='0';

function log(txt){
    "use strict";
	if(system_log===1){
		console.log(txt);
	}
}
function log2(txt){
    'use strict';
	if(process_log===1){
		console.log(txt);
	}
}
function fakeId(id){
	"use strict";	
	var element=$('[name="'+id+'"]');
	if(element.length<1){
		log(id+" does not exist");
		return true;
	}else{
		return false;
	}
}
function checkHidden(id){
	"use strict";	
	var element=$('[name="'+id+'"]');
	if(element.css('display')==='none'){
		log(id+" is hidden");
		return true;
	}else{
		return false;
	}	
}
//answer_pbd3_00//
//getVal('answer_pbd3_00');
function getVal(id) {   
	"use strict";
	var element=$('[name="'+id+'"]');
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){
		var value;
		if(element.attr('type')==="text"){
			value=$('[name="'+id+'"]').val();
		}else if(element.attr('type')==="radio"){
			element=$('[name="'+id+'"]:checked');
			value=element.val();
			if(value===''){
				msg('Must Not Be Blank');
				system_return="false";
				log(id+" has no value for getval");
			}
		}else if(element.attr('type')==="checkbox"){
			element=$('[name="'+id+'"]:checked');
			value=element.val();
			if(value===''){
				msg('Must Not Be Blank');
				system_return="false";
				log(id+" has no value for getval");
			}		
		}else{
			value=element.val();
		}
		if(value=== undefined){
			value="";
		}
		log(id+" has "+value+" for getval");
		return value;
	}
}
//answer_pbd3_00//
//setVal('answer_pbd3_00','Jay Ho');
function setVal(id,val) {   
	"use strict";
	//console.log("setval called with id: "+id+" and val: "+val);
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){
		
		var element=$('[name="'+id+'"]');
		if(element.attr('type')==="text"){
			element.val(val);
		}else if(element.attr('type')==="radio"){
			$('input[name="' + id + '"][value="' + val + '"]').prop('checked', true);
		}else if(element.attr('type')==="checkbox"){
			$('input[name="' + id + '"][value="' + val + '"]').prop('checked', true);
		}else{
			element.val(val);
		}		
		//element.val(val);
		log(id+" is setting value "+val+" for setval");
	}
}
//answer_pbd3_00//
//isRequired('answer_pbd3_00');
function isRequired(id){
	"use strict";
	//console.log("required function called");
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){
		var v1=$('[name="'+id+'"]').closest("li");
		if(v1.is(':visible')===true){
			var val='';
			var ttype=$('[name="'+id+'"]').attr('type');
			if(ttype==="radio"){
				if($('[name="'+id+'"]:checked').length>0){
					val=$('[name="'+id+'"]:checked').val();
				}
				if(val===''){
					msg(id+': Must Not Be Blank');
					system_return="false";
					log(id+" has no value for required");
				}else{
					system_return="";
				}				
			}else if(ttype==="checkbox"){
				var q=$('[name="'+id+'"]').data('id');
				
				var last_name=$('[data-id="'+q+'"]:last').attr('name');
				
				var e=$('[data-id="'+q+'"]:checked');
				if(e.length>0){	
					val=$('[data-id="'+q+'"]:checked').val();
				}
				if(id===last_name && val===''){
					msg(q+': Must Not Be Blank');
					system_return="false";
					log(q+" has no value for required");
				}else{
					system_return="";
				}				
				//console.log("val: "+q);
			}else if(ttype==="file"){
				val=$('[name="'+id+'"]').get(0).files.length;
				if(val===0){val='';}
				if(val===''){
					msg(id+': Must Not Be Blank');
					system_return="false";
					log(id+" has no value for required");
				}else{
					system_return="";
				}				
			}else{
				val=$('[name="'+id+'"]').val();
				if(val===''){
					msg(id+': Must Not Be Blank');
					system_return="false";
					log(id+" has no value for required");
				}else{
					system_return="";
				}				
			}
		}
	}
}
//answer_pbd3_10//
//isNum('answer_pbd3_10');
function isNum(id) {
	"use strict";
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		var regex = new RegExp("^[0-9 ]+$");
		if (!regex.test(val)) {
			msg('Must Be Numeric');
			system_return="false";
			log(id+" must be numeric");
		}else{
			system_return="";
		}
	}
}
//answer_pbd3_20//
//isAlpha('answer_pbd3_20');
function isAlpha(id) {
	"use strict";
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		//var regex = new RegExp("^[A-Z ]+$");
		var regex = new RegExp("^[^\s]+[-a-zA-Z\s]+([-a-zA-Z]+)*$");
		if (!regex.test(val)) {
			msg('Must Be Aphabets');
			system_return="false";
			log(id+" must be alphabets");
		}else{
			system_return="";
		}
	}
}
//answer_pbd3_30//
//isAlphaNum('answer_pbd3_30');
function isAlphaNum(id) {
	"use strict";	
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		var regex = new RegExp("^[a-zA-Z0-9 ]+$");
		if (!regex.test(val)) {
			msg('Must Be Alpha Numeric');
			system_return="false";
			log(id+" must be alphanumeric");
		}else{
			system_return="";
		}
	}
}
//answer_pbd3_40//
//isRange('a01',[1,2,3,'7-10']);
function isRange(id,val_arr) {
	"use strict";	
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		var regex = new RegExp("^[0-9]+$");
		if (regex.test(val)) {
			if (val_arr instanceof Array) {
				if(val_arr.length>0){
					var new_val_arr=[];
					val_arr.forEach(function(v) {
						if(typeof v === "number"){
							new_val_arr.push(v);
						}else{
							var inner_v=v.split("-");
							for (var i = parseInt(inner_v[0]); i <= parseInt(inner_v[1]); i++) { 
								new_val_arr.push(i);
							}
						}
					});	
					if(new_val_arr.indexOf(parseInt(val))===-1){
						msg('Must Be In Range');
						system_return="false";
						log(id+": "+val+" must be in "+new_val_arr);
					}
				}
			}
		}else{
			msg('Must Be Numeric');
			system_return="false";
			log(id+" must be numeric");
		}
	}
}
//answer_pbd3_00//
//isFixed('answer_pbd3_00','This is good');
function isFixed(id,newval) {   
	"use strict";		
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		$('[name="'+id+'"]').val(newval);
		log($('[name="'+id+'"]').attr('type')+" with id "+id+" is fixed with value "+newval);
	}
}
//answer_pbd3_00//
//doHide('answer_pbd3_00','answer_pbd3_01');
function doHide(start_id,end_id){
	"use strict";	
	var fakeid1=fakeId(start_id);
	var fakeid2;
	if(end_id!==''){
		fakeid2=fakeId(end_id);	
	}else{
		fakeid2=false;	
	}
	//console.log(fakeid1+" "+fakeid2);
	if(fakeid1===false && fakeid2===false){	
		if(end_id===''){
			$('[name="'+start_id+'"]').closest('ul.question').parent().hide();
			$('[name="'+start_id+'"]').hide();
			log("hiding: "+$('[name="'+start_id+'"]').attr('name'));
		}else{
			var currentForm,currentULQuestion,currentLi;
			var start_id_ele=$('[name="'+start_id+'"]');
			var end_id_ele=$('[name="'+end_id+'"]');

			if(start_id_ele.length===0){
				log('(doHide) Start Id Not Found: '+start_id);
				system_return="false";		
			}else if(end_id_ele.length===0){
				log('(doHide) End Id Not Found: '+end_id);
				system_return="false";		
			}else{}

			var start_form_id=start_id_ele.closest('form').data('id');
			var end_form_id=end_id_ele.closest('form').data('id');
			var start_question_parent_li_id=start_id_ele.closest('ul.question').parent().data('id');
			var end_question_parent_li_id=end_id_ele.closest('ul.question').parent().data('id');
			var f=$('form.section-slide');

			f.each(function(){
				currentForm=$(this);
				if( currentForm.data('id')>=start_form_id && currentForm.data('id')<=end_form_id ){
					currentForm.find('ul.question').each(function(){
						currentULQuestion=$(this);
						currentLi=currentULQuestion.parent().data('id');
						if( currentLi>=start_question_parent_li_id && currentLi<=end_question_parent_li_id){
							currentULQuestion.parent().hide();
							currentULQuestion.find(':input').each(function(){
								log("hiding: "+$(this).attr('name'));
								if($(this).attr('type')==="radio"){
									$(this).prop('checked', false);
								}else if($(this).attr('type')==="checkbox"){
									$(this).prop('checked', false);
								}else{
									$(this).val('');			
								}							
							});					
						}
					});
				}
				log('section finished');
			});
		}
	}
}
//answer_pbd3_00//
//doShow('answer_pbd3_00','answer_pbd3_01');
function doShow(start_id,end_id){
	"use strict";	
	var fakeid1=fakeId(start_id);
	var fakeid2;
	if(end_id!==''){
		fakeid2=fakeId(end_id);	
	}else{
		fakeid2=false;	
	}	//console.log(fakeid1+" "+fakeid2);
	if(fakeid1===false && fakeid2===false){		
		if(end_id===''){
			$('[name="'+start_id+'"]').closest('ul.question').parent().show();
			$('[name="'+start_id+'"]').show();
			log("showing: "+$('[name="'+start_id+'"]').attr('name'));
		}else{
			var currentForm,currentULQuestion,currentLi;
			var start_id_ele=$('[name="'+start_id+'"]');
			var end_id_ele=$('[name="'+end_id+'"]');

			if(start_id_ele.length===0){
				log('(doShow) Start Id Not Found: '+start_id);
				system_return="false";		
			}else if(end_id_ele.length===0){
				log('(doShow) End Id Not Found: '+end_id);
				system_return="false";		
			}else{}

			var start_form_id=start_id_ele.closest('form').data('id');
			var end_form_id=end_id_ele.closest('form').data('id');
			var start_question_parent_li_id=start_id_ele.closest('ul.question').parent().data('id');
			var end_question_parent_li_id=end_id_ele.closest('ul.question').parent().data('id');
			var f=$('form.section-slide');

			f.each(function(){
				currentForm=$(this);
				if( currentForm.data('id')>=start_form_id && currentForm.data('id')<=end_form_id ){
					currentForm.find('ul.question').each(function(){
						currentULQuestion=$(this);
						currentLi=currentULQuestion.parent().data('id');
						if( currentLi>=start_question_parent_li_id && currentLi<=end_question_parent_li_id){
							currentULQuestion.parent().show();
							currentULQuestion.find(':input').each(function(){
								log("showing: "+$(this).attr('name'));

							});					
						}
					});
				}
				log('section finished');
			});
		}
	}
}
//msg('txt to alert message');
function msg(text){
	"use strict";
	//alert(text);
	$('#error_panel').html("");
	$('#error_panel').removeClass('disappear');
	$('#error_panel').addClass('appear');
	$('#error_panel').html(text);	
	log2("message alerted "+text);
	setTimeout(function(){
		$('#error_panel').removeClass('appear');
		$('#error_panel').addClass('disappear');
	}, 3000);				
	
}
//answer_pbd3_00//
//doJumpForward('answer_pbd3_00','answer_pbd3_01');
function doJumpForward(start_id,end_id){
	"use strict";
	var fakeid1=fakeId(start_id);
	var fakeid2=fakeId(end_id);
	//console.log(fakeid1+" "+fakeid2);
	if(fakeid1===false && fakeid2===false){	
		var v1=$('[name="'+start_id+'"]').closest("ul").parent();
		var v2=$('[name="'+end_id+'"]').closest("ul").parent();
		v1.nextUntil(v2).hide();
		log('jumping from '+start_id+' to '+end_id);
	}
}
//answer_pbd3_00//
//var res_arr=["answer_q510","answer_q511","answer_q512"];
//openBox('answer_pbd3_00',res_arr,'Message');
function openBox(id,to_id_arr,mess){
	"use strict";
	var fakeid=fakeId(id);	
	//console.log(fakeid);
	if(fakeid===false){
		var newt='<table><tr><td>'+mess+'</td></tr>';
		to_id_arr.forEach(function(cv,i){
			//console.log(cv+" "+i);
			newt+='<tr><td><a data-id="'+id+'" onclick="openBoxSet(this);" href="javascript:void(0)">'+getVal(cv)+'</a></td></tr>';
		});	
		newt+='</table>';
		$('#BoxModal').modal('show');
		$('#BoxModal .modal-body').html('');
		$('#BoxModal .modal-body').append(newt);
		//append('<a onclick="openBoxSet(this);" href="javascript:void(0)">'+value+'</a>');
	}
}
function openBoxSet(anchor){
	"use strict";
	//console.log($(anchor).data('id'));
	setVal($(anchor).data('id'),$(anchor).html());
	$('#BoxModal').modal('hide');
}
//answer_q3//
//var d1_dd=getVal('answer_dd_q1');
//var d1_mm=getVal('answer_mm_q1');
//var d1_yyyy=getVal('answer_yyyy_q1');
//var d1_h=getVal('answer_h_q1');
//var d1_m=getVal('answer_m_q1');
//var d2_dd=getVal('answer_dd_q2');
//var d2_mm=getVal('answer_mm_q2');
//var d2_yyyy=getVal('answer_yyyy_q2');
//var d2_h=getVal('answer_h_q2');
//var d2_m=getVal('answer_m_q2');
//var d1=d1_dd+'/'+d1_mm+'/'+d1_yyyy+' '+d1_h+':'+d1_m;
//var d2=d2_dd+'/'+d2_mm+'/'+d2_yyyy+' '+d2_h+':'+d2_m;
//var date_diff=dateDiff(d1,d2,'HOURS');
//msg(date_diff);
function dateDiff(start_date,end_date,datekey=''){	//datekey=DAYS,MONTHS,YEARS,HOURS,MINUTES
	
	var dt1=moment(start_date, "DD/MM/YYYY HH:mm");
	var dt2=moment(end_date, "DD/MM/YYYY HH:mm");
	var duration = moment.duration(dt2.diff(dt1));

	log("miliseconds: "+dt2.diff(dt1)+" hours: "+dt2.diff(dt1, 'hours')+" minutes: "+dt2.diff(dt1, 'minutes')+" days: "+dt2.diff(dt1, 'days')+" months: "+dt2.diff(dt1, 'months')+" years: "+dt2.diff(dt1, 'years'));
	
	if(datekey==="DAYS"){
		return dt2.diff(dt1, 'days');
	}else if(datekey==="MONTHS"){
		return dt2.diff(dt1, 'months');
	}else if(datekey==="YEARS"){
		return dt2.diff(dt1, 'years');
	}else if(datekey==="HOURS"){
		return dt2.diff(dt1, 'hours');
	}else if(datekey==="MINUTES"){
		return dt2.diff(dt1, 'minutes');
	}else{
		return dt2.diff(dt1, 'days');
	}
}
//answer_id01//
//msg(today('DD/MM/YYYY'));
function today(key=''){	//key=DD/MM/YYYY
	
	return moment(new Date()).format(key);
}
//answer_id01//
//msg(now('HH:mm'));
function now(key=''){	//key=HH:mm
	
	return moment(new Date()).format(key);
}
//answer_id01//
//gps('ADDRESS','answer_id01');	//key=ADDRESS,LATITUDE,LONGITUDE
function gps(key='',id){
	
	var lat='';
	var lng='';
	var url='';
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function showPosition(position) {
				lat=position.coords.latitude;
				lng=position.coords.longitude;
				if(key==="LATITUDE"){
					setVal(id,lat);
				}
				if(key==="LONGITUDE"){
					setVal(id,lng);
				}
				if(key==="ADDRESS"){
					url="https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyA1jo1WAx0dNyXPHKmdDdBQl9tgseYKHzY";
					$.ajax({
						url: url, 
						type : "GET", 
						dataType: 'json',
						success : function(result) {
							log(result);
								setVal(id,result.results[0].formatted_address);
						},
						error: function(xhr, resp, text) {console.log(xhr, resp, text);}
					});
				}
			},function showError(){},{enableHighAccuracy: true});
		} else { 
			msg("Geolocation is not supported by this browser.");
			system_return="false";
		}
	}
}
//answer_q02_04//
//var a=getVal('answer_q02_04');
//if(a==1){
//doColumnHide('answer_q02_04',6);
//}
function doColumnHide(id,nos){
	"use strict";	
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var nextcell=$('[name="'+id+'"]');
		var toReset;
		var elementj,i,j;
		if(nos>=1){
			for (i = 0; i < nos; i++) {
				nextcell=nextcell.closest('td').next('td');
				nextcell.find('label').hide();
				nextcell.find(':input').not('.extratext').each(function(){
					if($(this).css('display')!=='none'){
						log("Hiding: "+$(this).attr('name'));
						$(this).hide();
					}
				});

				/* using loop empty elements */
				toReset=nextcell.find(':input').not('.extratext');
				var resetLength=toReset.length;
				//console.log(toReset);		
				for (j = 0; j < resetLength; j++) {
					elementj=$(toReset[j]);
					if(elementj.attr('type')==="radio"){
						elementj.prop('checked', false);
					}else if(elementj.attr('type')==="checkbox"){
						elementj.prop('checked', false);
					}else{
						elementj.val('');			
					}
				} 
			}
		}else if(nos===0){
			nextcell.closest('td').nextAll('td').each(function(){
				//$(this).find(':input').not('.extratext').hide();
				$(this).find('label').hide();
				$(this).find(':input').not('.extratext').each(function(){
					if($(this).css('display')!=='none'){
						log("Hiding: "+$(this).attr('name'));
						$(this).hide();
					}
				});				

				/* using loop empty elements */
				toReset=$(this).find(':input').not('.extratext');
				var resetLength=toReset.length;
				//console.log(toReset);		
				for (j = 0; j < resetLength; j++) {
					elementj=$(toReset[j]);
					if(elementj.attr('type')==="radio"){
						elementj.prop('checked', false);
					}else if(elementj.attr('type')==="checkbox"){
						elementj.prop('checked', false);
					}else{
						elementj.val('');			
					}
				} 
			});
		}else if(nos===-1){
			//console.log("hiding same"+nos);
			nextcell.closest('td').each(function(){
				//$(this).find(':input').not('.extratext').hide();
				$(this).find('label').hide();
				$(this).find(':input').not('.extratext').each(function(){
					if($(this).css('display')!=='none'){
						log("Hiding: "+$(this).attr('name'));
						$(this).hide();
					}
				});				

				/* using loop empty elements */
				toReset=$(this).find(':input').not('.extratext');
				var resetLength=toReset.length;
				//console.log(toReset);		
				for (j = 0; j < resetLength; j++) {
					elementj=$(toReset[j]);
					if(elementj.attr('type')==="radio"){
						elementj.prop('checked', false);
					}else if(elementj.attr('type')==="checkbox"){
						elementj.prop('checked', false);
					}else{
						elementj.val('');			
					}
				} 
			});
		}else{}
	}
}
//answer_q02_04//
//var a=getVal('answer_q02_04');
//if(a==2){
//doColumnShow('answer_q02_04',6);
//}
function doColumnShow(id,nos){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var nextcell=$('[name="'+id+'"]');
		var i;
		if(nos>=1){
			for (i = 0; i < nos; i++) { 
				nextcell=nextcell.closest('td').next('td');
				nextcell.find('label').show();
				nextcell.find(':input').not('.extratext').each(function(){
					if($(this).css('display')==='none'){
						log("Showing: "+$(this).attr('name'));
						$(this).show();
					}
				});				
			}		
		}else if(nos===0){
			nextcell.closest('td').nextAll('td').each(function(){
				$(this).find('label').show();
				$(this).find(':input').not('.extratext').each(function(){
					if($(this).css('display')==='none'){
						log("Showing: "+$(this).attr('name'));
						$(this).show();
					}
				});					
			});		
		}else if(nos===-1){
			nextcell.closest('td').each(function(){
				$(this).find('label').show();
				$(this).find(':input').not('.extratext').each(function(){
					if($(this).css('display')==='none'){
						log("Showing: "+$(this).attr('name'));
						$(this).show();
					}
				});					
			});		
		}else{}
	}
}
//answer_pbd3_00//
//var res_arr=["answer_q510","answer_q511","answer_q512"];
//random(res_arr);
function random(to_id_arr){
	"use strict";	
	var text=to_id_arr[Math.floor(Math.random() * to_id_arr.length)];
	text=getVal(text);
	console.log("random gets "+text);
	return text;		
}
//answer_q01//
//getStates('answer_q01');
function getStates(id){
	"use strict";	
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){
		system_return="false";
		if($('[name="'+id+'"]').attr('type')!=='select'){
			var p=$('[name="'+id+'"]').parent();
			var t=$('[name="'+id+'"]').attr('tabindex');
			$('[name="'+id+'"]').remove();
			p.append('<select name="'+id+'" tabindex="'+t+'"></select>');

			var pathname=window.location.pathname;
			pathname=pathname.substr(1,pathname.length);
			var i=pathname.indexOf("/");
			pathname = pathname.substr(0,i);
			var url=window.location.protocol+"//"+window.location.hostname+"/"+pathname+"/states";
			$.ajax({
				url: url, 
				type : "GET", 
				//dataType: 'json',
				success : function(result) {
					$('select[name="'+id+'"]').html(result);
					var length=$('select[name="'+id+'"]').find('option').length;
					$('select[name="'+id+'"]').attr('size',length);
				},
				error: function(xhr, resp, text) {console.log(xhr, resp, text);}
			});
		}
	}
}
//answer_q01//
//getDistricts('answer_q02','answer_q01');
function getDistricts(id,state_id){
	"use strict";	
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var pathname=window.location.pathname;
		pathname=pathname.substr(1,pathname.length);
		var i=pathname.indexOf("/");
		pathname = pathname.substr(0,i);
		var state=$('[name="'+state_id+'"]').val();
		var url;
		if(state!==''){
			url=window.location.protocol+"//"+window.location.hostname+"/"+pathname+"/districts/"+state;
		}else{
			url=window.location.protocol+"//"+window.location.hostname+"/"+pathname+"/districts";
		}
		$.ajax({
			url: url, 
			type : "GET", 
			//dataType: 'json',
			success : function(result) {
				$('[name="'+id+'"]').html(result);
				var length=$('[name="'+id+'"]').find('option').length;
				$('[name="'+id+'"]').attr('size',length);
			},
			error: function(xhr, resp, text) {console.log(xhr, resp, text);}
		});
	}
}

//answer_pbd3_00//
//skip('answer_pbd3_00','answer_pbd3_01');
function skip(start_id,end_id){
	"use strict";		
	var fakeid1=fakeId(start_id);
	var fakeid2=fakeId(end_id);	
	//console.log(fakeid1+" "+fakeid2);
	if(fakeid1===false && fakeid2===false){
		var currentForm,currentULQuestion,currentLi;
	var start_id_ele=$('[name="'+start_id+'"]');
	var end_id_ele=$('[name="'+end_id+'"]');
	
	if(start_id_ele.length===0){
		log('(skip) Start Id Not Found: '+start_id);
		system_return="false";		
	}else if(end_id_ele.length===0){
		log('(skip) End Id Not Found: '+end_id);
		system_return="false";		
	}else{}
	
	var start_form_id=start_id_ele.closest('form').data('id');
	var end_form_id=end_id_ele.closest('form').data('id');
	var start_question_parent_li_id=start_id_ele.closest('ul.question').parent().data('id');
	var end_question_parent_li_id=end_id_ele.closest('ul.question').parent().data('id');
	var f=$('form.section-slide');
	
	f.each(function(){
		currentForm=$(this);
		if( currentForm.data('id')>=start_form_id && currentForm.data('id')<=end_form_id ){
			currentForm.find('ul.question').each(function(){
				currentULQuestion=$(this);
				currentLi=currentULQuestion.parent().data('id');
				if( currentLi>start_question_parent_li_id && currentLi<end_question_parent_li_id){
					currentULQuestion.parent().hide();
					currentULQuestion.find(':input').each(function(){
						log("hiding: "+$(this).attr('name'));
						if($(this).attr('type')==="radio"){
							$(this).prop('checked', false);
						}else if($(this).attr('type')==="checkbox"){
							$(this).prop('checked', false);
						}else{
							$(this).val('');			
						}							
					});
				}
			});
		}
		log('section finished');
	});
	}
}
//answer_pbd3_00//
//endSurvey(answer_pbd3_00');
function endSurvey(start_id){
	"use strict";		
	var fakeid=fakeId(start_id);
	//console.log(fakeid);
	if(fakeid===false){	
		var currentLi=$('[name="'+start_id+'"]').closest('ul.question').closest('li');
		var currentForm=$('[name="'+start_id+'"]').closest('form');
		while(currentLi.next('li').length!==0){
			currentLi=currentLi.next('li');
			currentLi.hide();
		}
		while(currentForm.next().length!==0){
			currentForm=currentForm.next();
			currentLi=currentForm.find('label.question-text').closest('ul.question').closest('li');
			currentLi.hide();
			while(currentLi.next('li').length!==0){
				currentLi=currentLi.next('li');
				currentLi.hide();
			}			
		}
	}
}
//answer_pbd3_00//
//toFocus(answer_pbd3_00');
function toFocus(id){
	"use strict";		
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var currentForm=$(':focus').closest('form');
		var nextForm=$('form.section-slide[data-id="'+(parseInt(currentForm.data('id'))+1)+'"]').find('[name="'+id+'"]').length;
		var prevForm=$('form.section-slide[data-id="'+(parseInt(currentForm.data('id'))-1)+'"]').find('[name="'+id+'"]').length;
		if(nextForm>0){
			currentForm.closest('div.fill-survey').find('a.fill-survey-anchor-next').first().trigger('click');
		}else if(prevForm>0){
			currentForm.closest('div.fill-survey').find('a.fill-survey-anchor-prev').first().trigger('click');
		}else{
			//console.log('going nowhere');
			//console.log(prevForm+" "+nextForm);
		}
		
		var element=$('[name="'+id+'"]');
		var t=parseInt(element.attr('tabindex'));
		setTimeout(function(){
			$('[name="'+id+'"][tabindex=' + t + ']').focus();
			//log("directing focus to "+id);
		}, 10);				
	}
}
//a02a//
//var m=doMax(['a01a','a01','a02']);
//setVal('a02a',m);
function doMax(val_arr) {
	"use strict";	
	var fakeid;
	if (val_arr instanceof Array) {
		if(val_arr.length>0){
			var new_val_arr=[];
			var value;
			var regex = new RegExp("^[0-9\.]+$");
			val_arr.forEach(function(v) {
				fakeid=fakeId(v);
				if(fakeid===false){
					value=getVal(v);
					if(value!=="" && regex.test(value)){
						new_val_arr.push(parseFloat(value));
					}
				}
			});	
			var mx=Math.max.apply(null, new_val_arr);
			console.log("doMax returning value "+mx+" from "+new_val_arr);
			return mx;
		}
	}
}
//a02a//
//var m=doMin(['a01a','a01','a02']);
//setVal('a02a',m);
function doMin(val_arr) {
	"use strict";	
	var fakeid;
	if (val_arr instanceof Array) {
		if(val_arr.length>0){
			var new_val_arr=[];
			var value;
			var regex = new RegExp("^[0-9\.]+$");
			val_arr.forEach(function(v) {
				fakeid=fakeId(v);
				if(fakeid===false){
					value=getVal(v);
					if(value!=="" && regex.test(value)){
						new_val_arr.push(parseFloat(value));
					}
				}
			});	
			var mn=Math.min.apply(null, new_val_arr);
			console.log("doMin returning value "+mn+" from "+new_val_arr);
			return mn;
		}
	}
}
//answer_pbd3_00//
//doBlock('answer_pbd3_00');
function doBlock(id){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var element=$('[name="'+id+'"]');
		if(element.attr('type')==="text"){
			element.attr('readonly',true);
		}else if(element.attr('type')==="radio"){
			element.attr('disabled',true);
		}else if(element.attr('type')==="checkbox"){
			element.attr('disabled',true);
		}else{
			if(element.prop('type')==="select-one"){
				element.attr('disabled',true);
			}else{
				element.attr('readonly',true);
			}
		}	
		log(id+" is blocked");
	}
}
//answer_pbd3_00//
//doUnblock('answer_pbd3_00');
function doUnblock(id){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var element=$('[name="'+id+'"]');
		if(element.attr('type')==="text"){
			element.attr('readonly',false);
		}else if(element.attr('type')==="radio"){
			element.attr('disabled',false);
		}else if(element.attr('type')==="checkbox"){
			element.attr('disabled',false);
		}else{
			if(element.prop('type')==="select-one"){
				element.attr('disabled',false);
			}else{
				element.attr('readonly',false);
			}	}	
		log(id+" is Unblocked");
	}
}
//answer_pbd3_00//
//doCheck('answer_pbd3_00','20');
function doCheck(id,val){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var element=$('[name="'+id+'"]');
		if(element.attr('type')==="radio"){
			$("input[name="+id+"][value=" + val + "]").prop('checked', true);
		}else if(element.attr('type')==="checkbox"){
			$("input[name="+id+"][value=" + val + "]").prop('checked', true);
		}else{
			element.val(val);		
		}	
		log(id+" is checked");
	}
}
//answer_pbd3_00//
//doUncheck('answer_pbd3_00');
function doUncheck(id){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var element=$('[name="'+id+'"]');
		if(element.attr('type')==="radio"){
			$("input[name="+id+"]").prop('checked', false);
		}else if(element.attr('type')==="checkbox"){
			$("input[name="+id+"]").prop('checked', false);
		}else{
			element.val('');			
		}	
		log(id+" is unchecked");
	}
}
//answer_pbd3_20//
//toCaps('answer_pbd3_20');
function toCaps(id) {
	"use strict";
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		val=val.toUpperCase();
		$('[name="'+id+'"]').val(val);
		log(id+" changed to caps");
	}
}
//answer_pbd3_00//
//var res_arr=["answer_q510","answer_q511","answer_q512"];
//doPlus(res_arr);
function doPlus(res_arr){
	"use strict";	
	var temp_val;
	var total=0;
	var plus_error="false";
	var regex = new RegExp("^[0-9]+(.[0-9]{1,2})?$");
	var precision=0,precision_new=0;
	var val;
	res_arr.forEach(function(cv,i){
		val=getVal(cv);
		temp_val=parseFloat(val);
		if (regex.test(temp_val)) {
			if(temp_val.length>1){
				precision_new = (temp_val + "").split(".")[1].length;
				if(precision_new>precision){
					precision=precision_new;
				}
			}
			total=(total+temp_val);
		}else{
			plus_error="true";
		}		
	});
	if(plus_error==="true"){
		msg('All Must Be Numeric');
		system_return="false";
		log("All must be numeric");	
	}else{
		if(precision>=2){
			return total.toFixed(precision);
		}else{
			return total;
		}
	}
}
//answer_pbd3_00//
//doMinus('5','5');
function doMinus(first_val,second_val){
	"use strict";	
	var v1=parseInt(first_val);
	var v2=parseInt(second_val);
	var regex = new RegExp("^[0-9 ]+$");
	if (regex.test(v1) && regex.test(v1)) {
		system_return="";
		return v1-v2;
	}else{
		msg('Both Must Be Numeric');
		system_return="false";
		log("Both must be numeric");
	}
}
//answer_pbd3_00//
//doMultiply('5','5');
function doMultiply(first_val,second_val){
	"use strict";	
	var v1=parseInt(first_val);
	var v2=parseInt(second_val);
	var regex = new RegExp("^[0-9 ]+$");
	if (regex.test(v1) && regex.test(v1)) {
		system_return="";
		return (v1*v2);
	}else{
		msg('Both Must Be Numeric');
		system_return="false";
		log("Both must be numeric");
	}
}
//answer_pbd3_00//
//doDivide('5','5');
function doDivide(first_val,second_val){
	"use strict";	
	var v1=parseInt(first_val);
	var v2=parseInt(second_val);
	var regex = new RegExp("^[0-9 ]+$");
	if (regex.test(v1) && regex.test(v1)) {
		system_return="";
		return (v1/v2);
	}else{
		msg('Both Must Be Numeric');
		system_return="false";
		log("Both must be numeric");
	}
}
//answer_pbd3_00//
//var res_arr=["answer_q510","answer_q511","answer_q512"];
//doConcat(res_arr);
function doConcat(val_arr) {
	"use strict";	
	var fakeid;
	if (val_arr instanceof Array) {
		if(val_arr.length>0){
			var new_val_arr="";
			var value;
			val_arr.forEach(function(v) {
				fakeid=fakeId(v);
				if(fakeid===false){
					value=getVal(v);
					if(value!==""){
						new_val_arr=new_val_arr+""+value;
					}
				}else{
					if(v!==""){
						new_val_arr=new_val_arr+""+v;
					}					
				}
			});	
			console.log("doConcat returning value "+new_val_arr+" from "+val_arr);
			return new_val_arr;
		}
	}
}
//answer_q02_04//
//var a=getVal('answer_q02_04');
//if(a==1){
//doRowHide('answer_q02_04',6);
//}
function doRowHide(id,nos){

	"use strict";	
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var nextcell=$('[name="'+id+'"]');
		var toReset;
		var elementj,i,j;
		if(nos>=1){
			for (i = 0; i < nos; i++) {
				nextcell=nextcell.closest('tr').next('tr');
				nextcell.find('label').hide();
				nextcell.find(':input').not('.extratext').each(function(){
					log("Hiding: "+$(this).attr('name'));
					$(this).hide();
				});				

				/* using loop empty elements */
				toReset=nextcell.find(':input').not('.extratext');
				//console.log(toReset);		
				for (j = 0; j < toReset.length; j++) {
					elementj=$(toReset[j]);
					if(elementj.attr('type')==="radio"){
						elementj.prop('checked', false);
					}else if(elementj.attr('type')==="checkbox"){
						elementj.prop('checked', false);
					}else{
						elementj.val('');			
					}
				} 
			}
		}else if(nos===0){
			nextcell.closest('tr').nextAll('tr').each(function(){
				$(this).find('label').hide();
				$(this).find(':input').not('.extratext').each(function(){
					log("Hiding: "+$(this).attr('name'));
					$(this).hide();
				});					

				/* using loop empty elements */
				toReset=$(this).find(':input').not('.extratext');
				//console.log(toReset);		
				for (j = 0; j < toReset.length; j++) {
					elementj=$(toReset[j]);
					if(elementj.attr('type')==="radio"){
						elementj.prop('checked', false);
					}else if(elementj.attr('type')==="checkbox"){
						elementj.prop('checked', false);
					}else{
						elementj.val('');			
					}
				} 
			});
		}else if(nos===-1){
			//console.log("hiding same"+nos);
			nextcell.closest('tr').each(function(){
				$(this).find('td').each(function(){
					//$(this).find(':input').not('.extratext').hide();
					$(this).find('label').hide();
					$(this).find(':input').not('.extratext').each(function(){
						if($(this).css('display')!=='none'){
							log("Hiding: "+$(this).attr('name'));
							$(this).hide();
						}
					});				

					/* using loop empty elements */
					toReset=$(this).find(':input').not('.extratext');
					var resetLength=toReset.length;
					//console.log(toReset);		
					for (j = 0; j < resetLength; j++) {
						elementj=$(toReset[j]);
						if(elementj.attr('type')==="radio"){
							elementj.prop('checked', false);
						}else if(elementj.attr('type')==="checkbox"){
							elementj.prop('checked', false);
						}else{
							elementj.val('');			
						}
					} 
				});	
			});
		}else{}
	}
}
//answer_q02_04//
//var a=getVal('answer_q02_04');
//if(a==2){
//doRowShow('answer_q02_04',6);
//}
function doRowShow(id,nos){
	"use strict";
	var fakeid=fakeId(id);
	//console.log(fakeid);
	if(fakeid===false){	
		var nextcell=$('[name="'+id+'"]');
		var i;
		if(nos>=1){
			for (i = 0; i < nos; i++) { 
				nextcell=nextcell.closest('tr').next('tr');
				nextcell.find('label').show();
				nextcell.find(':input').not('.extratext').each(function(){
					log("Showing: "+$(this).attr('name'));
					$(this).show();
				});				
			}		
		}else if(nos===0){
			nextcell.closest('tr').nextAll('tr').each(function(){
				$(this).find('label').show();
				$(this).find(':input').not('.extratext').each(function(){
					log("Showing: "+$(this).attr('name'));
					$(this).show();
				});					
			});
		}else if(nos===-1){
			nextcell.closest('tr').each(function(){
				$(this).find('label').show();
				$(this).find(':input').not('.extratext').each(function(){
					log("Showing: "+$(this).attr('name'));
					$(this).show();
				});					
			});			
		}else{}
	}
}
//var res_arr={"label1":"value1", "label2:"value2"};
//setQtext('answer_q01',res_arr);
function setQtext(id,res_arr){
	"use strict";
	focus_by_setqtext='1';
	var object_resource=res_arr.object;
	delete object_resource.SPAN;
	//console.log(object_resource);
	delete res_arr.object;
	//console.log(res_arr);
	Object.keys(res_arr).forEach(function(key) {
		if(res_arr[key]!==undefined){
			var regex = /[.,\s]/g;
			res_arr[key]=res_arr[key].replace(regex, '');
			var resource_new_text=object_resource[res_arr[key]];
			//console.log(resource_new_text);
			$(key).after("<span class='temp'>"+resource_new_text+"</span>");
		}
	});
	log2("setQtext on: "+id);
}
//var a=getLabel('answer_q01');
//var res_arr={"label1":a.ENGLISH, "label2":a.HINDI};
//setQtext('answer_q01',res_arr);
function getLabel(id){
	"use strict";
	var element=$('[name="'+id+'"]');
	var labelLang=[];
	if(element.attr('type')==="radio"){
		$('[name="'+id+'"]:checked').parent().children().each(function(){
			if(!$(this).is(':input')){
				labelLang[$(this)[0].tagName]=$(this).html();
			}
		});
	}else if(element.attr('type')==="checkbox"){
		$('[name="'+id+'"]:checked').parent().children().each(function(){
			if(!$(this).is(':input')){
				labelLang[$(this)[0].tagName]=$(this).html();
			}
		});
	}else if(element.prop('type')==="select-one"){
		$(element.find(':selected').attr('data-lang')).each(function(){
			if($(this)[0].tagName!==undefined){
				labelLang[$(this)[0].tagName]=$(this).html();
			}
		});
	}else{}
	log2("getLabel: "+labelLang+" for: "+id);
	return labelLang;
}
//answer_pbd3_10//
//isNum('answer_pbd3_10',10,6);
function isMobile(id,digit,mindigit) {
	"use strict";
	var fakeid=fakeId(id);
	var checkhidden=checkHidden(id);
	//console.log(fakeid+" "+checkhidden);
	if(fakeid===false && checkhidden===false){	
		var val=$('[name="'+id+'"]').val();
		var regex = new RegExp("^[0-9 ]+$");
		if (!regex.test(val)) {
			msg('Must Be Numeric');
			system_return="false";
			log(id+" must be numeric");
		}else if (val.length<digit) {
			msg('Length must be equal to '+digit+' digits');
			system_return="false";
			log(id+'Length must be equal to '+digit+' digits');	
		}else if (val.length>digit) {
			msg('Length must be equal to '+digit+' digits');
			system_return="false";
			log(id+'Length must be equal to '+digit+' digits');	
		}else if (val.charAt(0)<mindigit) {
			msg('Must start with '+mindigit);
			system_return="false";
			log(id+'Must start with '+mindigit);	
		}else{
			system_return="";
		}
	}
}







