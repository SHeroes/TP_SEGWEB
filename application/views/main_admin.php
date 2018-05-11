<?php $this->load->view('header'); ?>

  <div class="navbar navbar-default">
    <div class="navbar-inner">
      <div class="container-fluid">
        <div class="navbar-header">

          <div class="collapse navbar-collapse">
                <a class="navbar-brand" id="head_user_info" pass-sha1="<?php echo $my_sha1_pass; ?>" id-user="<?php echo $my_id_user; ?>" href="#" name="top">Bienvenido <?php echo $name; ?> perfil: <?php echo $perfil;?></a>
                <ul class="nav navbar-nav">
                  <li class="usuarios">
                    <a href="show_main"><i class="glyphicon glyphicon-home"></i>Usuarios </a>
                    </li>
                  <li class="sectores">
                    <a href="show_sector"><i class="glyphicon glyphicon-th-list"></i>Sectores </a>
                  </li>
                  <li class="calendario">
                    <a href="show_calendar"><i class="glyphicon glyphicon-th-list"></i>Calendario </a>
                  </li>
                  <li class="catalogo-reclamos">
                    <a href="show_reclamo_tipo"><i class="glyphicon glyphicon-th-list"></i>Catálogo Reclamos </a>
                  </li>
                  <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-th-list"></i>
                    Reportes<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="../Reportes/show_reportes_pSector" target="_blank">Generar Reporte por Sector</a></li>
                      <li><a href="../Reportes/show_reportes_Reclamos" target="_blank">Generar Reporte Reclamos</a></li>
                      <li><a href="../Reportes/show_reportes_localidades" target="_blank">Generar Reporte por Localidades</a></li>
                    </ul>
                  </li>
                  <li class="dropdown hidden">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="#">One more separated link</a></li>
                    </ul>
                  </li>
                  <li>
                    <a class="btn" href="javascript:change_password();"><i class="glyphicon glyphicon-user"></i>Cambiar Contraseña</a>
                  </li>
                  <li>
                    <a class="btn" href="<?php echo base_url() ?>index.php/login/logout_user"><i class="glyphicon glyphicon-share"></i>Logout</a>          
                  </li>
                  <li><button>
                    <a class="btn" href="<?php echo base_url() ?>index.php/main_admin/pasos_admin_tramites"><i class="glyphicon glyphicon-share"></i>Admin Tramites</a></button>          
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