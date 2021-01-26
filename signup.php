<?php
include 'dbconnect.php';
$already=false;

?>
<?php


if(isset($_REQUEST['createaccount'])){
   $otp=$_REQUEST['otp'];
   $email=$_REQUEST['email'];

   $sql="SELECT * FROM `kit2clean`.`customermaster` where `cemailid`='$email' ";
   $result=mysqli_query($conn,$sql);

   while($row=mysqli_fetch_assoc($result)){
       $cotp=$row['cotp'];
       $custid=$row['customerid'];
       if($cotp==$otp){
        $sql="UPDATE `kit2clean`.`customermaster` SET `cemailverify` = '1' WHERE (`customerid` = '$custid')";
        $result=mysqli_query($conn,$sql);
        header('location:accountcreation.php?id='.$custid.'');

       }
   }






}




?>


<?php


if($_SERVER['REQUEST_METHOD']=="POST" and isset($_REQUEST['continue'])){
    $yname=$_REQUEST['yname'];
    $email=$_REQUEST['email'];
    $password=$_REQUEST['password'];
    $mobilenumber=$_REQUEST['mobilenumber'];
    $randomOtp = rand(1000, 9999);

    $sql="SELECT * FROM `kit2clean`.`customermaster` where `cemailid`='$email'";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)<1){
        $sql="INSERT INTO `kit2clean`.`customermaster` (`customername`, `cphonenumber`, `cemailid`, `cpassword`, `cotp`, `cemailverify`) VALUES ('$yname', '$mobilenumber', '$email', '$password', '$randomOtp', '0') ";
        $result=mysqli_query($conn,$sql);
    
          
        
        $to=$email;
        $subject = "Opt Verification for new user signup";
       
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        </head>
        <body>
        
            <div >
                
                
               <h1> Dear Sir, </h1>
        <p>  We have received a notification for adding you as a new user for singup on www.1head.com. If this is correct please enter the following code  <b style="font-size:18px;">  ' . $randomOtp . ' </b> in the login page. If you are not the right contact please ignore this email.</p>
       
    
        <p>Thanks <br>1Head  </p> 
            </div>
        
        
    
    
        </body>
        </html>
        
        
        
        
        
        
        ';
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From:user 1Head KDS kalpitjindal29@gmail.com';
       
        
        if (mail($to, $subject, $message, $headers)) {
            $gotp=$randomOtp;
            $small="";
        }

    }
    else{
        $already=true;
    }
    

   
}


if(isset($_REQUEST['resendbtn'])){
    $email=$_REQUEST['email'];
    $randomOtp = rand(1000, 9999);

      
    $sql="UPDATE `kit2clean`.`customermaster` SET `cotp` = '$randomOtp' WHERE (`cemailid` = '$email')";
    $result=mysqli_query($conn,$sql);

      
    
    $to=$email;
    $subject = "Opt Verification for new user signup";
   
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
    
        <div >
            
            
           <h1> Dear Sir, </h1>
    <p>  We have received a notification for adding you as a new user for singup on www.1head.com. If this is correct please enter the following code  <b style="font-size:18px;">  ' . $randomOtp . ' </b> in the login page. If you are not the right contact please ignore this email.</p>
   

    <p>Thanks <br>1Head  </p> 
        </div>
    
    


    </body>
    </html>
    
    
    
    
    
    
    ';
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From:user 1Head KDS kalpitjindal29@gmail.com';
   
    
    if (mail($to, $subject, $message, $headers)) {
        $gotp=$randomOtp;
        $small="A new code has been sent to your email";
    }




}




?>
<!Doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="Logo.png">
    <link rel="stylesheet" href="signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>
        Signup
    </title>

</head>

<body>
    <section class="signup">
        <div class="header">
            <img src="Logo.png" alt="kittu" class="header__logo" />
            <div class="header__text">
                <h3> KIT2CLEAN </h3>
                <h2>HOME PACKAGE </h2>
            </div>

        </div>
        

        <?php
        if($already){
            echo '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Alreadt Exist!</strong> You should try with another email account.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
            
            ';
        }

 if(!isset($gotp)){
     echo '
     <div class="createaccount shadow">
            <form  action="signup.php" method="post" >
            <h4 class="createaccount__text"> Create Account </h4>
            <div class="createaccount__input">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Your Name</label>
                    <input type="text" class="form-control"   name="yname"  required>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2"  class="form-label">Email</label>
                    <input type="email" class="form-control" id="email"  name="email"  required>
                    <small class="invalid-feedback">Enter a  Valid Email</small>

                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control"   name="mobilenumber" id="mobilenumber"  required >
                    <small class="invalid-feedback">Mobile number must be 10 digits only </small>

                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Password</label>
                    <input type="password" class="form-control " id="password" autocomplete="off" name="password"  required>
                    <small class="invalid-feedback">* Password must be at least 6 characters</small>

                </div>
            </div>

            <div class="createaccount__buttons">
                <button  class="btn btn-light" name="continue">Continue</button>

            </div>

        </form>
        </div>
     
     
     
     ';
 }       




elseif(isset($gotp)){
    echo '
    <div class="verifyemail">
    <form action="signup.php" method="post" >
            <h4 class="verifyemail__text"> Verify email Address </h4>
            <p class="verifyemail__ptext"> To verify your email, we\'ve sent a One Time Password (OTP) to
                '.$email.'<a class="btn btn-link" id="change">(Change) </button> </a>
            <div class="createaccount__input">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Enter OTP</label>
                    <input type="hidden"  name="email" value="'.$email.'">
                    <input type="text" class="form-control" id="formGroupExampleInput" autocomplete="off"  name="otp"  required>
                    <small class="small__text" > '.$small .'</small>
                    
                </div>

            </div>


            <div class="verifyemail__buttons">
                <button class="btn btn-light" name="createaccount"   >Create your account</button>

            </div>

            <p class="verifyemail__ptext2">
                By creating an account, you agree to Kit2Clean\'s Conditions of Use and Privacy Notice.
            </p>

            <button  class="verifyemail__anchor  btn btn-link" name="resendbtn" id="resendbtn"> Resend OTP </button>

            <p class="verifyemail__ntext">
                Note: If you didn\'t receive our verification email
                <br>
                confirm that your email address was entered correctly above.
                <br>
                Check your spam or junk email folder.

            </p>
            </form>
        </div>
    
    ';

}






         ?>










        




    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script>
    var change=document.getElementById('change');
    change?.addEventListener('click',()=>{
        window.history.back();
    })
    var password=document.getElementById('password');
    var email=document.getElementById('email');
    var mobilenumber=document.getElementById('mobilenumber');

    password?.addEventListener('input',()=>{
        var regex = /^.{6,}$/;
        if(regex.test(password.value)){
            if(password.classList.contains('is-invalid')){
                password.classList.remove('is-invalid');
                password.classList.add('is-valid');

            }
        }
        else{
            password.classList.add('is-invalid');

        }


    })


    email?.addEventListener('input',()=>{
        var regex = /^([0-9a-zA-Z_\-\.]+)@([0-9a-zA-Z_\-\.]+)\.([a-zA-Z]){2,5}$/;

        if(regex.test(email.value)){
            if(email.classList.contains('is-invalid')){
                email.classList.remove('is-invalid');
                email.classList.add('is-valid');

            }
        }
        else{
            email.classList.add('is-invalid');

        }


    })

    mobilenumber?.addEventListener('input',()=>{
        var regex = /^[0-9]{10}$/;
        if(regex.test(mobilenumber.value)){
            if(mobilenumber.classList.contains('is-invalid')){
                mobilenumber.classList.remove('is-invalid');
                mobilenumber.classList.add('is-valid');

            }
        }
        else{
            mobilenumber.classList.add('is-invalid');

        }


    })

   

    </script>

</body>





</html>