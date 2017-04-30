<?php

	function miniAutoloader($class) {
	    require __DIR__ . '/../src/' . $class . '.php';
	}

	spl_autoload_register('miniAutoloader');

    $term = isset($_POST['term']) ? $_POST['term'] : null;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StringCalc Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/framy/latest/css/framy.min.css">
</head>
<body>
    <h1>StringCalc Demo</h1>

	<form method="POST">
		Term:
		<input id="term" name="term" type="text" value="<?php echo $term !== null ? $term : '1+(2+max(-3,3))' ?>">
		<input type="submit" value="Calc">
	</form>

	<?php

		if ($term) {
			$stringCalc = new ChrisKonnertz\StringCalc\StringCalc();

			$result = $stringCalc->calculate($term);

			echo 'Result: '.$result. ' (Type: '.gettype($result).')';
		}

	?>
</body>
</html>