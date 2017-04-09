<?php

	function miniAutoloader($class) {
	    require __DIR__ . '/../src/' . $class . '.php';
	}

	spl_autoload_register('miniAutoloader');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>StringCalc Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/framy/latest/css/framy.min.css">
</head>
<body>
	<form method="POST">
		Term:
		<input id="term" name="term" type="text" value="1+1">
		<input type="submit" value="Calc">
	</form>

	<?php

		$term = isset($_POST['term']) ? $_POST['term'] : null;

		if ($term) {
			$stringCalc = new ChrisKonnertz\StringCalc\StringCalc();

			$result = $stringCalc->calculate($term);

			var_dump($result);
		}
		
	?>
</body>
</html>