<?php
$pwd=getcwd();
$path1=$pwd."/workspace//medicaid-provider-spending.csv";
$path0=$pwd."/workspace/NPPES_Data_Dissemination_April_2026_V2/npidata_pfile_20050523-20260412.csv";
$h=fopen($path1,"r"); if (!$h) {die("File failed to open. Check the path and permissions.");}
$h0=fopen($path0,"r"); if (!$h0) {die("File failed to open. Check the path and permissions.");}
$tmp=file_get_contents($pwd."/medicaid_files/npidata_pfile_20050523-20260412.ser");
$hash = unserialize($tmp);
$states= array("AL","AK","AZ","AR","AS","CA","CO","CT","DE","DC","FL","GA","GU","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MH","MP","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","PR","PW","RI","SC","SD","TN","TX","TT","UT","VT","VA","VI","WA","WV","WI","WY","ZZ","UK");
$counter=0;
$path2 = array();
$path3 = array();
$path4 = array();
$buff= array();
$buff2= array();
$start=0;
$readsize=8388608;
$csf=0;
foreach($states as $e) {
$path4[$counter]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$e).".billing";
$path5[$counter]=$pwd."/medicaid_files/npidata_pfile_20050523-20260412".basename("__".$e).".servicing";
$h3[$counter]=fopen($path4[$counter],"a"); if (!$h3[$counter]) {die("File failed to open. Check the path and permissions.");}
$h4[$counter]=fopen($path5[$counter],"a"); if (!$h3[$counter]) {die("File failed to open. Check the path and permissions.");}
$buff[$counter]=fopen('php://memory', 'r+');
$buff2[$counter]=fopen('php://memory', 'r+');
$counter++;    
}
$n=time();
$fs1=filesize($path1);
$index=0;
$f=count($states);

while ($start<$fs1) {
$counter=0;
foreach($states as $e) {
ftruncate($buff[$counter], 0);
ftruncate($buff2[$counter], 0);
rewind($buff[$counter]);
rewind($buff2[$counter]);
$counter++;}
fseek($h,$start);
$buf=fread($h,$readsize);
$a=explode("\n",$buf);
$d=count($a);
for ($b=0;$b<$d-1;$b++) {
//echo $b."\n";
$c=str_getcsv($a[$b]);
//echo $index."\n";
//echo $c[0]."\n";
//echo strlen($c[0])."\n";
//echo $c[1]."\n";
$counter=0;
$npiarray="";
$npiarray2="";
//echo substr($tmp,0,500)."\n";
if ($index==0){
fseek($h0,0);
$buf2=str_getcsv(fread($h0,2048));
$npiarray="\"".$c[0]."\",\"".$buf2[3]."\",\"".$buf2[4]."\",\"".$buf2[5]."\",\"".$buf2[6]."\",\"".$buf2[7]."\",\"".$buf2[8]."\",\"".$buf2[10]."\",\"".$buf2[11]."\",\"".$buf2[13]."\",\"".$buf2[14]."\",\"".$buf2[15]."\",\"".$buf2[20]."\",\"".$buf2[21]."\",\"".$buf2[22]."\",\"".$buf2[23]."\",\"".$buf2[24]."\",\"".$buf2[25]."\",\"".$buf2[26]."\",\"".$buf2[27]."\",\"".$buf2[28]."\",\"".$buf2[29]."\",\"".$buf2[30]."\",\"".$buf2[31]."\",\"".$buf2[32]."\",\"".$buf2[33]."\",\"".$buf2[34]."\",\"".$buf2[35]."\",\"".$buf2[36]."\",\"".$buf2[37]."\",\"".$buf2[10]."\",\"".$buf2[42]."\",\"".$buf2[43]."\",\"".$buf2[44]."\",\"".$buf2[45]."\",\"".$buf2[46]."\",\"".$buf2[47]."\",\"".$buf2[48]."\",\"".$buf2[50]."\",\"".$buf2[51]."\",\"".$c[1]."\",\"".$c[2]."\",\"".$c[3]."\",\"".$c[4]."\",\"".$c[5]."\",\"".$c[6]."\"\n";
$npiarray2="\"".$c[1]."\",\"".$buf2[3]."\",\"".$buf2[4]."\",\"".$buf2[5]."\",\"".$buf2[6]."\",\"".$buf2[7]."\",\"".$buf2[8]."\",\"".$buf2[10]."\",\"".$buf2[11]."\",\"".$buf2[13]."\",\"".$buf2[14]."\",\"".$buf2[15]."\",\"".$buf2[20]."\",\"".$buf2[21]."\",\"".$buf2[22]."\",\"".$buf2[23]."\",\"".$buf2[24]."\",\"".$buf2[25]."\",\"".$buf2[26]."\",\"".$buf2[27]."\",\"".$buf2[28]."\",\"".$buf2[29]."\",\"".$buf2[30]."\",\"".$buf2[31]."\",\"".$buf2[32]."\",\"".$buf2[33]."\",\"".$buf2[34]."\",\"".$buf2[35]."\",\"".$buf2[36]."\",\"".$buf2[37]."\",\"".$buf2[10]."\",\"".$buf2[42]."\",\"".$buf2[43]."\",\"".$buf2[44]."\",\"".$buf2[45]."\",\"".$buf2[46]."\",\"".$buf2[47]."\",\"".$buf2[48]."\",\"".$buf2[50]."\",\"".$buf2[51]."\",\"".$c[0]."\",\"".$c[2]."\",\"".$c[3]."\",\"".$c[4]."\",\"".$c[5]."\",\"".$c[6]."\"\n";
//echo $npiarray."\n";
for($e=0;$e<$f;$e++) {
fwrite($buff[$e],$npiarray);
fwrite($buff2[$e],$npiarray2);}}
else {
if (strlen($c[0])>0) {
if (isset($hash[$c[0]])) {
//echo "found a match1\n";
//echo $hash[$c[0]]."\n";
$tmp2=substr($hash[$c[0]],0,strpos($hash[$c[0]],"-"));
//echo $tmp2."\n";
$tmp3=substr($hash[$c[0]],strpos($hash[$c[0]],"-")+1);
if (strpos($tmp3,"-")!==FALSE) {$tmp3=substr($tmp3,strpos($tmp3,"-")+1);}
$g=0;
for($e=0;$e<$f;$e++) {if($states[$e]===$tmp2  || $e==$f-1) {$g=$e;break;}}
//echo $tmp2."\n";
//echo $tmp3."\n";
//if ($g==$f-1) {exit;}
fseek($h0,$tmp3);
//$buf2=fread($h0,2048);
$buf2=str_getcsv(fread($h0,1024));
//echo $buf2;
$npiarray="\"".$c[1]."\",\"".$buf2[3]."\",\"".$buf2[4]."\",\"".$buf2[5]."\",\"".$buf2[6]."\",\"".$buf2[7]."\",\"".$buf2[8]."\",\"".$buf2[10]."\",\"".$buf2[11]."\",\"".$buf2[13]."\",\"".$buf2[14]."\",\"".$buf2[15]."\",\"".$buf2[20]."\",\"".$buf2[21]."\",\"".$buf2[22]."\",\"".$buf2[23]."\",\"".$buf2[24]."\",\"".$buf2[25]."\",\"".$buf2[26]."\",\"".$buf2[27]."\",\"".$buf2[28]."\",\"".$buf2[29]."\",\"".$buf2[30]."\",\"".$buf2[31]."\",\"".$buf2[32]."\",\"".$buf2[33]."\",\"".$buf2[34]."\",\"".$buf2[35]."\",\"".$buf2[36]."\",\"".$buf2[37]."\",\"".$buf2[10]."\",\"".$buf2[42]."\",\"".$buf2[43]."\",\"".$buf2[44]."\",\"".$buf2[45]."\",\"".$buf2[46]."\",\"".$buf2[47]."\",\"".$buf2[48]."\",\"".$buf2[50]."\",\"".$buf2[51]."\",\"".$c[0]."\",\"".$c[2]."\",\"".$c[3]."\",\"".$c[4]."\",\"".$c[5]."\",\"".$c[6]."\"\n";
//echo $npiarray."\n";
fwrite($buff[$g],$npiarray);
}}
if (strlen($c[1])>0) {
if (isset($hash[$c[1]])) {
//echo "found a match2:".$states[$e]."\n";
$tmp2=substr($hash[$c[1]],0,strpos($hash[$c[1]],"-"));
//echo $tmp2."\n";
$tmp3=substr($hash[$c[1]],strpos($hash[$c[1]],"-")+1);
if (strpos($tmp3,"-")!==FALSE) {$tmp3=substr($tmp3,strpos($tmp3,"-")+1);}
$g=0;
for($e=0;$e<$f;$e++) {if($states[$e]===$tmp2 || $e==$f-1) {$g=$e;break;}}
//echo $tmp2."\n";
//echo $tmp3."\n";
fseek($h0,$tmp3);
//$buf2=fread($h0,2048);
$buf2=str_getcsv(fread($h0,1024));
//echo $buf2;
$npiarray2="\"".$c[0]."\",\"".$buf2[3]."\",\"".$buf2[4]."\",\"".$buf2[5]."\",\"".$buf2[6]."\",\"".$buf2[7]."\",\"".$buf2[8]."\",\"".$buf2[10]."\",\"".$buf2[11]."\",\"".$buf2[13]."\",\"".$buf2[14]."\",\"".$buf2[15]."\",\"".$buf2[20]."\",\"".$buf2[21]."\",\"".$buf2[22]."\",\"".$buf2[23]."\",\"".$buf2[24]."\",\"".$buf2[25]."\",\"".$buf2[26]."\",\"".$buf2[27]."\",\"".$buf2[28]."\",\"".$buf2[29]."\",\"".$buf2[30]."\",\"".$buf2[31]."\",\"".$buf2[32]."\",\"".$buf2[33]."\",\"".$buf2[34]."\",\"".$buf2[35]."\",\"".$buf2[36]."\",\"".$buf2[37]."\",\"".$buf2[10]."\",\"".$buf2[42]."\",\"".$buf2[43]."\",\"".$buf2[44]."\",\"".$buf2[45]."\",\"".$buf2[46]."\",\"".$buf2[47]."\",\"".$buf2[48]."\",\"".$buf2[50]."\",\"".$buf2[51]."\",\"".$c[1]."\",\"".$c[2]."\",\"".$c[3]."\",\"".$c[4]."\",\"".$c[5]."\",\"".$c[6]."\"\n";
//echo $npiarray2."\n";
fwrite($buff2[$g],$npiarray2);
}}
}
$csf+=strlen($a[$b])+1;
$index++;
}

//if ($index>5) {exit;}
for($e=0;$e<$f;$e++) {
    rewind($buff[$e]);
    rewind($buff2[$e]);
    fwrite($h3[$e],stream_get_contents($buff[$e]));
    fwrite($h4[$e],stream_get_contents($buff2[$e]));
    }

echo 100*($start/$fs1)." : ";
echo (time()-$n);
echo " : ";
if ($start>0) {echo (time()-$n)/(($start/$fs1))." : ";}
echo $start."\n";
$start=$csf;
}


?>
