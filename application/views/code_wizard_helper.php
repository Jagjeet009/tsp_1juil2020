<?php $custom_functions = array( "dateDiff", "doBlock", "doCheck", "doColumnHide", "doColumnShow", "doConcat", "doDivide", "doHide", "doJumpForward", "doMax", "doMin", "doMinus", "doMultiply", "doPlus", "doRowHide", "doRowShow", "doShow", "doUnblock", "doUncheck", "endSurvey", "getDistricts", "getLabel", "getStates", "getVal", "gps", "isAlpha", "isAlphaNum", "isFixed", "isMobile", "isNum", "isRange", "isRequired", "msg", "now", "openBox", "random", "setQtext", "setVal", "skip", "toCaps", "today", "toFocus" ); ?>
<span id="code_wizard_helper">
     <fieldset class="getVal">
          <legend>getVal <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />
          </fieldset>
     </fieldset>
     <fieldset class="setVal">
          <legend>setVal <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="variable_ids form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
          </fieldset>
     </fieldset>
     <fieldset class="isRequired">
          <legend>isRequired <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>          
     </fieldset>
     <fieldset class="isNum">
          <legend>isNum <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>           
     </fieldset>
     <fieldset class="isAlpha">
          <legend>isAlpha <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>           
     </fieldset>
     <fieldset class="isAlphaNum">
          <legend>isAlphaNum <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>           
     </fieldset>
     <fieldset class="isRange">
          <legend>isRange <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="range" class="form-control range" placeholder="1,2,3,7-10" />
          </fieldset>
     </fieldset>
     <fieldset class="isFixed">
          <legend>isFixed <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="variable_ids form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
          </fieldset>
     </fieldset>
     <fieldset class="doHide">
          <legend>doHide <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids start form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids end form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>
     </fieldset>
     <fieldset class="doShow">
          <legend>doShow <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids start form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids end form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>
     </fieldset>
     <fieldset class="msg">
          <legend>msg <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <input type="text" name="constant" class="form-control constant" placeholder="Text" />
     </fieldset>
     <fieldset class="doJumpForward">
          <legend>doJumpForward <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids start form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids end form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>     
     </fieldset>
     <fieldset class="openBox">
          <legend>openBox <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="openbox" class="form-control openbox" placeholder="Heading for OpenBox" />
          </fieldset>       
     </fieldset>
     <fieldset class="dateDiff">
          <legend>dateDiff <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="variable_ids multiple first form-control selectpicker" multiple>
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="separator" class="form-control hidden separator" value="/" readonly />
               <select class="variable_ids multiple second form-control selectpicker" multiple>
                    <option value="">Select Var</option>
               </select>          
               <input type="text" name="separator" class="form-control hidden separator" value="/" readonly />
               <select class="keys form-control selectpicker">
                    <option value="">Select Key</option>
                    <option value="DAYS">DAYS</option>
                    <option value="MONTHS">MONTHS</option>
                    <option value="YEARS">YEARS</option>
                    <option value="HOURS">HOURS</option>
                    <option value="MINUTES">MINUTES</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />
          </fieldset>      
     </fieldset>
     <fieldset class="today">
          <legend>today <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="keys form-control selectpicker">
                    <option value="">Select Key</option>
                    <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                    <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                    <option value="YYYY/MM/DD">YYYY/MM/DD</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />
          </fieldset>     
     </fieldset>
     <fieldset class="now">
          <legend>now <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="keys form-control selectpicker">
                    <option value="">Select Key</option>
                    <option value="HH:mm">HH:mm</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />
          </fieldset>     
     </fieldset>
     <fieldset class="gps">
          <legend>gps <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="keys form-control selectpicker">
                    <option value="">Select Key</option>
                    <option value="ADDRESS">ADDRESS</option>
                    <option value="LATITUDE">LATITUDE</option>
                    <option value="LONGITUDE">LONGITUDE</option>
               </select>
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>          
          </fieldset>      
     </fieldset>
     <fieldset class="doColumnHide">
          <legend>doColumnHide <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="nos" class="form-control nos" placeholder="-1" />
          </fieldset>     
     </fieldset>
     <fieldset class="doColumnShow">
          <legend>doColumnShow <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="nos" class="form-control nos" placeholder="-1" />
          </fieldset>         
     </fieldset>
     <fieldset class="random">
          <legend>random <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />               
          </fieldset>      
     </fieldset>
     <fieldset class="getStates">
          <legend>getStates <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>      
     </fieldset>
     <fieldset class="getDistricts">
          <legend>getDistricts <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids first form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids second form-control selectpicker">
                    <option value="">Select Id</option>
               </select>          
          </fieldset>     
     </fieldset>
     <fieldset class="skip">
          <legend>skip <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids start form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="element_ids end form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>      
     </fieldset>
     <fieldset class="endSurvey">
          <legend>endSurvey <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>       
     </fieldset>
     <fieldset class="toFocus">
          <legend>toFocus <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>      
     </fieldset>
     <fieldset class="doMax">
          <legend>doMax <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                 
          </fieldset>       
     </fieldset>
     <fieldset class="doMin">
          <legend>doMin <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                 
          </fieldset>       
     </fieldset>
     <fieldset class="doBlock">
          <legend>doBlock <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>      
     </fieldset>
     <fieldset class="doUnblock">
          <legend>doUnblock <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>      
     </fieldset>
     <fieldset class="doCheck">
          <legend>doCheck <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <select class="variable_ids form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
          </fieldset>     
     </fieldset>
     <fieldset class="doUncheck">
          <legend>doUncheck <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>        
     </fieldset>
     <fieldset class="toCaps">
          <legend>toCaps <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
          </fieldset>        
     </fieldset>
     <fieldset class="doPlus">
          <legend>doPlus <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                
          </fieldset>      
     </fieldset>
     <fieldset class="doMinus">
          <legend>doMinus <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="variable_ids first form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
               <select class="variable_ids second form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" /> 
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                        
          </fieldset>     
     </fieldset>
     <fieldset class="doMultiply">
          <legend>doMultiply <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="variable_ids first form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
               <select class="variable_ids second form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />   
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                        
          </fieldset>         
     </fieldset>
     <fieldset class="doDivide">
          <legend>doDivide <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="variable_ids first form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />
               <select class="variable_ids second form-control selectpicker">
                    <option value="">Select Var</option>
               </select>
               <input type="text" name="constant" class="form-control hidden constant" placeholder="Constant" />    
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                       
          </fieldset>         
     </fieldset>
     <fieldset class="doConcat">
          <legend>doConcat <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids multiple form-control selectpicker" multiple>
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />                
          </fieldset>     
     </fieldset>
     <fieldset class="doRowHide">
          <legend>doRowHide <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="nos" class="form-control nos" placeholder="-1" />
          </fieldset>     
     </fieldset>
     <fieldset class="doRowShow">
          <legend>doRowShow <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="nos" class="form-control nos" placeholder="-1" />
          </fieldset>      
     </fieldset>
     <fieldset class="setQtext">
          <legend>setQtext <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <?php 
               $survey=$this->Survey_model->get_survey_by_title_url($_COOKIE['design_survey']);
               $languages=array('English');
               $survey[0]['languages']=(array) json_decode($survey[0]['languages']);
               $languages=array_merge($languages,$survey[0]['languages']);
               $languages_text=array();
               for($i=0;$i<sizeof($languages);$i++){
                    array_push($languages_text,"Label".($i+1)."=".$languages[$i]);
               }
               $languages_text=implode(', ',$languages_text);
               $languages=implode(',',$languages);
               ?>
               <div class="languages_text" data-languages="<?php echo $languages; ?>"><?php echo $languages_text;?></div>
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>               
               <select class="variable_ids form-control no-constant selectpicker">
                    <option value="">Select Var</option>
               </select>
          </fieldset>             
     </fieldset>
     <fieldset class="getLabel">
          <legend>getLabel <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="returns" class="form-control returns" placeholder="Return" />
               <input type="button" value="Save" class="form-control save-button" />
          </fieldset>     
     </fieldset>
     <fieldset class="isMobile">
          <legend>isMobile <a href="javascript:void(0)" class="functionRemover" title="Remove Function"><i class="fa fa-times"></i></a></legend>
          <fieldset class="no-class">
               <select class="element_ids form-control selectpicker">
                    <option value="">Select Id</option>
               </select>
               <input type="text" name="digit" class="form-control digit" placeholder="10" />
               <input type="text" name="mindigit" class="form-control mindigit" placeholder="6" />
          </fieldset>      
     </fieldset>
</span> <span id="code_wizard_elseif_helper">
     <fieldset class="ELSEIF">
          <legend>ELSEIF <a href="javascript:void(0)" class="remove-elseif" title="Remove Else If"><i class="fa fa-times"></i></a> </legend>
          <fieldset class="condition">
               <legend>Condition <a href="javascript:void(0)" class="add-rule" title="Add Rule"><i class="fa fa-plus"></i></a></legend>
               <fieldset class="rule">
                    <legend>Rule <a href="javascript:void(0)" class="remove-rule" title="Remove Rule"><i class="fa fa-times"></i></a></legend>
                    <fieldset class="no-class">
                         <select class="conditional-operators hidden form-control">
                              <option value="">Select</option>
                              <option value="&&">AND</option>
                              <option value="||">OR</option>
                         </select>
                         <select class="variable_ids form-control no-constant">
                              <option value="">Select Var</option>
                         </select>
                         <select class="operators form-control">
                              <option value="">Select</option>
                              <option value="==">Equal</option>
                              <option value="!=">Not Equal</option>
                         </select>
                         <input type="text" name="conditionValue" class="form-control conditionValue" />
                         <!--<input type="button" value="Save" class="form-control save-button" />-->
                    </fieldset>
               </fieldset>
          </fieldset>
          <fieldset class="functions">
               <legend>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Insert Functions</a>
                    <ul class="dropdown-menu scrollable-menu">
                         <?php foreach($custom_functions as $cf){ ?>
                              <li><a class="add-function" href="javascript:void(0)" data-function="<?php echo $cf; ?>"><?php echo $cf; ?></a></li>
                         <?php } ?>
                    </ul>
               </legend>
          </fieldset>
     </fieldset>
</span> <span id="code_wizard_conditional_helper">
     <fieldset class="IF">
          <legend>IF <a href="javascript:void(0)" class="add-elseif" title="Add Else If"><i class="fa fa-plus"></i></a></legend>
          <fieldset class="condition">
               <legend>Condition <a href="javascript:void(0)" class="add-rule" title="Add Rule"><i class="fa fa-plus"></i></a></legend>
               <fieldset class="rule">
                    <legend>Rule <a href="javascript:void(0)" class="remove-rule" title="Remove Rule"><i class="fa fa-times"></i></a></legend>
                    <fieldset class="no-class">
                         <select class="conditional-operators hidden form-control">
                              <option value="">Select</option>
                              <option value="&&">AND</option>
                              <option value="||">OR</option>
                         </select>
                         <select class="variable_ids form-control no-constant">
                              <option value="">Select Var</option>
                         </select>
                         <select class="operators form-control">
                              <option value="">Select</option>
                              <option value="==">Equal</option>
                              <option value="!=">Not Equal</option>
                         </select>
                         <input type="text" name="conditionValue" class="form-control conditionValue" />
                         <!-- <input type="button" value="Save" class="form-control save-button" />-->
                    </fieldset>
               </fieldset>
          </fieldset>
          <fieldset class="functions">
               <legend>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Insert Functions</a>
                    <ul class="dropdown-menu scrollable-menu">
                         <?php foreach($custom_functions as $cf){ ?>
                              <li><a class="add-function" href="javascript:void(0)" data-function="<?php echo $cf; ?>"><?php echo $cf; ?></a></li>
                         <?php } ?>
                    </ul>
               </legend>
          </fieldset>
     </fieldset>
     <fieldset class="ELSE">
          <legend>ELSE</legend>
          <fieldset class="functions">
               <legend>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Insert Functions</a>
                    <ul class="dropdown-menu scrollable-menu">
                         <?php foreach($custom_functions as $cf){ ?>
                              <li><a class="add-function" href="javascript:void(0)" data-function="<?php echo $cf; ?>"><?php echo $cf; ?></a></li>
                         <?php } ?>
                    </ul>
               </legend>
          </fieldset>
     </fieldset>
</span> <span id="code_wizard_procedure_helper">
     <?php $this->load->view('code_wizard_prepost_accordion'); ?>
</span>