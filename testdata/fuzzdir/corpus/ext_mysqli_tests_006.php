<?php
	require_once("connect.inc");

	/*** test mysqli_connect 127.0.0.1 ***/
	$link = my_mysqli_connect($host, $user, $passwd, $db, $port, $socket);

	if (!mysqli_query($link, "SET sql_mode=''"))
		printf("[001] [%d] %s\n", mysqli_errno($link), mysqli_error($link));

	if (!mysqli_query($link,"DROP TABLE IF EXISTS test_bind_fetch"))
		printf("[002] [%d] %s\n", mysqli_errno($link), mysqli_error($link));

	$rc = mysqli_query($link,"CREATE TABLE test_bind_fetch(c1 int unsigned,
													c2 int unsigned,
													c3 int,
													c4 int,
													c5 int,
													c6 int unsigned,
													c7 int) ENGINE=" . $engine);
	if (!$rc)
		printf("[003] [%d] %s\n", mysqli_errno($link), mysqli_error($link));

	if (!mysqli_query($link, "INSERT INTO test_bind_fetch VALUES (-23,35999,NULL,-500,-9999999,-0,0)"))
		printf("[004] [%d] %s\n", mysqli_errno($link), mysqli_error($link));

	$stmt = mysqli_prepare($link, "SELECT * FROM test_bind_fetch");
	mysqli_stmt_bind_result($stmt, $c1, $c2, $c3, $c4, $c5, $c6, $c7);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_fetch($stmt);

	$test = array($c1,$c2,$c3,$c4,$c5,$c6,$c7);

	var_dump($test);

	mysqli_stmt_close($stmt);
	mysqli_query($link, "DROP TABLE IF EXISTS test_bind_fetch");
	mysqli_close($link);
	print "done!";
?>
