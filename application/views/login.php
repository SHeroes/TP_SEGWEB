<?php include 'header.php' ?>

  <div class="container">

    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6" style="margin-top: 50px;">
        <div class="span4 offset4 well">

          <legend>Por favor ingrese su email y contraseña</legend>

          <?php if (isset($error) && $error): ?>
            <div class="alert alert-error">
              <a class="close" data-dismiss="alert" href="#">×</a>Usuario o contraseña incorrectas!
            </div>
          <?php endif; ?>

          <?php echo form_open('login/login_user') ?>

          <input type="text" id="email" class="span4" name="email" placeholder="Email Address">
          <input type="password" id="password" class="span4" name="password" placeholder="Password">

          <!--<label class="checkbox">
            <input type="checkbox" name="remember" value="1"> Remember Me
          </label>-->

          <button type="submit" name="submit" class="btn btn-info">Log In</button>

          </form>
        </div>
      </div> 
      <div class="col-md-3"></div>
    </div>

    <div class="row" style="display:none;">
      <div class="span6 offset4">
        <p><strong>Para testear: </strong></p>
        <p><strong>Admin user email:</strong> dwgawron@hotmail.com</p>
        <p><strong>Contraseña:</strong> password </p>
        <!-- <p>The database is reset every night.</p> -->
        <p><strong>operador user email:</strong> walter@walter.com</p>
        <p><strong>Contraseña:</strong> walter </p>
        
      </div>
    </div>
  </div>

<?php include 'footer.php' ?>