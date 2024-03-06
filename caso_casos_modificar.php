<?php include('conexion.php');

$id=$_GET['id'];

$m_caso_descripcion=$_POST['m_caso_descripcion'];

$m_caes_id=$_POST['m_caes_id'];

$m_depa_id=$_POST['m_depa_id'];

$m_cati_id=$_POST['m_cati_id'];

$m_inso_id=$_POST['m_inso_id'];

$m_inpr_id=$_POST['m_inpr_id'];

$m_imec_id=$_POST['m_imec_id'];

$m_impe_id=$_POST['m_impe_id'];

$m_imma_id=$_POST['m_imma_id'];

$m_equi_id=$_POST['m_equi_id'];

$m_caso_fecha=$_POST['m_caso_fecha'];

$m_caso_nota=$_POST['m_caso_nota'];

$m_usua_id_aprobado=$_POST['m_usua_id_aprobado'];

$m_usua_id_asignado=$_POST['m_usua_id_asignado'];

$m_depa_id_asignado=$_POST["m_depa_id_asignado"];

$qsql = "update casos set 

caso_descripcion='$m_caso_descripcion',  

caes_id='$m_caes_id', 

depa_id='$m_depa_id', 

cati_id='$m_cati_id', 

inso_id='$m_inso_id', 

inpr_id='$m_inpr_id', 

imec_id='$m_imec_id', 

impe_id='$m_impe_id', 

imma_id='$m_imma_id', 

equi_id='$m_equi_id', 

caso_fecha='$m_caso_fecha', 

caso_nota='$m_caso_nota', 

usua_id_aprobado='$m_usua_id_aprobado', 

usua_id_asignado='$m_usua_id_asignado',

depa_id_asignado='$m_depa_id_asignado'

where caso_id='$id'";

mysql_query($qsql);

?>



