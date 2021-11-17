<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//desktop version url
define("DESKTOP_URL","http://127.0.0.1:8080/pdtest1/");
//online version url
define("ONLINE_URL","https://www.thesurveypoint.com/");
define("TRIAL_SECONDS",(86400*15));


$codeArr=array();
$codeArr['getVal']="
getVal('{id}');";
$codeArr['setVal']="
setVal('{id}','text');";
$codeArr['isRequired']="
//{id}//
isRequired('{id}');";
$codeArr['isNum']="
isNum('{id}');";
$codeArr['isAlpha']="
isAlpha('{id}');";
$codeArr['isAlphaNum']="
isAlphaNum('{id}');";
$codeArr['isRange']="
isRange('{id}',[1,2,3,'7-10']);";
$codeArr['isFixed']="
isFixed('{id}','text');";
$codeArr['doHide']="
var a=getVal('{id}');
if(a==2){
doHide('{id}','to question');
}
";
$codeArr['doShow']="
var a=getVal('{id}');
if(a==2){
doShow('{id}','to question');
}
";
$codeArr['msg']="
msg('text');";
$codeArr['doJumpForward']="
doJumpForward('{id1}','{id2}');";
$codeArr['openBox']="
var res_arr=['{id1}','{id2}','{id1}'];
openBox('{id}',res_arr,'message');";
$codeArr['dateDiff']="
var d1_dd=getVal('{id2}');
var d1_mm=getVal('{id2}');
var d1_yyyy=getVal('{id2}');
var d1_h=getVal('{id2}');
var d1_m=getVal('{id2}');
var d2_dd=getVal('{id2}');
var d2_mm=getVal('{id2}');
var d2_yyyy=getVal('{id2}');
var d2_h=getVal('{id2}');
var d2_m=getVal('{id2}');
var d1=d1_mm+'/'+d1_dd+'/'+d1_yyyy+' '+d1_h+':'+d1_m;
var d2=d2_mm+'/'+d2_dd+'/'+d2_yyyy+' '+d2_h+':'+d2_m;
dateDiff(d1,d2,'HOURS');";
$codeArr['today']="
today('DD/MM/YYYY');";
$codeArr['now']="
now('HH:mm');";
$codeArr['gps']="
gps('ADDRESS','{id}');";
$codeArr['doColumnHide']="
var a=getVal('{id}');
if(a==2){
doColumnHide('{id}',6);
}
";
$codeArr['doColumnShow']="
var a=getVal('{id}');
if(a==2){
doColumnShow('{id}',6);
}
";
$codeArr['random']="
var res_arr=['{id1}','{id1}','{id1}'];
random(res_arr);";
$codeArr['getStates']="
getStates('{id}');";
$codeArr['getDistricts']="
getDistricts('{id2}','{id}');";
$codeArr['skip']="
var a=getVal('{id}');
if(a==2){
skip('{id}','to question');
}
";
$codeArr['endSurvey']="
endSurvey('{id}');";
$codeArr['toFocus']="
toFocus('{id}');";
$codeArr['doMax']="
var m=doMax(['{id2}','{id2}','{id2}']);
setVal('{id}',m);";
$codeArr['doMin']="
var m=doMin(['{id2}','{id2}','{id2}']);
setVal('{id}',m);";
$codeArr['doBlock']="
doBlock('{id}');";
$codeArr['doUnblock']="
doUnblock('{id}');";
$codeArr['doCheck']="
doCheck('{id}','{val}');";
$codeArr['doUncheck']="
doUncheck('{id}');";
$codeArr['toCaps']="
toCaps('{id}');";
$codeArr['doPlus']="
var res_arr=['{id2}','{id2}','{id2}'];
var p=doPlus(res_arr);
setVal('q3',p);";
$codeArr['doMinus']="
v1=getVal('{id2}');
v2=getVal('{id2}');
v3=doMinus(v1,v2);
setVal('{id}',v3);";
$codeArr['doMultiply']="
v1=getVal('{id2}');
v2=getVal('{id2}');
v3=doMultiply(v1,v2);
setVal('{id}',v3);";
$codeArr['doDivide']="
v1=getVal('{id2}');
v2=getVal('{id2}');
v3=doDivide(v1,v2);
setVal('{id}',v3);";
$codeArr['doConcat']="
v1=getVal('{id2}');
v2=getVal('{id2}');
v3=doConcat(v1,v2);
setVal('{id}',v3);";
$codeArr['doRowHide']="
doRowHide('{id}',6);";
$codeArr['doRowShow']="
doRowShow('{id}',6);";
$codeArr['setQtext']="
var res_arr={'{label1}':'{value1}', '{label2}':'{value2}'};
setQtext('{id}',res_arr);";
$codeArr['getLabel']="
getLabel('{id}');";
$codeArr['isMobile']="
isMobile('{id}',10,6);";

define("codeArr",serialize($codeArr));
define("codeArrAvailable",serialize(array('isRequired','skip','isRange')));

define("COUNTRY",serialize(array("AF/AFG"=>"Afghanistan","AL/ALB"=>"Albania","DZ/DZA"=>"Algeria","AS/ASM"=>"American Samoa","AD/AND"=>"Andorra","AO/AGO"=>"Angola","AI/AIA"=>"Anguilla","AQ/ATA"=>"Antarctica","AG/ATG"=>"Antigua and Barbuda","AR/ARG"=>"Argentina","AM/ARM"=>"Armenia","AW/ABW"=>"Aruba","AU/AUS"=>"Australia","AT/AUT"=>"Austria","AZ/AZE"=>"Azerbaijan","BS/BHS"=>"Bahamas","BH/BHR"=>"Bahrain","BD/BGD"=>"Bangladesh","BB/BRB"=>"Barbados","BY/BLR"=>"Belarus","BE/BEL"=>"Belgium","BZ/BLZ"=>"Belize","BJ/BEN"=>"Benin","BM/BMU"=>"Bermuda","BT/BTN"=>"Bhutan","BO/BOL"=>"Bolivia","BA/BIH"=>"Bosnia and Herzegovina","BW/BWA"=>"Botswana","BR/BRA"=>"Brazil","IO/IOT"=>"British Indian Ocean Territory","VG/VGB"=>"British Virgin Islands","BN/BRN"=>"Brunei","BG/BGR"=>"Bulgaria","BF/BFA"=>"Burkina Faso","BI/BDI"=>"Burundi","KH/KHM"=>"Cambodia","CM/CMR"=>"Cameroon","CA/CAN"=>"Canada","CV/CPV"=>"Cape Verde","KY/CYM"=>"Cayman Islands","CF/CAF"=>"Central African Republic","TD/TCD"=>"Chad","CL/CHL"=>"Chile","CN/CHN"=>"China","CX/CXR"=>"Christmas Island","CC/CCK"=>"Cocos Islands","CO/COL"=>"Colombia","KM/COM"=>"Comoros","CK/COK"=>"Cook Islands","CR/CRI"=>"Costa Rica","HR/HRV"=>"Croatia","CU/CUB"=>"Cuba","CW/CUW"=>"Curacao","CY/CYP"=>"Cyprus","CZ/CZE"=>"Czech Republic","CD/COD"=>"Democratic Republic of the Congo","DK/DNK"=>"Denmark","DJ/DJI"=>"Djibouti","DM/DMA"=>"Dominica","DO/DOM"=>"Dominican Republic","TL/TLS"=>"East Timor","EC/ECU"=>"Ecuador","EG/EGY"=>"Egypt","SV/SLV"=>"El Salvador","GQ/GNQ"=>"Equatorial Guinea","ER/ERI"=>"Eritrea","EE/EST"=>"Estonia","ET/ETH"=>"Ethiopia","FK/FLK"=>"Falkland Islands","FO/FRO"=>"Faroe Islands","FJ/FJI"=>"Fiji","FI/FIN"=>"Finland","FR/FRA"=>"France","PF/PYF"=>"French Polynesia","GA/GAB"=>"Gabon","GM/GMB"=>"Gambia","GE/GEO"=>"Georgia","DE/DEU"=>"Germany","GH/GHA"=>"Ghana","GI/GIB"=>"Gibraltar","GR/GRC"=>"Greece","GL/GRL"=>"Greenland","GD/GRD"=>"Grenada","GU/GUM"=>"Guam","GT/GTM"=>"Guatemala","GG/GGY"=>"Guernsey","GN/GIN"=>"Guinea","GW/GNB"=>"Guinea-Bissau","GY/GUY"=>"Guyana","HT/HTI"=>"Haiti","HN/HND"=>"Honduras","HK/HKG"=>"Hong Kong","HU/HUN"=>"Hungary","IS/ISL"=>"Iceland","IN/IND"=>"India","ID/IDN"=>"Indonesia","IR/IRN"=>"Iran","IQ/IRQ"=>"Iraq","IE/IRL"=>"Ireland","IM/IMN"=>"Isle of Man","IL/ISR"=>"Israel","IT/ITA"=>"Italy","CI/CIV"=>"Ivory Coast","JM/JAM"=>"Jamaica","JP/JPN"=>"Japan","JE/JEY"=>"Jersey","JO/JOR"=>"Jordan","KZ/KAZ"=>"Kazakhstan","KE/KEN"=>"Kenya","KI/KIR"=>"Kiribati","XK/XKX"=>"Kosovo","KW/KWT"=>"Kuwait","KG/KGZ"=>"Kyrgyzstan","LA/LAO"=>"Laos","LV/LVA"=>"Latvia","LB/LBN"=>"Lebanon","LS/LSO"=>"Lesotho","LR/LBR"=>"Liberia","LY/LBY"=>"Libya","LI/LIE"=>"Liechtenstein","LT/LTU"=>"Lithuania","LU/LUX"=>"Luxembourg","MO/MAC"=>"Macau","MK/MKD"=>"Macedonia","MG/MDG"=>"Madagascar","MW/MWI"=>"Malawi","MY/MYS"=>"Malaysia","MV/MDV"=>"Maldives","ML/MLI"=>"Mali","MT/MLT"=>"Malta","MH/MHL"=>"Marshall Islands","MR/MRT"=>"Mauritania","MU/MUS"=>"Mauritius","YT/MYT"=>"Mayotte","MX/MEX"=>"Mexico","FM/FSM"=>"Micronesia","MD/MDA"=>"Moldova","MC/MCO"=>"Monaco","MN/MNG"=>"Mongolia","ME/MNE"=>"Montenegro","MS/MSR"=>"Montserrat","MA/MAR"=>"Morocco","MZ/MOZ"=>"Mozambique","MM/MMR"=>"Myanmar","NA/NAM"=>"Namibia","NR/NRU"=>"Nauru","NP/NPL"=>"Nepal","NL/NLD"=>"Netherlands","AN/ANT"=>"Netherlands Antilles","NC/NCL"=>"New Caledonia","NZ/NZL"=>"New Zealand","NI/NIC"=>"Nicaragua","NE/NER"=>"Niger","NG/NGA"=>"Nigeria","NU/NIU"=>"Niue","KP/PRK"=>"North Korea","MP/MNP"=>"Northern Mariana Islands","NO/NOR"=>"Norway","OM/OMN"=>"Oman","PK/PAK"=>"Pakistan","PW/PLW"=>"Palau","PS/PSE"=>"Palestine","PA/PAN"=>"Panama","PG/PNG"=>"Papua New Guinea","PY/PRY"=>"Paraguay","PE/PER"=>"Peru","PH/PHL"=>"Philippines","PN/PCN"=>"Pitcairn","PL/POL"=>"Poland","PT/PRT"=>"Portugal","PR/PRI"=>"Puerto Rico","QA/QAT"=>"Qatar","CG/COG"=>"Republic of the Congo","RE/REU"=>"Reunion","RO/ROU"=>"Romania","RU/RUS"=>"Russia","RW/RWA"=>"Rwanda","BL/BLM"=>"Saint Barthelemy","SH/SHN"=>"Saint Helena","KN/KNA"=>"Saint Kitts and Nevis","LC/LCA"=>"Saint Lucia","MF/MAF"=>"Saint Martin","PM/SPM"=>"Saint Pierre and Miquelon","VC/VCT"=>"Saint Vincent and the Grenadines","WS/WSM"=>"Samoa","SM/SMR"=>"San Marino","ST/STP"=>"Sao Tome and Principe","SA/SAU"=>"Saudi Arabia","SN/SEN"=>"Senegal","RS/SRB"=>"Serbia","SC/SYC"=>"Seychelles","SL/SLE"=>"Sierra Leone","SG/SGP"=>"Singapore","SX/SXM"=>"Sint Maarten","SK/SVK"=>"Slovakia","SI/SVN"=>"Slovenia","SB/SLB"=>"Solomon Islands","SO/SOM"=>"Somalia","ZA/ZAF"=>"South Africa","KR/KOR"=>"South Korea","SS/SSD"=>"South Sudan","ES/ESP"=>"Spain","LK/LKA"=>"Sri Lanka","SD/SDN"=>"Sudan","SR/SUR"=>"Suriname","SJ/SJM"=>"Svalbard and Jan Mayen","SZ/SWZ"=>"Swaziland","SE/SWE"=>"Sweden","CH/CHE"=>"Switzerland","SY/SYR"=>"Syria","TW/TWN"=>"Taiwan","TJ/TJK"=>"Tajikistan","TZ/TZA"=>"Tanzania","TH/THA"=>"Thailand","TG/TGO"=>"Togo","TK/TKL"=>"Tokelau","TO/TON"=>"Tonga","TT/TTO"=>"Trinidad and Tobago","TN/TUN"=>"Tunisia","TR/TUR"=>"Turkey","TM/TKM"=>"Turkmenistan","TC/TCA"=>"Turks and Caicos Islands","TV/TUV"=>"Tuvalu","VI/VIR"=>"U.S. Virgin Islands","UG/UGA"=>"Uganda","UA/UKR"=>"Ukraine","AE/ARE"=>"United Arab Emirates","GB/GBR"=>"United Kingdom","US/USA"=>"United States","UY/URY"=>"Uruguay","UZ/UZB"=>"Uzbekistan","VU/VUT"=>"Vanuatu","VA/VAT"=>"Vatican","VE/VEN"=>"Venezuela","VN/VNM"=>"Vietnam","WF/WLF"=>"Wallis and Futuna","EH/ESH"=>"Western Sahara","YE/YEM"=>"Yemen","ZM/ZMB"=>"Zambia","ZW/ZWE"=>"Zimbabwe")));
define("SECTOR",serialize(array("CS"=>"Customer Satisfaction","DE"=>"Demography","ED"=>"Education","EE"=>"Employee Engagement","EA"=>"Energy Access","EN"=>"Environment","EM"=>"Event Management","GE"=>"Gender","LI"=>"Livelihood","MR"=>"Market Research ","NU"=>"Nutrition","POL"=>"Polls","POV"=>"Poverty","PH"=>"Public health","RD"=>"Rural Development","UD"=>"Urban Development","WA"=>"WASH")));
$codeArr='';
$codeArrAvailable='';
$codeArr=unserialize(codeArr);
$codeArrAvailable=unserialize(codeArrAvailable);
$countryArr=unserialize(COUNTRY);
$sectorArr=unserialize(SECTOR);
