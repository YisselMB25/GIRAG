<?php
$nombre_completo = nombre_completo($user_check);
$imagen_usuario = obtener_valor("select usua_imagen from usuarios where usua_id=$user_check", "usua_imagen");
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="index.php" class="brand-link">
	  <img src="dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3"
		   style="opacity: 1.0">
	  <span class="brand-text font-weight-light">OVERSEAS <b>Web</b></span>
	</a>
        <!-- sidebar: style can be found in sidebar.less -->
        <?php include('header.php');?>
        <!-- /.sidebar -->
</aside>