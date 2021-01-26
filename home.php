<?php

include 'dbconnect.php';


?>
<?php


if($_SERVER['REQUEST_METHOD']=="POST"){
    $email=$_REQUEST['email'];
    $passcode=$_REQUEST['passcode'];

    $sql="SELECT * FROM  `kit2clean`.`customermaster` where cemailid='$email' and cpassword='$passcode'";
    $result=mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($result)){
        $phonenumber=$row['cphonenumber'];
        $customerid=$row['customerid'];


    }

    
    if(mysqli_num_rows($result)==1){
        session_start();
        $_SESSION["user"] = $phonenumber;
        $_SESSION['customerid']=$customerid;
        $_SESSION['login']=true;
        header('location:addservices.php');

    }
}




?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="Logo.png">
    <link rel="stylesheet" href="home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>
        Home
    </title>
</head>

<body>
    <section class="home">
        <div class="home__header">
            <img src="Logo.png" alt="kittu data" class="home__logo">
            <div class="home__text">
                <p class="home__textp1" > KIT2CLEAN </p>
                <p class="home__textp2">COMMUNITY  PACAKGE </p>

            </div>


        </div>
         <form action="home.php" method="post">
        <div class="home__listandsigninbox">
        <div class="card">
                <div class="card-body">
                    An exclusive website that offers the below list of services on a ONETIME or SUBSCRIPTION basis; <br>
                    The services offered are :-<br>
                    Landscaping and Gardening, <br>
                    Maids & Drivers (Temp / Per day only), <br>
                    Car Cleaning,<br>
                    Tank/Sump Cleaning, <br>
                    Pre-Movein Cleaning, <br>
                    Deep Cleaning, <br>
                    Glass Facade Cleaning, <br>
                    Dog Walkers,<br>
                    Motor Emergencies, <br>
                    Elder Care, <br>
                    Local Assistant etc...                </div>
            </div>



            <div class="home__signin">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control from-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" name="email">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Passcode" autocomplete="off" name="passcode">
                    <label for="floatingPassword">Passcode</label>
                </div>
                <div class="home__buttons">
                <button  class="btn btn-light">Sign-in</button>
                <a href="signup.php" class="btn btn-light" >sign-up</a>
                <button type="button" class="btn btn-light">Forgot Passcode</button>
                </div>
                <div class="home__image">
            <img src="pics/attachments/1.jpg"  alt="kit2clean" >
            <img src="pics/attachments/2.jpg"  alt="kit2clean">
            <img src="pics/attachments/3.jpg"  alt="kit2clean">
            <img src="pics/attachments/4.jpg"  alt="kit2clean">
            <img src="pics/attachments/5.jpg"  alt="kit2clean">
            <img src="pics/attachments/6.jpg"  alt="kit2clean">
            <img src="pics/attachments/7.jpg"  alt="kit2clean">
            <img src="pics/attachments/8.jpg"  alt="kit2clean">
            <img src="pics/attachments/9.jpg"  alt="kit2clean">
            <img src="pics/attachments/10.jpg" alt="kit2clean">
            <img src="pics/attachments/11.jpg" alt="kit2clean">




        </div>

            </div>
            
       


        </div>

        </form>




    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

</body>


</html>