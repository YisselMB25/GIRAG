<script>
function crear() {
$('#result').load('cata_casos_tareas_crear.php'
,
{
    'i_cate_nombre':  $('#i_cate_nombre').val(),
    'i_cate_descripcion':  $('#i_cate_descripcion').val(),
    'i_cate_fecha_cierre':  $('#i_cate_fecha_cierre').val(),
    'i_cate_estado':  $('#i_cate_estado').val(),
    'i_depa_id':  $('#i_depa_id').val(),
    'i_usua_id':  $('#i_usua_id').val()
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
$('#result').load('cata_casos_tareas_modificar.php?id=' + $('#h2_id').val()
,
{
     'm_cate_id':  $('#m_cate_id').val(),
     'm_cate_nombre':  $('#m_cate_nombre').val(),
     'm_cate_descripcion':  $('#m_cate_descripcion').val(),
     'm_cate_fecha_cierre':  $('#m_cate_fecha_cierre').val(),
     'm_cate_estado':  $('#m_cate_estado').val(),
     'm_depa_id':  $('#m_depa_id').val(),
     'm_usua_id':  $('#m_usua_id').val()
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
   $('#result').load('cata_casos_tareas_borrar.php?id=' + id
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
$.get('cata_casos_tareas_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(r_array[0]);
     $('#m_cate_nombre').val(r_array[1]);
     $('#m_cate_descripcion').val(r_array[2]);
     $('#m_cate_fecha_cierre').val(r_array[3]);
     $('#m_cate_estado').val(r_array[4]);
     $('#m_depa_id').val(r_array[5]);
     $('#m_usua_id').val(r_array[6]);
     });
}
function mostrar() {
$('#datos_mostrar').load('cata_casos_tareas_mostrar.php');
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
<td class='etiquetas'>Tarea:</td>
<td><input type='text' id=i_cate_nombre size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Descrición:</td>
<td><input type='text' id=i_cate_descripcion size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Fecha de cierre:</td>
<td><input type='text' id=i_cate_fecha_cierre size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('casos_estado', 'Estado', 'caes_nombre', 'i_cate_estado', 'caes_id', 'caes_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo(' departamentos ', 'Departamento asignado ', ' depa_nombre', 'i_depa_id', ' depa_id ', ' depa_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Persona asignada', 'usua_nombre', 'i_usua_id', 'usua_id', 'usua_nombre', '0', '0', '');?>
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
<td class='etiquetas'>Tarea:</td>
<td><input type='text' id=m_cate_nombre size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Descrición:</td>
<td><input type='text' id=m_cate_descripcion size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Fecha de cierre:</td>
<td><input type='text' id=m_cate_fecha_cierre size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('casos_estado', 'Estado', 'caes_nombre', 'm_cate_estado', 'caes_id', 'caes_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo(' departamentos ', 'Departamento asignado ', ' depa_nombre', 'm_depa_id', ' depa_id ', ' depa_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Persona asignada', 'usua_nombre', 'm_usua_id', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>

