
<div class="container">

<?php    
  $this->view('buscar_vecinos_registrados');
  $this->view('registrar_vecino_nuevo');
?>

</div>

<?php echo '<script src="'. base_url() .'assets/js/plugin/json2.js"></script>'; ?>
<?php echo '<script src="'. base_url() .'assets/js/show_vecinos.js"></script>'; ?>

<style>
.input-search-result{
  cursor: pointer;
  display: none;
}

</style>