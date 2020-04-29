<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC"); // using mysqli_query instead
?>

<html>
<head>	
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
</head>

<body>
<a href="add.html">Add New Data</a>
	<a href="dom_pdf.php">| Download PDF</a>
	<div class="form-group">
		<div class="row">
		<label class="col-lg-2 control-label">Filter By Age</label>
		<div class="col-lg-4">
			<select id="age-dropdown">
				<option value="" >Select Age</option>
			</select>
		</div>
		</div>
	</div>
	<table id="example" class="table-striped">
	<thead>
	<tr bgcolor='#CCCCCC'>
		<th>Name</td>
		<th class="select-filter">Age</td>
		<th>Email</td>
		<th>Update</td>
	</tr>
	</thead>
	<tbody>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['name']."</td>";
		echo "<td>".$res['age']."</td>";
		echo "<td>".$res['email']."</td>";	
		echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</tbody>
	</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
		initComplete: function () {
            this.api().columns('.select-filter').every( function () {
                var column = this;
                var select = $('#age-dropdown')
                    //.appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }	
	});
} );
</script>
</body>
</html>
