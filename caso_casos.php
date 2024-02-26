<script>
function crear() {
$('#result').load('caso_casos_crear.php'
,
{
    'i_caso_descripcion':  $('#i_caso_descripcion').val(),
    'i_usua_id_abierto':  $('#i_usua_id_abierto').val(),
    'i_caso_estado':  $('#i_caso_estado').val(),
    'i_depa_id':  $('#i_depa_id').val(),
    'i_cati_id':  $('#i_cati_id').val(),
    'i_inso_id':  $('#i_inso_id').val(),
    'i_inpr_id':  $('#i_inpr_id').val(),
    'i_imec_id':  $('#i_imec_id').val(),
    'i_impe_id':  $('#i_impe_id').val(),
    'i_imma_id':  $('#i_imma_id').val(),
    'i_equi_id':  $('#i_equi_id').val(),
    'i_caso_fecha':  $('#i_caso_fecha').val(),
    'i_caso_nota':  $('#i_caso_nota').val(),
    'i_usua_id_aprobado':  $('#i_usua_id_aprobado').val(),
    'i_usua_id_asignado':  $('#i_usua_id_asignado').val()
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
$('#result').load('caso_casos_modificar.php?id=' + $('#h2_id').val()
,
{
     'm_caso_id':  $('#m_caso_id').val(),
     'm_caso_descripcion':  $('#m_caso_descripcion').val(),
     'm_usua_id_abierto':  $('#m_usua_id_abierto').val(),
     'm_caso_estado':  $('#m_caso_estado').val(),
     'm_depa_id':  $('#m_depa_id').val(),
     'm_cati_id':  $('#m_cati_id').val(),
     'm_inso_id':  $('#m_inso_id').val(),
     'm_inpr_id':  $('#m_inpr_id').val(),
     'm_imec_id':  $('#m_imec_id').val(),
     'm_impe_id':  $('#m_impe_id').val(),
     'm_imma_id':  $('#m_imma_id').val(),
     'm_equi_id':  $('#m_equi_id').val(),
     'm_caso_fecha':  $('#m_caso_fecha').val(),
     'm_caso_nota':  $('#m_caso_nota').val(),
     'm_usua_id_aprobado':  $('#m_usua_id_aprobado').val(),
     'm_usua_id_asignado':  $('#m_usua_id_asignado').val()
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
   $('#result').load('caso_casos_borrar.php?id=' + id
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
$.get('caso_casos_datos.php?id=' + id, function(data){
     var resp=data;
     r_array = resp.split('||');
     //alert(r_array[0]);
     $('#m_caso_descripcion').val(r_array[1]);
     $('#m_usua_id_abierto').val(r_array[2]);
     $('#m_caso_estado').val(r_array[3]);
     $('#m_depa_id').val(r_array[4]);
     $('#m_cati_id').val(r_array[5]);
     $('#m_inso_id').val(r_array[6]);
     $('#m_inpr_id').val(r_array[7]);
     $('#m_imec_id').val(r_array[8]);
     $('#m_impe_id').val(r_array[9]);
     $('#m_imma_id').val(r_array[10]);
     $('#m_equi_id').val(r_array[11]);
     $('#m_caso_fecha').val(r_array[12]);
     $('#m_caso_nota').val(r_array[13]);
     $('#m_usua_id_aprobado').val(r_array[14]);
     $('#m_usua_id_asignado').val(r_array[15]);
     });
}
function mostrar() {
$('#datos_mostrar').load('caso_casos_mostrar.php');
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
<td class='etiquetas'>Descripción:</td>
<td><input type='text' id=i_caso_descripcion size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Abierto por', 'usua_nombre', 'i_usua_id_abierto', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Estado:</td>
<td><input type='text' id=i_caso_estado size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('departamentos', 'Departamento', 'depa_nombre', 'i_depa_id', 'depa_id', 'depa_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('casos_tipos', 'Tipo', 'cati_nombre', 'i_cati_id', 'cati_id', 'cati_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('incidencia_seg_op', 'Inc. Seguridad Operacional', 'inso_nombre', 'i_inso_id', 'inso_id', 'inso_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('incidencia_procesos', 'Inc. de procesos', 'inpr_nombre', 'i_inpr_id', 'inpr_id', 'inpr_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_economico', 'Impacto economico', 'imec_nombre', 'i_imec_id', 'imec_id', 'imec_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_personas', 'Impacto en personas', 'impe_nombre', 'i_impe_id', 'impe_id', 'impe_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_medio_ambiente', 'Impacto medio ambiente', 'imma_nombre', 'i_imma_id', 'imma_id', 'imma_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('equipos', 'Equipos', 'equi_nombre', 'i_equi_id', 'equi_id', 'equi_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Fecha de apertura:</td>
<td><input type='text' id=i_caso_fecha size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Detalles:</td>
<td><input type='text' id=i_caso_nota size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Aprobado por', 'usua_nombre', 'i_usua_id_aprobado', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Asignado a', 'usua_nombre', 'i_usua_id_asignado', 'usua_id', 'usua_nombre', '0', '0', '');?>
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
<td class='etiquetas'>Descripción:</td>
<td><input type='text' id=m_caso_descripcion size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Abierto por', 'usua_nombre', 'm_usua_id_abierto', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Estado:</td>
<td><input type='text' id=m_caso_estado size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('departamentos', 'Departamento', 'depa_nombre', 'm_depa_id', 'depa_id', 'depa_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('casos_tipos', 'Tipo', 'cati_nombre', 'm_cati_id', 'cati_id', 'cati_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('incidencia_seg_op', 'Inc. Seguridad Operacional', 'inso_nombre', 'm_inso_id', 'inso_id', 'inso_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('incidencia_procesos', 'Inc. de procesos', 'inpr_nombre', 'm_inpr_id', 'inpr_id', 'inpr_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_economico', 'Impacto economico', 'imec_nombre', 'm_imec_id', 'imec_id', 'imec_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_personas', 'Impacto en personas', 'impe_nombre', 'm_impe_id', 'impe_id', 'impe_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('impacto_medio_ambiente', 'Impacto medio ambiente', 'imma_nombre', 'm_imma_id', 'imma_id', 'imma_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('equipos', 'Equipos', 'equi_nombre', 'm_equi_id', 'equi_id', 'equi_nombre', '0', '0', '');?>
</tr>
<tr>
<td class='etiquetas'>Fecha de apertura:</td>
<td><input type='text' id=m_caso_fecha size=40 class='entradas'></td>
</tr>
<tr>
<td class='etiquetas'>Detalles:</td>
<td><input type='text' id=m_caso_nota size=40 class='entradas'></td>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Aprobado por', 'usua_nombre', 'm_usua_id_aprobado', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<?php echo catalogo('usuarios', 'Asignado a', 'usua_nombre', 'm_usua_id_asignado', 'usua_id', 'usua_nombre', '0', '0', '');?>
</tr>
<tr>
<td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
</tr>
</table>
</div>
<a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>

