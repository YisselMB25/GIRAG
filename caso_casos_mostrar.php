<?php include('conexion.php'); ?>
<div class="table-responsive table-striped table-bordered table-hover table-sm" style="text-align: center; align-items:center">
   <table class="table align-middle">
      <thead class="thead-dark">
         <tr>
            <th scope="col">ID</th>
            <th scope="col">Descripción</th>
            <th scope="col">Revisado por</th>
            <th scope="col">Estado</th>
            <th scope="col">Departamento</th>
            <th scope="col">Tipo</th>
            <th scope="col">Ubicacion</th>
            <th scope="col">Incidencia Seguridad Operacional</th>
            <th scope="col">Incidencia de Procesos</th>
            <th scope="col">Impacto Economico</th>
            <th scope="col">Impacto Personas</th>
            <th scope="col">Impacto Medio Ambiente</th>
            <th scope="col">Equipos</th>
            <th scope="col">Fecha de apertura</th>
            <th scope="col">Aprobado por</th>
            <th scope="col">Usuario asignado</th>
            <th scope="col">&nbsp;</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $usua_id_revisado = $_GET['usua_id_revisado'];
         $cati_id = $_GET["cati_id"];
         $equi_id = $_GET["equi_id"];
         $usua_id_aprobado = $_GET["usua_id_aprobado"];
         $usua_id_asignado = $_GET["usua_id_asignado"];
         $depa_id= $_GET["depa_id"];
         $caes_id = $_GET["caes_id"];

		   $where='';
		 
		   if($usua_id_revisado!='') $where .= " AND  a.usua_id_revisado IN ($usua_id_revisado)";
         if($cati_id != "") $where .=" AND a.cati_id IN ($cati_id)";
         if($equi_id != "") $where .= " AND a.equi_id IN ($equi_id)";
         if($usua_id_aprobado != "") $where .= " AND a.usua_id_aprobado IN ($usua_id_aprobado)";
         if($usua_id_asignado != "") $where .= " AND a.usua_id_asignado IN ($usua_id_asignado)";
         if($caes_id != "") $where .= " AND a.caes_id IN ($caes_id)";
         if($depa_id != "") $where .= " AND a.depa_id IN ($depa_id)";

         $qsql = "SELECT caso_id, caso_descripcion, cati_nombre, inso_nombre, inpr_nombre, depa_nombre, caso_ubicacion, imec_nombre, imma_nombre, equi_nombre, caso_fecha, caso_nota, impe_nombre, usua_id_aprobado, usua_id_revisado, 
(SELECT usua_nombre FROM usuarios WHERE usua_id = usua_id_revisado) revisado,
(SELECT usua_nombre FROM usuarios WHERE  usua_id = usua_id_aprobado) aprobado,
(SELECT usua_nombre FROM usuarios WHERE usua_id=usua_id_asignado) usua_asignado,
(SELECT depa_nombre FROM departamentos WHERE depa_id=a.depa_id) depa_nombre,
(SELECT caes_nombre FROM casos_estado WHERE caes_id=a.caes_id) caso_estado
FROM casos a, casos_tipos b, departamentos c, equipos d, impacto_economico e, impacto_medio_ambiente f, impacto_personas g, incidencia_procesos h, incidencia_seg_op i 
WHERE a.cati_id=b.cati_id
AND a.depa_id=c.depa_id 
AND a.equi_id=d.equi_id 
AND a.imec_id=e.imec_id 
AND a.imma_id=f.imma_id 
AND a.impe_id=g.impe_id 
AND a.inpr_id=h.inpr_id
AND a.inso_id=i.inso_id
$where";
         $rs = mysql_query($qsql);
         $num = mysql_num_rows($rs);
         $i = 0;
         while ($i < $num) {
         ?>
            <tr>
               <td><?php echo mysql_result($rs, $i, 'caso_id'); ?></td>
               <td>
                  <a href="index.php?p=detalle-caso&caso=<?php echo mysql_result($rs, $i, 'caso_id'); ?>">
                     <?php echo mysql_result($rs, $i, 'caso_descripcion'); ?>
                  </a>
               </td>
               <td><?php echo mysql_result($rs, $i, 'revisado');?></td> <!-- Revisado por-->
               <td><?php echo mysql_result($rs, $i, 'caso_estado'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'depa_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'cati_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'caso_ubicacion'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'inso_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'inpr_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'imec_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'impe_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'imma_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'equi_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'caso_fecha'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'aprobado'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'usua_asignado'); ?></td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a class="btn" href='javascript:editar(<?php echo mysql_result($rs, $i, 'caso_id'); ?>)' ;>
                        <svg style="width: 22px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path fill="#FFD43B" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                        </svg>
                     </a>
                     <a class="btn" href='javascript:borrar(<?php echo mysql_result($rs, $i, 'caso_id'); ?>)' ;>
                        <svg style="width: 22px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                           <path fill="#ad0000" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                     </a>
                     <?php if(mysql_result($rs, $i, 'usua_id_revisado') == 0):?>
                     <!-- <button type="button" class="btn" onclick="aprobarCaso(<?php //echo  mysql_result($rs, $i, 'caso_id')?>)"  style="font-size: 22px;" data-casoid=<?php //echo mysql_result($rs, $i, 'caso_id')?>>
                        <i class="fa-solid fa-check-to-slot" style="color: #1e7000;"></i>
                     </button> -->
                     <button type="button" class="btn" style="font-size: 22px;" data-target="#revisado-observaciones" data-toggle="modal" type="button" data-casoid="<?php echo  mysql_result($rs, $i, 'caso_id')?>">
                        <i class="fa-solid fa-check-to-slot" style="color: #1e7000;"></i>
                     </button>
                     <?php endif?>
                  </div>
               </td>
            </tr>
         <?php
            $i++;
         }
         ?>
      </tbody>
   </table>
</div>

<script>

</script>