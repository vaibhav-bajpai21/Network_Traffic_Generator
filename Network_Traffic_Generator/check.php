<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
			function back() {
				window.location="home.html"
			}
		</script>
</head>
<body>
<input type="button" value="Back" onclick="back()" />
<br>
<?php

//echo "111";

$sip1= $_POST["sip"];
$dip1= $_POST["dip"];
$protocol1= $_POST["protocol"]; 

if ($protocol1=="tcp") {
//echo "tc1";
	$proto="tcp";
		}

else if ($protocol1=="udp") {
	$proto="udp";
		     }
else if ($protocol1=="icmp") {
	$proto="icmp";
		     }



$sapplication= $_POST["ssport"];
$dapplication= $_POST["ddport"];
$sport=$_POST["sport"];
$dport=$_POST["dport"];

$app=array("ftp"=>21,"ssh"=>22,"telnet"=>23,"dns"=>53,"mail"=>25,"voip"=>1719,"http"=>80,"https"=>443);

if($sapplication=="specify")
	$sapp_port=$sport;
else
	$sapp_port=$app[$sapplication];

if($dapplication=="dspecify")
	$dapp_port=$dport;
else
	$dapp_port=$app[$dapplication];




$num_pac1=$_POST["num_pac"];
$number= $_POST["nop"];
$counter=$number;

if($num_pac1=="cont")
{	
//echo "fish!!";
$counter=1;
$number=1;
}
else $counter=0;


$pa=$_POST["plength"];
if($pa=="min") 
        $payloadlength=8;
else if($pa=="max")
	$payloadlength=512;

else if ($pa=="define")
{
	$payloadlength= $_POST["len"];
}

$pgap1=$_POST['pgap'];

$poption= $_POST["rnd"];
if($poption=="spec")
{
	$poptype=$_POST["datatyp"];
	$pdetail=$_POST["payload"];
}




if($pdetail)
{
	//echo $pdetail;
	exec("sh -c 'echo $pdetail > payload.txt'");
	exec("sh -c 'echo  > packet.txt'");
		
	$file=fopen("payload.txt","r");

	   echo "$number $proto Packets send to port $dapp_port of $dip1";
		echo "<br>";
	while($number>=1)	
		{
			//echo $payloadlength;
			$i=0;
			$ofile=fopen("packet.txt","w");
		
			while($i<$payloadlength)	
			{
				
				if(feof($file))	
				{
					break;
				}
				$var=fgetc($file);
				fputs($ofile,$var);
				$i++;
			}
			//$data==`cat payload.txt`;
			$data=shell_exec("cat packet.txt");
			echo $data;
			if($poptype=="ascii")	
			{
				$pload="-f packet.txt";
			}
			if($poptype=="hex")	
			{
				$pload="-d0x$data";
				$pload=preg_replace('/\s+/','',$pload);
			}
			
			if($proto=="tcp")
			{
				//echo"hello";
				echo shell_exec("sendip -p ipv4 -is $sip1 -p $proto -ts $sapp_port -td $dapp_port -d \"$pdetail\" -v $dip1");
				echo"<br>";
			}
			else if($proto=="udp")
			{
				echo shell_exec("sendip -p ipv4 -is $sip1 -p $proto -us $sapp_port -ud $dapp_port -d $pdetail -v $dip1");
echo"<br>";
			}
			else	
			{
				//echo"icmppppppp";
				echo shell_exec("sendip -p ipv4 -is $sip1 -p icmp -d \"$pdetail\" -v $dip1");
				echo"<br>";	
			}
			
			usleep($pgap1);
			if($counter==0)
				$number--;
			fclose($file);
			fclose($ofile);
		}



}

else	
{
	$pdetail="Prashant";
	//echo "<br>$pdetail<br>";
	while($number>=1)	
	{
		if($proto=="tcp")
			{
				//echo"hello";
				echo shell_exec("sendip -p ipv4 -is $sip1 -p $proto -ts $sapp_port -td $dapp_port -d \"$pdetail\" -v $dip1");
				echo"<br>";
			}
			else if($proto=="udp")
			{
				echo shell_exec("sendip -p ipv4 -is $sip1 -p $proto -us $sapp_port -ud $dapp_port -d \"$pdetail\" -v $dip1");
				echo"<br>";
			}
			else	
			{
				//echo"icmppppppp";
				echo shell_exec("sendip -p ipv4 -is $sip1 -p icmp -d \"$pdetail\" -v $dip1");
				echo"<br>";	
			}
			usleep($pgap1);
			if($counter==0)
				{$number--;}
	}
}
	


//echo $sip1;



 ?>

		
</body>
</html>
