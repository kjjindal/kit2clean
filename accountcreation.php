<?php
include 'dbconnect.php';
?>


<?php

if($_SERVER['REQUEST_METHOD']=="POST" and $_GET['id'] ){
    $fname=$_REQUEST['fname'];
    $mobilenumber=$_REQUEST['mobilenumber'];
    $landmark=$_REQUEST['landmark'];
    $pincode=$_REQUEST['pincode'];
    $tcity=$_REQUEST['tcity'];
    $fhbca=$_REQUEST['fhbca'];
    $acssv=$_REQUEST['acssv'];
    $spr=$_REQUEST['spr'];
    $custid=$_GET['id'];



    $sql="UPDATE `kit2clean`.`customermaster`  SET `cpincode`='$pincode',`cflatno`='$fhbca',`carea`='$acssv',`clandmark`='$landmark', `ccity`= '$tcity', `cstate`='$spr' WHERE `customerid`='$custid' ";
    $result=mysqli_query($conn,$sql);

    if($result){
        header('location:home.php');
    }




}

if(isset($_GET['id'])){
    $custid=$_GET['id'];

    $sql="SELECT * FROM `kit2clean`.`customermaster` where customerid='$custid' ";
    $result=mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($result)){
        $fname=$row['customername'];
        $mobilenumber=$row['cphonenumber'];
    }
}


?>
<!Doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="Logo.png">
    <link rel="stylesheet" href="accountcreation.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>
        Account Creation
    </title>

</head>

<body>
    <section class="accountcreation">
        <div class="header">
            <img src="Logo.png" alt="kittu" class="header__logo" />
            <div class="header__text">
                <h3>KIT2CLEAN</h3>
                <h4> HOME PACKAGE</h4>

            </div>

        </div>
        <div class="accountcreation__addresslabel">

        <h2 class="accountcreation__haddress"> Add Address  </h2>

        </div>
        <?php 

        if(isset($_GET['id'])){
            echo '
            <form action="accountcreation.php?id='.$custid.'" method="post" >
        
        <div class="accountcreation__addressinputbox">
        <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Full name (First and Last name)</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" autocomplete="off" name="fname" value="'.$fname.'"  readonly >
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" autocomplete="off" name="mobilenumber" value="'.$mobilenumber.'"  readonly >
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Pin Code</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" autocomplete="off" name="pincode">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Flat, House no., Building, Company, Apartment</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" autocomplete="off" name="fhbca">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Area, Colony, Street, Sector, Village</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" autocomplete="off" name="acssv">
                </div>
               
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Landmark</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" autocomplete="off" name="landmark">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Town / City</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" autocomplete="off" name="tcity">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">State / Province / Region</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" autocomplete="off" name="spr">
                </div>
              <div class="accountcreation__buttons">
                <button  class="btn ">Add Address</button>
                </div>
        
                 </div> 
                </form>
              

                
            
            
            ';
        }
        


    ?>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

</body>





</html>
