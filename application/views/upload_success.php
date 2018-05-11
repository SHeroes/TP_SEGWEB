<?php $this->load->view('header'); ?>

  <div class="navbar navbar-default upload-form">
    <div class="navbar-inner">
      <div class="container">
       <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="margin-top: 50px;">
              <div class="span4 offset4 well">

                  <legend>Tu archivo se ha subido correctamente</legend>  
		
                  <div style="display: none;"><pre> <?php print_r($upload_data); ?></pre></div>
            		
                  <p>¿ Desea subir otro archivo asociado al mismo Reclamo ?

                  <?php echo anchor('upload?id-rec='.$this->session->userdata('id-reclamo-aux') . '" class="btn btn-success"', 'Si');?>
                        <a onclick="self.close()" class="btn btn-info" >No</a>
                   
                    

                  </p>  
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