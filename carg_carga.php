<script>
  function crear() {
    $('#result').load('carg_carga_crear.php', {
        'i_carg_id': $('#i_carg_id').val(),
        'i_cati_id': $('#i_cati_id').val(),
        'i_carg_guia': $('#i_carg_guia').val(),
        'i_vuel_id': $('#i_vuel_id').val(),
        'i_aeco_id_destino_final': $('#i_aeco_id_destino_final').val(),
        'i_usua_id_creador': $('#i_usua_id_creador').val(),
        'i_carg_fecha_registro': $('#i_carg_fecha_registro').val(),
        'i_carg_recepcion_real': $('#i_carg_recepcion_real').val(),
        'i_liae_id': $('#i_liae_id').val(),
        'i_caes_id': $('#i_caes_id').val()
      },
      function() {
        $('#modal').hide('slow');
        $('#overlay').hide();
        mostrar();
      }
    );
  }

  function modificar() {
    $('#result').load('carg_carga_modificar.php?id=' + $('#h2_id').val(), {
        'm_carg_id': $('#m_carg_id').val(),
        'm_cati_id': $('#m_cati_id').val(),
        'm_carg_guia': $('#m_carg_guia').val(),
        'm_vuel_id': $('#m_vuel_id').val(),
        'm_aeco_id_destino_final': $('#m_aeco_id_destino_final').val(),
        'm_usua_id_creador': $('#m_usua_id_creador').val(),
        'm_carg_fecha_registro': $('#m_carg_fecha_registro').val(),
        'm_carg_recepcion_real': $('#m_carg_recepcion_real').val(),
        'm_liae_id': $('#m_liae_id').val(),
        'm_caes_id': $('#m_caes_id').val()
      },
      function() {
        $('#modal2').hide('slow');
        $('#overlay2').hide();
        mostrar();
      }
    );
  }

  function borrar(id) {
    var agree = confirm('¿Está seguro?');
    if (agree) {
      $('#result').load('carg_carga_borrar.php?id=' + id,
        function() {
          mostrar();
        }
      );
    }
  }

  function editar(id) {
    $('#modal2').show();
    $('#overlay2').show();
    $('#modal2').center();
    $('#h2_id').val(id);
    $.get('carg_carga_datos.php?id=' + id, function(data) {
      var resp = data;
      r_array = resp.split('||');
      //alert(r_array[0]);
      $('#m_carg_id').val(r_array[0]);
      $('#m_cati_id').val(r_array[1]);
      $('#m_carg_guia').val(r_array[2]);
      $('#m_vuel_id').val(r_array[3]);
      $('#m_aeco_id_destino_final').val(r_array[4]);
      $('#m_usua_id_creador').val(r_array[5]);
      $('#m_carg_fecha_registro').val(r_array[6]);
      $('#m_carg_recepcion_real').val(r_array[7]);
      $('#m_liae_id').val(r_array[8]);
      $('#m_caes_id').val(r_array[9]);
    });
  }

  function mostrar() {
    $('#datos_mostrar').load('carg_carga_mostrar.php');
  }
</script>
<div id='separador'>
  <table width='' class=filtros>
    <tr>
      <td class='tabla_datos'>
        <div id='b_mostrar'><a href='javascript:mostrar()' class=botones>Mostrar</a></div>
      </td>
      <td>
        <div id='dmodal' style='text-align:right'><a href='#' class=botones>Nuevo</a></div>
      </td>
    </tr>
  </table>
</div>
<div id='columna6'>
  <div id='datos_mostrar'></div>
</div>
<!--MODAL-->
<div id='overlay'></div>
<div id='modal'>
  <div id='content'>
    <table>
      <tr>
        <td class='etiquetas'>NO:</td>
        <td><input type='text' id=i_carg_id size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('carga_tipos', 'Tipo', 'cati_nombre', 'i_cati_id', 'cati_id', 'cati_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td class='etiquetas'>Guia:</td>
        <td><input type='text' id=i_carg_guia size=40 class='entradas'></td>
      </tr>
      <tr>
        <td class='etiquetas'>Vuelo:</td>
        <td><input type='text' id=i_vuel_id size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('aereopuertos_codigos', 'Destino final', 'aeco_nombre', 'i_aeco_id_destino_final', 'aeco_id', 'aeco_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <?php echo catalogo('usuarios', 'Registrado por', 'usua_nombre', 'i_usua_id_creador', 'usua_id', 'usua_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td class='etiquetas'>Fecha de registro:</td>
        <td><input type='text' id=i_carg_fecha_registro size=40 class='entradas'></td>
      </tr>
      <tr>
        <td class='etiquetas'>Fecha de recepcion:</td>
        <td><input type='text' id=i_carg_recepcion_real size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('lineas_aereas', 'Linea aerea', 'liae_nombre', 'i_liae_id', 'liae_id', 'liae_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <?php echo catalogo('carga_estado', 'Estado', 'caes_nombre', 'i_caes_id', 'caes_id', 'caes_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td colspan=2><a href='javascript:crear()' class='botones'>Crear</a></td>
      </tr>
    </table>
  </div>
  <a href='#' id='close'>close</a>
</div>

<div id='overlay2'></div>
<div id='modal2'>
  <div id='content2'>
    <input type=hidden id=h2_id>
    <table>
      <tr>
        <td class='etiquetas'>NO:</td>
        <td><input type='text' id=m_carg_id size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('carga_tipos', 'Tipo', 'cati_nombre', 'm_cati_id', 'cati_id', 'cati_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td class='etiquetas'>Guia:</td>
        <td><input type='text' id=m_carg_guia size=40 class='entradas'></td>
      </tr>
      <tr>
        <td class='etiquetas'>Vuelo:</td>
        <td><input type='text' id=m_vuel_id size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('aereopuertos_codigos', 'Destino final', 'aeco_nombre', 'm_aeco_id_destino_final', 'aeco_id', 'aeco_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <?php echo catalogo('usuarios', 'Registrado por', 'usua_nombre', 'm_usua_id_creador', 'usua_id', 'usua_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td class='etiquetas'>Fecha de registro:</td>
        <td><input type='text' id=m_carg_fecha_registro size=40 class='entradas'></td>
      </tr>
      <tr>
        <td class='etiquetas'>Fecha de recepcion:</td>
        <td><input type='text' id=m_carg_recepcion_real size=40 class='entradas'></td>
      </tr>
      <tr>
        <?php echo catalogo('lineas_aereas', 'Linea aerea', 'liae_nombre', 'm_liae_id', 'liae_id', 'liae_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <?php echo catalogo('carga_estado', 'Estado', 'caes_nombre', 'm_caes_id', 'caes_id', 'caes_nombre', '0', '0', ''); ?>
      </tr>
      <tr>
        <td colspan=2><a href='javascript:modificar()' class='botones'>Modificar</a></td>
      </tr>
    </table>
  </div>
  <a href='javascript:void(0);' id='close2'>close</a>
</div>

<div id=result></div>