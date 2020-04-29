<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$condition = '';
if(isset($_POST['submit'])){
	$age = $_POST['age'];
	if(!empty($age)) {
		$condition = " where age = $age ";
	}
}
$result = mysqli_query($mysqli, "SELECT * FROM users $condition ORDER BY id DESC"); // using mysqli_query instead
$age_list = mysqli_query($mysqli, "SELECT distinct age FROM users ORDER BY id DESC");
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
	<?php if(isset($_POST['submit']) && !empty($_POST['age'])){ 
		$age = $_POST['age'];
		
	?>
		<a href="dom_pdf.php?age=<?php echo $age; ?>">| Download PDF</a>
	<?php 
		} else {  ?>
	<a href="dom_pdf.php">| Download PDF</a>
	<?php } ?>
	<form class="form-horizontal no-margin" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
	<div class="form-group">
		<div class="row">
		<label class="col-lg-2 control-label">Filter By Age</label>
		<div class="col-lg-4">
			<select id="age-dropdown" name="age" class="form-control">
				<option value="" >Select Age</option>
				<?php while($res = mysqli_fetch_array($age_list)) { ?>
					<option value="<?php echo $res['age'];?>" <?php if(!empty($_POST['age']) && $res['age'] == $_POST['age']) { echo "selected"; }?>><?php echo $res['age'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-lg-2">
		<input type="submit" class="form-control btn btn-info" value="Submit" name="submit">
		</div>
		</div>
	</div>
	</form>
	<table id="example" class="table-striped" cellpadding="5" style="width:100%;">
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
</body>
</html>
