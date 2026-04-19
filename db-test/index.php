<?php
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

	echo $_SERVER['HTTP_HOST'].'<br><br><br>';
	if ($_SERVER['HTTP_HOST'] == 'localhost')
	{
		define('HOST',  'localhost');
		define('USER',  'root');
		define('PASS',  '1550');
		define('DB',    'palindromes');
	}
	else
	{
		define('HOST',  'sql208.infinityfree.com');
		define('USER',  'if0_39026963');
		define('PASS',  'To75hucRBh');
		define('DB',    'if0_39026963_palindromes');
	}
	

	//CONNECT TO THE DATABASE
	$conn = mysqli_connect(HOST,USER,PASS,DB) or die('No connection to mysql.');

	//WRITE A DB QUERY
	$sql = 'SELECT * FROM palindrome;';
	
	//RUN DB QUERY 
	$results = mysqli_query($conn, $sql);

	
	//LOOP THROUGH THE DATA 
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	{
		echo $row['phrase'].'<br>';
	};


?>