<?php
    require_once("../lib/pdf/mpdf.php");
//Conexion base de datos.
$conn= mysql_connect("localhost","root","") or die('No se pudo conectar');
mysql_select_db("escomtitulos",$conn) or die (
"Error: No es posible establecer la conexión"
);
$query = "SELECT * FROM evento";
$resultSet =mysql_query($query,$conn) or die ('Consulta fallida');
$query1= "SELECT * FROM personal";
$result= mysql_query($query1,$conn)or die ('consulta fallida');
//fin conexion base de datos
//datos tabla_evento.
if($row=mysql_fetch_array($resultSet)){
	$var1=$row["evento_primerTexto"];
	$var2=$row["evento_segundoTexto"];
	$var3=$row["evento_direccion"];
	$var4=$row["evento_programa"];
	
}
//datos tabla_personal
while($paes[]= mysql_fetch_array($result, MYSQL_ASSOC));
/*
echo "<table>\n";
while ($line = mysql_fetch_array($resultSet, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

echo $row["evento_primerTexto"].$row["evento_segundoTexto"];*/
//Variables por hoja para pdf 
	$html = '<ul id="pag">
		<li id="p1">
		  <blockquote>
		  <br><br><br>
		    <pre>'.$var1.'<br><br><br>'.$var2.'<br><br>Ubicacion:<br>'.$var3.'<br>
		     	Teléfono: 5729 6000<br>
		      	Exts. 52056, 52000, 52012 ESCOM</pre>
</blockquote>
		</li>
		</ul>';
	$html2= '<ul id="pag1">
		<br><br><br><br>
			<h1> Programa</h1>
			<ol id="p1">
				<pre>'.$var4.'</pre>
			</ol>
			</ul>';
	$html3='<h2>INSTITUTO POLIT&Eacute;CNICO NACIONAL</h2><ul id="personal">';
	foreach($paes as $pae){
		$html3.= '<li><p id="titulo">'.$pae["personal_titulo"].$pae["personal_nombre"].'<br><br><p id="puesto">'.$pae["personal_puesto"].'</p></li>';
	} 
	$mpdf = new mPDF('c','A4');
	$css = file_get_contents('../css/estilospdf.css');
	$mpdf->writeHTML($css,1);
    $mpdf->writeHTML($html);
	$mpdf->writeHTML($html2);
	$mpdf->shrink_tables_to_fit;
	$mpdf->writeHTML($html3);
	$mpdf->Output('invitacion.pdf','I');
?>