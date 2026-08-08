<?php
//$states= array("AL","AK","AZ","AR","AS","CA","CO","CT","DE","DC","FL","GA","GU","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","MP","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX","TT","UT","VT","VA","VI","WA","WV","WI","WY");
$pwd=getcwd();
$path1=$pwd."/workspace/NPPES_Data_Dissemination_April_2026_V2/npidata_pfile_20050523-20260412.csv";
$id1=23;
// $path2 = array();
$path3 = array();
$path4 = array();
$hash=array();
$start=0;
$readsize=8388608;
$csf=0;

$h=fopen($path1,"r"); if (!$h) {die("File failed to open. Check the path and permissions.");}
$n=time();
$fs1=filesize($path1);
echo "filesize:".$fs1."\n";
//$fs2=filesize($file2);
$npiarray="";
$index=0;
while ($start<$fs1) {
fseek($h,$start);
$buf=fread($h,$readsize);
//echo $buf."\n";
$a=explode("\n",$buf);
$d=count($a);
for ($b=0;$b<$d-1;$b++) {
//echo $b."\n";
$c=str_getcsv($a[$b]);
//echo $c."\n";
//echo "\nc:".$c[$id1]."\n";
if ($index==0) {}
else {//$npiarray=substr($a[$b],1,strpos($a[$b],",")-2)."+".$c[23]."-".$csf.",";
$hash[substr($a[$b],1,strpos($a[$b],",")-2)]=$c[23]."-".$csf;
}
$index++;
$csf+=strlen($a[$b])+1;
}
//if ($index>5) {exit;}
echo 100*($start/$fs1)." : ";
echo (time()-$n);
echo " : ";
if ($start>0) {echo (time()-$n)/(($start/$fs1))." : ";}
echo $start."\n";
$start=$csf;
}
$serializedData = serialize($hash);
file_put_contents($pwd."/medicaid_files/npidata_pfile_20050523-20260412.ser", $serializedData);
?>
