function ready1(){
	var prev_survey_case_id=$('input[name="survey_case_id"]').val();
	//log2("previous survey case id was "+prev_survey_case_id);
	var survey_case_id = localStorage.getItem("survey_case_id");
	if(survey_case_id){
		$('input[name="survey_case_id"]').val(survey_case_id);
		//log2("new survey case id is "+survey_case_id);
	}else{
		$('input[name="survey_case_id"]').val(prev_survey_case_id);
		//log2("again previous survey case id is set "+prev_survey_case_id);
	}
	partialSet('');
	partialLoad('0');
	//partialNextTill();
	if($('input[name="survey_language"]:checked').length>0){$(this).find(':input').each(function(){
		var i=$(this);
		//console.log(i);
	});
		checkLanguage($('input[name="survey_language"]:checked'));
	}else{
		checkLanguage($('input[name="survey_language"]:first-child'));
	}	
}	
function partialSet(turn){
//log2('partialSet turn: '+turn);
	$('form.section-slide').hide();
	var currentPartial=$('input[name="section-slide-counter"]').val();
	var sectionCount=$('input[name="section-count"]').val();
	currentPartial=parseInt(currentPartial);
	sectionCount=parseInt(sectionCount);
	//console.log("currentPartial: "+currentPartial+" turn: "+turn);
	if(currentPartial=="1"){
		$('.fill-survey-anchor-prev').hide();
		$('.fill-survey-anchor-next').show();
	}else if(currentPartial==sectionCount){
		$('.fill-survey-anchor-prev').show();
		$('.fill-survey-anchor-next').hide();
	}else{
		$('.fill-survey-anchor-prev').show();
		$('.fill-survey-anchor-next').show();
	}	
	var f=$('form.section-slide:nth-of-type('+currentPartial+')');
	f.show();
	if(turn=="prev"){
		//var i=f.find('ul.question:last').find(':input:last');
		var i=f.find('ul.question').find(':input:last').last();
		i.focus();
	}
	if(turn=="next"){
		//var i=f.find('ul.question:first').find(':input:first');
		var i=f.find('ul.question').find(':input:first').first();
		i.focus();
	}
	
	//console.log(i);
}	
function partialPrev(anchor){
//log2('partialPrev');	
	var currentPartial=$('input[name="section-slide-counter"]').val();
	currentPartial=parseInt(currentPartial);
	
	var currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
	var noPrevious='1';	
	//console.log("currentpartial: "+currentPartial);
	
	while(true){
		if(currentForm.length<1 || noPrevious=='0'){
			break;
		}else{
			currentPartial--;
			
			currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
			var prevFormLi=currentForm.find('ul.question').parent('li').length;
			var prevFormLiHidden=0;
			currentForm.find('ul.question').parent('li').each(function(){
				//console.log($(this).find(':input'));
				//console.log($(this).css('display'));
				if($(this).css('display')=='none' || $(this).find(':input').length===0){
					prevFormLiHidden++;
				}
			});
			if(prevFormLi!==prevFormLiHidden && prevFormLi!=='0'){
				noPrevious='0';
			}
		//console.log("currentpartial: "+currentPartial+" form length: "+currentForm.length+" noprevious: "+noPrevious);
		//console.log("total li: "+prevFormLi+" hidden li: "+prevFormLiHidden);
		}
	}
	//console.log("currentpartial: "+currentPartial);
	$('input[name="section-slide-counter"]').val(currentPartial);
	partialSet('prev');
	partialLoad('');
}	
function partialNext(anchor){
//log2('partialNext');
	$(window).scrollTop(0);
	
	var currentPartial=$('input[name="section-slide-counter"]').val();
	currentPartial=parseInt(currentPartial);
	var sectionCount=$('input[name="section-count"]').val();
	sectionCount=parseInt(sectionCount);
	var currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
	var noForward='1';
	//console.log("currentpartial: "+currentPartial);
	
	var currentSaveButton=currentForm.find('[name="partial-save"]');	
	partialSave(currentSaveButton,0);
	
	while(true){
		if(currentForm.length<1 || noForward=='0'){
			break;
		}else{
			currentPartial++;
			
			currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
			var nextFormLi=currentForm.find('ul.question').parent('li').length;
			var nextFormLiHidden=0;
			currentForm.find('ul.question').parent('li').each(function(){
				if($(this).css('display')=='none'){
					nextFormLiHidden++;
				}
			});
			if(nextFormLi!==nextFormLiHidden){
				noForward='0';
			}else{
				//dont save to get back whole section skip condition
				//currentSaveButton=currentForm.find('[name="partial-save"]');	
				//partialSave(currentSaveButton,0);
			}
			//console.log(currentForm.find('input[name="section_title_url"]').val());
			//console.log("total li: "+nextFormLi+" hidden li: "+nextFormLiHidden);
		}
	}
	//console.log("currentpartial: "+currentPartial);
	if(currentPartial<=sectionCount){
		$('input[name="section-slide-counter"]').val(currentPartial);
	}
	partialSet('next');
	partialLoad('');	

}	
function partialNextTill(section_id){
	//console.log("partial next until");
	if(section_id!=''){
		$(window).scrollTop(0);
		$('input[name="section-slide-counter"]').val(section_id);
		var currentPartial=$('input[name="section-slide-counter"]').val();
		//console.log(" current partial: "+currentPartial);
		partialSet('next');
	}
}
function partialLoad(is_first){
//log2('partialLoad '+is_first);	
	var survey_case_id=$('input[name="survey_case_id"]').val();
	var currentPartial=$('input[name="section-slide-counter"]').val();
	var form_data=$('form.section-slide:nth-of-type('+currentPartial+')').serializeArray();
	var survey_case=localStorage.getItem("case");
	if(survey_case=="Old"){
		$.ajax({
			url: '<?php echo base_url()."survey/partial/load/";?>'+survey_case_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : form_data, // post data || get data
			dataType : 'json',
			success : function(result) {
				if(typeof result =='object'){
					result2=result;
					result=result.all_values;
					//result=JSON.parse(result);
					for (var key in result) {
						if (result.hasOwnProperty(key)) {
							var val = result[key];
							var type=$('[name='+key+']').attr('type');
							var type1=$('[name='+key+']').prop('tagName');
							//log2(key+" "+val+" "+type+" "+type1);
							if(type=="text"){
								$('input[name="'+key+'"]').val(val);
							}
							if(type=="radio"){
								$('input[name="'+key+'"][value="'+val+'"]').prop('checked',true);
							}
							if(type=="checkbox"){
								$('input[name="'+key+'"][value="'+val+'"]').prop('checked',true);
							}
							if(type==undefined){
								if(type1=="SELECT"){
									$('select[name="'+key+'"]').val(val);
								}
							}
						}
					}	
					if(is_first!=''){
						//console.log('first time');
						partialNextTill(result2.till_section);
					}else{
						//console.log('second time');
					}					
				}
			},error: function(xhr, resp, text) {log2(xhr, resp, text);
			}
		});	
	}
}


/*function finishSave(currentButton){
//log2('finishSave');	
	var complete=partialSave(currentButton,0);
	if(complete===true){
		var formData=$(currentButton).closest('form').serializeArray();
		var survey_case_id=$('input[name="survey_case_id"]').val();
		$.ajax({
			url: '<?php echo base_url()."survey/final/save/";?>'+survey_case_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {formData},
			success : function(result) {
				//log2(result);
				alert('Finally Saved!!');
				localStorage.removeItem("survey_case_id");
				window.location.reload();
			},error: function(xhr, resp, text) {log2(xhr, resp, text);}
		});
	}
}	*/
function showLanguage(language){
	//console.log("show language "+language);
	processLanguages();
}
function hideLanguage(language){
	//console.log("hide language "+language);
	processLanguages();
}
function pl(ele){
	//console.log("pl "+ele);
	var json_string=readCookie("survey_language");
	var json_array=JSON.parse(json_string);
	for (i=0; i < json_array.length; i++) {
		ele.find(json_array[i]).removeClass('hide_language');
	}
}	
function rl(ele,optext){						//calls on select elements for language
	if(optext===undefined){
	}else{
		//console.log("rl "+ele+" "+optext);
		var temp_language='';
		var json_string=readCookie("survey_language");

		var json_array=JSON.parse(json_string);
		for (i=0; i < json_array.length; i++) {
			optextarr=optext.replace(/> </g,">@<");
			optextarr=optextarr.split("@");
			for (j=0; j < optextarr.length; j++) {
				if(optextarr[j].indexOf(json_array[i])===1){
					optextarr[j]=optextarr[j].replace(/(<([^>]+)>)/ig,"");
					//temp_language=temp_language+" <br>"+optextarr[j]; 	inserting br tag in select box in filling form
					temp_language=temp_language+" "+optextarr[j];
				}
			}
		}
		if(temp_language!=''){
			ele.text("["+ele.val()+"] "+temp_language);
		}
	}
}	
function processLanguages(){
	//console.log("processlanguages");
	var labels=$('.fill-survey').find('label').not('.navigation-labels,.savebuttonlabel,.language_labels').each(function (i) {
		var label=$(this);
		label.children().not(':input,table,div,span.question-no,span.option-value').each(function (i) {	//simple text in html
			$(this).addClass('hide_language');
		});
		label.children().each(function (i) {
			if($(this).prop('type')=="select-one"){						//simple select element in html
				var sel=$(this);
				sel.children().each(function (j) {
					var op=$(this);
					var optext=op.data('lang');
					rl(op,optext);
				});
			}
		});
		label.children().find(':input').each(function (i) {
			if($(this).prop('type')=="select-one"){						//select element in table in html
				var sel=$(this);
				sel.children().each(function (j) {
					var op=$(this);
					var optext=op.data('lang');
					rl(op,optext);
				});
			}
		});
		label.find('th,td').children().not(':input,label.option,br').each(function (i) {		//simple text in table in html
			$(this).addClass('hide_language');
		});
		pl($(this));
	});
}
/*function modify_db_list(element){
	var element_name=element.attr('name'); 
	var element_value;
	if(element.prop('tagName')=="SELECT"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.prop('tagName')=="TEXTAREA"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="text"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="radio"){
		if(element.filter(':checked').length==0){
			element_value=element.filter(':first-child').val();
			if (!db_list.hasOwnProperty(element_name)) {
				db_list[element_name]=element_value;
			}
		}else{
			element_value=element.filter(':checked').val();
			db_list[element_name]=element_value;
		}
	}
	else if(element.attr('type')=="checkbox"){
		$('input[type="checkbox"][data-id="'+element.data('id')+'"]').each(function (i) { 
			db_list[element.attr('name')]=element.val();
		});
	}
	else if(element.attr('type')=="file"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="submit"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else{}	
	//console.log(db_list);
}*/
function ready2(){
	$(".fixTable").tableHeadFixer({"head" : true, "left" : 1}); 
	$('input[type="text"][class="extratext"]').hide();
    $('input[type="text"]').keyup(function(event){					//auto enter on max length passed of input field
		code=event.which || event.keyCode;
		if($(this).attr("maxlength")!="" && ($(this).val().length)!=0 && code!=38){		//for up arrow
			if(($(this).val().length)==$(this).attr("maxlength") && code!=13){
				$(this).trigger($.Event('keydown', { keyCode: 13 }));
			}
		}
	});
	$('.fill-survey').find('input[type="text"]').each(function(){
		var maxlength=$(this).attr('maxlength');
		$(this).attr('size',maxlength);
		
		if(maxlength>=50){
			$(this).attr('word-break','break-word');
		}
	});
}	
function ready4(){
	$('.fill-survey form').on('keydown', 'input[type="radio"],input[type="checkbox"],input[type="text"],textarea', function(event) {
		code=event.which || event.keyCode;
		//console.log("code: "+code);
		if(code=='9' || code=='13' || code=='40'){		//tab enter down-arrow
			event.preventDefault();
			//console.log("system_return: "+system_return+"stop_next: "+stop_next);

			//checking default required
			if($(this).prop('required')==true){
				var name=$(this).attr('name');
				//console.log(name+" running required");
				eval("isRequired('"+name+"')");
			}
			//checking default required

			var func_name=$(this).attr('name');
			fn = window[func_name];
			if (typeof fn == 'function') { 
				var fn_string=fn.toString();
				//setTimeout(function(){
					log2("going to run "+fn_string);
					eval(func_name+"()");
					//setTabIndexAll();
				//}, 1);					
			}
			if(stop_next=="true"){
				stop_next="";
			}
			if(system_return=="" && stop_next!="true"){
				var tabindex=getTabIndexByName($(this));
				goNext(tabindex);
			}
			if(system_return!=""){
				system_return="";
			}
		}
		if(code=='38'){								//up-arrow
			event.preventDefault();
			var tabindex=getTabIndexByName($(this));
			goPrev(tabindex);
			stop_next="true";

		}
	});	
	$('.fill-survey form').on('keydown', 'select', function(event) {
		var sel=$(this);
		var optsel = $(this).find('option:selected').val();
		var tabindex=getTabIndexByName($(this));
		code=event.which || event.keyCode;
		if(code=='9' || code=='13'){		//tab enter
			event.preventDefault();

			//checking default required
			if($(this).prop('required')==true){
				var name=$(this).attr('name');
				//console.log(name+" running required");
				eval("isRequired('"+name+"')");
			}
			//checking default required

			var func_name=$(this).attr('name');
			fn = window[func_name];
			if (typeof fn == 'function') { 
				log2("going to run "+fn.toString());
				eval(func_name+"()");
				//setTabIndexAll();
			}
			if(stop_next=="true"){
				stop_next="";
			}
			if(system_return=="" && stop_next!="true"){
				var tabindex=getTabIndexByName($(this));
				goNext(tabindex);
			}
		}
		if(code=='40'){								//down-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prop("selected", true);		
				goNext(tabindex);
			}, 10);		
		}	
		if(code=='38'){								//up-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prop("selected", true);		
				goPrev(tabindex);
			}, 10);		
		}
		if(code=='37'){								//left-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prev().prop("selected", true);		
				goPrev(tabindex);
			}, 10);	
		}	
		if(code=='39'){								//right-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').next().prop("selected", true);		
				goPrev(tabindex);
			}, 10);	
		}
	});	
	$('.fill-survey form').on('focus', 'input[type="radio"],input[type="checkbox"],input[type="text"],textarea,select', function(event){
		event.preventDefault();
		//console.log("wnt to run pre"+focus_by_setqtext);
		if(focus_by_setqtext=='0'){
			//console.log("going to ru pre for"+$(this).attr('name'));
			var func_name="_"+$(this).attr('name');
			fn = window[func_name];
			if (typeof fn == 'function') { 
				log2("going to run "+fn.toString());
				eval(func_name+"()");
				//setTabIndexAll();
			}
		}else{
			//console.log("stop ru pre for"+$(this).attr('name'));
		}
	});		
	alert("Here you Go!");
}	
function setTabIndexAll(){
	//console.log("tab indexing start: "+new Date());
	var system_elements_temp=[];
	$('form.section-slide').find('input[type="radio"],input[type="checkbox"],input[type="text"],textarea,select').each(function (i) { 
		var element_name=$(this).attr('name'); 
		var element_value;
		if($(this).prop('tagName')=="SELECT"){
			element_value=$(this).val();
		}
		else if($(this).prop('tagName')=="TEXTAREA"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="text"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="radio"){
			if($(this).filter(':checked').length==0){
				element_value=$(this).filter(':first-child').val();
			}else{
				element_value=$(this).filter(':checked').val();
			}
		}
		else if($(this).attr('type')=="checkbox"){
			$('input[type="checkbox"][data-id="'+$(this).data('id')+'"]').each(function (i) { 
				element_value=$(this).val();
			});
		}
		else if($(this).attr('type')=="file"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="submit"){
			element_value=$(this).val();
		}
		else{}
		system_elements_temp[element_name]=element_value;
	});
	system_elements=system_elements_temp;
	Object.keys(system_elements).forEach(function(key,index) {
		$('[name="'+key+'"]').attr('tabindex', (index+1));
	});	
	//console.log("tab indexing end: "+new Date());
}	
function goNext(tabIndex){
	//console.log("going next to start to 0");
	//code for automatic next section click on last input of current
	var currentForm=$('form.section-slide:nth-of-type('+$('input[name="section-slide-counter"]').val()+')');
	var last_element=-1;
	currentForm.find('ul.question:visible').each(function(){
		if($(this).find(':input:visible:last').length>0){
			last_element=$(this).find(':input:visible:last').attr('tabindex');
		}
	});
	if(tabIndex===last_element){
		var nav_next=$('div.navigation-labels:first').find('a.fill-survey-anchor-next:visible:first');
		if(nav_next.length==1){
			nav_next.trigger('click');
		}else{
			var button=$('form.section-slide:visible .finish-survey:visible:first');
			button.trigger('click');
		}
	}
	
	var returnTabIndex=tabIndex;
	tabIndex++;	
	while($('[tabindex=' + tabIndex + ']').css('display')==='none' || $('[tabindex=' + tabIndex + ']').closest('ul.question').closest('li').css('display')==='none'){
		tabIndex++;
	}
	if($('[tabindex=' + tabIndex + ']').css('display')!='none'){
		setFocusOnTabIndex(tabIndex);
	}else{
		tabIndex=returnTabIndex;
	}
	return tabIndex;	
}
function goPrev(tabIndex){
//log2("go prev");	
	//code for automatic prev section click on first input of current
	var currentForm=$('form.section-slide:nth-of-type('+$('input[name="section-slide-counter"]').val()+')');
	var first_element=-1;
	currentForm.find('ul.question:visible').each(function(){
		if($(this).find(':input:visible:first').length>0){
			if(first_element==-1){
				first_element=$(this).find(':input:visible:first').attr('tabindex');
				//console.log($(this).find(':input:visible:first'));
			}
		}
	});
	if(tabIndex===first_element){
		var nav_prev=$('div.navigation-labels:first').find('a.fill-survey-anchor-prev:visible:first');
		nav_prev.trigger('click');
	}
	
	focus_by_setqtext='0';
	var returnTabIndex=tabIndex;	
	
	var toShow=[];
	toShow.push(parseInt(tabIndex)); 
	tabIndex--;
	toShow.push(tabIndex); 
	
	while($('[tabindex=' + tabIndex + ']').css('display')==='none' || $('[tabindex=' + tabIndex + ']').closest('ul.question').closest('li').css('display')==='none'){
		toShow.push(tabIndex); 
		tabIndex--;
	}
	for(var i in toShow) {
		$('[tabindex=' + toShow[i] + ']').closest('ul.question').closest('li').css('display','list-item');
		$('[tabindex=' + toShow[i] + ']').not('.extratext').each(function(){
			$(this).parent().removeClass("published_selected_element");
			$(this).parent().show();
			$(this).show();
		});
		//$('[tabindex=' + toShow[i] + ']:not(.extratext)').css('display','inline-block');
		var lTag=$('[tabindex=' + toShow[i] + ']').closest('ul.question').find('.temp');
		if(lTag.length>0){
			lTag.remove();
		}		
	}	
	if($('[tabindex=' + tabIndex + ']').css('display')!='none'){
		setFocusOnTabIndex(tabIndex);
	}else{
		tabIndex=returnTabIndex;
	}	
	return tabIndex;		
}
function setFocusOnTabIndex(tabIndex){
	var e=$('[tabindex=' + tabIndex + ']');
	if(e.length>1){
		e.eq(0).focus();
	}else{
		e.focus();
	}
}
function getTabIndexByName(element_name){
	var tindex;
	if(element_name.attr('type')=="radio"){
		if(element_name.filter(':checked').length==0){
			tindex=element_name.filter('[tabindex]').attr('tabindex');
		}else{
			tindex=element_name.filter(':checked').attr('tabindex');
		}
	}else{
		tindex=element_name.attr('tabindex');
	}
	if(isNaN(tindex)){
		log2("error:trying to get index of  "+element_name.attr('name')+" "+element_name.attr('type')+" with value"+element_name.val());
	}
	return tindex;
}	
function editProfile()	{
	$('#profileModal').modal('show');
}
function editPermission(){
	$('#permissionModal').modal('show');
}	
function toggleSection(anchor){
	$(anchor).parent().parent().find('ul.dragndrop1').toggle();
	$(anchor).find('i').toggleClass(function(){
		return $(this).is('.fa-caret-right, .fa-caret-down') ? 'fa-caret-right fa-caret-down' : 'fa-caret-right';
	});
}	
function callAjaxGet(ajaxUrl,modalId){
	$.ajax({
		url: ajaxUrl, // url where to submit the request
		type : "GET", // type of action POST || GET
		success : function(result) {
			if(modalId!=''){
				$('#'+modalId+" .modal-body").html(result);
				//console.log(result);
			}
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})		
}	
function callAjaxPost(ajaxUrl,formData,modalId){
	$.ajax({
		url: ajaxUrl, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {formData},
		success : function(result) {
			if(modalId!=''){
				$('#'+modalId+" .modal-body").html(result);
				//console.log(result);
			}
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})		
}	
function primaryDashboard(survey_title_url=''){
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	setTimeout(function(){
		window.location='<?php echo base_url(); ?>';
	}, 1000);
}		
function createOrExistSurvey(){
	$('#createOrExistSurveyModal').modal('show');
}	
function createSurvey(){
	$('#createOrExistSurveyModal').modal('hide');
	$('#createSurveyModal').modal('show');
}	
function editSurvey(survey_title_url){
	$('#editSurveyModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/edit/";?>'+survey_title_url,'editSurveyModal');
}	
function editSurveyStyle(survey_title_url){
	$('#styleSurveyModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/style/";?>'+survey_title_url,'styleSurveyModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function compileSurvey(survey_title_url){
	$('#compileModal').modal('show');
	var mesg='';
	var errorList=[];
	$.ajax({
		url: '<?php echo base_url()."survey/compile/";?>'+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		//data : {"elements":columnArray1},
		success : function(result) {
			result=JSON.parse(result);
			for (i = 0; i < result.length; i++) {
				//console.log(eval(result[i]));
				try{
					eval(result[i]);
				}catch(e){
					//mesg+=e.message+" at "+e.lineNumber+" in "+result[i];
					var jsonError={"Error":e.message,"Line":e.lineNumber,"In":result[i]};
					errorList.push(jsonError);
				}finally{
					
				}
			} 	
			for (i = 0; i < errorList.length; i++) {
				//console.log(errorList[i]);
				mesg+="Error: "+errorList[i].Error+'<br>';
				mesg+="Line No: "+errorList[i].Line+'<br>';
				mesg+="In: "+errorList[i].In+'<br><br>';
			}			
			//console.log(mesg);
			//alert(mesg);
			if(mesg==""){
				mesg="No Compilation Errors!";
			}
			$('#compileModal .modal-body').html(mesg);
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}	
function duplicateSurvey(survey_title_url){
	$.ajax({
		url: '<?php echo base_url()."survey/duplicate/";?>'+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		//data : {"elements":columnArray1},
		success : function(result) {
			result=JSON.parse(result);
			console.log(result.survey_id);
			$('#duplicateSurveyModal').modal('show');
			$('#duplicateSurveyModal input[name="id"]').val(result.survey_id);
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}		
function createSection(){
	$('#createSectionModal').modal('show');
}	
function editSection(section_title_url){
	$('#editSectionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/section/edit/";?>'+section_title_url,'editSectionModal');
}	
function duplicateSection(section_title_url){
	callAjaxGet('<?php echo base_url()."survey/section/duplicate/";?>'+section_title_url);
	setTimeout(function(){
		window.location.reload();
	}, 3000);
}	
function delSection(section_title_url){
	if(confirm("Are You Sure! You Want To Delete!!") == true) {
		callAjaxGet('<?php echo base_url()."survey/section/delete/";?>'+section_title_url,'');
		setTimeout(function(){
			window.location.reload();
		}, 1000);
	} 	
}	
function editSectionStyle(section_title_url){
	$('#styleSectionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/section/style/";?>'+section_title_url,'styleSectionModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function chooseQuestionFrom(section_title_url){
	$('#chooseQuestionFromModal').modal('show');
	$('#chooseQuestionFromModal input[name="section_name"]').val(section_title_url);
}	
function chooseQuestion(){
	var section_title_url=$('#chooseQuestionFromModal input[name="section_name"]').val();
	$('#chooseQuestionFromModal').modal('hide');
	$('#chooseQuestionModal').modal('show');
	$('#chooseQuestionModal input[name="section_name"]').val(section_title_url);
}	
function chooseQuestionExisting(){
	var section_title_url=$('#chooseQuestionFromModal input[name="section_name"]').val();
	$('#chooseQuestionExistingModal').modal('show');
	$('#chooseQuestionExistingModal input[name="section_id"]').val(section_title_url);
	$('#chooseQuestionFromModal').modal('hide');
}
function createQuestion(qtype){
	var section_title_url=$('#chooseQuestionModal input[name="section_name"]').val();
	$('#chooseQuestionModal').modal('hide');
	$('#createQuestionModal').modal('show');
	$('#createQuestionModal input[name="section_name"]').val(section_title_url);
	callAjaxGet('<?php echo base_url()."survey/question/add/";?>'+qtype+"/"+section_title_url,'createQuestionModal');
	setTimeout(function(){
		var ind=1;
		var fields=$('#createQuestionModal').find('input[type="text"],textarea,input[type="checkbox"],input[type="submit"]').each(function (i) {
			$(this).attr('tabindex', (ind++));
		});	
	}, 2000);		
}	
function createQuestionFromExisting(insertButton){
	var section_id=$('#chooseQuestionExistingModal input[name="section_id"]').val();
	var question_id=$('#chooseQuestionExistingModal input[name="question_id"]').val();
	callAjaxGet('<?php echo base_url()."survey/question/copy/";?>'+section_id+"/"+question_id,'');
	$('#chooseQuestionExistingModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function editQuestion(question_id){
	$('#editQuestionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/question/edit/";?>'+question_id,'editQuestionModal');
	setTimeout(function(){
		var ind=1;
		var fields=$('#editQuestionModal').find('input[type="text"],textarea,input[type="checkbox"],input[type="submit"]').each(function (i) {
			$(this).attr('tabindex', (ind++));
		});	
	}, 2000);	
}	
function duplicateQuestion(question_id){
	callAjaxGet('<?php echo base_url()."survey/question/duplicate/";?>'+question_id);
	setTimeout(function(){
		window.location.reload();
	}, 2000);	
}		
function editQuestionStyle($question_id){
	$('#styleQuestionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/question/style/";?>'+$question_id,'styleQuestionModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function delQuestion(question_id,section_title_url){
	if(confirm("Are You Sure! You Want To Delete!!") == true) {
		callAjaxGet('<?php echo base_url()."survey/question/delete/";?>'+question_id+"/"+section_title_url,'');
		setTimeout(function(){
			window.location.reload();
		}, 1000);
	} 	
}	
function codeQuestion(codeAnchor,question_id){
	var columnArray1 = [];
	$(codeAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	//alert(columnArray1);
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			$('#collectCodeNameModal').modal('show');
			callAjaxGet('<?php echo base_url()."survey/question/collectname/";?>'+question_id,'collectCodeNameModal');
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}	
function lengthQuestion(lengthAnchor,question_id){
	var columnArray1 = [];
	$(lengthAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			$('#collectLengthModal').modal('show');
			callAjaxGet('<?php echo base_url()."survey/question/lengths/";?>'+question_id,'collectLengthModal');
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}
function lengthsSurvey(survey_title_url){
	$('#collectLengthsModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/lengths/";?>'+survey_title_url,'collectLengthsModal');
}
function completeQuestion(completeAnchor,question_id){
	var columnArray1 = [];
	$(completeAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			console.log(result);
			callAjaxGet('<?php echo base_url()."survey/question/completequestion/";?>'+question_id,'');
			setTimeout(function(){
				window.location.reload();
			}, 1000);			
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function saveCodename(savebutton){
	var duplicate=true;
	var arr = [];
	$("#formCodeName").find('input[type="text"]').each(function(){
		var value = $(this).val();
		if(arr.indexOf(value) == -1){
			if(value!=""){
				arr.push(value);
			}
		}else{
			duplicate=false;
			$(this).addClass("duplicate_codename");
		}
	});	

	if(duplicate==true){
		var question_id=$('#question_id').val();
		var form_serialized_data=$("#formCodeName").serialize();
		$.ajax({
			url: '<?php echo base_url()."survey/question/savecodename/";?>'+question_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#formCodeName").serialize(), // post data || get data
			success : function(result) {
				//console.log(result);
				$('#collectCodeNameModal').modal('hide');
				$('#collectCodeQuestionModal').modal('show');
				callAjaxGet('<?php echo base_url()."survey/question/collectcode/";?>'+question_id,'collectCodeQuestionModal');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});	
	}else{
		alert('Duplicate Detected!');
	}
}	
function saveLengths(savebutton){
	var all='true';
	var question_id=$('#question_id').val();
	var form_lengths_fields=$('#formLengths input[type="text"]').each(function(){
		if($(this).val()==""){
			all='false';
		}
	});
	console.log(all);
	if(all==='true'){
		$.ajax({
			url: '<?php echo base_url()."survey/question/savelengths/";?>'+question_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#formLengths").serialize(), // post data || get data
			success : function(result) {
				alert("Format & Lengths saved sucessfully");
				$('#collectLengthModal').modal('hide');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});	
	}else{
		alert("Please fill all lengths");
	}
}	
function saveLengthsAll(survey_title_url){
	var forms=$('form[name="formLengths"]');
	var i=[];
	//console.log(forms);
	
	var all='true';	
	var form_lengths_fields=$('form[name="formLengths"] input[type="text"]').each(function(){
		if($(this).val()==""){
			all='false';
		}
	});
	//console.log(all);
	forms.each(function(){
		var question_id=$(this).find('input[name="question_id"]').val();
		var formData=$(this).serialize();
		i.push({question_id: question_id, formData: formData});
	});
	//console.log(i);
	i=JSON.stringify(i);
	all='true';
	if(all==='true'){
		$.ajax({
			url: '<?php echo base_url()."survey/savelengths/";?>'+survey_title_url, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {i}, // post data || get data
			success : function(result) {
				alert("Format & Lengths saved sucessfully");
				$('#collectLengthsModal').modal('hide');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});			
	}else{
		alert("Please fill all lengths");
	}
}	
function generateCode(generateButton){
	$('#collectCodeQuestionModal').modal('hide');
	var form_data=$(generateButton).closest('form').serializeArray();
	var question_id=$('#collectCodeQuestionModal').find('input[name="question_id"]').val();
	//alert(form_data);
	$('#saveBeforeClose').attr('checked',true);
	$('#generateCodeQuestionModal').modal('show');
	callAjaxPost('<?php echo base_url()."survey/question/generatecode/";?>',form_data,'generateCodeQuestionModal');
		setTimeout(function(){
			$('#comm_panel').numberedtextarea();

			
			$.ajax({
				url: '<?php echo base_url();?>survey/question/default_name/'+question_id, // url where to submit the request
				type : "GET", // type of action POST || GET
				//data : $("#form_data_code").serialize(), // post data || get data
				success : function(result) {
					//console.log(result);
					$('input[name="default_question_no"]').val(result);
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});				
		}, 1000);
}	
function saveCode(saveButton){
	$('#generateCodeQuestionModal .loader').show();
	var comm_question_id=$('#comm_question_id').val();
	$.ajax({
		url: '<?php echo base_url();?>survey/question/codesave/'+comm_question_id, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : $("#form_data_code").serialize(), // post data || get data
		success : function(result) {
			$('#saveBeforeClose').attr('checked',false);
			$('#generateCodeQuestionModal').modal('hide');
			alert('Saved Successfully');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	});	
}	
function printFunction(selectButton){
	var t=$('#comm_panel');
	var default_question_no=$('#generateCodeQuestionModal .modal-title input[name="default_question_no"]').val();
	var current_question_no=$(selectButton).val();
	default_question_no=$.trim(default_question_no);
	current_question_no=current_question_no.replace('{id}',default_question_no);
	current_question_no=current_question_no.replace("'{id}'","'"+default_question_no+"'");
	t.val(t.val()+current_question_no);
	//$('#comm_panel').numberedtextarea();
}	
function increaseDiv(a){
	var parentdiv=$(a).parent().parent();
	var childdiv=$(parentdiv).find('.acc').get(0);
	$(childdiv).clone().appendTo($(parentdiv));
}	
function decreaseDiv(a){
	var parentdiv=$(a).parent().parent().find('.acc').length;
	if(parentdiv>1){
		var parentchilddiv=$(a).parent();
		$(parentchilddiv).remove();
	}else{
		alert('You must have atleast one answer choice');
	}
}
function increaseLanguage(a){
	var parentdiv=$(a).parent().parent();
	var childdiv=$(parentdiv).find('.acc').get(0);
	$(childdiv).clone().appendTo($(parentdiv));
}	
function decreaseLanguage(a){
	var parentdiv=$(a).parent().parent().find('.acc').length;
	if(parentdiv>1){
		var parentchilddiv=$(a).parent();
		$(parentchilddiv).remove();
	}else{
		$(a).parent().find('input').val('');
		//alert('You must have atleast one choice');
	}
}
function take_answer_choices(a){
	var textarea=$(a).parent().find('textarea');
	$(textarea).toggle();
}
function selectSurvey(){
	$('#createOrExistSurveyModal').modal('hide');
	$('#selectSurveyModal').modal('show');
}	
function chooseSurvey(survey_title_url){
	document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	$('#selectSurveyModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function fillSurvey(){
	$('#fillSurveyModal').modal('show');
}	
function chooseSurveyAndFill(survey_title_url){
	//var survey=$('[name="survey_title_url"]:first');
	//console.log(survey_title_url+" "+survey.val());
	
	document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	$('#fillSurveyModal').modal('hide');
	$('#selectSurveyCaseToCompleteModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/cases/";?>'+survey_title_url,'selectSurveyCaseToCompleteModal');
}
function setSurveyCase(survey_case_id,survey_case){
	localStorage.setItem("survey_case_id", survey_case_id);
	localStorage.setItem("case", survey_case);
	setTimeout(function(){
		window.location.reload();
	}, 1);
}
function setSurveyCase2(survey_case_id,survey_case){
	var survey_copy=$('#survey_copy');
	localStorage.setItem("survey_case_id", survey_case_id);
	localStorage.setItem("case", survey_case);
	if(survey_copy.length>0){
		if(survey_case=="New"){
			$('#survey_carbon').html($('#survey_copy').html());
			$('#selectSurveyCaseToCompleteModal').modal('hide');
			ready1();
			ready2();
			ready3();
			ready5();
			ready4();
			ready6();
		}else if(survey_case=="Old"){
			$('#survey_carbon').html($('#survey_copy').html());
			$('#selectSurveyCaseToCompleteModal').modal('hide');
			ready1();
			ready2();
			ready3();
			ready5();
			ready4();
			ready6();
		}else{}		
	}else{
		setTimeout(function(){
			window.location.reload();
		}, 1);		
	}
	//console.log($('#survey_copy').html());
}
function analyticsSurvey(){
	$('#analyticsSurveyModal').modal('show');
}	
function chooseSurveyAndAnalytics(survey_title_url){
	document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	$('#analyticsSurveyModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function prepareSurveyAnalytics(survey_title_url,survey_text){
	$('#analyticsSurveyModal').modal('hide');
	$('#prepareAnalyticsSurveyModal').modal('show');
	$('#prepareAnalyticsSurveyModal .modal-title').html('<strong>Set Indicators - <span class="title">'+survey_text+'</span></strong>');
	callAjaxGet('<?php echo base_url()."survey/indicators/";?>'+survey_title_url,'prepareAnalyticsSurveyModal');
}	
function saveIndicators(saveIndicatorsButton){
	var formData=$(saveIndicatorsButton).closest('form').serializeArray();
	$.ajax({
		url: '<?php echo base_url();?>survey/indicators/save', // url where to submit the request
		type : "POST", // type of action POST || GET
		data : formData, // post data || get data
		success : function(result) {
			setTimeout(function(){
				//$('#generateCodeQuestionModal .loader').hide();
				window.location.reload();
			}, 1000);
		},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function selectMoreIndicators(){
	$('#analyticsMoreIndicatorsSurveyModal').modal('show');
	var survey_id=$('input[name="analytics-survey"]').val();
	callAjaxGet('<?php echo base_url()."survey/list/indicators/";?>'+survey_id,'analyticsMoreIndicatorsSurveyModal');
}
function savePermission(savePermissionButton){
	var formData=$(savePermissionButton).closest('form').serializeArray();
	$.ajax({
		url: '<?php echo base_url();?>survey/permission/save', // url where to submit the request
		type : "POST", // type of action POST || GET
		data : formData, // post data || get data
		success : function(result) {
			alert('Permission Saved Sucessfully!');
			$('#permissionModal').modal('hide');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function editPermissions(){
	$('#permissionModal').modal('hide');
	$('#permissionsModal').modal('show');	
	
}	
function removePermission(permission_remove_link,survey_id,value,username){
	//console.log(survey_id+" "+value+" "+username);
	callAjaxGet('<?php echo base_url()."survey/permission/update/";?>'+survey_id+"/"+value+"/"+username,'');
	$(permission_remove_link).parent().html('');
}	
function closePermission(){
	$('#permissionsModal').modal('hide');	
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}	
function duplicate_question(){
	var arr = [];
	$("input.duplicate_question_check").each(function(){
		var value = $(this).val();
		if (arr.indexOf(value) == -1)
			arr.push(value);
		else
			$(this).closest('li').addClass("duplicate_question");
	});	
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function languageExist(JSONObject,v){
	for (i=0; i < JSONObject.length; i++) {
		if (JSONObject[i] == v)
			return true;
	}
	return false;	
}
function checkLanguage(language_checkbox){
	var language_checked=$(language_checkbox).prop('checked');
	var language_value=$(language_checkbox).val();
	//console.log(language_value+" "+language_checked);
	if(language_checked){
		//alert("language is true");
		if(document.cookie.indexOf("survey_language=")==-1){
			//alert("cookie not exist but created");
			var json_array = [""+language_value+""];
			var json_string = JSON.stringify(json_array);
			document.cookie = "survey_language="+json_string+";path=/;";
			showLanguage(language_value);
		}else{
			//alert("cookie already created");
			var json_string=readCookie("survey_language");
			var json_array=JSON.parse(json_string);
			if(languageExist(json_array,language_value)){
				//alert("language exist");				
				showLanguage(language_value);
			}else{
				json_array.push(language_value);
				json_string = JSON.stringify(json_array);
				document.cookie = "survey_language="+json_string+";path=/;";
				//alert("language not exist but added");				
				showLanguage(language_value);
			}
		}
	}else{
		//alert("language is false");
		if(document.cookie.indexOf("survey_language=")==-1){
			//alert("cookie not exist");
		}else{
			//alert("cookie already created");
			var json_string=readCookie("survey_language");
			var json_array=JSON.parse(json_string);
			if(json_array.length<2){
				//document.cookie = "survey_language=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";	
				alert("You must have atleast One Language");
				return false;
			}else{
				if(languageExist(json_array,language_value)){
					//alert("language exist and deleted");				
					for (i=0; i < json_array.length; i++) {
						if (json_array[i] == language_value)
							json_array.splice(i,1);
					}
					json_string = JSON.stringify(json_array);
					document.cookie = "survey_language="+json_string+";path=/;";
					hideLanguage(language_value);
				}else{
					//alert("language not exist");				
				}
			}
		}
	}
	//alert(document.cookie);
	//console.log(document.cookie);
	return true;
}
function controlSurvey(survey_title_url){
	$('#controlModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/control/";?>'+survey_title_url,'controlModal');
}		
function license_check(){
	var pattern=/[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}/g;
	var license=$('input[name="license_key"]').val();
	var username=$('input[name="username"]').val();
	if(pattern.test(license)){

	<?php if(base_url()!=ONLINE_URL){?>		
		$.post('<?php echo ONLINE_URL."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
			result=JSON.parse(result);
			console.log(result.license_key);
			return $.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':result.license_key,'username':result.username});
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));			
	<?php }else{ ?>
		$.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));
		<?php }?>
	}else{
		alert('Please Enter Correct License Key');
	}
}		
function execSync(anchor){
	var a=$(anchor);
	if(a.hasClass('disabled')){
		alert("Please Wait!");
	}else{
		$(a).addClass('disabled');
		checkQueue();
		goSync();
	}
}	
