<?php include('conexion.php'); ?>
<div class="table-responsive table-striped table-bordered table-hover table-sm" style="text-align: center; align-items:center">
   <table class="table">
      <thead class="thead-dark">
         <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Abierto por</th>
            <th scope="col">Estado</th>
            <th scope="col">Tipo</th>
            <th scope="col">Incidencia Seguridad Operacional</th>
            <th scope="col">Incidencia de Procesos</th>
            <th scope="col">Impacto Economico</th>
            <th scope="col">Impacto Personas</th>
            <th scope="col">Impacto Medio Ambiente</th>
            <th scope="col">Equipos</th>
            <th scope="col">Fecha de apertura</th>
            <th scope="col">Aprobado por</th>
            <th scope="col">Asignado a</th>
            <th scope="col">&nbsp;</th>
         </tr>
      </thead>
      <tbody>
         <?php
         // $nombre = $_GET['nombre'];
         $qsql = "SELECT caso_id, caso_descripcion, caso_abierto_por as  abierto_por, caso_estado, cati_nombre, inso_nombre, inpr_nombre,
imec_nombre, imma_nombre, equi_nombre, caso_fecha, caso_nota, impe_nombre,
(SELECT usua_nombre FROM usuarios WHERE  usua_id=usua_id_aprobado) aprobado,
(SELECT usua_nombre FROM usuarios WHERE usua_id=usua_id_asignado) asignado
FROM casos a, casos_tipos b, departamentos c, equipos d, impacto_economico e, impacto_medio_ambiente f, impacto_personas g, incidencia_procesos h, incidencia_seg_op i 
WHERE a.cati_id=b.cati_id
AND a.depa_id=c.depa_id 
AND a.equi_id=d.equi_id 
AND a.imec_id=e.imec_id 
AND a.imma_id=f.imma_id 
AND a.impe_id=g.impe_id 
AND a.inpr_id=h.inpr_id
AND a.inso_id=i.inso_id";
         $rs = mysql_query($qsql);
         $num = mysql_num_rows($rs);
         $i = 0;
         while ($i < $num) {
         ?>
            <tr>
               <th scope="row">
                  <a href="index.php?p=detalle-caso&caso=<?php echo mysql_result($rs, $i, 'caso_id'); ?>">
                     <?php echo mysql_result($rs, $i, 'caso_descripcion'); ?>
                  </a>
               </th>
               <td><?php echo mysql_result($rs, $i, 'abierto_por');
                     ?></td>
               <td><?php echo mysql_result($rs, $i, 'caso_estado'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'cati_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'inso_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'inpr_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'imec_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'impe_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'imma_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'equi_nombre'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'caso_fecha'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'aprobado'); ?></td>
               <td><?php echo mysql_result($rs, $i, 'asignado'); ?></td>
               <td>
                  <div class="btn-group btn-group-sm">
                     <a class="btn" href='javascript:editar(<?php echo mysql_result($rs, $i, 'caso_id'); ?>)' ;>
                        <svg style="width: 22px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path fill="#FFD43B" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                        </svg>
                     </a>
                     <a class="btn" href='javascript:borrar(<?php echo mysql_result($rs, $i, 'caso_id'); ?>)' ;>
                        <svg style="width: 22px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                           <path fill="#ad0000" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                     </a>
                     <button type="button" class="btn" data-toggle="modal" data-target="#caso_detalle_<?php echo mysql_result($rs, $i, 'caso_id'); ?>" data-whatever="@mdo">
                        <svg style="width: 22px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path fill="#005eff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                        </svg>
                     </button>
                  </div>
                  <div class="modal fade" id="caso_detalle_<?php echo mysql_result($rs, $i, 'caso_id'); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Detalles del caso</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <p><?php echo mysql_result($rs, $i, 'caso_nota'); ?></p>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
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