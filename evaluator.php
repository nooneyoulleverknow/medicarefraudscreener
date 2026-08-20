<?php
//an advanced engine would want A0090 not to be an llc
//and an advance engine would make sure an ambulance service didn't have an apartment number
//also the taxonmy code would have to make sure that say a foot doctor isn't doing say cardiovascular work
//an advanced engine would look at the social security death index to make sure no one is stealing an npi number
$y2="";
if (!isset($argv[1])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
if (!isset($argv[2])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
if (!isset($argv[3])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
if (!isset($argv[4])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
if (!isset($argv[5])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
if (!isset($argv[6])) {echo "You need six arguments state/state:state/all B/S year1/year1:year2 code:HCPC_CODE/term/term:term/all zscore clients/revenue/address/phone/first:last/fax/organization [match(a least one match)/matchall(all must match, empties cosidered a match)/!match(breaks if foreign)] [areacode/zipcode/nameorigin/term/term1:term2] [field/field1:field2]";exit();}
$pwd=getcwd();
$uname="";
$state=strtoupper($argv[1]);
$type=strtolower($argv[2]);
$y1=$argv[3];
$code=strtolower($argv[4]);
$std2=strtolower($argv[5]);
$bagglist=array();
$sagglist=array();
$field2=strtolower($argv[6]);
if ($field2==="revenuesperclient" || $field2==="paidperclient" || $field2==="revenuesperpatient" || $field2==="revenues/client" || $field2==="paid/client" || $field2==="revenues/patient" || $field2==="paid/patient") {$field2="paidperpatient";}
if ($field2==="revenuesperclaim" || $field2==="revenues/claim" || $field2==="paid/claim")  {$field2="paidperclaim";}
if ($field2==="claimsperclient" || $field2==="claims/client" || $field2==="claims/patient")  {$field2="claimsperpatient";}
$m="";
$areacodes="";
$zipcodes="";
if (isset($argv[7])) {$m=$argv[7];}
$search="";
$search2="";
if (isset($argv[8])) {$search2=$search=strtolower($argv[8]);
if ($search==="areacode" || $search==="areacodes") {$areacodes=file_get_contents($pwd."/data/areacodes");$search="areacode";}
if ($search==="zip" || $search==="zipcode" || $search==="zipcodes") {$zipcodes=file_get_contents($pwd."/data/zipcodes");$search="zip";}
}
$field="";
if (isset($argv[9])) {$field=strtolower($argv[9]);}

$states= array("AL","AK","AZ","AR","AS","CA","CO","CT","DE","DC","FL","GA","GU","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MH","MP","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","TT","UT","VT","VA","VI","WA","WV","WI","WY","ZZ","UK");
$states3=array();
$in=0;
foreach($states as $i) {
$states3[$i]=$in;
$in++;
}
//print_r($states3);exit;
$path=array();
$path2=array();

//file to inspect

if ($type==="b" || $type==="billing" || $type==="billing") {$type="billing";}
else if ($type==="s" || $type==="service" || $type==="servicing") {$type="servicing";}
else if ($type==="bs" || $type==="all" || $type==="b/s") {$type="all";}
else {echo "type needs to be b, bill, billing s, service, servicing, or all";exit;}


//state control
$s2i=1;
$path[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$state)."."."billing";
$path2[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$state)."."."servicing";
if ($type==="all"){
$path[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$state).".billing";
$path2[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$state).".servicing";}
$states2=$states;
if (strpos($state,":")!==false) {
$states2=explode(":",$state);
$s2i=0;
foreach($states2 as $s2) {

$path[$s2i]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$s2).".billing";
$path2[$s2i]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$s2).".servicing";
$s2i++;
}}

if ($state==="ALL") {
$counter=0;
$s2i=$g=count($states);
for($e=0;$e<$f;$e++) {
$path[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$states[$e]).".billing";
$path2[0]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$states[$e]).".servicing";}
}
echo "number of states:".$s2i."\n";
$s2i2=$s2i;
if ($s2i>1) {$s2i2=$s2i+1;}
//this will tell us the values to search in the cells
$dictionary=str_getcsv(strtolower(file_get_contents($pwd."/data/hcpcsdictionary2"))."\",".strtolower(file_get_contents($pwd."/data/cptdictionary2")));
$namedictionary="";
$namedictionary2=array();
if ($search2==="nameorigin") {$namedictionary=strtolower(file_get_contents($pwd."/data/namedictionary2"));
$tempd=explode("\n",$namedictionary);
foreach($tempd as $tempd2) {
echo $tempd2."\n";
$tempd3=str_getcsv($tempd2);
$namedictionary2[strtolower($tempd3[0])]=$tempd3[1];
}
print_r($namedictionary2);
}
$f=count($dictionary);
$codes=array();
$cindex=0;
$cstart=1;
$code3=array();
if (strpos($code,"code:")!==false) {$cstart=0;$code=substr($code,5);echo "code:".$code."\n";}

for($e=$cstart;$e<$f;$e+=2) {
if (strpos($code,":")!==false){
$codes2=explode(":",$code);
foreach($codes2 as $c2) {
//echo "c2:".$c2."/n";
if (strpos($dictionary[$e],$c2)!==false) {
if ($e%2==0) {$codes[$cindex]=$e;$cindex++;break;}
else {$codes[$cindex]=$e-1;$cindex++;break;}
}}}
else {
if (strpos($dictionary[$e],$code)!==false || $code==="all") {
if ($e%2==0) {$codes[$cindex]=$e;$cindex++;}
else {$codes[$cindex]=$e-1;$cindex++;}
}
else {if ($code===$dictionary[$e]) {$codes[$cindex]=$e;}}
}

}

print_r($codes);
$code2="";
$coindex=0;
foreach($codes as $c2){
if ($coindex!=0) {$code2.=":";}
$code2.=$dictionary[$c2];
$code3[$dictionary[$c2]]=$coindex;
$coindex++;
}
echo "code:".$code."\n";
echo "codes:";
echo ($code2);
echo "dictionary[codes[0]]:".$dictionary[$codes[0]]."\n";
echo "dictionary[codes[0]+1]:".$dictionary[$codes[0]+1]."\n";
echo "remadecode:".$code2."\n";
$years=array();
if ($y1==="all") {$y1="2018:2019:2020:2021:2022:2023:2024:2025:2026";}
if (strpos($y1,":")!==false) {$years=explode(":",$y1);
foreach($years as $y2) {if (!($y2==2018 || $y2==2019 || $y2==2020 || $y2==2021 || $y2==2022 || $y2==2023 || $y2==2024 || $y2==2025 || $y2==2026)) {echo "the year needs to be 2018-2026";exit;}}
}
else {if (!($y1==2018 || $y1==2019 || $y1==2020 || $y1==2021 || $y1==2022 || $y1==2023 || $y1==2024 || $y1==2025 || $y1==2026)) {echo "the year needs to be 2018-2026";exit;} else $years[0]=$y1;}

echo "hello world\n";
print_r($years);

//if we are going to do a one to one mapping, we need to make sure they have the same count.  a single zip or areacode should be fine here
$scount=0;
$ssearch="";
$f1="";
if (isset($argv[7]) && isset($argv[8]) && isset($argv[9])) {
$f1=explode(":",$field);
$ssearch=explode(":",$search);
$scount=count($f1);
if ($scount!=count($ssearch) && !($search2=="nameorigin" || $search2=="zip" || $search2=="areacode")) {echo "the number of search terms do not match the number of fields"; exit;}
}

$undcodes=array();

//create the file handlers to load each state
$aggpbuffer=fopen("php://memory","r+");
$aggsbuffer=fopen("php://memory","r+");
$aggpdatabuffer=fopen("php://memory","r+");
$aggsdatabuffer=fopen("php://memory","r+");
$fname=fopen($pwd."/data/namedictionary","a");if (!$fname) {die("File failed to open. Check the path and permissions.");}
for($e=0;$e<$s2i;$e++) {
$n=time();
echo "path:".$path[$e]."\n";
echo "path2:".$path2[$e]."\n";
$h1[$e]=fopen($path[$e],"r");if (!$h1[$e]) {die("File failed to open. Check the path and permissions.");}
$h2[$e]=fopen($path2[$e],"r");if (!$h2[$e]) {die("File failed to open. Check the path and permissions.");}
echo "states(line1333):".$e."\n";
$statepbuffer[$e]=fopen("php://memory","r+");
$statesbuffer[$e]=fopen("php://memory","r+");
$s2=0;
if (strlen($state)==2)
{$s2=$states3[$state];}
else {$s2=$states3[$states2[$e]];}
if ($search==="zip") {$ssearch=str_getcsv(explode("\n",$zipcodes)[$s2])[1];$scount=count(explode(":",$ssearch));}
if ($search==="areacode") {$ssearch=str_getcsv(explode("\n",$areacodes)[$s2])[1];$scount=count(explode(":",$ssearch));}
$start=0;
$chunksize=8*1024*1025; //8mb
if($type==="billing" || $type==="all") {
$fs1=filesize($path[$e]);
while($start<$fs1) {
fseek($h1[$e],$start);
$data=fread($h1[$e],$chunksize);
$data2=explode("\n",$data);

$h=count($data2)-1;
$line="";
for($i=0;$i<$h;$i++) {
$jump=strlen($data2[$i]);
//echo "data2:".$data2[$i]."\n";
$line=str_getcsv(strtolower($data2[$i]));
//echo "code:".$code2." ".$line[41]."\n";
//if (count($line)<46) {$cl=count($line);for($cl2=0;$cl2<(46-$cl);$cl2++) {$data2[$i]=",".$data2[$i];} $line=str_getcsv(strtolower($data2[$i]));echo count($line)."\n"; }

//much of these attempts to try to correct the table size may be unnecessary.
//it's possible some of the original data might have an errant quote in it that wasn't removed.  if that is the case, medicaidmakebills.php can be modified to remove quotes and replace with, idk, tildes or whatever is safe.
if (count($line)==55) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==54) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==53) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==52) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==51) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}


if (count($line)==50) {if (strlen($line[41])!=5 || strlen($line[42])!=7) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}
if (count($line)==49) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==48) {if (strlen($line[41])>5 || strlen($line[41])==0) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==47) {if (strlen($line[41])>5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
    $stream = fopen('php://memory', 'r+');
    fputcsv($stream, $line);
    rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}


if (count($line)==46) {if (strlen($line[41])>5) {if (substr($line[41],0,5)==="88888") {$line[41]="88888";} }}

if (strpos($code2,$line[41])!==false && strpos($y1,substr($line[42],0,4))!==false) {
//echo "line41:".$line[41]."\n";
//echo "line41:".$data2[$i]."\n";
//exit;
if (isset($argv[7]) && isset($argv[8])) {
$dowrite=false;

if ($search=="/*zip*/") {
//15,23
if (strlen($list[15])==3 || strlen($list[15])==7) {$list[15]="00".$list[15];}
if (strlen($list[15])==4 || strlen($list[15])==8) {$list[15]="0".$list[15];}
if (strlen($list[23])==3 || strlen($list[23])==7 ) {$list[23]="00".$list[23];}
if (strlen($list[23])==4 || strlen($list[23])==8) {$list[23]="0".$list[23];}
if (strlen($list[15])==0) {$list[15]=0;}
if (strlen($list[23])==0) {$list[23]=0;}
$l15=substr($list[15],5);
$l23=substr($list[23],5);
for ($ee=0;$ee<$scount;$ee++) {
$lower=substr($ssearch[$ee],5);
$upper=substr($ssearch[$ee],-5);
if (($lower<=$l15 && $upper>$l15) || ($lower<=$l23 && $upper>$l23)) {
    if ($m==="match") {$dowrite=true;}
    else if ($m==="matchall") {if ( (($lower<=$l15 && $upper>=$l15) || $l15==0) &&  (($lower<=$l23 && $upper>=$l23)  || $l23==0)) {$dowrite=true;}}}
    if ($m==="!match")
    {if (!((($lower<=$l15 && $upper>=$l15) || $l15==0) && (($lower<=$l23 && $upper>=$l23)  || $l23==0))) {$dowrite=true;}
}}
if ($dowrite) {
echo "term:".$ssearch."\n";
echo "writing:".$data2[$i].",".$start;
fwrite($statepbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggpbuffer,$data2[$i].",".$start."\n");}
}
else if ($search==="areacode") {

    if (str_starts_with($list[17],"1-")) {$list[17]=substr($list[17],2);}
    if (str_starts_with($list[18],"1-")) {$list[18]=substr($list[18],2);}
    if (str_starts_with($list[25],"1-")) {$list[25]=substr($list[25],2);}
    if (str_starts_with($list[26],"1-")) {$list[26]=substr($list[26],2);}
    if (str_starts_with($list[34],"1-")) {$list[34]=substr($list[34],2);}
    if (strlen($list[17]==0)) {$list[17]="~~~";}
    if (strlen($list[18]==0)) {$list[18]="~~~";}
    if (strlen($list[25]==0)) {$list[25]="~~~";}
    if (strlen($list[26]==0)) {$list[26]="~~~";}
    if (strlen($list[34]==0)) {$list[34]="~~~";}
    if (strpos($ssearch, substr($list[17],0,3))!==false || strpos($ssearch, substr($list[18],0,3))!==false || strpos($ssearch, substr($list[25],0,3))!==false || strpos($ssearch, substr($list[26],0,3))!==false || strpos($ssearch, substr($list[34],0,3))!==false) {
    if ($m==="match") {$dowrite=true;}
    else if ($m==="matchall") {if ((strpos($ssearch, substr($list[17],0,3))!==false || $list[17]==="~~~") && (strpos($ssearch, substr($list[18],0,3))!==false  || $list[18]==="~~~") && (strpos($ssearch, substr($list[25],0,3))!==false  || $list[25]==="~~~") && (strpos($ssearch, substr($list[26],0,3))!==false  || $list[26]==="~~~") && (strpos($ssearch, substr($list[34],0,3))!==false  || $list[34]==="~~~")) {$dowrite=true;}}}

    if ($m==="!match") {if (!((strpos($ssearch, substr($list[17],0,3))!==false || $list[17]==="~~~") && (strpos($ssearch, substr($list[18],0,3))!==false  || $list[18]==="~~~") && (strpos($ssearch, substr($list[25],0,3))!==false  || $list[25]==="~~~") && (strpos($ssearch, substr($list[26],0,3))!==false  || $list[26]==="~~~") && (strpos($ssearch, substr($list[34],0,3))!==false  || $list[34]==="~~~"))) {$dowrite=true;}}


if ($dowrite) {
echo "term:".$ssearch."\n";
echo "writing:".$data2[$i].",".$start;
fwrite($statepbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggpbuffer,$data2[$i].",".$start."\n");}

}
else if (isset($argv[9])) {
$oldterm="";
$active=0;
$oldsearch=0;
$newsearch=0;
$allgood=true;
$list=$line; //quick error correct
for ($ee=0;$ee<$scount;$ee++) {
$oldterm=$active;
$active=$f1[$ee];
$oldsearch=$newsearch;
$newsearch=$ssearch[$ee];
//title 34
//organization 2,8
// lname 3,9,31
// fname 4,10,32
// state 24
//city 14,23
//ein 1
//npi 0
//address 12 20
//echo "field:".$f1[$ee]."\n";
if ($search2==="nameorigin") {
$allgood=false;
if (!isset($namedictionary2[strtolower($list[4])]) && strlen($list[4])>0) {if (!(strpos($uname,"\n".strtolower($list[4]).",")!==false)) {fwrite($fname,"\n".strtolower($list[4]).",");$uname.="\n".strtolower($list[4]).",";}}
if (!isset($namedictionary2[strtolower($list[10])]) && strlen($list[10])>0) {if (!(strpos($uname,"\n".strtolower($list[10]).",")!==false)) {fwrite($fname,"\n".strtolower($list[10]).",");$uname.="\n".strtolower($list[10]).",";}}
if (!isset($namedictionary2[strtolower($list[32])]) && strlen($list[32])>0) {if (!(strpos($uname,"\n".strtolower($list[32]).",")!==false)) {fwrite($fname,"\n".strtolower($list[32]).",");$uname.="\n".strtolower($list[32]).",";}}

//test against undesired types
//we can exit, and try to correct the codeor edt the name database.
//if(strpos($namedictionary2[strtolower($list[4])],"+n")!==false || strpos($namedictionary2[strtolower($list[10])],"+n")!==false || strpos($namedictionary2[strtolower($list[32])],"+n")!==false) {echo "\ndata2:".$data2[$i];exit;}
//if(strpos($namedictionary2[strtolower($list[4])],"+l")!==false || strpos($namedictionary2[strtolower($list[10])],"+l")!==false || strpos($namedictionary2[strtolower($list[32])],"+l")!==false) {echo "\ndata2:".$data2[$i];exit;}
///if(strpos($namedictionary2[strtolower($list[4])],"##")!==false || strpos($namedictionary2[strtolower($list[10])],"##")!==false || strpos($namedictionary2[strtolower($list[32])],"##")!==false) {echo "\ndata2:".$data2[$i];exit;}
// or we can say the rulebreakers are automatically good as to inspect
if(strpos($namedictionary2[strtolower($list[4])],"+n")!==false || strpos($namedictionary2[strtolower($list[10])],"+n")!==false || strpos($namedictionary2[strtolower($list[32])],"+n")!==false) {$allgood=true;}
if(strpos($namedictionary2[strtolower($list[4])],"+l")!==false || strpos($namedictionary2[strtolower($list[10])],"+l")!==false || strpos($namedictionary2[strtolower($list[32])],"+l")!==false) {$allgood=true;}
if(strpos($namedictionary2[strtolower($list[4])],"##")!==false || strpos($namedictionary2[strtolower($list[10])],"##")!==false || strpos($namedictionary2[strtolower($list[32])],"##")!==false) {$allgood=true;}

if(strpos($argv[9],":")!==false) {
$argv9=explode(":",$argv[9]);
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[32])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[32])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[32])],$a9)!==false)) {} else {$allgood=true;}}
}
//echo "\nuname:".$uname;
echo "\nlist4:".$list[4];
echo "\nlist10:".$list[10];
echo "\nlist32:".$list[32];
echo "\nlocation:".$argv[9];
echo "\naallgood:".$allgood;
if (!isset($namedictionary2[strtolower($list[32])])) {echo "\ndata2:".$data2[$i];}
echo "\nregion:".$namedictionary2[strtolower($list[32])];
if (strpos($namedictionary2[strtolower($list[32])],"+1")!==false) {
echo "\nlist31:".$list[31];
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[31])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[31])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[31])],$a9)!==false)) {} else {$allgood=true;}}
}
echo "\nlist33:".$list[33];
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[33])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[33])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[33])],$a9)!==false)) {} else {$allgood=true;}}
}
echo "\ndata2:".$data2[$i];
}
//if (!$allgood) {exit(0);}
}
else {

if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false) {$allgood=true;} else {$allgood=false;break;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false && strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false && strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false) {$allgood=true;} else {$allgood=false;break;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false)) {$allgood=false;break;} {$allgood=true;}}
}
//echo "\nuname:".$uname;
echo "\nlist4:".$list[4];
echo "\nlist10:".$list[10];
echo "\nlist32:".$list[32];
echo "\nlocation:".$argv[9];
echo "\naallgood:".$allgood;
echo "\nregion:".$namedictionary2[strtolower($list[32])];

//if (!$allgood) {exit(0);}
if(strpos($namedictionary2[strtolower($list[4])],"##")!==false) {print_r($list);echo "\n##";exit(0);}
}
else if ($f1[$ee]==="title") {
    if ($m==="match" || $m==="matchall") {
        if(strpos($list[34],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {if(strpos($list[34],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="organization") {
    if ($m==="match") {if(strpos($list[2],$ssearch[$ee])!==false || strpos($list[8],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[2],$ssearch[$ee])!==false && strpos($list[8],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {
        if(strpos($list[2],$ssearch[$ee])!==false || strpos($list[8],$ssearch[$ee])!==false) {$allgood=false;break;}
    }}
else if ($f1[$ee]==="lname") {
if ($oldsearch==="fname") {
    if ($m==="match") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false)) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
    if ($m==="matchall") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) && (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) && ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        else if ($m==="!match") {if(!( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) )) {$allgood=false;} else {}}
    }
else {
    if ($m==="match") {if(strpos($list[3],$ssearch[$ee])!==false || strpos($list[9],$ssearch[$ee])!==false  || strpos($list[31],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="matchall") {if(strpos($list[3],$ssearch[$ee])!==false && strpos($list[9],$ssearch[$ee])!==false  && strpos($list[31],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="!match") {if(!(strpos($list[3],$ssearch[$ee])!==false || strpos($list[9],$ssearch[$ee])!==false  || strpos($list[31],$ssearch[$ee])!==false)) {$allgood=false;} }}
}
else if ($f1[$ee]==="fname") {
    if ($oldsearch==="lname") {
        if ($m==="match") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        if ($m==="matchall") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) && (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) && ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        else if ($m==="!match") {if(!( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) )) {$allgood=false;} else {}}
}
else {
    if ($m==="match") {if(strpos($list[4],$ssearch[$ee])!==false || strpos($list[10],$ssearch[$ee])!==false  || strpos($list[32],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="matchall") {if(strpos($list[4],$ssearch[$ee])!==false && strpos($list[10],$ssearch[$ee])!==false  && strpos($list[32],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="!match") {if(!(strpos($list[4],$ssearch[$ee])!==false || strpos($list[10],$ssearch[$ee])!==false  || strpos($list[32],$ssearch[$ee])!==false)) {$allgood=false;}}}
}
else if ($f1[$ee]==="state") {
    if ($m==="match" || $m==="matchall") {
        if(strpos($list[24],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
        else if ($m==="!match") {if(strpos($list[24],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="city") {
    if ($m==="match") {if(strpos($list[14],$ssearch[$ee])!==false || strpos($list[23],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[14],$ssearch[$ee])!==false && strpos($list[23],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {if(!(strpos($list[14],$ssearch[$ee])!==false || strpos($list[23],$ssearch[$ee])!==false)) {$allgood=false;break;}}}

else if ($f1[$ee]==="ein") {if ($m==="match" || $m==="matchall") {if(strpos($list[1],$ssearch[$ee])!==false) {} else {$allgood=false;break;}} else if ($m==="!match") {if(strpos($list[1],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="npi") {if ($m==="match" || $m==="matchall") {if(strpos($list[0],$ssearch[$ee])!==false) {} else {$allgood=false;break;}} else if ($m==="!match") {if(strpos($list[0],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="address") {
    if ($m==="match") {if(strpos($list[12],$ssearch[$ee])!==false || strpos($list[20],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[12],$ssearch[$ee])!==false && strpos($list[20],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {
        if(!(strpos($list[12],$ssearch[$ee])!==false || strpos($list[20],$ssearch[$ee])!==false)) {$allgood=false;break;}
    }}

}//endfor

$dowrite=$allgood;

if ($dowrite) {
echo "match:".$m."\n";
echo "scount:".$scount."\n";
echo "index:".$ee."\n";
echo "field:".$field."\n";
echo "search:".$search."\n";
echo "writing:".$data2[$i].",".$start;
echo "\npaid:".$line[45]."\n";
fwrite($statepbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggpbuffer,$data2[$i].",".$start."\n");}
}//endisset9
}//end isset(7&8)
else if (isset($argv[7]) && $m==="company") {
$list=$line;//quick error fix
$sy=substr($list[42],0,4);
if (strlen($list[2]>0)) {
if (isset($bagglist[$list[2]."-".$list[41]."-".$sy])) {$bagglist[$list[2]."-".$list[41]."-".$sy][43]+=$list[43];    $bagglist[$list[2]."-".$list[41]."-".$sy][44]+=$list[44];    $bagglist[$list[2]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$bagglist[$list[2]."-".$list[41]."-".$sy]=$list;$bagglist[$list[2]."-".$list[41]."-".$sy][46]=$start;$bagglist[$list[2]."-".$list[41]."-".$sy][42]=$sy;}}
if (strlen($list[8]>0)) {
if (strlen($list[2]>0)) {
//if (isset($bagglist[$list[8]."-".$list[41]."-".$sy."-dup"])) {
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][43]+=$list[43];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][44]+=$list[44];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][45]+=$list[45];}
//else {$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"]=$list;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][42]=$sy;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}
}

else {
if (isset($bagglist[$list[8]."-".$list[41]."-".$sy])) {$bagglist[$list[8]."-".$list[41]."-".$sy][43]+=$list[43];$bagglist[$list[8]."-".$list[41]."-".$sy][44]+=$list[44];$bagglist[$list[8]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$bagglist[$list[8]."-".$list[41]."-".$sy]=$list;$bagglist[$list[8]."-".$list[41]."-".$sy][42]=$sy;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}}

}

}

else if (isset($argv[7]) && $m==="address") {
$list=$line;//quick error fix
$sy=substr($list[42],0,4);
if (strlen($list[12]>0)) {
if (isset($bagglist[$list[12]."-".$list[41]."-".$sy])) {$bagglist[$list[12]."-".$list[41]."-".$sy][43]+=$list[43];    $bagglist[$list[12]."-".$list[41]."-".$sy][44]+=$list[44];    $bagglist[$list[12]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$bagglist[$list[12]."-".$list[41]."-".$sy]=$list;$bagglist[$list[12]."-".$list[41]."-".$sy][46]=$start;$bagglist[$list[12]."-".$list[41]."-".$sy][42]=$sy;}}
if (strlen($list[20]>0)) {
if (strlen($list[12]>0)) {
//if (isset($bagglist[$list[8]."-".$list[41]."-".$sy."-dup"])) {
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][43]+=$list[43];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][44]+=$list[44];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][45]+=$list[45];}
//else {$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"]=$list;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][42]=$sy;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}
}

else {
if (isset($bagglist[$list[20]."-".$list[41]."-".$sy])) {$bagglist[$list[20]."-".$list[41]."-".$sy][43]+=$list[43];$bagglist[$list[20]."-".$list[41]."-".$sy][44]+=$list[44];$bagglist[$list[20]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$bagglist[$list[20]."-".$list[41]."-".$sy]=$list;$bagglist[$list[20]."-".$list[41]."-".$sy][42]=$sy;$bagglist[$list[20]."-".$list[41]."-".$sy."-dup"][46]=$start;}}

}

}

else {
//echo "writing:".$data2[$i].",".$start."\n";
//echo "paid:".$line[45]."\n";
fwrite($statepbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggpbuffer,$data2[$i].",".$start."\n");
}
}//end if hcode and year match
else {if ($i>0)
    {//echo "strpos".(strpos($code2,$line[41]))."\n";
     //echo "year:".strpos($y1,substr($line[42],0,4))."\n";
echo "y".$y1."\n";

echo "l41".$line[41]."\n";
echo "l42".$line[42]."\n";
//echo "count(line)".count($line)."\n";
echo "start".$start."\n";
        echo $data2[$i];$undcode[$line[41]]="\"0\"";
//        exit;
    }

}
$start+=$jump+1;
}//endfor each line in read

echo "\nstart:".$start."\n";

echo 100*($start/$fs1)."% : ";
echo (time()-$n);
echo "(s) : ";
echo (time()-$n)/(($start/$fs1))."(s) estimate : ";
echo $start."\n";

}//end while
if (isset($argv[7]) && ($m==="company" || $m==="address")) {

foreach($bagglist as $sl) {
$tmp="";
//echo "sl:";print_r($sl);
foreach($sl as $sl2) {
//echo "sl2:".$sl2;
$tmp.="\"".$sl2."\",";}
$tmp=substr_replace($tmp, "\n", -1);
echo "tmp:".$tmp;
fwrite($statepbuffer[$e],$tmp);
fwrite($aggpbuffer,$tmp);

}
$bagglist="";
}

}//end if billing
echo "type".$type."\n";


if($type==="servicing" || $type==="all") {
$start=0;
$fs1=filesize($path2[$e]);
while($start<$fs1) {
fseek($h2[$e],$start);
$data=fread($h2[$e],$chunksize);
$data2=explode("\n",$data);
$h=count($data2)-1;
$line="";
for($i=0;$i<$h;$i++) {
$jump=strlen($data2[$i]);
$line=str_getcsv(strtolower($data2[$i]));

//echo "count(line):".count($line)."\n";
if (count($line)==55) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==54) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==53) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==52) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==51) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}


if (count($line)==50) {if (strlen($line[41])!=5 || strlen($line[42])!=7) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}
if (count($line)==49) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}

if (count($line)==48) {if (strlen($line[41])>5 || strlen($line[41])==0) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}


if (count($line)==47) {if (strlen($line[41])>5) {

for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
$line=array_values($line);
$stream = fopen('php://memory', 'r+');
fputcsv($stream, $line);
rewind($stream);$data2[$i]=stream_get_contents($stream);fclose($stream);break;}}
}}


if (count($line)==46) {if (strlen($line[41])>5) {if (substr($line[41],0,5)==="88888") {$line[41]="88888";} }}

if (strpos($code2,$line[41])!==false && strpos($y1,substr($line[42],0,4))!==false && strlen($line[41])>0) {

if (isset($argv[7]) && isset($argv[8])) {
$dowrite=false;

if ($search=="zip") {
//15,23
if (strlen($list[15])==3 || strlen($list[15])==7) {$list[15]="00".$list[15];}
if (strlen($list[15])==4 || strlen($list[15])==8) {$list[15]="0".$list[15];}
if (strlen($list[23])==3 || strlen($list[23])==7 ) {$list[23]="00".$list[23];}
if (strlen($list[23])==4 || strlen($list[23])==8) {$list[23]="0".$list[23];}
if (strlen($list[15])==0) {$list[15]=0;}
if (strlen($list[23])==0) {$list[23]=0;}
$l15=substr($list[15],5);
$l23=substr($list[23],5);
for ($ee=0;$ee<$scount;$ee++) {
echo "\nssearch".$ssearch[$ee];
$lower=substr($ssearch[$ee],5);
$upper=substr($ssearch[$ee],-5);
if (($lower<=$l15 && $upper>$l15) || ($lower<=$l23 && $upper>$l23)) {
if ($m==="match") {$dowrite=true;}
else if ($m==="matchall") {if ( (($lower<=$l15 && $upper>=$l15) || $l15==0) &&  (($lower<=$l23 && $upper>=$l23)  || $l23==0)) {$dowrite=true;}}}
if ($m==="!match")
{if (!((($lower<=$l15 && $upper>=$l15) || $l15==0) && (($lower<=$l23 && $upper>=$l23)  || $l23==0))) {$dowrite=true;}
}}
exit;
if ($dowrite) {
echo "term:".$ssearch."\n";
echo "writing:".$data2[$i].",".$start;
fwrite($statesbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggsbuffer,$data2[$i].",".$start."\n");}
}
else if ($search==="areacode") {

if (str_starts_with($list[17],"1-")) {$list[17]=substr($list[17],2);}
if (str_starts_with($list[18],"1-")) {$list[18]=substr($list[18],2);}
if (str_starts_with($list[25],"1-")) {$list[25]=substr($list[25],2);}
if (str_starts_with($list[26],"1-")) {$list[26]=substr($list[26],2);}
if (str_starts_with($list[34],"1-")) {$list[34]=substr($list[34],2);}
if (strlen($list[17])==0) {$list[17]="~~~";}
if (strlen($list[18])==0) {$list[18]="~~~";}
if (strlen($list[25])==0) {$list[25]="~~~";}
if (strlen($list[26])==0) {$list[26]="~~~";}
if (strlen($list[34])==0) {$list[34]="~~~";}
if (strpos($ssearch, substr($list[17],0,3))!==false || strpos($ssearch, substr($list[18],0,3))!==false || strpos($ssearch, substr($list[25],0,3))!==false || strpos($ssearch, substr($list[26],0,3))!==false || strpos($ssearch, substr($list[34],0,3))!==false) {
if ($m==="match") {$dowrite=true;}
else if ($m==="matchall") {if ((strpos($ssearch, substr($list[17],0,3))!==false || $list[17]==="~~~") && (strpos($ssearch, substr($list[18],0,3))!==false  || $list[18]==="~~~") && (strpos($ssearch, substr($list[25],0,3))!==false  || $list[25]==="~~~") && (strpos($ssearch, substr($list[26],0,3))!==false  || $list[26]==="~~~") && (strpos($ssearch, substr($list[34],0,3))!==false  || $list[34]==="~~~")) {$dowrite=true;}}}

if ($m==="!match") {if (!((strpos($ssearch, substr($list[17],0,3))!==false || $list[17]==="~~~") && (strpos($ssearch, substr($list[18],0,3))!==false  || $list[18]==="~~~") && (strpos($ssearch, substr($list[25],0,3))!==false  || $list[25]==="~~~") && (strpos($ssearch, substr($list[26],0,3))!==false  || $list[26]==="~~~") && (strpos($ssearch, substr($list[34],0,3))!==false  || $list[34]==="~~~"))) {$dowrite=true;}}


if ($dowrite) {
echo "term:".$ssearch."\n";
echo "writing:".$data2[$i].",".$start;
fwrite($statesbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggsbuffer,$data2[$i].",".$start."\n");}

}
else if (isset($argv[9])) {
$oldterm="";
$active=0;
$oldsearch=0;
$newsearch=0;
$allgood=true;
$list=$line; //quick error check
for ($ee=0;$ee<$scount;$ee++) {
$oldterm=$active;
$active=$f1[$ee];
$oldsearch=$newsearch;
$newsearch=$ssearch[$ee];
//title 34
//organization 2,8
// lname 3,9,31
// fname 4,10,32
// state 24
//city 14,23
//ein 1
//npi 0
//address 12 20
//echo "field:".$f1[$ee]."\n";
if ($search2==="nameorigin") {
$allgood=false;
if (!isset($namedictionary2[strtolower($list[4])]) && strlen($list[4])>0) {if (!(strpos($uname,"\n".strtolower($list[4]).",")!==false)) {fwrite($fname,"\n".strtolower($list[4]).",");$uname.="\n".strtolower($list[4]).",";}}
if (!isset($namedictionary2[strtolower($list[10])]) && strlen($list[10])>0) {if (!(strpos($uname,"\n".strtolower($list[10]).",")!==false)) {fwrite($fname,"\n".strtolower($list[10]).",");$uname.="\n".strtolower($list[10]).",";}}
if (!isset($namedictionary2[strtolower($list[32])]) && strlen($list[32])>0) {if (!(strpos($uname,"\n".strtolower($list[32]).",")!==false)) {fwrite($fname,"\n".strtolower($list[32]).",");$uname.="\n".strtolower($list[32]).",";}}

//test against undesired types
//we can exit, and try to correct the codeor edt the name database.
//if(strpos($namedictionary2[strtolower($list[4])],"+n")!==false || strpos($namedictionary2[strtolower($list[10])],"+n")!==false || strpos($namedictionary2[strtolower($list[32])],"+n")!==false) {echo "\ndata2:".$data2[$i];exit;}
//if(strpos($namedictionary2[strtolower($list[4])],"+l")!==false || strpos($namedictionary2[strtolower($list[10])],"+l")!==false || strpos($namedictionary2[strtolower($list[32])],"+l")!==false) {echo "\ndata2:".$data2[$i];exit;}
///if(strpos($namedictionary2[strtolower($list[4])],"##")!==false || strpos($namedictionary2[strtolower($list[10])],"##")!==false || strpos($namedictionary2[strtolower($list[32])],"##")!==false) {echo "\ndata2:".$data2[$i];exit;}
// or we can say the rulebreakers are automatically good as to inspect
if(strpos($namedictionary2[strtolower($list[4])],"+n")!==false || strpos($namedictionary2[strtolower($list[10])],"+n")!==false || strpos($namedictionary2[strtolower($list[32])],"+n")!==false) {$allgood=true;}
if(strpos($namedictionary2[strtolower($list[4])],"+l")!==false || strpos($namedictionary2[strtolower($list[10])],"+l")!==false || strpos($namedictionary2[strtolower($list[32])],"+l")!==false) {$allgood=true;}
if(strpos($namedictionary2[strtolower($list[4])],"##")!==false || strpos($namedictionary2[strtolower($list[10])],"##")!==false || strpos($namedictionary2[strtolower($list[32])],"##")!==false) {$allgood=true;}

if(strpos($argv[9],":")!==false) {
$argv9=explode(":",$argv[9]);
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[32])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[32])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[32])],$a9)!==false)) {} else {$allgood=true;}}
}
//echo "\nuname:".$uname;
echo "\nlist4:".$list[4];
echo "\nlist10:".$list[10];
echo "\nlist32:".$list[32];
echo "\nlocation:".$argv[9];
echo "\naallgood:".$allgood;
if (!isset($namedictionary2[strtolower($list[32])])) {echo "\ndata2:".$data2[$i];}
echo "\nregion:".$namedictionary2[strtolower($list[32])];
if (strpos($namedictionary2[strtolower($list[32])],"+1")!==false) {
echo "\nlist31:".$list[31];
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[31])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[31])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[31])],$a9)!==false)) {} else {$allgood=true;}}
}
echo "\nlist33:".$list[33];
foreach($argv9 as $a9) {
//not designed to work where contacts may be mixed
if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[33])],$a9)!==false) {$allgood=true;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$a9)!==false && strpos($namedictionary2[strtolower($list[10])],$a9)!==false && strpos($namedictionary2[strtolower($list[33])],$a9)!==false) {$allgood=true;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$a9)!==false || strpos($namedictionary2[strtolower($list[10])],$a9)!==false || strpos($namedictionary2[strtolower($list[33])],$a9)!==false)) {} else {$allgood=true;}}
}
echo "\ndata2:".$data2[$i];
}
//if (!$allgood) {exit(0);}
}
else {

if ($m==="match") {if(strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false) {$allgood=true;} else {$allgood=false;break;}}
else if ($m==="matchall") {if(strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false && strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false && strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false) {$allgood=true;} else {$allgood=false;break;}}
if ($m==="!match") {if((strpos($namedictionary2[strtolower($list[4])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[10])],$argv[9])!==false || strpos($namedictionary2[strtolower($list[32])],$argv[9])!==false)) {$allgood=false;break;} {$allgood=true;}}
}
//echo "\nuname:".$uname;
echo "\nlist4:".$list[4];
echo "\nlist10:".$list[10];
echo "\nlist32:".$list[32];
echo "\nlocation:".$argv[9];
echo "\naallgood:".$allgood;
echo "\nregion:".$namedictionary2[strtolower($list[32])];

//if (!$allgood) {exit(0);}
if(strpos($namedictionary2[strtolower($list[4])],"##")!==false) {print_r($list);echo "\n##";exit(0);}
}
else if ($f1[$ee]==="title") {
    if ($m==="match" || $m==="matchall") {
        if(strpos($list[34],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {if(strpos($list[34],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="organization") {
    if ($m==="match") {if(strpos($list[2],$ssearch[$ee])!==false || strpos($list[8],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[2],$ssearch[$ee])!==false && strpos($list[8],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {
        if(!(strpos($list[2],$ssearch[$ee])!==false || strpos($list[8],$ssearch[$ee])!==false)) {$allgood=false;break;}
    }}
else if ($f1[$ee]==="lname") {
if ($oldsearch==="fname") {
    if ($m==="match") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false)) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
    if ($m==="matchall") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) && (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) && ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        else if ($m==="!match") {if(!( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) )) {$allgood=false;} else {}}
    }
else {
    if ($m==="match") {if(strpos($list[3],$ssearch[$ee])!==false || strpos($list[9],$ssearch[$ee])!==false  || strpos($list[31],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="matchall") {if(strpos($list[3],$ssearch[$ee])!==false && strpos($list[9],$ssearch[$ee])!==false  && strpos($list[31],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="!match") {if(!(strpos($list[3],$ssearch[$ee])!==false || strpos($list[9],$ssearch[$ee])!==false  || strpos($list[31],$ssearch[$ee])!==false)) {$allgood=false;} }}
}
else if ($f1[$ee]==="fname") {
    if ($oldsearch==="lname") {
        if ($m==="match") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        if ($m==="matchall") {if( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) && (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) && ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) ) {} else {$allgood=false;}}
        else if ($m==="!match") {if(!( ( (strpos($list[3],$newsearch)!==false && strpos($list[4],$oldsearch)!==false) || (strpos($list[3],$oldsearch)!==false && strpos($list[4],$newsearch)!==false) ) || ( (strpos($list[9],$newsearch)!==false && strpos($list[10],$oldsearch)!==false) || (strpos($list[9],$oldsearch)!==false && strpos($list[10],$newsearch)!==false) )  ||  ( (strpos($list[31],$newsearch)!==false && strpos($list[32],$oldsearch)!==false) || (strpos($list[31],$oldsearch)!==false && strpos($list[32],$newsearch)!==false) ) )) {$allgood=false;} else {}}
}
else {
    if ($m==="match") {if(strpos($list[4],$ssearch[$ee])!==false || strpos($list[10],$ssearch[$ee])!==false  || strpos($list[32],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="matchall") {if(strpos($list[4],$ssearch[$ee])!==false && strpos($list[10],$ssearch[$ee])!==false  && strpos($list[32],$ssearch[$ee])!==false) {} else {$allgood=false;}}
    else if ($m==="!match") {if(!(strpos($list[4],$ssearch[$ee])!==false || strpos($list[10],$ssearch[$ee])!==false  || strpos($list[32],$ssearch[$ee])!==false)) {$allgood=false;}}}
}
else if ($f1[$ee]==="state") {
    if ($m==="match" || $m==="matchall") {
        if(strpos($list[24],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
        else if ($m==="!match") {if(strpos($list[24],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="city") {
    if ($m==="match") {if(strpos($list[14],$ssearch[$ee])!==false || strpos($list[23],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[14],$ssearch[$ee])!==false && strpos($list[23],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {if(!(strpos($list[14],$ssearch[$ee])!==false || strpos($list[23],$ssearch[$ee])!==false)) {$allgood=false;break;}}}

else if ($f1[$ee]==="ein") {if ($m==="match" || $m==="matchall") {if(strpos($list[1],$ssearch[$ee])!==false) {} else {$allgood=false;break;}} else if ($m==="!match") {if(strpos($list[1],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="npi") {if ($m==="match" || $m==="matchall") {if(strpos($list[0],$ssearch[$ee])!==false) {} else {$allgood=false;break;}} else if ($m==="!match") {if(strpos($list[0],$ssearch[$ee])!==false) {$allgood=false;break;} else {$allgood=true;}}}
else if ($f1[$ee]==="address") {
    if ($m==="match") {if(strpos($list[12],$ssearch[$ee])!==false || strpos($list[20],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="matchall") {if(strpos($list[12],$ssearch[$ee])!==false && strpos($list[20],$ssearch[$ee])!==false) {} else {$allgood=false;break;}}
    else if ($m==="!match") {
        if(!(strpos($list[12],$ssearch[$ee])!==false || strpos($list[20],$ssearch[$ee])!==false)) {$allgood=false;break;}
    }}

}//endfor

$dowrite=$allgood;

if ($dowrite) {
echo "match:".$m."\n";
echo "scount:".$scount."\n";
echo "index:".$ee."\n";
echo "field:".$field."\n";
echo "search:".$search."\n";
echo "writing:".$data2[$i].",".$start;
echo "\npaid:".$line[45]."\n";
fwrite($statesbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggsbuffer,$data2[$i].",".$start."\n");}
}//end isset(9)
}//end isset(7&8)
else if (isset($argv[7]) && $m==="company") {
$list=$line;//quick error fix
$sy=substr($list[42],0,4);
if (strlen($list[2]>0)) {
if (isset($sagglist[$list[2]."-".$list[41]."-".$sy])) {$sagglist[$list[2]."-".$list[41]."-".$sy][43]+=$list[43];    $sagglist[$list[2]."-".$list[41]."-".$sy][44]+=$list[44];    $sagglist[$list[2]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$sagglist[$list[2]."-".$list[41]."-".$sy]=$list;$sagglist[$list[2]."-".$list[41]."-".$sy][46]=$start;$sagglist[$list[2]."-".$list[41]."-".$sy][42]=$sy;}}
if (strlen($list[8]>0)) {
if (strlen($list[2]>0)) {
//if (isset($sagglist[$list[8]."-".$list[41]."-".$sy."-dup"])) {
//    $sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][43]+=$list[43];
//    $sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][44]+=$list[44];
//    $sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][45]+=$list[45];}
//else {$sagglist[$list[8]."-".$list[41]."-".$sy."-dup"]=$list;$sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][42]=$sy;$sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}
}

else {
if (isset($sagglist[$list[8]."-".$list[41]."-".$sy])) {$sagglist[$list[8]."-".$list[41]."-".$sy][43]+=$list[43];$sagglist[$list[8]."-".$list[41]."-".$sy][44]+=$list[44];$sagglist[$list[8]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$sagglist[$list[8]."-".$list[41]."-".$sy]=$list;$sagglist[$list[8]."-".$list[41]."-".$sy][42]=$sy;$sagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}}

}

}
else if (isset($argv[7]) && $m==="address") {
$list=$line;//quick error fix
$sy=substr($list[42],0,4);
if (strlen($list[12]>0)) {
if (isset($sagglist[$list[12]."-".$list[41]."-".$sy])) {$sagglist[$list[12]."-".$list[41]."-".$sy][43]+=$list[43];    $sagglist[$list[12]."-".$list[41]."-".$sy][44]+=$list[44];    $sagglist[$list[12]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$sagglist[$list[12]."-".$list[41]."-".$sy]=$list;$sagglist[$list[12]."-".$list[41]."-".$sy][46]=$start;$sagglist[$list[12]."-".$list[41]."-".$sy][42]=$sy;}}
if (strlen($list[20]>0)) {
if (strlen($list[12]>0)) {
//if (isset($bagglist[$list[8]."-".$list[41]."-".$sy."-dup"])) {
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][43]+=$list[43];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][44]+=$list[44];
//    $bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][45]+=$list[45];}
//else {$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"]=$list;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][42]=$sy;$bagglist[$list[8]."-".$list[41]."-".$sy."-dup"][46]=$start;}
}

else {
if (isset($sagglist[$list[20]."-".$list[41]."-".$sy])) {$sagglist[$list[20]."-".$list[41]."-".$sy][43]+=$list[43];$sagglist[$list[20]."-".$list[41]."-".$sy][44]+=$list[44];$sagglist[$list[20]."-".$list[41]."-".$sy][45]+=$list[45];}
else {$sagglist[$list[20]."-".$list[41]."-".$sy]=$list;$sagglist[$list[20]."-".$list[41]."-".$sy][42]=$sy;$sagglist[$list[20]."-".$list[41]."-".$sy."-dup"][46]=$start;}}

}

}

else {
//echo "writing:".$data2[$i].",".$start."\n";
//echo "paid:".$line[45]."\n";
fwrite($statesbuffer[$e],$data2[$i].",".$start."\n");
fwrite($aggsbuffer,$data2[$i].",".$start."\n");
}
}//end hcode and year match
else {if ($i>0)
    {//echo "strpos".(strpos($code2,$line[41]))."\n";
     //echo "year:".strpos($y1,substr($line[42],0,4))."\n";
//echo "y".$y1."\n";

//echo "l41".$line[41]."\n";
//echo "l42".$line[42]."\n";
//echo "count(line)".count($line)."\n";
//echo "start".$start."\n";
//        echo $data2[$i];$undcode[$line[41]]="\"0\"";
//        exit;
    }

}
$start+=$jump+1;
}//endfor each line in read

echo "\nstart:".$start."\n";

echo 100*($start/$fs1)."% : ";
echo (time()-$n);
echo "(s) : ";
echo (time()-$n)/(($start/$fs1))."(s) estimate : ";
echo $start."\n";
}//endwhile(start/fs1)
if (isset($argv[7]) && ($m==="company" || $m==="address")) {

foreach($sagglist as $sl) {
$tmp="";
//echo "sl:";print_r($sl);
foreach($sl as $sl2) {
//echo "sl2:".$sl2;
$tmp.="\"".$sl2."\",";}
$tmp=substr_replace($tmp, "\n", -1);
echo "tmp:".$tmp;
fwrite($statesbuffer[$e],$tmp);
fwrite($aggsbuffer,$tmp);

}
$sagglist="";
}


}//endservicing
}//end for (states loop)


//print_r($undcode);

//do math (mean, media, mode)
//start with billing
//first by state
//then by year
//then by code
//code aggrate by year
//code aggregate all years
//switch to service, repeat above
//switch to national & repeat
//do second math round, and analysis
//then report violators, or report all in separate file

$statess=array();
if ($state==="ALL") {$statess=$states;}
else{$statess=explode(":",$state);}
$years=explode(":",$y1);
$z=count($years);
$codess=explode(":",$code2);
$y=count($codess);
$bufbasicreport=fopen("php://memory","r+");
$bufcriticalreport=fopen("php://memory","r+");
$sample="";
$sample2="";
$sample3="";
$sample4="";
$specialsample3="";
$specialsample4="";
if ($type==="billing" || $type==="all") {$sample=getdata($statess, $years,$codess,1,$field2);}
if ($type==="servicing" || $type==="all") {$sample2=getdata($statess, $years,$codess,2,$field2);}





if ($type==="billing" || $type==="all") {
for($e=0;$e<$s2i2;$e++) {
if ($e==$s2i) {fwrite($bufbasicreport,"Aggregate Billing\n");} else {fwrite($bufbasicreport,$statess[$e]." Billing\n");}
foreach($years as $f) {
fwrite($bufbasicreport,"\t".$f."\n");
for($g=0;$g<$y;$g++) {
//echo "g".$g."\n";
//echo "codess[g]".$codess[$g]."\n";
//echo "codes[g]".$codes[$g];
if ($field2==="revenue" || $field2==="paid" ||$field2==="claims" || $field2==="claimlines" ||$field2==="patients" || $field2==="clients") {
echo $e." ".$f." ".$g." ".$codess[$g]."\n";
$play=str_getcsv($sample[$e][(int)$f][$codess[$g]]);
$mean=0;$std=0;$var=0;
$k=count($play);
echo "k:".$k."\n";
//because our data ends with a comma, there is actualy one less count than our k value reveals.
if ($k>1) {
for($j=0;$j<$k-1;$j++){$mean+=$play[$j];}
$mean=$mean/($k-1);
for($j=0;$j<$k-1;$j++){$var+=pow($mean-$play[$j],2);}
$var=$var/($k-1);}
$std=sqrt($var);
if ($mean!=0 && $std!=0) {
fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");}$sample3.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";}

else if ($field2==="paidperpatient" || $field2==="paidperclaim" ||$field2==="claimsperpatient") {
    $play=str_getcsv($sample[$e][(int)$f][$codess[$g]]);
    $k=count($play);
    if ($k>1) {
        $std=0;$var=0;$mean=0;$mean2=0;
        for($j=0;$j<$k-1;$j++) {
        $play3=explode(":",$play[$j]);
        $mean+=(float)$play3[0];
        $mean2+=(float)$play3[1];
        }
//        echo "mean:".$mean." mean2:".$mean2; exit;
        $mean=($mean/$mean2);
        for($j=0;$j<$k-1;$j++) {$play3=explode(":",$play[$j]);if ($play3[1]==0) {$play3[1]=1;}$var+=pow($mean-(float)($play3[0]/((float)$play3[1])),2);}
        $var=$var/($k-1);}
        $std=sqrt($var);
//        echo "mean:".$mean
//        exit;
        if ($mean!=0 && $std!=0) {
        fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
        fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");}$sample3.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";}


else if ($field2==="company" || $field2==="organization" || $field2==="nonorganization" || $field2==="person" || $field2==="lastname" || $field2==="lname" || $field2==="address" ) {
$play=str_getcsv($sample[$e][(int)$f][$codess[$g]]);
if (count($play)==1 && strlen($play[0])==0) {continue;}
//echo "play:\n";
//print_r($play);
$k=count($play);
if ($k==1 && strlen($play[0]==0)) {continue;}
//if ($k==1) {$k=2;}
$play2=array_count_values($play);
$uplay=count($play2);
    if ($uplay==0) {continue;}
    if ($uplay==1) {continue;}
    $mean=($k-1)/($uplay-1);
$var=0;
$specialsample3.="-".$e."-".$f."-".$g."-";
foreach($play2 as $play3) {$var+=pow($mean-$play3,2);}
$std=sqrt($var/$k);
if ($mean!=0 && $std!=0) {
fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");
if (is_numeric($std2)) {foreach($play2 as $k1 => $play3) {if ($play>=($mean+$std2*$std)) {$specialsample3.=$k1.":".$play3.",";}}}}
$sample3.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";
}
}
}}//endfors
}



if ($type==="servicing" || $type==="all") {
    for($e=0;$e<$s2i2;$e++) {
        if ($e==$s2i) {fwrite($bufbasicreport,"Aggregate Servicing\n");} else {fwrite($bufbasicreport,$statess[$e]." Servicing\n");}
foreach($years as $f) {
fwrite($bufbasicreport,"\t".$f."\n");
for($g=0;$g<$y;$g++) {
if ($field2==="revenue" || $field2==="paid" ||$field2==="claims" || $field2==="claimlines" ||$field2==="patients" || $field2==="clients") {

$play=str_getcsv($sample2[$e][(int)$f][$codess[$g]]);
$mean=0;$std=0;$var=0;
$k=count($play);
//because our data ends with a comma, there is actualy one less count than our k value reveals.
if ($k>1) {
for($j=0;$j<$k-1;$j++){$mean+=$play[$j];}
$mean=$mean/($k-1);
for($j=0;$j<$k-1;$j++){$var+=pow($mean-$play[$j],2);}
$var=$var/($k-1);}
/*
echo "\nmean:".$mean;
echo "\nvar:".$var;
echo "\nyear:".$f;
echo "\ncode:".$codess[$g];
if ($f==2024  && $codess[$g]==="t2016") {exit(0);}
*/
$std=sqrt($var);
if ($mean!=0 && $std!=0) {
   fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");}$sample4.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";}

else if ($field2==="paidperpatient" || $field2==="paidperclaim" ||$field2==="claimsperpatient") {
$play=str_getcsv($sample2[$e][(int)$f][$codess[$g]]);
$k=count($play);
if ($k>1) {

$std=0;$var=0;$mean=0;$mean2=0;
for($j=0;$j<$k-1;$j++) {
    $play3=explode(":",$play[$j]);
    $mean+=(float)$play3[0];
    $mean2+=(float)$play3[1];
}

$mean=($mean/$mean2);
for($j=0;$j<$k-1;$j++) {$play3=explode(":",$play[$j]);if ($play3[1]==0) {$play3[1]=1;}$var+=pow($mean-(float)($play3[0]/((float)$play3[1])),2);}
$var=$var/($k-1);}
$std=sqrt($var);
        if ($mean!=0 && $std!=0) {
fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");}$sample4.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";}


               else if ($field2==="company" || $field2==="organization" || $field2==="nonorganization" || $field2==="person" || $field2==="lastname" || $field2==="lname" || $field2==="address" ) {
    $play=str_getcsv($sample2[$e][(int)$f][$codess[$g]]);
    if (count($play)==1 && strlen($play[0])==0) {continue;}
    $k=count($play);
    if ($k==1 && strlen($play[0]==0)) {continue;}
//    if ($k==1) {$k=2;}
    $play2=array_count_values($play);
    echo "k:".$k."\n";
    echo "play2:";print_r($play2);
    $uplay=count($play2);
    echo "uplay:".$uplay."\n";
    if ($uplay==0) {continue;}
    if ($uplay==1) {continue;}
    $mean=($k-1)/($uplay-1);
    $var=0;
$specialsample4.="-".$e."-".$f."-".$g."-";
    foreach($play2 as $play3) {$var+=pow($mean-$play3,2);}
$std=sqrt($var/$k);
        if ($mean!=0 && $std!=0) {
//why are we doin this here?
        fwrite($bufbasicreport,"\t\n".$codess[$g].":".$dictionary[$codes[$g]+1]."\n");
 fwrite($bufbasicreport,"\t\t mean:".$mean."std dev:".$std."\n");

if (is_numeric($std2)) {foreach($play2 as $k1=> $play3) {if ($play>=($mean+$std2*$std)) {$specialsample4.=$k1.":".$play3.",";}}}
            }$sample4.="-".$e."-".$f."-".$codes[$g]."-m".$mean."s".$std."\n";

}
            }

}

    }
}
//echo "count_sample2:".count($sample2)."\n";
//print_r($sample2);
//echo "sample4len:".strlen($sample4)."\n";
//echo "specialsample2len:".strlen($specialsample4)."\n";
rewind($bufbasicreport);
$fp=stream_get_contents($bufbasicreport);
$fph=fopen($pwd."/".basename($state."-".$type."-".$y1."-".$code."-".$std2."-".$field2."-".$m."-".$search2."-".$field2)."basicreport.txt","w");
fwrite($fph,$fp);
fclose($fph);



//now for the filtering

$data4=array();
$data5=array();



if (is_numeric($std2)) {
if ($type==="billing" || $type==="all"){
    for($e=0;$e<$s2i2;$e++) {
$data4[$e]=array();
        for($f=0;$f<$z;$f++) {//echo "years[f]:".$years[$f]."\n";
            $data4[$e][(int)$f]=array();
            fwrite($bufcriticalreport,"\t".$years[$f]."\n");
            for($g=0;$g<$y;$g++) {//echo "g:".$g."\n";
            $data4[$e][(int)$f][$g]="";}}}
for($e=0;$e<$s2i2;$e++) {
if ($e==$s2i) {rewind($aggpbuffer);$finalpass=stream_get_contents($aggpbuffer);}
else {rewind($statepbuffer[$e]);$finalpass=stream_get_contents($statepbuffer[$e]);}
if ($e==$s2i) {
$fph=fopen($pwd."/".basename($state."-".$type."-".$y1."-".$code."-".$std2."-".$field2."-".$m."-".$search2."-".$field2)."-rawbilling.csv","w");
fwrite($fph,$finalpass);
fclose($fph);}

echo "len(fp):".strlen($finalpass)."\n";
$lines=explode("\n",$finalpass);
echo "countlines".count($lines)."\n";
$lines2=count($lines);
$lcount=1;
//if ($e==$s2i) {fwrite($bufcriticalreport,"Aggregate Billing\n");} else {fwrite($bufcriticalreport,$statess[$e]." Billing\n");}
foreach($lines as $cc) {
echo $lcount."/".$lines2."\r";
$lcount++;
if (strlen($cc)<=12) {continue;}
$line=str_getcsv($cc);


if (count($line)==55) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==54) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==53) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==52) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==51) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}


if (count($line)==50) {if (strlen($line[41])!=5 || strlen($line[42])!=7) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}
if (count($line)==49) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==48) {if (strlen($line[41])>5 || strlen($line[41])==0) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==47) {if (strlen($line[41])>5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}
if (count($line)==46) {if (strlen($line[41])>5) {if (substr($line[41],0,5)==="88888") {$line[41]="88888";} }}





$f=substr($line[42],0,4);
if (strlen($line[41])==4) {$line[41]="0".$line[41];}
if (strlen($line[41])==7 && strpos($line[41],"-")!==false) {$line[42]=$line[41];$line[41]=$line[40];}
if ($line[41]==="888888") {$line[41]="88888";}
$g=$code3[strtolower($line[41])];
//print_r($code3);
//echo "line:".$cc."\n";
//echo "count:".count($line)."\n";
//echo "g:".$g;

$play=substr($sample3,strpos($sample3,"-".$e."-".$f."-".$codes[$g]."-m"));
$play=substr($play,0,strpos($play,"\n"));
$mean=substr($play,strpos($play,"-m")+2);
$mean=(float)substr($mean,0,strpos($mean,"s"));
$std=(float)substr($play,strrpos($play,"s")+1);
//echo "stdev:".$std;
//echo "play:".$play;
$x=$field2;
$objective=0;
if ($x==="revenue" || $x==="paid" || $x==="claimlines" || $x==="claims" || $x==="patients" || $x==="clients" || $x==="paidperpatient" || $x==="paidperclaim" || $x==="claimsperpatient") {
$r=$line;//quickbug fix
if ($x==="revenue" || $x==="paid" ) {$objective=$r[45];}
else if ($x==="claimlines" || $x==="claims") {$objective=$r[44];}
else if ($x==="patients" || $x==="clients") {$objective=$r[43];}
else if ($x==="paidperpatient") {$objective=$r[45]/$r[43];}
else if ($x==="paidperclaim") {$objective=$r[45]/$r[44];}
else if ($x==="claimsperpatient") {$objective=$r[44]/$r[43];}
$zs=0;
if ($std==0) {$std=1;//echo $sample3."\n";echo $g."\n";echo $codes[$g]."\n";echo $play;exit;
}
$zs=((float)$objective-$mean)/$std;
//if ($zs>100) {echo "x:".$objective." xbar:".$mean." stdev:".$std." play:".$play."\n";exit;}
if (abs($zs)>=((float)$std2)) {//echo "x:".$objective." xbar:".$mean." stdev:".$std."\n";
if (!array_key_exists($e,$data4))
{$data4[$e]=array();}
if (!array_key_exists((int)$f,$data4[$e]))
{$data4[$e][(int)$f]=array();}
if (!array_key_exists($g,$data4[$e][(int)$f]))
{$data4[$e][(int)$f][$g]=$cc.",".$zs."\n";}
else {$data4[$e][(int)$f][$g].=$cc.",".$zs."\n";}}

}
else {
$r=$line;//quickbug fix
if ($x==="company" || $x==="organization" ) {$objective=$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
else if ($x==="person" || $x==="lastname" || $x==="lname") {$objective=$r[3];}
else if ($x==="nonorganization" && strlen($r[2])==0) {$objective=$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
else if ($x==="address") {if (strlen($r[12])!=0) {$objective=$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[2].":".$r[3].":".$r[4].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[31].":".$r[32];}}
if (strpos($specialsample3,$objective)!==FALSE) {
if (!array_key_exists($e,$data4))
{$data4[$e]=array();}
if (!array_key_exists((int)$years[0],$data4[$e]))
{$data4[$e][(int)$years[0]]=array();}
if (!array_key_exists(0,$data4[$e][(int)$years[0]]))
{$data4[$e][(int)$years[0]][0]="";}

if (strpos($data4[$e][$years[0]][0],$objective)!==FALSE) {} else {$data4[$e][$years[0]][0].=$objective."\n";}

if ($x==="company" || $x==="organization" || $x==="address" ) {
if ($x==="company" || $x==="organization" ) {$objective=$r[8].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
else if ($x==="address") {if (strlen($r[20])!=0) {$objective=$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}}
if (!array_key_exists($e,$data4))
{$data4[$e]=array();}
if (!array_key_exists((int)$years[0],$data4[$e]))
{$data4[$e][(int)$years[0]]=array();}
if (!array_key_exists(0,$data4[$e][(int)$years[0]]))
{$data4[$e][(int)$years[0]][0]="";}
if (strpos($specialsample3,$objective)!==FALSE) {
if (strpos($data4[$e][$years[0]][0],$objective)!==FALSE) {} else {$data4[$e][$years[0]][0].=$objective."\n";}
}}
if ($x==="nonorganization" ) {$objective=$r[9].":".$r[10].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;
if (!array_key_exists($e,$data5))
{$data5[$e]=array();}
if (!array_key_exists((int)$years[0],$data5[$e]))
{$data5[$e][(int)$years[0]]=array();}
if (!array_key_exists(0,$data5[$e][(int)$years[0]]))
{$data5[$e][(int)$years[0]][0]="";}
if (strpos($specialsample4,$objective)!==FALSE) {
if (strpos($data5[$e][$years[0]][0],$objective)!==FALSE) {} else {$data5[$e][$years[0]][0].=$objective."\n";}
}
}

}}

}
}}}//endbigif

if (is_numeric($std2)) {
if ($type==="servicing" || $type==="all"){
    for($e=0;$e<$s2i2;$e++) {
        $data5[$e]=array();
        for($f=0;$f<$z;$f++) {
            $data5[$e][(int)$f]=array();
//            fwrite($bufcriticalreport,"\t".$years[$f]."\n");
            for($g=0;$g<$y;$g++) {
            $data5[$e][(int)$f][$g]=array();}}}
for($e=0;$e<$s2i2;$e++) {
if ($e==$s2i) {rewind($aggsbuffer);$finalpass=stream_get_contents($aggsbuffer);}
else {rewind($statesbuffer[$e]);$finalpass=stream_get_contents($statesbuffer[$e]);}
if ($e==$s2i) {
$fph=fopen($pwd."/".basename($state."-".$type."-".$y1."-".$code."-".$std2."-".$field2."-".$m."-".$search2."-".$field2)."-rawsevicing.csv","w");
fwrite($fph,$finalpass);
fclose($fph);}

$lines=explode("\n",$finalpass);
$lines2=count($lines);
$lcount=1;
foreach($lines as $cc) {
echo $lcount."/".$lines2."\r";
$lcount++;
if (strlen($cc)<=12) {continue;}
$line=str_getcsv($cc);
if (count($line)==55) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);
break;}}
}}

if (count($line)==54) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==53) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==52) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==51) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}


if (count($line)==50) {if (strlen($line[41])!=5 || strlen($line[42])!=7) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}
if (count($line)==49) {if (strlen($line[41])!=5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==48) {if (strlen($line[41])>5 || strlen($line[41])==0) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}

if (count($line)==47) {if (strlen($line[41])>5) {
for ($aa=41;$aa>0;$aa--) {if (strlen($line[$aa])==0) {unset($line[$aa]);
    $line=array_values($line);break;}}
}}
if (count($line)==46) {if (strlen($line[41])>5) {if (substr($line[41],0,5)==="88888") {$line[41]="88888";} }}


$f=substr($line[42],0,4);
if (strlen($line[41])==4) {$line[41]="0".$line[41];}
if (strlen($line[41])==7 && strpos($line[41],"-")!==false) {$line[42]=$line[41];$line[41]=$line[40];}
if ($line[41]==="888888") {$line[41]="88888";}
$g=$code3[strtolower($line[41])];
//echo "cc:".$cc."\n";
//echo "g:".$g."\n";
$play=substr($sample4,strpos($sample4,"-".$e."-".$f."-".$codes[$g]."-m"));
//echo "play:".$play;
$play=substr($play,0,strpos($play,"\n"));
$mean=substr($play,strpos($play,"-m")+2);
$mean=(float)substr($mean,0,strpos($mean,"s"));
$std=(float)substr($play,strrpos($play,"s")+1);
//echo "\nstdev:".$std;
//echo "mean:".$mean;
//echo "play:".$play;

$x=$field2;
$objective=0;
if ($x==="revenue" || $x==="paid" || $x==="claimlines" || $x==="claims" || $x==="patients" || $x==="clients" || $x==="paidperpatient" || $x==="paidperclaim" || $x==="claimsperpatient") {
$r=$line;//quickbug fix
if ($x==="revenue" || $x==="paid" ) {$objective=$r[45];}
else if ($x==="claimlines" || $x==="claims") {$objective=$r[44];}
else if ($x==="patients" || $x==="clients") {$objective=$r[43];}
else if ($x==="paidperpatient") {$objective=$r[45]/$r[43];}
else if ($x==="paidperclaim") {if ($r[44]==0) {$objective=$mean;fwrite($bufcriticalreport,"\trevenue with no claims:".$cc."\n");} else {$objective=$r[45]/$r[44];}}
else if ($x==="claimsperpatient") {$objective=$r[44]/$r[43];}
$zs=0;
if ($std==0) {$std=1;//echo $sample3."\n";echo $g."\n";echo $codes[$g]."\n";echo $play;exit;
}
$zs=((float)$objective-$mean)/$std;
if (abs($zs)>=((float)$std2)) {//echo "x:".$objective." xbar:".$mean." stdev:".$std."\n";
if (!array_key_exists($e,$data5))
{$data5[$e]=array();}
if (!array_key_exists((int)$f,$data5[$e]))
{$data5[$e][(int)$f]=array();}
if (!array_key_exists($g,$data5[$e][(int)$f]))
{$data5[$e][(int)$f][$g]=$cc.",".$zs."\n";}
else {$data5[$e][(int)$f][$g].=$cc.",".$zs."\n";}}
}
else {
$r=$line;//quickbug fix
if ($x==="company" || $x==="organization" ) {$objective=$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
else if ($x==="nonorganization" && strlen($r[2])==0) {$objective=$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
else if ($x==="person" || $x==="lastname" || $x==="lname") {$objective=$r[3];}
else if ($x==="address") {if (strlen($r[20])!=0) {$objective=$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[2].":".$r[3].":".$r[4].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[31].":".$r[32];}}
if (strpos($specialsample4,$objective)!==FALSE) {
if (!array_key_exists($e,$data5)) {$data5[$e]=array();}
if (!array_key_exists((int)$years[0],$data5[$e])) {$data5[$e][(int)$years[0]]=array();}
if (!array_key_exists(0,$data5[$e][(int)$years[0]])) {$data5[$e][(int)$years[0]][0]="";}
if (strpos($data5[$e][$years[0]][0],$objective)!==FALSE) {} else {$data5[$e][$years[0]][0].=$objective."\n";}
}
if ($x==="company" || $x==="organization" || $x==="address" || $x==="nonorganization") {
if ($x==="company" || $x==="organization" ) {$objective=$r[8].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
else if ($x==="nonorganization" ) {$objective=$r[9].":".$r[10].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
else if ($x==="address") {if (strlen($r[20])!=0) {$objective=$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}}
if (!array_key_exists($e,$data5))
{$data5[$e]=array();}
if (!array_key_exists((int)$years[0],$data5[$e]))
{$data5[$e][(int)$years[0]]=array();}
if (!array_key_exists(0,$data5[$e][(int)$years[0]]))
{$data5[$e][(int)$years[0]][0]="";}
if (strpos($specialsample4,$objective)!==FALSE) {
if (strpos($data5[$e][$years[0]][0],$objective)!==FALSE) {} else {$data5[$e][$years[0]][0].=$objective."\n";}
}
}
}



}
}
}//endservicing
}

$x=$field2;
rewind($bufcriticalreport);
fwrite($bufcriticalreport,"Id, , Company name,Last name,First name, Middle name,title,certification,,Lake Name,First name, Middle Name,street address, apt, city, state, zip, country, phone, phone 2, Street address, apt, city, state, zip, country, phone, phone 2, date , date 2, cert , last name, first name, middle name, title, phone, taxonomy code, , , , id code 2, billing code, billing date, clients, billings, revenues, memory location,zscore \n");
if ($type==="billing" || $type==="all"){
foreach($data4 as $k1 => $nd1) {
if ($k1==$s2i) {
if ($x==="company" || $x==="organization" || $x==="nonorganization" || $x==="person" || $x==="lastname" || $x==="lname" || $x==="address") {break;}
fwrite($bufcriticalreport,"Aggregate\n");}
else {fwrite($bufcriticalreport,"State:".$statess[$k1]."\n");}
foreach($nd1 as $k2 => $nd2) {
echo "k2:".$k2."\n";
if ($k2>2010) {fwrite($bufcriticalreport,"/tYear:".$k2."\n");
foreach($nd2 as $k3 => $nd3) {
echo "k3:".$k3."\n";
if (strlen($k3)!=0) {fwrite($bufcriticalreport,"/ttHCPCS code:".$dictionary[$codes[$k3]]."\n\"".$dictionary[$codes[$k3]+1]."\"\n\n");}
fwrite($bufcriticalreport,str_replace(":",",",$nd3)."\n");
}}}}}

if ($type==="servicing" || $type==="all"){
foreach($data5 as $k1 => $nd1) {
if ($k1==$s2i) {
if ($x==="company" || $x==="organization" || $x==="nonorganization" || $x==="person" || $x==="lastname" || $x==="lname" || $x==="address") {break;}
fwrite($bufcriticalreport,"Aggregate\n");}
else {fwrite($bufcriticalreport,"State:".$statess[$k1]."\n");}
foreach($nd1 as $k2 => $nd2) {
echo "k2:".$k2."\n";
if ($k2>2010) {fwrite($bufcriticalreport,"/tYear:".$k2."\n");
foreach($nd2 as $k3 => $nd3) {
echo "k3:".$k3."\n";
if (strlen($k3)!=0) {fwrite($bufcriticalreport,"/ttHCPCS code:".$dictionary[$codes[$k3]]."\n\"".$dictionary[$codes[$k3]+1]."\"\n\n");}
fwrite($bufcriticalreport,str_replace(":",",",$nd3)."\n");
}}}}
print_r($data5);
}

rewind($bufcriticalreport);
$fp=stream_get_contents($bufcriticalreport);
$fph=fopen($pwd."/".basename($state."-".$type."-".$y1."-".$code."-".$std2."-".$field2."-".$m."-".$search2."-".$field2)."-critreport.csv","w");
fwrite($fph,$fp);
fclose($fph);


function getdata($a,$b,$c,$z,$x) {

global $statepbuffer,$statesbuffer;
if (!isset($statepbuffer)) {echo "statebuffer isn't global";exit;}
if (!isset($statepbuffer[0])) {echo "statebuffer is global, but it's index is not";exit;}
rewind($statepbuffer[0]);
$data3=array();
$statess=$a;
$g=count($statess);
$years=$b;
$codess=$c;
echo "count(codess):".count($codess)."\n";
for($d=0;$d<=$g;$d++) {
$data3[$d] =array();
foreach($years as $yin) {
echo "years".$yin."\n";
$data3[$d][(int)$yin]=array();
foreach($codess as $cin) {
echo "codess".$cin."\n";
$data3[$d][(int)$yin][strtolower($cin)] ="";}
}}
for($d=0;$d<$g;$d++) {
echo "776:".$d."\n";
echo "776:".$g."\n";
if ($z==1) {
$finalpass="";
rewind($statepbuffer[$d]);
$finalpass=stream_get_contents($statepbuffer[$d]);
$lines=explode("\n",$finalpass);
foreach($lines as $q) {
if (strlen($q)<=12) {continue;}
$r=str_getcsv($q);
$objective="";
echo "\n".strlen($q)."\n";
echo $q."\n";
echo "organization:".$r[2];
if ($x==="revenue" || $x==="paid" ) {$objective=$r[45];}
else if ($x==="claimlines" || $x==="claims") {$objective=$r[44];}
else if ($x==="patients" || $x==="clients") {$objective=$r[43];}
else if ($x==="paidperpatient") {$objective=$r[45].":".$r[43];}
else if ($x==="paidperclaim") {$objective=$r[45].":".$r[44];}
else if ($x==="claimsperpatient") {$objective=$r[44].":".$r[43];}
else if ($x==="company" || $x==="organization" ) {
$objective="";
if (!(strlen($r[2])==0 || $r[2]==="<UNAVAIL>")) {$objective=$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
if (!(strlen($r[8])==0 || $r[8]==="<UNAVAIL>")) {
if (strlen($objective)!=0) {$objective.=",";}
$objective.=$r[8].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
if (strlen($objective)==0) {

continue;}
}
else if ($x==="nonorganization" ) {
$objective="";
if ((strlen($r[2])==0 || $r[2]==="<UNAVAIL>") && !(strlen($r[3])==0 &&  strlen($r[4])==0)) {$objective=$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
if ((strlen($r[8])==0 || $r[8]==="<UNAVAIL>") && !(strlen($r[9])==0 &&  strlen($r[10])==0)) {
if (strlen($objective)!=0) {$objective.=",";}
$objective.=$r[9].":".$r[10].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
if (strlen($objective)==0) {continue;}}

else if ($x==="person" || $x==="lastname" || $x==="lname") {$objective=$r[9];}
else if ($x==="address"  || $x==="combined" ) {exit;
if (strlen($r[12])!=0) {$objective=$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[2].":".$r[3].":".$r[4].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[31].":".$r[32];
if (strlen($r[20])!=0) {$objective.=",".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}}
else if (strlen($r[20])!=0) {$objective=$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}
}
else if ($x==="addressonly") {$objective=$r[12];}
if (strlen($r[41])==4) {$r[41]="0".$r[41];}
if ($r[41]==="888888") {$r[41]="88888";}
$data3[$d][(int)substr($r[42],0,4)][strtolower($r[41])].=$objective.",";
$data3[$g][(int)substr($r[42],0,4)][strtolower($r[41])].=$objective.",";
}}
else {
    rewind($statesbuffer[$d]);
    $finalpass=stream_get_contents($statesbuffer[$d]);
    echo "streamsize".$finalpass."\n";
    $lines=explode("\n",$finalpass);
    foreach($lines as $q) {
        if (strlen($q)<=12) {continue;}
        $r=str_getcsv($q);
        $objective="";echo "\n".strlen($q)."\n";
echo $q."\n";
echo "organization:".$r[2];
if ($x==="revenue" || $x==="paid" ) {$objective=$r[45];}
else if ($x==="claimlines" || $x==="claims") {$objective=$r[44];}
else if ($x==="patients" || $x==="clients") {$objective=$r[43];}
else if ($x==="paidperpatient") {$objective=$r[45].":".$r[43];}
else if ($x==="paidperclaim") {$objective=$r[45].":".$r[44];}
else if ($x==="claimsperpatient") {$objective=$r[44].":".$r[43];}
else if ($x==="company" || $x==="organization" ) {
$objective="";
if (!(strlen($r[2])==0 || $r[2]==="<UNAVAIL>")) {$objective=$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
if (!(strlen($r[8])==0 || $r[8]==="<UNAVAIL>")) {if (strlen($objective)!=0) {$objective.=",";}$objective.=$r[8].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];;}
if (strlen($objective)==0) {continue;}
}
else if ($x==="nonorganization" ) {
$objective="";
if ((strlen($r[2])==0 || $r[2]==="<UNAVAIL>") && !(strlen($r[3])==0 &&  strlen($r[4])==0 )) {$objective=$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];echo $objective."\n";}
if ((strlen($r[8])==0 || $r[8]==="<UNAVAIL>") && (strlen($r[9])!=0 &&  strlen($r[10])!=0)) {if (strlen($objective)!=0) {$objective.=",";}$objective.=$r[9].":".$r[10].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26];}
if (strlen($objective)==0) {continue;}
if (strlen($objective)==1) {continue;}
}

else if ($x==="person" || $x==="lastname" || $x==="lname") {$objective=$r[9];}
else if ($x==="address" || $x==="combined") {
if (strlen($r[12])!=0) {$objective=$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[2].":".$r[3].":".$r[4].":".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[31].":".$r[32];
if (strlen($r[20])!=0) {$objective.=",".$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}
}
else if (strlen($r[20])!=0) {$objective=$r[20].":".$r[21].":".$r[22].":".$r[23].":".$r[24].":".$r[26].":".$r[2].":".$r[3].":".$r[4].":".$r[12].":".$r[13].":".$r[14].":".$r[15].":".$r[16].":".$r[18].":".$r[31].":".$r[32];}}
else if ($x==="addressonly") {$objective=$r[12];}
if (strlen($r[41])==4) {$r[41]="0".$r[41];}
if ($r[41]==="888888") {$r[41]="88888";}
$data3[$d][(int)substr($r[42],0,4)][strtolower($r[41])].=$objective.",";
$data3[$g][(int)substr($r[42],0,4)][strtolower($r[41])].=$objective.",";
if (strlen($r[41])==4) {exit;}
}
}
}
//print_r($data3);
return $data3;
}

?>
