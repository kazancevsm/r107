<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Gallery Site (No categories)</title>
		<meta name="robots" content="index, follow, noarchive" />
		<link rel="stylesheet" href="style.css" type="text/css" />

		<!-- This includes the ImageFlow CSS and JavaScript -->
		<link rel="stylesheet" href="imageflow.packed.css" type="text/css" />
		<script type="text/javascript" src="imageflow.packed.js"></script>

	</head>
	<body>
<!-- This is all the XHTML ImageFlow needs-->
<div id='myImageFlow' class='imageflow' >
	<?php
include "conf.php";
$query = mysql_query("SELECT * FROM gallery_photos ORDER BY id_photo DESC");
$row = mysql_fetch_array($query);
$src_photo = $row['src_photo'];
$longdesc_photo = $row['longdesc_photo'];
$w_photo = $row['w_photo'];
$h_photo = $row['h_photo'];
$alt_photo = $row['alt_photo'];
do 
{
		echo"<img src=";
		echo $row['src_photo'];
		echo" longdesc=";
		echo $row['longdesc_photo'];
		echo" width=";
		echo $row['w_photo'];
		echo" height=";
		echo $row['h_photo'];
		echo" alt='";
		echo $row["alt_photo"]; 
		echo "'/>";
}
while ($row = mysql_fetch_array($query));

?>
</div>
	</body>
</html>