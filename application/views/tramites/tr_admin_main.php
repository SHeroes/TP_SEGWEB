<?php $this->load->view('tramites/tr_header'); ?>
  <div class="navbar navbar-default">
    <div class="navbar-inner">
      <div class="container-fluid">
        <div class="navbar-header">

          <div class="collapse navbar-collapse">
                <a class="navbar-brand" id="head_user_info" pass-sha1="<?php echo $my_sha1_pass; ?>" id-user="<?php echo $my_id_user; ?>" href="#" name="top">Bienvenido    <?php echo $name; ?>     perfil: <?php echo $perfil;?>
                  </a>
                <ul class="nav navbar-nav">
                  <li class="tr_pasos">
                    <a href="<?php echo base_url(); ?>index.php/main_admin/pasos_admin_tramites"><i class="glyphicon glyphicon-th-list"></i>Crear Pasos</a>
                  </li>
                  <li class="tr_formularios">
                    <a href="<?php echo base_url(); ?>index.php/main_admin/formularios_admin_tramites"><i class="glyphicon glyphicon-paperclip"></i>Formularios</a>
                  </li>
                  <li class="tr_tipo_tramite">
                    <a href="<?php echo base_url(); ?>index.php/main_admin/tipo_tramite_admin_tramites"><i class="glyphicon glyphicon-sort-by-attributes"></i>Armar Tipo Tramite</a>
                  </li>                  

                  <li>
                    <a class="btn" href="<?php echo base_url() ?>"><i class="glyphicon glyphicon-level-up"></i>Volver al CAV Reclamos</a>          
                  </li>
                  <li>
                    <a class="btn" href="<?php echo base_url() ?>index.php/login/logout_user"><i class="glyphicon glyphicon-share"></i>Logout</a>          
                  </li>
                </ul>
          </div>
        </div>
        <!--/.navbar-header -->
      </div>
      <!--/.container-fluid -->
    </div>
    <!--/.navbar-inner -->
  </div>
  <!--/.navbar -->
  <?php $this->load->view('change_pass'); ?>