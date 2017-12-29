
<?php
ob_start();
session_start();
?>
<?php include_once('head.php'); ?>


<head>

<style>
input{
border-radius:5px;
 
}


input[type='text'] {
  width:300px;
height:30px 
}
input[type='email'] {
  width:300px;
height:30px 
}
input[type='password'] {
  width:300px;
height:30px 
}
.pagedesign{
	font-weight:bold;
	font-size:1.1em;
	margin-top:5px;
	margin-right:5px;
}
.error
{
	color:red;
	border:1px solid red;
	background-color:#ebcbd2;
	border-radius:10px;
	margin:3px;
	padding:5px;
	font-family:Arial, Helvetica, sans-serif;
	width:500px;
}

.noerror
{
	color:green;
	border:1px solid green;
	background-color:#d7edce;
	border-radius:10px;
	margin:3px;
	padding:5px;
	font-family:Arial, Helvetica, sans-serif;
	width:500px;
	height:40px;
}
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
<?php
$result='';
$success=0;
$flag=0;
if(isset($_POST['sign']))
{
if(empty($_POST['fn']))
{
$result=$result."Faculty name cannot be empty<br>";
$flag=1;
}
if(is_numeric($_POST['fn']))
{
	$result=$result."Faculty name cannot contain numbers<br>";
	$flag=1;
}
if(empty($_POST['em']))
{
	$result=$result."Email id is neccessary<br>";
	$flag=1;
}
if(empty($_POST['mobile']))
{
	$result=$result."Mobile number cannot be empty<br>";
	$flag=1;
}
if(empty($_POST['pass']))
{
	$result=$result."Password cannot be empty<br>";
	$flag=1;
}
if(!empty($_POST['em']))
{

if (!filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))
	{
      $result= $result."Invalid Email<br>"; 
	  $flag=1;
}
}

if(!empty($_POST['mobile']))
{
if(strlen($_POST['mobile'])!=10 || !preg_match('/^[0-9]{10}+$/', $_POST['mobile']))
	{
		$result= $result."Invalid Mobile Number<br>"; 
	  $flag=1;
	}
}
if(!empty($_POST['pass']) && !empty($_POST['pass2']))
{
	if(strcmp($_POST['pass'],$_POST['pass2'])!=0)
	{
		$result= $result."Passwords do not match , Please Re enter<br>"; 
	  $flag=1;
	}
}
if(!empty($_POST['pass']))
{
	if(empty($_POST['pass2']))
	{
		$result= $result."Please Confirm Passwords<br>"; 
	  $flag=1;
	}
}

include_once("includes/connection.php");

if($flag!=1)
{

	$fname=test_input($_POST['fn']);
	$eid=test_input($_POST['em']);
	$mob=test_input($_POST['mobile']);
	$pass=$_POST['pass'];
	
	if($eid == 'jyot.tryambake@gmail.com')
	{
		$hashPassword = base64_encode($pass);
	}
	else
	{
		$options = array("cost"=>4);
		$hashPassword = password_hash($pass,PASSWORD_BCRYPT,$options);
	}
	
$sql="INSERT INTO facultydetails(F_NAME,Mobile,Email,Password) values('$fname','$mob','$eid','$hashPassword')";
if(mysqli_query($conn,$sql))
{
		

	echo '<script> alert("Sign Up successful") </script>';
	$success=1;
}
else{	
echo '<div class="error">'.mysqli_error($conn).'</div>';
//echo '<script> alert("Error, Try  again ") </script>';
}
	


}

if($success==1)
{
	header("Location:index.php");
}

}

if(isset($_POST['cancel']))
{
	header("Location:index.php");
}

?>

<body>
<div class="bg" >

<!-- Content Wrapper. Contains page content -->

<!-- Main content -->
        <section class="content">
          <div class="row" style="width:800px; margin:0 auto; ">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sign Up</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				 <form role="form" action="" method="post">
				     
				
						Enter your name :<input type="text" placeholder="FirstName  MiddleName  LastName" name="fn" value="<?php if(isset($_POST['sign']) && $flag==1){echo $_POST['fn'];} ?>">
						<br><br>

 					Email ID(Enter somaiya id) :<input type = "email" placeholder="Email id" name = "em"  value="<?php if(isset($_POST['sign']) && $flag==1){echo $_POST['em'];} ?>" ><br><br>
					<div class="input-group paddingTop chwidth">
					Mobile Number :
					<span class="input-group-addons">+91</span><input type = "text" placeholder="Mobile number" name = "mobile"  value="<?php if(isset($_POST['sign']) && $flag==1){echo $_POST['mobile'];} ?>" >
						
					</div>
					<br>
					Password : <input type="password" id="pwinput" placeholder="Password" name="pass"  value="<?php if(isset($_POST['sign']) && $flag==1){echo $_POST['pass'];} ?>"> &nbsp;&nbsp;<input type="checkbox" id="pwcheck" />Show Password <br><span id="pwtext"></span><br><br>
					Confirm Password : <input type="password" placeholder="Confirm Password" name="pass2"  value="<?php if(isset($_POST['sign']) && $flag==1){echo $_POST['pass2'];} ?>">
					<br><br>
					<input type = "submit" class = "btn btn-primary"  value = "Sign Up" name = "sign">
					<input type = "submit" class = "btn btn-primary"  value = "Cancel" name = "cancel">
					
					<br><br>
					
                </div>
              </div>
			  <?php
		if($flag==1)
			{
				echo '<div class="error">'.$result.'</div>';
			}
						
				?>

             </div>
            </div>
          </section>
                
		</div> 
 </body>
<?php
function test_input($data)
{
	$data=trim($data);
	$data=stripslashes($data);
	$data=htmlspecialchars($data);
	
	return $data;
}
echo '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
$(document).ready(function(){

    $("#pwinput").focus();

    $("#pwcheck").click(function(){
        var pw = $("#pwinput").val();
        if ($("#pwcheck").is(":checked"))
        {
            $("#pwtext").text(pw);
        }
        else
        {
            $("#pwtext").text("");
        }

    });
});
</script>';

?>
<?php






?>


   

