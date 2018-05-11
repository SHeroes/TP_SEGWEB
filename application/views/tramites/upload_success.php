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
            		
                  <p>¿ Desea subir otro formulario asociado al mismo Paso de Trámite ?

                  <?php echo anchor('tramites/upload_tr_formulario?id-paso='.$this->session->userdata('id-paso-aux') . '" class="btn btn-success"', 'Si');?>
                  <a href="main_admin/pasos_admin_tramites" class="btn btn-info" >crear otro paso</a>
                  <a href="main_admin/tipo_tramite_admin_tramites" class="btn btn-info" >armar tipo de tramite</a>
                        <!-- <a onclick="self.close()" class="btn btn-info" >No</a> -->
                   
                    

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