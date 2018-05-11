<?php $this->load->view('header') ?>

  <div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#" name="top">El usuario <?php echo $name; ?> es: <?php echo $perfil;?> y no tiene permisos para esta parte del sistema</a>

          <div class="btn-group pull-right">
            
          
           
              <a class="btn" href="<?php echo base_url() ?>index.php/login/logout_user"><i class="icon-share"></i> Logout</a>
            
          </div>
      </div>
      <!--/.container-fluid -->
    </div>
    <!--/.navbar-inner -->
  </div>