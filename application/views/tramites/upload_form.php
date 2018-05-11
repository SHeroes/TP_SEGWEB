
<?php $this->load->view('tramites/tr_header'); ?>

  <div class="navbar navbar-default upload-form">
    <div class="navbar-inner">
      <div class="container">
       <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="margin-top: 50px;">
              <div class="span4 offset4 well">

                  <legend>Por favor seleccione el formulario a subir</legend>
                  <h8>Maximo 10 Mb</h8>

                  <div class="upload-form">
                  <?php // echo $error;?> 
                  <?php echo form_open_multipart('tramites/upload_tr_formulario/do_upload');?> 
            		
                  <form action = "" method = "">
                      <p> <input type = "file" name = "userfile" size = "20" class="span4" /> </p>
                      <p><input type="text" class="form-control" name="titulo" size="30" placeholder="Título"></p>
                      <p><textarea type="text" class="form-control" name="descripcion" cols="30" rows="5" placeholder="Descripción"></textarea></p>
                      <p><input type="text" class="form-control" name="cod_int" size="30" placeholder="Codigo Interno (opcional)"></p>
                     <br /><br /> 
                     <input type = "submit" value = "upload" class="span4 btn btn-primary"/> 
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
