<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
.bold{font-weight:bold;}
table{font-family:Courier New;font-size:15px;display:inline;width:400px;margin:auto;color:#999;}
table th{font-size:16px;font-weight:bold;}
table td{text-align:left;line-height:18px;}
table tr:hover{background-color:#eee;color:#000;}
.grey-tab{background-color:#ccc;}
.task-tabs{display:none;}
.navbar-custom>ul:first-child{display:none;}
strong{font-weight:900 !important;}
</style>
  <div class="container template-middle">
<table cellspacing="0" cellpadding="0" class="docs-table">
  <tr>
    <th width="39">Sno. </th>
    <th width="225">Function</th>
    <th width="264">Description</th>
    <th width="391">Example</th>
  </tr>
  <tr>
    <td valign="middle">1</td>
    <td valign="middle">getVal(id)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var a=getVal('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>msg(a);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">2</td>
    <td valign="middle">setVal(id,value)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('answer_q501','Jay Ho');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>var a=getVal('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>setVal('answer_q501',a);</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">3</td>
    <td valign="middle">isRequired(id)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>isRequired('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
       <td valign="middle">&nbsp;</td>
       <td valign="middle">&nbsp;</td>
       <td></td>
       <td>//must apply to all options in case of checkboxes</td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">4</td>
    <td valign="middle">isNum(id)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>isNum('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">5</td>
    <td valign="middle">isAlpha(id)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>isAlpha('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">6</td>
    <td valign="middle">isAlphaNum(id)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>isAlphaNum('answer_q501');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">7</td>
    <td valign="middle">isRange('a01',[1,2,3,'7-10']);</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//isRange('answer_q501',[1,2,3,'7-10']);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">8</td>
    <td valign="middle">isFixed(id,value)</td>
    <td></td>
    <td>//answer_q501//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>isFixed('answer_q501','This is good');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">9</td>
    <td valign="middle">doHide(start_id,end_id)</td>
    <td>includes start and end ids</td>
    <td>//answer_q502//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle">doHide(start_id,'')</td>
    <td>includes start and blank id</td>
    <td>var a=getVal('answer_q502');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td><strong>[Preproc Only]</strong></td>
    <td>if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>doHide('answer_q503','answer_q505');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">10</td>
    <td valign="middle">doShow(start_id,end_id)</td>
    <td>includes start and end ids</td>
    <td>//answer_q502//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle">doShow(start_id,'')</td>
    <td>includes start and blank id</td>
    <td>var a=getVal('answer_q502');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td><strong>[Preproc Only]</strong></td>
    <td>if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>doShow('answer_q503','answer_q505');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">11</td>
    <td valign="middle">msg(value)</td>
    <td></td>
    <td>msg('txt to alert message');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">12</td>
    <td valign="middle">doJumpForward(start_id,end_id)</td>
    <td>jump start to end id and hide between</td>
    <td>//answer_q502//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var a=getVal('answer_q502');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>doJumpForward('answer_q502','answer_q505');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">13</td>
    <td valign="middle">openBox(id,ids_array,'Message')</td>
    <td></td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;];</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>openBox('answer_pbd3_00',res_arr,'Please Select From Above List');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">14</td>
    <td valign="middle">dateDiff(start_date,end_date,key)</td>
    <td>datekey=DAYS,MONTHS,YEARS,HOURS,MINUTES</td>
    <td>//answer_q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1_dd=getVal('answer_dd_q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1_mm=getVal('answer_mm_q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1_yyyy=getVal('answer_yyyy_q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1_h=getVal('answer_h_q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1_m=getVal('answer_m_q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2_dd=getVal('answer_dd_q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2_mm=getVal('answer_mm_q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2_yyyy=getVal('answer_yyyy_q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2_h=getVal('answer_h_q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2_m=getVal('answer_m_q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d1=d1_dd+'/'+d1_mm+'/'+d1_yyyy+' '+d1_h+':'+d1_m;</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var d2=d2_dd+'/'+d2_mm+'/'+d2_yyyy+' '+d2_h+':'+d2_m;</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var dd=dateDiff(d1,d2,'HOURS');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('answer_q6',dd);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">15</td>
    <td valign="middle">today(key)</td>
    <td>key=DD/MM/YYYY</td>
    <td>//answer_id01//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//msg(today('DD/MM/YYYY'));</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">16</td>
    <td valign="middle">now(key)</td>
    <td>key=HH:mm</td>
    <td>//answer_id01//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//msg(now('HH:mm'));</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">17</td>
    <td valign="middle">gps(key,id)</td>
    <td>key=ADDRESS,LATITUDE,LONGITUDE </td>
    <td>//answer_id01//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//gps('ADDRESS','answer_id01');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">18</td>
    <td valign="middle">doColumnHide(id,Nos)</td>
    <td>Nos=0 for rest of all, -1 for self</td>
    <td>//answer_q02_04//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var a=getVal('answer_q02_04');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//if(a==1){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doColumnHide('answer_q02_04',6);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">19</td>
    <td valign="middle">doColumnShow(id,Nos)</td>
    <td>Nos=0 for rest of all, -1 for self</td>
    <td>//answer_q02_04//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var a=getVal('answer_q02_04');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doColumnShow('answer_q02_04',6);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">20</td>
    <td valign="middle">random(ids_array)</td>
    <td>&nbsp;</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;];</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var r=random(res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//setVal('answer_pbd3_00',r);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">21</td>
    <td valign="middle"> getStates(id)</td>
    <td></td>
    <td>//answer_q01//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//getStates('answer_q01');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">22</td>
    <td valign="middle">getDistricts(id,state_id)</td>
    <td></td>
    <td>//answer_q01//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//getDistricts('answer_q02','answer_q01');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">23</td>
    <td valign="middle">skip(start_id,end_id)</td>
    <td>jump start to end id and hide between</td>
    <td>//answer_q502//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td><strong>[Postproc Only]</strong></td>
    <td>var a=getVal('answer_q502');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>skip('answer_q502','answer_q505');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">24</td>
    <td valign="middle">endSurvey(start_id)</td>
    <td>to end the survey for finish</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//endSurvey('answer_pbd3_00');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">25</td>
    <td valign="middle">toFocus(id)</td>
    <td>to set direct focus </td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//toFocus('answer_pbd3_00');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">26</td>
    <td valign="middle">doMax(val_arr)</td>
    <td>maximum value in array of ids</td>
    <td>//a02a//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;];</td>
  </tr>  
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var m=doMax(res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//setVal('a02a',m);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">27</td>
    <td valign="middle">doMin(val_arr)</td>
    <td>minimum value in array of ids</td>
    <td>//a02a//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;];</td>
  </tr>    
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var m=doMin(res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//setVal('a02a',m);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">28</td>
    <td valign="middle">doBlock(id)</td>
    <td>block field with id</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doBlock('answer_pbd3_00');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">29</td>
    <td valign="middle">doUnblock(id)</td>
    <td>unblock field with id</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doUnblock('answer_pbd3_00');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">30</td>
    <td valign="middle">doCheck(id,val)</td>
    <td>check field with id,val for checkbox,radio,select</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doCheck('answer_pbd3_00','3');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">31</td>
    <td valign="middle">doUncheck(id)</td>
    <td>uncheck field with id,val for checkbox,radio,select</td>
    <td>//answer_pbd3_00//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doUncheck('answer_pbd3_00');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">32</td>
    <td valign="middle">toCaps(id)</td>
    <td>change to capital letters</td>
    <td>//answer_pbd3_20//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//toCaps('answer_pbd3_20');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">33</td>
    <td valign="middle">doPlus(res_arr)</td>
    <td>add values in array</td>
    <td>//q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;,&quot;5&quot;];</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var p=doPlus(res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('q3',p);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">34</td>
    <td valign="middle">doMinus(val1,val2)</td>
    <td>minus numeric values</td>
    <td>//q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v1=getVal('q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v2=getVal('q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v4 = '2';</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doMinus(v1,v2);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doMinus(v1,'10');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('q3',v3);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">35</td>
    <td valign="middle">doMultiply(val1,val2)</td>
    <td>multiply numeric values</td>
    <td>//q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v1=getVal('q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v2=getVal('q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v4 = '2';</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doMultiply(v1,v2);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doMultiply(v1,'10');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('q3',v3);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">36</td>
    <td valign="middle">doDivide(val1,val2)</td>
    <td>divide numeric values</td>
    <td>//q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v1=getVal('q1');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v2=getVal('q2');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v4 = '2';</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doDivide(v1,v2);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doDivide(v1,'10');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('q3',v3);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">37</td>
    <td valign="middle">doConcat(res_arr)</td>
    <td>concat values</td>
    <td>//q3//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>var res_arr=[&quot;answer_q510&quot;,&quot;answer_q511&quot;,&quot;answer_q512&quot;];</td>
  </tr>   
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>v3=doConcat(res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>setVal('q3',v3);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">38</td>
    <td valign="middle">doRowHide(id,Nos)</td>
    <td>Nos=0 for rest of all, -1 for self</td>
    <td>//answer_q02_04//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var a=getVal('answer_q02_04');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//if(a==1){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doRowHide('answer_q02_04',6);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">39</td>
    <td valign="middle">doRowShow(id,Nos)</td>
    <td>Nos=0 for rest of all, -1 for self</td>
    <td>//answer_q02_04//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var a=getVal('answer_q02_04');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//if(a==2){</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//doRowShow('answer_q02_04',6);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//}</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">40</td>
    <td valign="middle">setQtext(id,res_arr)</td>
    <td></td>
    <td>//answer_q02_04//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var res_arr={&quot;label1&quot;:&quot;value1&quot;, &quot;label2&quot;:&quot;value2&quot;};</td>
    </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//setQtext('answer_q01',res_arr);</td>
    </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">41</td>
    <td valign="middle">getLabel(id)</td>
    <td></td>
    <td>//var a=getLabel('answer_q01');</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//var res_arr = {'label1':'.ENGLISH','label2': '.HINDI','object': a};</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>//setQtext('answer_q01',res_arr);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle">42</td>
    <td valign="middle">isMobile(id,digits,minimumdigit)</td>
    <td>digits- total digit of phone</td>
    <td>//answer_pbd3_10//</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td>minimumdigit - starting digit</td>
    <td>//isMobile('answer_pbd3_10',10,6);</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle"></td>
    <td valign="middle"></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>

    </div>