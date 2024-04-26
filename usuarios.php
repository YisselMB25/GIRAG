<script>
function crear() {
$('#result').load('usuarios_crear.php'
,
{
    'i_usua_nombre':  $('#i_usua_nombre').val(),
    'i_usti_id':  $('#i_usti_id').val(),
    'i_usua_password':  $('#i_usua_password').val(),
    'i_usua_nombre_completo':  $('#i_usua_nombre_completo').val(),
    'i_usua_mail':  $('#i_usua_mail').val()
    }
    ,
    function(){
        $('#modal').hide('slow');
        $('#overlay').hide();
        mostrar();
    }
  );
}
function modificar() {
$('#result').load('usuarios_modificar.php?id=' + $('#h2_id').val()
,
{
     'm_usua_id':  $('#m_usua_id').val(),
     'm_usua_nombre':  $('#m_usua_nombre').val(),
     'm_usti_id':  $('#m_usti_id').val(),
     'm_usua_password':  $('#m_usua_password').val(),
     'm_usua_nombre_completo':  $('#m_usua_nombre_completo').val(),
     'm_usua_mail':  $('#m_usua_mail').val()
    }
    ,
    function(){
       $('#modal2').hide('slow');
       $('#overlay2').hide();
       mostrar();
    }
  );
}
function borrar(id)
{
var agree=confirm('¿Está seguro?');
if(agree) {
   $('#result').load('usuarios_borrar.php?id=' + id
   ,
   function()
     {
     mostrar();
     }
  );
 }
}
function editar(id)
{
$('#modal2').show();
$('#overlay2').show();
$('#modal2').center();
$('#h2_id').val(id);
$.get('usuarios_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(r_array[0]);
     $('#m_usua_nombre').val(r_array[1]);
     $('#m_usti_id').val(r_array[2]);
     $('#m_usua_password').val(r_array[3]);
     $('#m_usua_nombre_completo').val(r_array[4]);
     $('#m_usua_mail').val(r_array[5]);
     });
}
function mostrar() {
$('#datos_mostrar').load('usuarios_mostrar.php');
}
</script>
<div id='separador'>
<table width='' class=filtros>
<tr>
<td class='tabla_datos'><div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div></td>
<td><div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div></td>
</tr>
</table>
</div>
<div id='columna6'>
<div id='datos_mostrar'></div>
</div>
<!--MODAL-->
<div id='overlay'></div>
<div id='modal'><div id='content'>
<table>
<tr>
<td class='etiquetas'>Usuario:</td>
<td><input type='text' id=i_usua_nombre size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios_tipos', 'Tipo', 'usti_nombre', 'i_usti_id', 'usti_id', 'usti_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Password:</td>
<td><input type='text' id=i_usua_password size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Nombre Completo:</td>
<td><input type='text' id=i_usua_nombre_completo size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>E-mail:</td>
<td><input type='text' id=i_usua_mail size=40 class='entradas'></td>
</tr>
<tr>
<td colspan=2><a href='javascript:crear()' class='botones'>Crear</a></td>
</tr>
</table>
</div>
<a href='#' id='close'>close</a>
</div>

<div id='overlay2'></div>
<div id='modal2'><div id='content2'>
<input type=hidden id=h2_id><table>
<tr>
<td class='etiquetas'>Usuario:</td>
<td><input type='text' id=m_usua_nombre size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios_tipos', 'Tipo', 'usti_nombre', 'm_usti_id', 'usti_id', 'usti_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Password:</td>
<td><input type='text' id=m_usua_password size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Nombre Completo:</td>
<td><input type='text' id=m_usua_nombre_completo size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>E-mail:</td>
<td><input type='text' id=m_usua_mail size=40 class='entradas'></td>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>

