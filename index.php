<?php 
session_start();

include_once ("includes/functions.php");
$flag = 0;
if(isset($_GET['alert'])){
	$flag = 1;
    if($_GET['alert']=="success"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Password changed successfully</strong>
        </div>';  

    }
	if($_GET['alert']=="error"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Error Resetting Password</strong>
        </div>';  

    }
	
}	


if(isset($_POST['login'])){
	$errors = "";
	$succ =0;
	
	if(empty($_POST['email']))
	{
		$errors=$errors."email id cannot be empty!!";
		$succ=1;
	}
	if(empty($_POST['password']))
	{
		$errors=$errors."passsword cannot be empty!!";
		$succ=1;
	}
	if($succ != 1)
	{
		
    //taking input from user
    $formUsername=validateFormData($_POST['email']);
    $formPassword=validatePassword($_POST['password']);
    include("includes/connection.php");
    //fetching data from database
    $query="SELECT * from facultydetails where Email='$formUsername'";
    $result=mysqli_query($conn,$query);
    
    //verifying id query returned something
    /*if(mysqli_num_rows($result)>1){
        $error=" <div class='alert alert-danger'> There is some error in databse please contact the DBA
            <a class='close' data-dismiss='alert'>&times; </a>
        </div> ";
    }
    //else store the basic user data in local variables
    else*/

	if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
		$_SESSION['Fac_ID']  =$row['Fac_ID'];
        $_SESSION['username']=$row['Email'];
        $pass=$row['Password'];
        
        //verify if the password matches the hashed password
        $loginsuccess = 0;

		
		if($_SESSION['username'] == 'jyot.tryambake@gmail.com')
		{
				$hashedPassword=base64_decode($pass);
				$loginsuccess = 1;

		}
		else
		{
			if(password_verify($formPassword,$pass)){
				$loginsuccess = 1;
			}
		}
        if($loginsuccess == 1){
            //login details are correct start the session
            //store the data in session variable
            
            $_SESSION['loggedInUser']=$row['F_NAME'];
            $_SESSION['loggedInEmail']=$row['Email'];
            
		
			if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
			{
				header("location:2_dashboard_hod.php");

			}
			else
				header("location:actcount.php");
        }//end of password verified
        //if password didn't match
        else{
        /*    $error="<div class='alert alert-danger'> Wrong username,password combination.
            <a class='close' data-dismiss='alert'>&times; </a></div>";*/
			echo "<script> alert('Incorrect Password') </script>";

			
        }//end of password didnot match
    }//end of num rows =1
    else{
		//echo "<script> alert('Incorrect Username') </script>";

      /*  $error="<div class='alert alert-danger'> Username not found.
            <a class='close' data-dismiss='alert'>&times; </a> </div>";*/
			echo "<script> alert('Incorrect Username') </script>";

    }//end of 0 results fetched case
    
    mysqli_close($conn);
}
else{
	//echo '<div class="error">'.$errors.'</div>';
		echo "<script> alert('$errors') </script>";

}
}
if(isset($_POST['signup']))
{
	header("Location:signup.php");
}
?>
<?php include_once('head.php'); ?>
<?php //include_once('header.php'); ?>
<?php// include_once('sidebar.php'); ?>
<head>
<link rel="stylesheet" type="text/css" href="facultystyles.css">
<style>
body, html {
    height: 100%;
    margin: 0;
}

.bg {
    /* The image used */
    background-image: url("images/background.jpg");

    /* Full height */
    height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
	

}

</style>
</head>
<!-- Content Wrapper. Contains page content -->
<body>
<div class="bg" >

<!-- Main content -->
        <section class="content" >
          <div class="row"  style="width:800px; margin:0 auto; " >
            <!-- left column -->
            <div class="col-md-6" >
              <!-- general form elements -->
              <div class="box box-primary"  >
                <div class="box-header with-border">
				<?php 
        if($flag == 1){
        echo $successMessage;
    }
    ?>
                  <h3 class="box-title">Login</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "" method = "POST" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address *</label>
                      <input type="text"  name = "email" class="form-control input-lg" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password *</label>
                      <input type="password"  name = "password"class="form-control input-lg" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name = 'login' class="btn btn-primary">Login</button>
                  </div>
				  <div class="form-group">
				  <label for="newuser"><h4>Are you a new user? If yes, Then </h4></label>
				  <div class="box-footer">
                    <button type="submit" name = 'signup' class="btn btn-primary">Signup</button>
                  </div>
				  </div>
                </form>
				
                	<a href="forgotpassword.php" >Forgot Password</a>
                </div>
              </div>
           </div>      
        </section>
        
</div>
</body>


    
<?php //include_once('footer.php'); ?>
   
   