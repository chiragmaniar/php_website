<?php include_once('head.php'); ?>
<?php include_once('header.php'); ?>
<?php include_once('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Classroom 
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Classroom</li>
          </ol>
        </section>
 <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Classroom</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                <form role="form" action="index.php" method="post">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter classroom name" name="name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Student Count</label>
                      <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter student count" name="student_count">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Hall Charge</label>
                      <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter hall charge" name="hall_charge">
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  	
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
                
                </div>
              </div>
         	</div>
         </section><!-- End of form section tag -->                                                   
</div> 
    
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    
    
<?php include_once('footer.php'); ?>    


    
    
    
    
    
    
    