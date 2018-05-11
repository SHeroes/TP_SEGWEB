
<?php $this->load->view('header'); ?>

  <div class="navbar navbar-default upload-form">
    <div class="navbar-inner">
      <div class="container">
       <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="margin-top: 50px;">
              <div class="span4 offset4 well">

                  <legend>Por favor seleccione el archivo a subir</legend>

                  <div class="upload-form">
                  <?php // echo $error;?> 
                  <?php echo form_open_multipart('upload/do_upload');?> 
            		
                  <form action = "" method = "">
                     <input type = "file" name = "userfile" size = "20" class="span4" /> 
                     <br /><br /> 
                     <input type = "submit" value = "upload" class="span4"/> 
                  </form>
                  </div>

               </div>
               <!--/.container-fluid -->
             </div>
          </div>
        <!--/.navbar-header -->
      </div>
      <!--/.container-fluid -->
    </div>
    <!--/.navbar-inner -->
  </div>
  <!--/.navbar -->
  
  
  
<?php $this->load->view('footer_base'); ?>
