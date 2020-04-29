<?php
require_once("dompdf/autoload.inc.php");;
//require_once "dompdf_config.inc.php";
include_once("config.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$where_condition='';
if(isset($_GET['age'])){
	$where_condition = " where age= ".$_GET['age']." ";
}
$result = mysqli_query($mysqli, "SELECT * FROM users $where_condition ORDER BY id DESC"); 
	$html_row = '';
	while($res = mysqli_fetch_array($result)) { 		
		$html_row .= "<tr>";
		$html_row .= "<td>".$res['name']."</td>";
		$html_row .= "<td>".$res['age']."</td>";
		$html_row .= "<td>".$res['email']."</td>";
	}
$html = "
<html>
 <body>
  	<table id='example' class='table-striped'>
	<thead>
	<tr bgcolor='#CCCCCC'>
		<th>Name</td>
		<th class='select-filter'>Age</td>
		<th>Email</td>
	</tr>
	</thead>
	<tbody>
	$html_row
	</tbody>
	</table>
 </body>
</html>";

$dompdf->loadHtml($html);
$dompdf->render();

$dompdf->stream("hello.pdf");