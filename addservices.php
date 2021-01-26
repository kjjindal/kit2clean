<?php
include 'dbconnect.php';
session_start();
$value="";
$tvalue="";


?>
<?php

// $sql="SELECT * FROM kit2clean.dimservicesdetails ";
$sql="select
 k.serviceid,unit,unitprice,minimumunitqty,servicedetaildescription,k.servicecode,servicename

 from kit2clean.dimservicesdetails d inner join kit2clean.dimservicesmast k where d.serviceid=k.serviceid

";
$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result)){
  $servicecode=$row['servicecode'];
  $unit=$row['unit'];
  $unitprice=$row['unitprice'];
  $minimumunitqty=$row['minimumunitqty'];
  $minimumamount=(int)explode(" ",$minimumunitqty)[0];
  $servicedetaildescription=$row['servicedetaildescription'];
  $servicename=$row['servicename'];
  
  $value=$value.'
  <tr class="table__leftRow" >
      <th scope="row"><div>
  <input class="form-check-input" type="checkbox"  value="'.$servicecode.'" aria-label="...">
</div></th>
      <td>'.$servicename.'</td>
      <td>'.$unit.'</td>
      <td>'.$unitprice.' '.$unit.'</td>
      <td>'.$minimumunitqty.'</td>
      <td>'.$minimumamount*$unitprice.'</td>

    </tr>
  ';

  $tvalue=$tvalue. '<tr>
  <td><input type="number" class="table__rightInput" name="'.$servicecode.'" id="'.$servicecode.'"  min="'.$minimumamount.'" price="'.$unitprice.'" readonly></td>
  <td class="singleamount">0</td>
  
</tr>';



}




?>


<!DOCTYPE html>
<html>

<head>
    <title> Add Services </title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="Logo.png">
    <link rel="stylesheet" href="addservices.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>
<section class="addservices">
<form class="addservices__form"  method="post" action="cart.php" >  

<?php

if(isset($_SESSION['login'])){
  $phonenumber=$_SESSION['user'];

  $sql="SELECT * FROM `kit2clean`.`customermaster` where cphonenumber='$phonenumber'";
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

  echo '<div class="header">
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
<div class="header__package">
<ul class="list-group">
  <li class="list-group-item active" aria-current="true">Package</li>
  <li class="list-group-item">Cart promocode</li>
  
</ul>
</div>

</div>';

}

?>

<div class="services">

<table class="table table-bordered table-sm table__left">
<thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Select the Services</th>
      <th  colspan="4">Rate</th>
    
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"></th>
      <td> </td>
      <td>Unit </td>
      <td>Unit Rate</td>
      <td>Min</td>
      <td>Amount</td>

    </tr>
    <?php


echo $value;



?>
    
   
  </tbody>
  
</table>
<table class="table table-sm table-bordered  table__right">
  <thead>
    <tr>
      <th scope="col">Total Amt:</th>
      <th scope="col" id="totalamount" >0</th>
     
    </tr>
  </thead>
  <tbody>
    <tr>
    
      <td>No of Units</td>
      <td>Bill Amt</td>
    </tr>
    <?php

    echo $tvalue;


?>
  
  </tbody>
</table>

</div>


<div class="services__buttons">
  <button class="btn btn-light" name="cart"  > Add 2 Cart  </button>

</div>

</form>


</section>








    
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
                crossorigin="anonymous">
            </script>
            <script>

            var checks=document.getElementsByClassName('form-check-input');

            

            for (check of checks){
              check.addEventListener('click',(e)=>{
                
                 if(e.target.checked==true){
                     var v=e.target.value;
                var input=document.getElementById(v);
                input.readOnly=false; 
                input.style.borderColor="black";
                input.focus();
                
                 }
                 else{
                  var v=e.target.value;
                var input=document.getElementById(v);
                input.readOnly=true; 
                input.value="";
                input.style.borderColor="lightgray";

              


                 }

               
              

              

              })

            }




            var inputs=document.getElementsByClassName('table__rightInput');
            var totalamount=document.getElementById('totalamount');
          

            for (input of inputs){
              input.addEventListener('input',(e)=>{
                 
              var  b=e.target.parentElement.parentElement.children[1];
              var value=e.target.value;
              var unit=e.target.getAttribute('price')
              b.innerText=value*unit; 

              totalamount.innerText=total();
      
            
             

              })




              


            }


            function total(){
              var total=0;
              var singleamount=document.getElementsByClassName('singleamount');

              for(single of singleamount){
              var total=total+Number(single.innerText);

              }
              return total;




            }

           



            
         


              </script>
</body>

</html>