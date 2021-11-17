// JavaScript Document
var pathparts = location.pathname.split('/');
var url = '';
if (location.host === 'localhost') {
     url = location.origin + '/' + pathparts[1].trim('/') + '/'; // http://localhost/myproject/
} else {
     url = location.origin + '/'; // http://stackoverflow.com
}

function codeQuestionWizard(codeAnchor, question_id) {
     $('#codeWizardModal').modal('show');
     $('#codeWizardModal .modal-body').find('form[name="codeWizardForm"]').attr('data-question-id', question_id);
     var nav = $('#codeWizardModal .modal-body .wizard ul.nav');
     var tabcontent = $('#codeWizardModal .modal-body .wizard div.tab-content');
     $.get(url + 'survey/get_survey_code2/' + question_id, function (data1) {
          data1 = data1.trim();
          //console.log(data1);
          if (data1 !== '') {
               $('#codeWizardModal .modal-body').find('form[name="codeWizardForm"]').html(data1);
               nav = $('#codeWizardModal .modal-body .wizard ul.nav');
               tabcontent = $('#codeWizardModal .modal-body .wizard div.tab-content');
          } else {
               nav = $('#codeWizardModal .modal-body .wizard ul.nav');
               tabcontent = $('#codeWizardModal .modal-body .wizard div.tab-content');
               nav.html('');
               tabcontent.html('');
          }

          $.get(url + 'survey/get_survey_elements_list/' + question_id, function (data) {
               //console.log(data);
               data = JSON.parse(data);
               var counter = 0;
               var previous_li = '';
               for (var i in data) {
                    var l = $('#' + data[i]).length;


                    if (l < 1) {
                         counter = nav.find('li').length;
                         counter++;
                         if (counter == 1) {
                              tabcontent.append('<div class="tab-pane active" id="' + data[i] + '" data-element="' + data[i] + '">');
                         } else {
                              tabcontent.append('<div class="tab-pane" id="' + data[i] + '" data-element="' + data[i] + '">');
                         }

                         var pl = nav.find('li a[href="#' + previous_li + '"]').parent();
                         if (previous_li !== undefined && previous_li.length > 0) {
                              $('<li><a href="#' + data[i] + '" data-toggle="tab">' + data[i] + '</a></li>').insertAfter(pl);
                         } else {
                              nav.append('<li><a href="#' + data[i] + '" data-toggle="tab">' + data[i] + '</a></li>');
                         }

                         var tabcontent_html = $('#code_wizard_procedure_helper>div.panel-group').clone();
                         var attr_data = tabcontent_html.attr('id');
                         tabcontent_html.attr('id', attr_data + counter);

                         tabcontent_html.find('.panel-title').each(function () {
                              $(this).find('a').attr('data-parent', $(this).find('a').attr('data-parent') + counter);
                              $(this).find('a').attr('href', $(this).find('a').attr('href') + counter);
                         });

                         tabcontent_html.find('.panel-collapse').each(function () {
                              $(this).attr('id', $(this).attr('id') + counter);
                         });

                         tabcontent.find('#' + data[i] + '').append(tabcontent_html);
                    }
                    previous_li = data[i];
               }
               nav.find('li.active').removeClass('active');
               nav.find('li:first-child').addClass('active');
          });

          $.get(url + 'survey/get_survey_code/' + question_id, function (data) {
               $('#codeWizardModal .modal-body .codeWizardDisplayForm').html(data);
               //$('.selectpicker').selectpicker('refresh');   
               setTimeout(function () {
                    $('#comm_panel').numberedtextarea();
               }, 2000);
          });
     });
}
function convert_code_from_code2(code2form) {
     var html = '';
     var elements = [];
     code2form.find('.tab-pane').each(function () {
          var e = $(this).attr('data-element');
          elements.push(e);
     });
     for (var i = 0; i < elements.length; i++) {
          //console.log(elements[i]);
          var element_html = '';
          element_html += '//' + elements[i] + '//' + '\r\n';

          //preproc wizard
          var preproc_html = '';
          var fieldset_preproc = code2form.find('[data-element="' + elements[i] + '"]').find('fieldset.preproc');
          //*nonconditional preproc wizard
          var fieldset_preproc_nonconditional = fieldset_preproc.find('fieldset.nonconditional');
          var fieldset_preproc_function_list_html = '';
          fieldset_preproc_nonconditional.find('fieldset.functions').find('>fieldset').each(function () {
               var f = $(this);
               var f_name = f.attr('class');
               //fieldset_preproc_function_list_html += f_name + '\r\n';

               //function start
               fieldset_preproc_function_list_html += convert_code_from_function(f);
               //function end
          });
          element_html += '/*preproc*/' + '\r\n' + fieldset_preproc_function_list_html;
          //console.log(element_html);

          //*conditional preproc wizard
          var fieldset_preproc_conditional = fieldset_preproc.find('fieldset.conditional');
          var fieldset_preproc_conditional_if = fieldset_preproc_conditional.find('>fieldset.IF');
          //console.log(fieldset_preproc_conditional_if);
          if (fieldset_preproc_conditional_if.length > 0) {
               var fieldset_preproc_conditional_if_condition_text = '';
               fieldset_preproc_conditional_if.find('fieldset.condition').find('fieldset.rule').each(function () {
                    var rule = $(this);
                    var co = rule.find('.no-class').find('.conditional-operators');
                    if (!co.hasClass('hidden')) { //it is visible only
                         fieldset_preproc_conditional_if_condition_text += ' ' + co.val() + ' ';
                    }
                    var vid = rule.find('.no-class').find('.variable_ids');
                    fieldset_preproc_conditional_if_condition_text += '' + vid.val();

                    var o = rule.find('.no-class').find('.operators');
                    fieldset_preproc_conditional_if_condition_text += '' + o.val();

                    var cv = rule.find('.no-class').find('.conditionValue ');
                    fieldset_preproc_conditional_if_condition_text += '' + cv.val();
               });
               fieldset_preproc_conditional_if_condition_text = 'if(' + fieldset_preproc_conditional_if_condition_text + '){' + '\r\n';
               var fieldset_preproc_function_list_html = '';
               fieldset_preproc_conditional_if.find('fieldset.functions').find('>fieldset').each(function () {
                    var f = $(this);
                    var f_name = f.attr('class');
                    //fieldset_preproc_function_list_html += f_name + '\r\n';

                    //function start
                    fieldset_preproc_function_list_html += convert_code_from_function(f);
                    //function end                    
               });
               //console.log(fieldset_preproc_function_list_html);
               fieldset_preproc_conditional_if_condition_text += fieldset_preproc_function_list_html + '}';
               //console.log(fieldset_preproc_conditional_if_condition_text);
               element_html += fieldset_preproc_conditional_if_condition_text;
          }

          var fieldset_preproc_conditional_elseif = fieldset_preproc_conditional.find('>fieldset.ELSEIF');
          //console.log(fieldset_preproc_conditional_elseif);
          if (fieldset_preproc_conditional_elseif.length > 0) {
               var fieldset_preproc_conditional_elseif_condition_text = '';  
               fieldset_preproc_conditional_elseif.each(function(){
                    var fieldset_preproc_conditional_elseif_each=$(this);
                    //console.log(fieldset_preproc_conditional_elseif_each);
                    var fieldset_preproc_conditional_elseif_each_text='';
                    fieldset_preproc_conditional_elseif_each_text = 'else if(';                    
                    fieldset_preproc_conditional_elseif_each.find('fieldset.condition').find('fieldset.rule').each(function () {
                         var rule = $(this);
                         var co = rule.find('.no-class').find('.conditional-operators');
                         if (!co.hasClass('hidden')) { //it is visible only
                              fieldset_preproc_conditional_elseif_each_text += ' ' + co.val() + ' ';
                         }
                         var vid = rule.find('.no-class').find('.variable_ids');
                         fieldset_preproc_conditional_elseif_each_text += '' + vid.val();

                         var o = rule.find('.no-class').find('.operators');
                         fieldset_preproc_conditional_elseif_each_text += '' + o.val();

                         var cv = rule.find('.no-class').find('.conditionValue ');
                         fieldset_preproc_conditional_elseif_each_text += '' + cv.val();

                         var fieldset_preproc_function_list_html = '';
                         rule.find('fieldset.functions').find('>fieldset').each(function () {
                              var f = $(this);
                              var f_name = f.attr('class');
                              //fieldset_preproc_function_list_html += f_name + '\r\n';

                              //function start
                              fieldset_preproc_function_list_html += convert_code_from_function(f);
                              //function end   
                         });
                    });
                    fieldset_preproc_conditional_elseif_each_text += '){' + '\r\n';
                    fieldset_preproc_conditional_elseif_each_text += fieldset_preproc_function_list_html + '}';
                    //console.log(fieldset_preproc_conditional_elseif_each_text);
                    fieldset_preproc_conditional_elseif_condition_text += fieldset_preproc_conditional_elseif_each_text;                       
               });

               console.log(fieldset_preproc_conditional_elseif_condition_text);
               element_html += fieldset_preproc_conditional_elseif_condition_text;
          }

          var fieldset_preproc_conditional_else = fieldset_preproc_conditional.find('>fieldset.ELSE');
          //console.log(fieldset_preproc_conditional_else);
          if (fieldset_preproc_conditional_else.length > 0) {
               var fieldset_preproc_conditional_else_condition_text = '';
               fieldset_preproc_conditional_else_condition_text = 'else{' + '\r\n';
               var fieldset_preproc_function_list_html = '';
               fieldset_preproc_conditional_else.find('fieldset.functions').find('>fieldset').each(function () {
                    var f = $(this);
                    var f_name = f.attr('class');
                    //fieldset_preproc_function_list_html += f_name + '\r\n';

                    //function start
                    fieldset_preproc_function_list_html += convert_code_from_function(f);
                    //function end   
               });
               //console.log(fieldset_preproc_function_list_html);
               fieldset_preproc_conditional_else_condition_text += fieldset_preproc_function_list_html + '}';
               //console.log(fieldset_preproc_conditional_elseif_condition_text);   
               element_html += fieldset_preproc_conditional_else_condition_text
          }
          element_html += '\r\n' + '/*preproc*/' + '\r\n';

          
          //postproc wizard
          var postproc_html = '';
          var fieldset_postproc = code2form.find('[data-element="' + elements[i] + '"]').find('fieldset.postproc');
          //*nonconditional postproc wizard
          var fieldset_postproc_nonconditional = fieldset_postproc.find('fieldset.nonconditional');
          var fieldset_postproc_function_list_html = '';
          fieldset_postproc_nonconditional.find('fieldset.functions').find('>fieldset').each(function () {
               var f = $(this);
               var f_name = f.attr('class');
               //fieldset_postproc_function_list_html += f_name + '\r\n';

               //function start
               fieldset_postproc_function_list_html += convert_code_from_function(f);
               //function end
          });
          element_html += fieldset_postproc_function_list_html + '\r\n';
          //console.log(element_html);

          //*conditional postproc wizard
          var fieldset_postproc_conditional = fieldset_postproc.find('fieldset.conditional');
          var fieldset_postproc_conditional_if = fieldset_postproc_conditional.find('>fieldset.IF');
          //console.log(fieldset_postproc_conditional_if);
          if (fieldset_postproc_conditional_if.length > 0) {
               var fieldset_postproc_conditional_if_condition_text = '';
               fieldset_postproc_conditional_if.find('fieldset.condition').find('fieldset.rule').each(function () {
                    var rule = $(this);
                    var co = rule.find('.no-class').find('.conditional-operators');
                    if (!co.hasClass('hidden')) { //it is visible only
                         fieldset_postproc_conditional_if_condition_text += ' ' + co.val() + ' ';
                    }
                    var vid = rule.find('.no-class').find('.variable_ids');
                    fieldset_postproc_conditional_if_condition_text += '' + vid.val();

                    var o = rule.find('.no-class').find('.operators');
                    fieldset_postproc_conditional_if_condition_text += '' + o.val();

                    var cv = rule.find('.no-class').find('.conditionValue ');
                    fieldset_postproc_conditional_if_condition_text += '' + cv.val();
               });
               fieldset_postproc_conditional_if_condition_text = 'if(' + fieldset_postproc_conditional_if_condition_text + '){' + '\r\n';
               var fieldset_postproc_function_list_html = '';
               fieldset_postproc_conditional_if.find('fieldset.functions').find('>fieldset').each(function () {
                    var f = $(this);
                    var f_name = f.attr('class');
                    //fieldset_postproc_function_list_html += f_name + '\r\n';

                    //function start
                    fieldset_postproc_function_list_html += convert_code_from_function(f);
                    //function end                    
               });
               //console.log(fieldset_postproc_function_list_html);
               fieldset_postproc_conditional_if_condition_text += fieldset_postproc_function_list_html + '}';
               //console.log(fieldset_postproc_conditional_if_condition_text);
               element_html += fieldset_postproc_conditional_if_condition_text;
          }

          var fieldset_postproc_conditional_elseif = fieldset_postproc_conditional.find('>fieldset.ELSEIF');
          //console.log(fieldset_postproc_conditional_elseif);
          if (fieldset_postproc_conditional_elseif.length > 0) {
               var fieldset_postproc_conditional_elseif_condition_text = '';  
               fieldset_postproc_conditional_elseif.each(function(){
                    var fieldset_postproc_conditional_elseif_each=$(this);
                    //console.log(fieldset_postproc_conditional_elseif_each);
                    var fieldset_postproc_conditional_elseif_each_text='';
                    fieldset_postproc_conditional_elseif_each_text = 'else if(';                    
                    fieldset_postproc_conditional_elseif_each.find('fieldset.condition').find('fieldset.rule').each(function () {
                         var rule = $(this);
                         var co = rule.find('.no-class').find('.conditional-operators');
                         if (!co.hasClass('hidden')) { //it is visible only
                              fieldset_postproc_conditional_elseif_each_text += ' ' + co.val() + ' ';
                         }
                         var vid = rule.find('.no-class').find('.variable_ids');
                         fieldset_postproc_conditional_elseif_each_text += '' + vid.val();

                         var o = rule.find('.no-class').find('.operators');
                         fieldset_postproc_conditional_elseif_each_text += '' + o.val();

                         var cv = rule.find('.no-class').find('.conditionValue ');
                         fieldset_postproc_conditional_elseif_each_text += '' + cv.val();

                         var fieldset_postproc_function_list_html = '';
                         rule.find('fieldset.functions').find('>fieldset').each(function () {
                              var f = $(this);
                              var f_name = f.attr('class');
                              //fieldset_postproc_function_list_html += f_name + '\r\n';

                              //function start
                              fieldset_postproc_function_list_html += convert_code_from_function(f);
                              //function end   
                         });
                    });
                    fieldset_postproc_conditional_elseif_each_text += '){' + '\r\n';
                    fieldset_postproc_conditional_elseif_each_text += fieldset_postproc_function_list_html + '}';
                    //console.log(fieldset_postproc_conditional_elseif_each_text);
                    fieldset_postproc_conditional_elseif_condition_text += fieldset_postproc_conditional_elseif_each_text;                       
               });

               console.log(fieldset_postproc_conditional_elseif_condition_text);
               element_html += fieldset_postproc_conditional_elseif_condition_text;
          }

          var fieldset_postproc_conditional_else = fieldset_postproc_conditional.find('>fieldset.ELSE');
          //console.log(fieldset_postproc_conditional_else);
          if (fieldset_postproc_conditional_else.length > 0) {
               var fieldset_postproc_conditional_else_condition_text = '';
               fieldset_postproc_conditional_else_condition_text = 'else{' + '\r\n';
               var fieldset_postproc_function_list_html = '';
               fieldset_postproc_conditional_else.find('fieldset.functions').find('>fieldset').each(function () {
                    var f = $(this);
                    var f_name = f.attr('class');
                    //fieldset_postproc_function_list_html += f_name + '\r\n';

                    //function start
                    fieldset_postproc_function_list_html += convert_code_from_function(f);
                    //function end   
               });
               //console.log(fieldset_postproc_function_list_html);
               fieldset_postproc_conditional_else_condition_text += fieldset_postproc_function_list_html + '}';
               //console.log(fieldset_postproc_conditional_elseif_condition_text);   
               element_html += fieldset_postproc_conditional_else_condition_text
          }
          

          element_html += '\r\n';
          //console.log(element_html);
          html += element_html;
     }
     //console.log(html);
     return html;
}
function convert_code_from_function(f){
     var function_text='';
     var f_name = f.attr('class');
     if(f_name=="getVal"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var returns=f.find('.returns').val();
          function_text+="var "+returns+"="+f_name+"('"+element_ids+"');"+"\r\n";
     }else if(f_name=="setVal"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var variable_ids=f.find('.variable_ids').val();
          var returns=f.find('.returns').val();
          if(variable_ids=="constant"){
               var constant=f.find('.constant').val();
               function_text+=f_name+"('"+element_ids+"','"+constant+"');"+"\r\n";
          }else{
               function_text+=f_name+"('"+element_ids+"',"+variable_ids+");"+"\r\n";               
          }
     }else if(f_name=="isRequired"){ 
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";    
     }else if(f_name=="isNum"){ 
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";    
     }else if(f_name=="isAlpha"){ 
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n"; 
     }else if(f_name=="isAlphaNum"){ 
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";            
     }else if(f_name=="isRange"){ 
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var range=f.find('.range').val();
          range=range.split(',');
          var range_arr=[];
          var new_range="";
          for (var i = 0; i < range.length; i++) {
               if(range[i].includes('-')==true){
                    range_arr.push("'"+range[i]+"'");
               }else{
                    range_arr.push(range[i]);
               }
          }
          new_range=range_arr.join(',');
          function_text+=f_name+"('"+element_ids+"',["+new_range+"]);"+"\r\n";  
     }else if(f_name=="isFixed"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var variable_ids=f.find('.variable_ids').val();
          var returns=f.find('.returns').val();
          if(variable_ids=="constant"){
               var constant=f.find('.constant').val();
               function_text+=f_name+"('"+element_ids+"','"+constant+"');"+"\r\n";
          }else{
               function_text+=f_name+"('"+element_ids+"',"+variable_ids+");"+"\r\n";               
          } 
     }else if(f_name=="doHide"){ 
          var element_ids_start=f.find('.element_ids.start').val();
          var element_ids_end=f.find('.element_ids.end').val();          
          function_text+=f_name+"('"+element_ids_start+"','"+element_ids_end+"');"+"\r\n";      
     }else if(f_name=="doShow"){ 
          var element_ids_start=f.find('.element_ids.start').val();
          var element_ids_end=f.find('.element_ids.end').val();          
          function_text+=f_name+"('"+element_ids_start+"','"+element_ids_end+"');"+"\r\n";      
     }else if(f_name=="msg"){ 
          var constant=f.find('.constant').val();
          function_text+=f_name+"('"+constant+"');"+"\r\n";  
     }else if(f_name=="doJumpForward"){ 
          var element_ids_start=f.find('.element_ids.start').val();
          var element_ids_end=f.find('.element_ids.end').val();          
          function_text+=f_name+"('"+element_ids_start+"','"+element_ids_end+"');"+"\r\n";         
     }else if(f_name=="openBox"){ 
          var t="ra"+new Date().getTime();
          var element_ids=f.find('.element_ids').not('.multiple').val();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          element_ids_multiple=element_ids_multiple.join("','");
          var openbox=f.find('.openbox').val();     
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+=f_name+"('"+element_ids+"',"+t+",'"+openbox+"');"+"\r\n";   
     }else if(f_name=="dateDiff"){ 
          var variable_ids_first=f.find('.variable_ids.multiple.first'); 
          var variable_ids_second=f.find('.variable_ids.multiple.second'); 
          var d1='';
          var d2='';
          if(variable_ids_first.val().length>1){
               var t="d"+new Date().getTime();
               function_text+="var "+t+"="+variable_ids_first.val().join("+'/'+")+";"+"\r\n";  
               d1=t; 
          }else{
               d1=variable_ids_first.val();
          }
          if(variable_ids_second.val().length>1){
               var t="d"+new Date().getTime();
               function_text+="var "+t+"="+variable_ids_second.val().join("+'/'+")+";"+"\r\n";   
               d2=t; 
          }else{
               d2=variable_ids_second.val();
          }         
          var keys=f.find('.keys').val();
          var returns=f.find('.returns').val();
          function_text+="var "+returns+"="+f_name+"("+d1+","+d2+",'"+keys+"');"+"\r\n";
     }else if(f_name=="today"){ 
          var keys=f.find('.keys').val();
          var returns=f.find('.returns').val();
          function_text+="var "+returns+"="+f_name+"('"+keys+"');"+"\r\n"; 
     }else if(f_name=="now"){ 
          var keys=f.find('.keys').val();
          var returns=f.find('.returns').val();
          function_text+="var "+returns+"="+f_name+"('"+keys+"');"+"\r\n";  
     }else if(f_name=="gps"){ 
          var keys=f.find('.keys').val();
          var element_ids=f.find('.element_ids').not('.multiple').val();
          function_text+=f_name+"('"+keys+"','"+element_ids+"');"+"\r\n";   
     }else if(f_name=="doColumnHide"){ 
          var element_ids=f.find('.element_ids').val();
          var nos=f.find('.nos').val();
          function_text+=f_name+"('"+element_ids+"',"+nos+");"+"\r\n";        
     }else if(f_name=="doColumnShow"){ 
          var element_ids=f.find('.element_ids').val();
          var nos=f.find('.nos').val();
          function_text+=f_name+"('"+element_ids+"',"+nos+");"+"\r\n";    
     }else if(f_name=="random"){ 
          var t="ra"+new Date().getTime();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          var returns=f.find('.returns').val();
          element_ids_multiple=element_ids_multiple.join("','");
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+="var "+returns+"="+f_name+"("+t+");"+"\r\n";          
     }else if(f_name=="getStates"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";  
     }else if(f_name=="getDistricts"){
          //console.log(f);
          var element_ids_first=f.find('.element_ids.first').val();
          var element_ids_second=f.find('.element_ids.second').val();          
          function_text+=f_name+"('"+element_ids_first+"','"+element_ids_second+"');"+"\r\n"; 
     }else if(f_name=="skip"){
          //console.log(f);
          var element_ids_start=f.find('.element_ids.start').val();
          var element_ids_end=f.find('.element_ids.end').val();          
          function_text+=f_name+"('"+element_ids_start+"','"+element_ids_end+"');"+"\r\n";     
     }else if(f_name=="endSurvey"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";   
     }else if(f_name=="toFocus"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";    
    }else if(f_name=="doMax"){ 
          var t="ra"+new Date().getTime();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          var returns=f.find('.returns').val();
          element_ids_multiple=element_ids_multiple.join("','");
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+="var "+returns+"="+f_name+"("+t+");"+"\r\n";       
    }else if(f_name=="doMin"){ 
          var t="ra"+new Date().getTime();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          var returns=f.find('.returns').val();
          element_ids_multiple=element_ids_multiple.join("','");
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+="var "+returns+"="+f_name+"("+t+");"+"\r\n";    
     }else if(f_name=="doBlock"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";  
     }else if(f_name=="doUnblock"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";  
     }else if(f_name=="doCheck"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var variable_ids=f.find('.variable_ids').val();
          var returns=f.find('.returns').val();
          if(variable_ids=="constant"){
               var constant=f.find('.constant').val();
               function_text+=f_name+"('"+element_ids+"','"+constant+"');"+"\r\n";
          }else{
               function_text+=f_name+"('"+element_ids+"',"+variable_ids+");"+"\r\n";               
          }           
     }else if(f_name=="doUncheck"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";    
     }else if(f_name=="toCaps"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          function_text+=f_name+"('"+element_ids+"');"+"\r\n";    
    }else if(f_name=="doPlus"){ 
          var t="ra"+new Date().getTime();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          var returns=f.find('.returns').val();
          element_ids_multiple=element_ids_multiple.join("','");
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+="var "+returns+"="+f_name+"("+t+");"+"\r\n";  
     }else if(f_name=="doMinus"){
          //console.log(f);
          var returns=f.find('.returns').val();
          var variable_ids_first=f.find('.variable_ids.first');
          var variable_ids_first_var='';
          if(variable_ids_first.val()=="constant"){
               var constant=variable_ids_first.next('.constant').val();
               variable_ids_first_var="'"+constant+"'";
          }else{
               variable_ids_first_var=variable_ids_first.val();
          }               
          var variable_ids_second=f.find('.variable_ids.second');
          var variable_ids_second_var='';
          if(variable_ids_second.val()=="constant"){
               var constant=variable_ids_second.next('.constant').val();
               variable_ids_second_var="'"+constant+"'";
          }else{
               variable_ids_second_var=variable_ids_second.val();
          }
          function_text+="var "+returns+"="+f_name+"("+variable_ids_first_var+","+variable_ids_second_var+");"+"\r\n";
     }else if(f_name=="doMultiply"){
          //console.log(f);
          var returns=f.find('.returns').val();
          var variable_ids_first=f.find('.variable_ids.first');
          var variable_ids_first_var='';
          if(variable_ids_first.val()=="constant"){
               var constant=variable_ids_first.next('.constant').val();
               variable_ids_first_var="'"+constant+"'";
          }else{
               variable_ids_first_var=variable_ids_first.val();
          }               
          var variable_ids_second=f.find('.variable_ids.second');
          var variable_ids_second_var='';
          if(variable_ids_second.val()=="constant"){
               var constant=variable_ids_second.next('.constant').val();
               variable_ids_second_var="'"+constant+"'";
          }else{
               variable_ids_second_var=variable_ids_second.val();
          }
          function_text+="var "+returns+"="+f_name+"("+variable_ids_first_var+","+variable_ids_second_var+");"+"\r\n";
     }else if(f_name=="doDivide"){
          //console.log(f);
          var returns=f.find('.returns').val();
          var variable_ids_first=f.find('.variable_ids.first');
          var variable_ids_first_var='';
          if(variable_ids_first.val()=="constant"){
               var constant=variable_ids_first.next('.constant').val();
               variable_ids_first_var="'"+constant+"'";
          }else{
               variable_ids_first_var=variable_ids_first.val();
          }               
          var variable_ids_second=f.find('.variable_ids.second');
          var variable_ids_second_var='';
          if(variable_ids_second.val()=="constant"){
               var constant=variable_ids_second.next('.constant').val();
               variable_ids_second_var="'"+constant+"'";
          }else{
               variable_ids_second_var=variable_ids_second.val();
          }
          function_text+="var "+returns+"="+f_name+"("+variable_ids_first_var+","+variable_ids_second_var+");"+"\r\n";                    
    }else if(f_name=="doConcat"){ 
          var t="ra"+new Date().getTime();
          var element_ids_multiple=f.find('.element_ids.multiple').val(); 
          var returns=f.find('.returns').val();
          element_ids_multiple=element_ids_multiple.join("','");
          function_text+="var "+t+"="+"['"+element_ids_multiple+"'];"+"\r\n";    
          function_text+="var "+returns+"="+f_name+"("+t+");"+"\r\n";       
     }else if(f_name=="doRowHide"){ 
          var element_ids=f.find('.element_ids').val();
          var nos=f.find('.nos').val();
          function_text+=f_name+"('"+element_ids+"',"+nos+");"+"\r\n";  
     }else if(f_name=="doRowShow"){ 
          var element_ids=f.find('.element_ids').val();
          var nos=f.find('.nos').val();
          function_text+=f_name+"('"+element_ids+"',"+nos+");"+"\r\n";  
     }else if(f_name=="getLabel"){
          //console.log(f);
          var element_ids=f.find('.element_ids').val();
          var returns=f.find('.returns').val();
          function_text+="var "+returns+"="+f_name+"('"+element_ids+"');"+"\r\n";      
     }else if(f_name=="setQtext"){
          //console.log(f);
          var t="ra"+new Date().getTime();
          var element_ids=f.find('.element_ids').val();
          var variable_ids=f.find('.variable_ids').val();
          var languages=f.find('.languages_text').attr('data-languages');
          languages=languages.split(',');
          var language={};
          for (var i = 0; i < languages.length; i++) {
               var l="Label"+(i+1);
               language[l]="."+languages[i];
          }
          language['object']=variable_ids;
          language=JSON.stringify(language);
          //console.log(language);         

          language=language.replace(/"/g,"'"); 
          var c=language.lastIndexOf("'");
          part1 = language.substring(0, c);
          part2 = language.substring(c + 1, language.length);
          language=part1 + part2;
          language=language.replace(/"/g,"'"); 
          var c=language.lastIndexOf("'");
          part1 = language.substring(0, c);
          part2 = language.substring(c + 1, language.length);
          language="var "+t+"="+part1 + part2+";";          
          //console.log(language);
          function_text+=language+"\r\n";
          function_text+=f_name+"('"+element_ids+"',"+t+");"+"\r\n";                    
     }else if(f_name=="isMobile"){ 
          var element_ids=f.find('.element_ids').val();
          var digit=f.find('.digit').val();
          var mindigit=f.find('.mindigit').val();
          function_text+=f_name+"('"+element_ids+"',"+digit+","+mindigit+");"+"\r\n";                                  
     }else{}
     //console.log(function_text);
     return function_text;
}
function updateCodeWizardForm(variables){
     //update variable dropdowns
     //with multiple
     var html = '<option value="">Select Var</option>';
     //html += '<option value="constant">Constant</option>';
     variables.find('li').each(function () {
          html += '<option value="' + $(this).text() + '">' + $(this).text() + '</option>';
     });
     //console.log($('.variable_ids.multiple'));
     $('.variable_ids.multiple').each(function () {
          var sel = $(this).val();
          $(this).html(html);
          $(this).val(sel);
     });           
 
     //without multiple only
     var html = '<option value="">Select Var</option>';
     html += '<option value="constant">Constant</option>';
     variables.find('li').each(function () {
          html += '<option value="' + $(this).text() + '">' + $(this).text() + '</option>';
     });
     //console.log($('.variable_ids:not(.multiple)'));
     $('.variable_ids').not('.multiple').each(function () {
          var sel = $(this).val();
          $(this).html(html);
          $(this).val(sel);
     });    

     //without multiple and has no-constant
     var html = '<option value="">Select Var</option>';
     //html += '<option value="constant">Constant</option>';
     variables.find('li').each(function () {
          html += '<option value="' + $(this).text() + '">' + $(this).text() + '</option>';
     });
     //console.log($('.variable_ids:not(.multiple)'));
     $('.variable_ids.no-constant').not('.multiple').each(function () {
          var sel = $(this).val();
          $(this).html(html);
          $(this).val(sel);
     });    
     //$('.selectpicker').selectpicker('refresh');         
}
$(document).on('click', '.add-function', function () {
     var variables=$(this).closest('.panel-body>fieldset').find('ul.variables');
     //console.log(variables);
     var t = new Date().getTime();
     var survey_id = $(this).closest('form').attr('data-survey-id');
     var all_funcs = $('#code_wizard_helper');
     var functions_box = $(this).closest('.functions');
     var func = $(this).attr('data-function');
     if (func !== '') {
          var c = all_funcs.find('.' + func);
          c = c.clone();
          c.attr('data-time', t);
          c.appendTo(functions_box);
     }
     //console.log(functions_box);
     var gsela = '<option value="">Select Id</option>';
     $.get(url + 'survey/get_survey_elements_list_all/' + survey_id, function (data) {
          data = JSON.parse(data);
          for (var i in data) {
               gsela += '<option value="' + data[i] + '">' + data[i] + '</option>';
          }
          functions_box.find('>fieldset:last-child').find('.element_ids').html(gsela);
     });
     updateCodeWizardForm(variables);
     //$('.selectpicker').selectpicker('refresh');
});
$(document).on('click', '.functionRemover', function () {
     $(this).parent().parent().remove();
});
$(document).on('click', '.add-rule', function () {
     var condition_box = $(this).parent().parent();
     var rule = condition_box.find('.rule').last().clone();
     rule.find('.conditional-operators').removeClass('hidden');
     rule.appendTo(condition_box);
});
$(document).on('click', '.remove-rule', function () {
     if ($(this).parent().parent().parent().find('.rule').length > 1) {
          $(this).parent().parent().remove();
     } else {
          alert('There should be atleast one rule');
     }
});
$(document).on('click', '.remove-elseif', function () {
     $(this).parent().parent().remove();
});
$(document).on('click', '.add-elseif', function () {
     var elseif = $('#code_wizard_elseif_helper').find('.ELSEIF');
     var else_location = $(this).closest('.conditional').find('.ELSE');
     elseif.clone().insertBefore(else_location);
});
$(document).on('click', '.remove-conditional', function () {
     var conditional = $(this).parent().parent();
     conditional.find('fieldset').remove();
});
$(document).on('click', '.add-conditional', function () {
     var variables=$(this).closest('.panel-body>fieldset').find('ul.variables');
     var conditional_location = $(this).parent().parent();
     if (conditional_location.find('.IF').length < 1) {
          var if_code = $('#code_wizard_conditional_helper').find('.IF');
          var elseif_code = $('#code_wizard_conditional_helper').find('.ELSEIF');
          var else_code = $('#code_wizard_conditional_helper').find('.ELSE');
          if_code.clone().appendTo(conditional_location);
          elseif_code.clone().appendTo(conditional_location);
          else_code.clone().appendTo(conditional_location);
     }
     updateCodeWizardForm(variables);
});
$(document).on('click', '.save-button', function () {
     var f = $(this).closest('.no-class');
     var f_box = f.parent();
     var variables=$(this).closest('.panel-body>fieldset').find('ul.variables');
     var val = f.find('.returns').val();
     var go = true;
     var msg='';
     f.find('input,select').not('[type="button"]').each(function () {
          if ($(this).val() === "") {
               go = false;
               msg='Function should be completed';
          }
     });
     if (go == true) {
          var v = variables.find('li:contains("' + val + '")');
          if (v.length > 0 && v.data('time') == f_box.data('time')) {
               msg='Variable Exists';
          } else if (variables.find('[data-time="' + f_box.data('time') + '"]').length > 0) {
               variables.find('[data-time="' + f_box.data('time') + '"]').remove();
               if (typeof val !== "undefined") {
                    variables.append('<li data-time="' + f_box.data('time') + '">' + val + '</li>');
               }
          } else {
               if (typeof val !== "undefined") {
                    variables.append('<li data-time="' + f_box.data('time') + '">' + val + '</li>');
               }
          }
          updateCodeWizardForm(variables);
     } else {
          alert(msg);
     }
});
$(document).on("click", ".save-wizard-code", function () {
     var form = $(this).closest('form[name="codeWizardForm"]');
     var survey_id = form.attr('data-survey-id');
     var question_id = form.attr('data-question-id');
     //var question_id = form.data('question-id');
     //console.log(question_id);
     form.find('.wizard').find('input[type="text"]').each(function () {
          //console.log($(this));
          $(this).attr('value', $(this).val());
     });
     form.find('.wizard').find('select').each(function () {
          //console.log($(this));
          var v = $(this).val();
          $(this).find('option').removeAttr("selected");
          $(this).find('option[value="' + v + '"]').attr("selected", "selected");
          $(this).val(v);
     });

     var html = form.html();
     var text = '';
     html = html.replace(/\n|\t/g, ' ');
     //console.log(question_id);
     $.post(url + 'survey/save_wizard_code/', {
          'html': html,
          'question_id': question_id
     }).then(function (result) {
          text = convert_code_from_code2($('#codeWizardModal .modal-body').find('form[name="codeWizardForm"]'));
          return $.post(url+'survey/save_wizard_updated_code/',{'code':text,'question_id':question_id});
     }).then(function () {
          var comm_panel=form.closest('.modal-body').find('.codeWizardDisplayForm').find('textarea');
          comm_panel.val(text);
          alert('code saved');
     }).fail(console.log.bind(console));
});
$(document).on('change', '.variable_ids', function () {
     var vi=$(this);
     var v=vi.val();
     var vi_next=vi.next('.constant');
     //console.log(vi);
     //console.log(vi_next);
     if(v=="constant"){
          vi_next.removeClass('hidden');
          //vi.parent().find('.constant').removeClass('hidden');
     }else{
          vi_next.addClass('hidden');
          //vi.parent().find('.constant').addClass('hidden');
     }
     if(vi.hasClass('multiple')){
          var n=vi.next();
          if(vi.val().length>1){
               n.removeClass('hidden');
          }else{
               n.addClass('hidden');
          }
          
     }
});
$(document).on('change', '.element_ids.multiple,.variable_ids.multiple', function () {
     var s=$(this);
     s.find('option:selected').each(function() {
          $(this).attr("selected", "selected");
     });   
     s.find('option').not(':selected').each(function() {
          $(this).removeAttr("selected");
     });      
});
$(document).on('change', 'select', function () {
     var s=$(this);
     var v=s.val();
     s.find('option').removeAttr("selected");
     s.find('option[value="' + v + '"]').attr("selected", "selected");
     s.val(v);
});
