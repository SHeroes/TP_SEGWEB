<?php $this->load->view('header'); ?>

  <div class="navbar navbar-default">
    <div class="navbar-inner">
      <div class="container-fluid">
        <div class="navbar-header">

          <div class="collapse navbar-collapse">
                <a class="navbar-brand" id="head_user_info" pass-sha1="<?php echo $my_sha1_pass; ?>" id-user="<?php echo $my_id_user; ?>" href="#" name="top">Bienvenido <?php echo $name; ?><div style="display: none"> perfil: <?php echo $perfil;?></div></a>
                <ul class="nav navbar-nav">

                  <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-print"></i>
                    Reclamos<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="show_main" ></i>Rec. No Vistos </a></li>
                      <li><a href="show_no_contact" ></i>Rec. No Contactados </a></li>
                      <li><a href="show_verificados" ></i>Rec. Verificados </a></li>
                    </ul>
                  </li>   


                  <li class=""><a href="show_contactados"><i class="glyphicon glyphicon-phone-alt"></i>Rev. Rec</a></li>                  
                  <li class=""><a href="show_reclamos"><i class="glyphicon glyphicon-list-alt"></i>Ver Reclamos</a></li>


                  <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-th-list"></i>
                    Reportes<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="../Reportes/show_reportes_pSector" target="_blank">Generar Reporte por Sector</a></li>
                      <li><a href="../Reportes/show_reportes_Reclamos" target="_blank">Generar Reporte Reclamos</a></li>
                      <li><a href="../Reportes/show_reportes_localidades" target="_blank">Generar Reporte por Localidades</a></li>
                      <li><a href="../Reportes/show_reportes_composicion_sectores" target="_blank">Reporte de Composicion de Sectores</a></li>
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
                    <a class="btn" href="<?php echo base_url() ?>index.php/login/logout_user"><i class="glyphicon glyphicon-share"></i> Logout</a>          
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