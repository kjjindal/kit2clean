<?php

use function PHPSTORM_META\type;

include 'dbconnect.php';
session_start();
$value="";
$multipledate=array();
$serviceidarray=array();
$custoarray=array();


?>
<?php

$sql="SELECT * FROM kit2clean.dimservicesmast";
$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result)){

    $serviceidarray[$row['servicecode']]=$row['serviceid'];
  
   if($row['servicedatemultiple']==1){
    array_push($multipledate,$row['servicecode']);

   }
   

}






?>

<?php


if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['payment'])){
  $date=$_POST['date'];
  $amount=$_POST['amount'];
  $unit=$_POST['unit'];
  $servicecode=$_POST['service'];
  $customerid=$_SESSION['customerid'];

  $totalamount=array_sum($amount);
  $countservice=count($servicecode);


  $sql="INSERT INTO `kit2clean`.`customertransactionmaster` (`customerid`, `countofservices`, `totalserviceamount`, `discountcoupon`, `totalserviceamountafterdiscount`) VALUES ('$customerid', '$countservice', '$totalamount','0', '$totalamount')";
  $result=mysqli_query($conn,$sql);



  





   for ($i=0;$i<$countservice;$i++){
     $serviceidvalue=$serviceidarray[$servicecode[$i]];
     
     $sql="SELECT customertransactionmasterid FROM kit2clean.customertransactionmaster ORDER BY customertransactionmasterid DESC LIMIT 1";
     $result=mysqli_query($conn,$sql);

     while($row=mysqli_fetch_assoc($result)){
       $customertransactionmasterid=$row['customertransactionmasterid'];
     }

  $sql="INSERT INTO `kit2clean`.`customertransactiondetails` (`customertransactionmasterid`, `tran_noofunits`, `tran_serviceamount`, `servicedetailsid`) VALUES ('$customertransactionmasterid', '$unit[$i]', '$amount[$i]', '$serviceidvalue')";

  $result=mysqli_query($conn,$sql);
  


   }
   $j=0;
   $l=0;

  //  for ($j=0;$j<$countservice;$j++){
     while($j<$countservice){

    $servicecodevalue=$servicecode[$j];
    $sql="SELECT * FROM kit2clean.customertransactiondetails where customertransactionmasterid='$customertransactionmasterid'";
    $result=mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($result)){

      array_push($custoarray,$row['customertransactionsid']);


    }



    if(in_array($servicecodevalue,$multipledate)){


      for ($k=0;$k<$unit[$j];$k++){
        // echo "multidate". $date[$l]."<br>";
        $servicedatemul=$date[$l];
        $sql="INSERT INTO `kit2clean`.`customertransactiondate` (`customertransactionsid`, `tran_noofunits_total`, `tran_unit_serial_count`, `tran_unit_serial_date`) VALUES ('$custoarray[$j]', '$unit[$j]', '$k', '$servicedatemul')"; 
        $result=mysqli_query($conn,$sql);
        $l=$l+1;
       
        
      }

       



    }
    else{
      // echo "singledate".$date[$l]."<br>";

      $servicedate=$date[$l];
      $sql="INSERT INTO `kit2clean`.`customertransactiondate` (`customertransactionsid`, `tran_noofunits_total`, `tran_unit_serial_count`, `tran_unit_serial_date`) VALUES ('$custoarray[$j]', '1', '1', '$servicedate')"; 
      $result=mysqli_query($conn,$sql);
     
      $l=$l+1;
      
    }
    $j=$j+1;



   }



 header('location:home.php');












  
  
  
}



?>


<?php

if($_SERVER['REQUEST_METHOD']=="POST" and  !isset($_POST['payment']) ){
  $TNKCLE=$_POST['TNKCLE'];
  $GARDEN=$_POST['GARDEN'];
  $MAIDTE=$_POST['MAIDTE'];
  $DRIVLO=$_POST['DRIVLO'];
  $DRIVOU=$_POST['DRIVOU'];
  $CARCLE=$_POST['CARCLE'];
  $GLACLE=$_POST['GLACLE'];
  $DOGWLK=$_POST['DOGWLK'];
  $TYRECH=$_POST['TYRECH'];
  $BATTJU=$_POST['BATTJU'];
  $FUELFI=$_POST['FUELFI'];
  $SANITI=$_POST['SANITI'];
  $HELP2K=$_POST['HELP2K'];
  $ELDDIG=$_POST['ELDDIG'];
  $ELDDAY=$_POST['ELDDAY'];
  $DEPCLE=$_POST['DEPCLE'];
  $PRECLR=$_POST['PRECLR'];
  $BTHCLE=$_POST['BTHCLE'];
}

?>


<?php


if($_SERVER['REQUEST_METHOD']=="POST" and  !isset($_POST['payment']) ){
// $sql="SELECT * FROM kit2clean.dimservicesdetails ";
$sql="select
 k.serviceid,unit,unitprice,minimumunitqty,servicedetaildescription,k.servicecode,servicename

 from kit2clean.dimservicesdetails d inner join kit2clean.dimservicesmast k where d.serviceid=k.serviceid

";
$result=mysqli_query($conn,$sql);
$tableamount=0;
$unitcount=0;

while($row=mysqli_fetch_assoc($result)){
  $servicecode=$row['servicecode'];
  $unit=$row['unit'];
  $unitprice=$row['unitprice'];
  $minimumunitqty=$row['minimumunitqty'];
  $minimumamount=(int)explode(" ",$minimumunitqty)[0];
  $servicedetaildescription=$row['servicedetaildescription'];
  $servicename=$row['servicename'];
  $tableamount=$tableamount+(int)$$servicecode*$unitprice;
  $unitcount=$unitcount+(int)$$servicecode;
  
$tdrow=(in_array($servicecode,$multipledate) ? str_repeat('<input type="date" name="date[]">',(int)$$servicecode) :'<input type="date" name="date[]">' );
  
  $onerow=($$servicecode!=0 ? '
  <tr>
    <th scope="row" class="cart__th" > - </th>
    <td>'.$servicename.'</td>
    <td><input type="hidden"  name="service[]" value="'.$servicecode.'"><input value='.($$servicecode>0?$$servicecode:0).' name="unit[]" readonly ></td>
    <td><input value='.(int)$$servicecode*$unitprice.' name="amount[]" readonly></td>
    <td>'.$tdrow.'</td>
  </tr>
  
  ':null    );
 
  
$value=$value.$onerow;


}

}

  ?>


<!DOCTYPE html>
<html>
<head>
<title> Cart </title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


</head>
<body>
    <section class="cartpage">
    <form action="payment.php" method="post">

    <?php

if(isset($_SESSION['login']) and !isset($_POST['payment'])   ){
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
        <img src="Logo.png" alt="kittu" class="header__logo" />
<div class="header__text">
<p> KIT2CLEAN - HOME PACKAGE  </p>
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
   
   
   
   ';


 echo '
        
        <div class="cart">
        <table class="table table-bordered table-sm table__left">
<thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Select the Services</th>
      <th  colspan="3">Rate</th>
    
    </tr>
  </thead>';  


  echo '<tbody>
  <tr>
    <th scope="row"></th>
    <td> </td>
    <td>No of Units</td>
    <td>Amount</td>
    <td>Service Date</td>
  
  
  </tr>
  '.$value.'
  
  <tr>
  <td></td>
  <td class="text-end">Total Amount </td>
  <td>'.$unitcount.' </td>
  <td>'.$tableamount.' </td>
  
  
  </tr>
  
  </tbody>
  </table>


        </div>
        <div class="cart__buttons">

          <button class="btn btn-success button__payment" name="payment">Payment </button>
          <a class="btn btn-warning button__cancel"  href="home.php">Cancel </a>
          <a class="btn btn-danger button__exit" href="home.php">Exit </a>

        </div>
  
  
  ';

}

?>





    </form>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script>

      var minuses=document.getElementsByClassName('cart__th');


      for(minus of minuses){
          minus.addEventListener('click',(e)=>{
            
            e.target.parentElement.remove();



      })
      }
    



</script>
</body>

</html>


