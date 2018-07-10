<?php

	include("dbConfig.php");

	$query = mysql_query("Select count(id) From members Where position = 'Student'");
	$result = mysql_fetch_assoc($query);

	$query2 = mysql_query("Select count(bookId) From books");
	$result2 = mysql_fetch_assoc($query2);

	$query3 = mysql_query("Select count(id) From members Where position = 'Faculty'");
	$result3 = mysql_fetch_assoc($query3);

	$query4 = mysql_query("Select count(publisher) From books Group By publisher");
	$result4 = mysql_num_rows($query4);
	
	$query5 = mysql_query("Select sum(price) From books");
	$result5 = mysql_fetch_assoc($query5);

	$query6 = mysql_query("Select count(bookId) From books Where available = 1");
	$result6 = mysql_fetch_assoc($query6);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/dashboard.css">
		<link rel="stylesheet" type="text/css" href="../css/title.css">
	</head>
	<body>
		<div class="title">Dashboard</div>
		<div class="containerDashboard">

			<div class="tile">Total Student : <br> <?php echo $result['count(id)'];?></div>

			<div class="tile">Total Book : <br> <?php echo $result2['count(bookId)']; ?></div>

			<div class="tile">Total Faculty : <br> <?php echo $result3['count(id)']?></div>			

			<div class="tile">Total Publishers: <br> <?php echo $result4; ?></div>

			<div class="tile">Price of all books: <br> <?php echo $result5['sum(price)']; ?></div>

			<div class="tile">Books in library: <br> <?php echo $result6['count(bookId)']; ?></div>

		</div>
	</body>
</html>