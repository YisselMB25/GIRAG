<script>
function crear() {
$('#result').load('depa_departamentos_crear.php'
,
{
    'i_depa_nombre':  $('#i_depa_nombre').val(),
    'i_depa_correo':  $('#i_depa_correo').val()
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
$('#result').load('depa_departamentos_modificar.php?id=' + $('#h2_id').val()
,
{
     'm_depa_id':  $('#m_depa_id').val(),
     'm_depa_nombre':  $('#m_depa_nombre').val(),
     'm_depa_correo':  $('#m_depa_correo').val()
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
   $('#result').load('depa_departamentos_borrar.php?id=' + id
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
$.get('depa_departamentos_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(r_array[0]);
     $('#m_depa_nombre').val(r_array[1]);
     $('#m_depa_correo').val(r_array[2]);
     });
}
function mostrar() {
$('#datos_mostrar').load('depa_departamentos_mostrar.php');
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
<td class='etiquetas'>Departamento:</td>
<td><input type='text' id=i_depa_nombre size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Correo:</td>
<td><input type='text' id=i_depa_correo size=40 class='entradas'></td>
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
<td class='etiquetas'>Departamento:</td>
<td><input type='text' id=m_depa_nombre size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Correo:</td>
<td><input type='text' id=m_depa_correo size=40 class='entradas'></td>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>

