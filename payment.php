<?php

include 'dbconnect.php';
session_start();
$multipledate=array();
$value="";
$datecount=0;
$sql="SELECT * FROM kit2clean.dimservicesmast";
$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result)){

    // $serviceidarray[$row['servicecode']]=$row['serviceid'];
  
   if($row['servicedatemultiple']==1){
    array_push($multipledate,$row['servicecode']);

   }
   

}
?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $amount=$_POST['amount'];
  $servicecode=$_POST['service'];
 $date=$_POST['date'];
 $unit=$_POST['unit'];

    $totalamount=array_sum($amount);


    for($i=0;$i<count($servicecode);$i++){
        $servicecodevalue=$servicecode[$i];
        $unitvalue=$unit[$i];

        if(!in_array($servicecodevalue,$multipledate)){
          $sql="SELECT * FROM `kit2clean`.`dimservicesmast` WHERE servicecode='$servicecodevalue'";
          $result=mysqli_query($conn,$sql);
  
  
          while($row=mysqli_fetch_assoc($result)){
              
            $servicename=$row['servicename'];
  
          
            $value=$value.' <tr>
        
            <td>'.$servicename.'</td>
            <td>'. date("j M Y", strtotime($date[$datecount])).'</td>
          </tr>';
  
            
  
  
          }
          $datecount=$datecount+1;
        }
        else{
          
          $sql="SELECT * FROM `kit2clean`.`dimservicesmast` WHERE servicecode='$servicecodevalue'";
          $result=mysqli_query($conn,$sql);
          while($row=mysqli_fetch_assoc($result)){
              
            $servicename=$row['servicename'];
            $dates=$date[$datecount];
            $dates=date("j M Y", strtotime($dates));

  
          
            for($j=1;$j<$unitvalue;$j++){

           
            $datecount=$datecount+1;
            $dates=$dates.','. date("j M Y", strtotime($date[$datecount]));

  

  
            }
             
            $value=$value.' <tr>
          
            <td>'.$servicename.'</td>
            <td>'.$dates.'</td>
          </tr>';
          $datecount=$datecount+1;

  
            
  
  
          }

         



        }


        
       

        


    }

}


?>
      

<?php
function numberTowords($num)
{

$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
"014" => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
}
}
return $rettxt;
}
// extract($_POST);
// if(isset($convert))
// {
// echo "<p align='center' style='color:blue'>".numberTowords("1456")."</p>";
// }
?>







<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport"  content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="payment.css">
        <link rel="icon"  href="Logo.png" >
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title> Payment  </title>
    </head>
    <body>
        <section class="payment">
        <?php

if(isset($_SESSION['login']) ){
  $phonenumber=$_SESSION['user'];
  $customerid=$_SESSION['customerid'];

  $sql="SELECT * FROM `kit2clean`.`customermaster` where customerid='$customerid'";
  $result=mysqli_query($conn,$sql);

  while($row=mysqli_fetch_assoc($result)){
    $email=$row['cemailid'];
    $fname=$row['customername'];
    $flat=$row['cflatno'];
    $area=$row['carea'];
    $landmark=$row['clandmark'];
    $pincode=$row['cpincode'];
    $city=$row['ccity'];
    $state=$row['cstate'];
    



  }

  echo '
  
  <div class="header">
  <img src="Logo.png"  alt="kit2clean" class="header__logo" />
  <div class="header__text">
      <p> KIT2CLEAN-COMMUNITY PACKAGE   </p>

  </div>
  <div class="header__address">
  <ul class="list-group">
<li class="list-group-item active" aria-current="true">Address</li>
<li class="list-group-item">'.$flat.','.$area.',' .$landmark.',' .$city.',' .$state.',' .$pincode .'</li>

</ul>

  </div>
  <div class="header__information">
  <ul class="list-group">
<li class="list-group-item active" aria-current="true">Hello '.$fname.' ,</li>
<li class="list-group-item">+91'.$phonenumber.'</li>
<li class="list-group-item">'.$email.'</li>

</ul>

  </div>


</div>

<div class="amount">
<p class="amount__total"> Total Amount <span class="amount__int">RS. '.$totalamount.'</span></p>
<p  class="amount__word" >Rupees - '.numberTowords($totalamount).' ONLY</p>

</div>
  
  
  ';


}

?>

<div class="logos" >
    <img src="pics/attachments/gpay.png" alt="google pay" class="logos__logo" />
    <img src="pics/attachments/paytm.png" alt="paytm" class="logos__logo" />
    <img src="pics/attachments/phonepe.jfif" alt="phonepe" class="logos__logo phonepe" />

    <!-- <img src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8yIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjAiIHk9IjAiIHZpZXdCb3g9IjAgMCAxMzIgNDgiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxzdHlsZT4uc3Qwe2ZpbGw6IzVmMjU5Zn08L3N0eWxlPjxjaXJjbGUgdHJhbnNmb3JtPSJyb3RhdGUoLTc2LjcxNCAxNy44NyAyNC4wMDEpIiBjbGFzcz0ic3QwIiBjeD0iMTcuOSIgY3k9IjI0IiByPSIxNy45Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTkwLjUgMzQuMnYtNi41YzAtMS42LS42LTIuNC0yLjEtMi40LS42IDAtMS4zLjEtMS43LjJWMzVjMCAuMy0uMy42LS42LjZoLTIuM2MtLjMgMC0uNi0uMy0uNi0uNlYyMy45YzAtLjQuMy0uNy42LS44IDEuNS0uNSAzLS44IDQuNi0uOCAzLjYgMCA1LjYgMS45IDUuNiA1LjR2Ny40YzAgLjMtLjMuNi0uNi42SDkyYy0uOSAwLTEuNS0uNy0xLjUtMS41em05LTMuOWwtLjEuOWMwIDEuMi44IDEuOSAyLjEgMS45IDEgMCAxLjktLjMgMi45LS44LjEgMCAuMi0uMS4zLS4xLjIgMCAuMy4xLjQuMi4xLjEuMy40LjMuNC4yLjMuNC43LjQgMSAwIC41LS4zIDEtLjcgMS4yLTEuMS42LTIuNC45LTMuOC45LTEuNiAwLTIuOS0uNC0zLjktMS4yLTEtLjktMS42LTIuMS0xLjYtMy42di0zLjljMC0zLjEgMi01IDUuNC01IDMuMyAwIDUuMiAxLjggNS4yIDV2Mi40YzAgLjMtLjMuNi0uNi42aC02LjN6bS0uMS0yLjJIMTAzLjJ2LTFjMC0xLjItLjctMi0xLjktMnMtMS45LjctMS45IDJ2MXptMjUuNSAyLjJsLS4xLjljMCAxLjIuOCAxLjkgMi4xIDEuOSAxIDAgMS45LS4zIDIuOS0uOC4xIDAgLjItLjEuMy0uMS4yIDAgLjMuMS40LjIuMS4xLjMuNC4zLjQuMi4zLjQuNy40IDEgMCAuNS0uMyAxLS43IDEuMi0xLjEuNi0yLjQuOS0zLjguOS0xLjYgMC0yLjktLjQtMy45LTEuMi0xLS45LTEuNi0yLjEtMS42LTMuNnYtMy45YzAtMy4xIDItNSA1LjQtNSAzLjMgMCA1LjIgMS44IDUuMiA1djIuNGMwIC4zLS4zLjYtLjYuNmgtNi4zem0tLjEtMi4ySDEyOC42di0xYzAtMS4yLS43LTItMS45LTJzLTEuOS43LTEuOSAydjF6TTY2IDM1LjdoMS40Yy4zIDAgLjYtLjMuNi0uNnYtNy40YzAtMy40LTEuOC01LjQtNC44LTUuNC0uOSAwLTEuOS4yLTIuNS40VjE5YzAtLjgtLjctMS41LTEuNS0xLjVoLTEuNGMtLjMgMC0uNi4zLS42LjZ2MTdjMCAuMy4zLjYuNi42aDIuM2MuMyAwIC42LS4zLjYtLjZ2LTkuNGMuNS0uMiAxLjItLjMgMS43LS4zIDEuNSAwIDIuMS43IDIuMSAyLjR2Ni41Yy4xLjcuNyAxLjQgMS41IDEuNHptMTUuMS04LjRWMzFjMCAzLjEtMi4xIDUtNS42IDUtMy40IDAtNS42LTEuOS01LjYtNXYtMy43YzAtMy4xIDIuMS01IDUuNi01IDMuNSAwIDUuNiAxLjkgNS42IDV6bS0zLjUgMGMwLTEuMi0uNy0yLTItMnMtMiAuNy0yIDJWMzFjMCAxLjIuNyAxLjkgMiAxLjlzMi0uNyAyLTEuOXYtMy43em0tMjIuMy0xLjdjMCAzLjItMi40IDUuNC01LjYgNS40LS44IDAtMS41LS4xLTIuMi0uNHY0LjVjMCAuMy0uMy42LS42LjZoLTIuM2MtLjMgMC0uNi0uMy0uNi0uNlYxOS4yYzAtLjQuMy0uNy42LS44IDEuNS0uNSAzLS44IDQuNi0uOCAzLjYgMCA2LjEgMi4yIDYuMSA1LjZ2Mi40ek01MS43IDIzYzAtMS42LTEuMS0yLjQtMi42LTIuNC0uOSAwLTEuNS4zLTEuNS4zdjYuNmMuNi4zLjkuNCAxLjYuNCAxLjUgMCAyLjYtLjkgMi42LTIuNFYyM3ptNjguMiAyLjZjMCAzLjItMi40IDUuNC01LjYgNS40LS44IDAtMS41LS4xLTIuMi0uNHY0LjVjMCAuMy0uMy42LS42LjZoLTIuM2MtLjMgMC0uNi0uMy0uNi0uNlYxOS4yYzAtLjQuMy0uNy42LS44IDEuNS0uNSAzLS44IDQuNi0uOCAzLjYgMCA2LjEgMi4yIDYuMSA1LjZ2Mi40em0tMy42LTIuNmMwLTEuNi0xLjEtMi40LTIuNi0yLjQtLjkgMC0xLjUuMy0xLjUuM3Y2LjZjLjYuMy45LjQgMS42LjQgMS41IDAgMi42LS45IDIuNi0yLjRWMjN6Ii8+PHBhdGggZD0iTTI2IDE5LjNjMC0uNy0uNi0xLjMtMS4zLTEuM2gtMi40bC01LjUtNi4zYy0uNS0uNi0xLjMtLjgtMi4xLS42bC0xLjkuNmMtLjMuMS0uNC41LS4yLjdsNiA1LjdIOS41Yy0uMyAwLS41LjItLjUuNXYxYzAgLjcuNiAxLjMgMS4zIDEuM2gxLjR2NC44YzAgMy42IDEuOSA1LjcgNS4xIDUuNyAxIDAgMS44LS4xIDIuOC0uNXYzLjJjMCAuOS43IDEuNiAxLjYgMS42aDEuNGMuMyAwIC42LS4zLjYtLjZWMjAuOGgyLjNjLjMgMCAuNS0uMi41LS41di0xem0tNi40IDguNmMtLjYuMy0xLjQuNC0yIC40LTEuNiAwLTIuNC0uOC0yLjQtMi42di00LjhoNC40djd6IiBmaWxsPSIjZmZmIi8+PC9zdmc+" alt="phone pe" class="logos__logo" />
 -->



</div>

            <div class="detail">
            <table class="table table-bordered detail__table table-sm">
  <thead>
    <tr>
      <th scope="col">Services Availed</th>
      <th scope="col">Date/Monthly</th>
     
    </tr>
  </thead>
  <tbody>
  <?php

  echo $value;



?>
   
  </tbody>
</table>
<div class="buttons">
    <button  class="btn button__submit" >Submit </button>
    <a  class="btn button__cancel" href="cart.php" >cancel </a>
    <a  class="btn button__exit" href="home.php" >Exit </a>


</div>

            </div>
      

        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>


</html>