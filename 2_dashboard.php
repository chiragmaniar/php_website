<?php
session_start();
if(!isset($_SESSION['loggedInUser'])){
    //send them to login page
    header("location:index.php");
}
//connect to database
include("includes/connection.php");
$fid = $_SESSION['Fac_ID'];
//query and result
$query = "SELECT * FROM faculty where Fac_ID ='".$_SESSION['Fac_ID']."' ;";
$result = mysqli_query($conn,$query);
$successMessage="";
if(isset($_GET['alert'])){
    if($_GET['alert']=="success"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record added successfully</strong>
        </div>';  

    }
    elseif($_GET['alert']=="update"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record updated successfully</strong>
        </div>';  

    }
    elseif($_GET['alert']=="delete"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Record deleted successfully</strong>
        </div>';  

    }
}
?>





<?php include_once('head.php'); ?>
<?php include_once('header.php'); ?>
<?php 
if($_SESSION['username'] == 'hodextc@somaiya.edu')
  {
	    include_once('sidebar_hod.php');

  }
  else
	  include_once('sidebar.php');
 ?>

<style>
div.scroll
{
overflow:scroll;

}


</style>



<div class="content-wrapper">
    <?php 
        {
        echo $successMessage;
    }
    ?>
    <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h2 class="box-title">Paper Publication/Presentation</h2>
                </div><!-- /.box-header -->
                <div class="box-body">
				<div class="scroll">
    <table  class="table table-stripped table-bordered " id = 'example1'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>N/I</th>
                <th>Conference/Journal Name</th>
				
                <th>Category</th>
                <th>Co-authors</th>
                <th>Date from</th>
                <th>Date to</th>
                <th>Location</th>
                <th>Volume</th>
                <th>H-Index</th>
				<th>FDC Status</th>

			
                <th>Paper</th>
                <th>Certificate</th>
                <th>Report</th>

                <th>Upload Paper</th>
                <th>Upload Certificate</th>
                <th>Upload Report</th>

                <th>Edit</th>
                <th>Delete</th>

            </tr>
        </thead>
        <?php
        if(mysqli_num_rows($result)>0){
            //we have data to display 
            while($row =mysqli_fetch_assoc($result)){
                echo "<tr>";
            //  echo "<td>".$row['Fac_ID']."</td>";
                echo "<td>".$row['Paper_title']."</td>";
                echo "<td>".$row['Paper_type']."</td>";
                echo "<td>".$row['Paper_N_I']."</td>";
                echo "<td>".$row['conf_journal_name']."</td>";
				
                echo "<td>".$row['paper_category']."</td>";
                echo "<td>".$row['Paper_co_authors']."</td>";
                echo "<td>".$row['Date_from']."</td>";
                echo "<td>".$row['Date_to']."</td>";
                echo "<td>".$row['Location']."</td>";
                echo "<td>".$row['volume']."</td>";
                echo "<td>".$row['h_index']."</td>";
                echo "<td>".$row['FDC_Y_N']."</td>";
				$_SESSION['P_ID'] = $row['P_ID'];
                if(($row['paper_path']) != "")
				{
						if(($row['paper_path']) == "NULL")
							echo "<td>not yet available</td>";
						else if(($row['paper_path']) == "not_applicable") 
							echo "<td>not applicable</td>";
						else
							echo "<td> <a href = '".$row['paper_path']."'>View paper</td>";
				}
				else
						echo "<td>no status </td>";
				
				if(($row['certificate_path']) != "")
				{
						if(($row['certificate_path']) == "NULL")
							echo "<td>not yet available</td>";
						else if(($row['certificate_path']) == "not_applicable") 
							echo "<td>not applicable</td>";
						else
							echo "<td> <a href = '".$row['certificate_path']."'>View certificate</td>";
				}
				else
						echo "<td>no status </td>";
				
				if(($row['report_path']) != "")
				{
						if(($row['report_path']) == "NULL")
							echo "<td>not yet available</td>";
						else if(($row['report_path']) == "not_applicable") 
							echo "<td>not applicable</td>";
						else
							echo "<td> <a href = '".$row['report_path']."'>View report</td>";
				}
				else
						echo "<td>no status </td>";
                echo "<td>
                    <form action = 'upload-paper.php' method = 'POST'>
                        <input type = 'hidden' name = 'id' value = '".$row['P_ID']."'>
                        <button type = 'submit' class = 'btn btn-primary btn-sm'>
                            <span class='glyphicon glyphicon-upload'></span>
                        </button>
                    </form>
                </td>";
                echo "<td>
                    <form action = 'upload-certificate.php' method = 'POST'>
                        <input type = 'hidden' name = 'id' value = '".$row['P_ID']."'>
                        <button type = 'submit' class = 'btn btn-primary btn-sm'>
                            <span class='glyphicon glyphicon-upload'></span>
                        </button>
                    </form>
                </td>";
				
				echo "<td>
                    <form action = 'upload-report.php' method = 'POST'>
                        <input type = 'hidden' name = 'id' value = '".$row['P_ID']."'>
                        <button type = 'submit' class = 'btn btn-primary btn-sm'>
                            <span class='glyphicon glyphicon-upload'></span>
                        </button>
                    </form>
                </td>";
				
                echo "<td>
                    <form action = '3_edit.php' method = 'POST'>
                        <input type = 'hidden' name = 'id' value = '".$row['P_ID']."'>
                        <button type = 'submit' class = 'btn btn-primary btn-sm'>
                            <span class='glyphicon glyphicon-edit'></span>
                        </button>
                    </form>
                </td>";
                echo "<td>
                    <form action = '4_delete.php' method = 'POST'>
                        <input type = 'hidden' name = 'id' value = '".$row['P_ID']."'>
                        <button type = 'submit' class = 'btn btn-primary btn-sm'>
                            <span class='glyphicon glyphicon-trash'></span>
                        </button>
                    </form>
                </td>";
                echo"</tr>";
            }
        }
        else{
            //if ther are no entries
            echo "<div class='alert alert-warning'>You have no papers</div>";
        }
        ?>
        
    </table>
	
       
	</div>
	            <div class="text-left"><a href="actcount.php"type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus">Add Paper</span></a>
	            <a href="count_your.php" type="button" class="btn btn-success btn-sm"><span class="glyphicon ">Count Publications</span></a> 
	            <a href="export_to_excel.php" type="button" class="btn btn-success btn-sm"><span class="glyphicon ">Export to Excel</span></a> 

    </div>
              </div>
             </div>
            </div>
          </section>
</div>
<?php include_once('footer.php'); ?>