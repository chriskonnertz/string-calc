<?php

    /**
     * Minimal class autoloader
     *
     * @param string $class
     */
    function miniAutoloader($class)
    {
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
    <style>
        body { padding: 20px }
        h1 { margin-bottom: 40px }
        h4 { margin-top: 40px }
        form { margin-bottom: 20px }
        div.success { border: 1px solid #4ce276; padding: 10px; border-top-width: 10px }
        div.error { border: 1px solid #f36362; padding: 10px; border-top-width: 10px }
    </style>
</head>
<body>
    <h1>StringCalc Demo</h1>

    <form method="POST">

        <div class="form-element">
            <label for="term">Term:</label>
            <input id="term" class="form-field" name="term" type="text" value="<?php echo $term !== null ? $term : '1+(2+max(-3,3))' ?>">
        </div>

        <input type="submit" value="Calc" class="button">
    </form>

    <div class="block result">
        <?php

            $stringCalc = new ChrisKonnertz\StringCalc\StringCalc();

            if ($term !== null) {
                try {
                    $result = $stringCalc->calculate($term);

                    echo '<div class="success">Result: <code><b>' . $result . '</b></code> (Type: ' . gettype($result) . ')</div>';
                } catch (ChrisKonnertz\StringCalc\Exceptions\StringCalcException $exception) {
                    echo '<div class="error">'.$exception->getMessage();
                    if ($exception->getPosition()) {
                        echo ' at position <b>' . $exception->getPosition() . '</b>';
                    }
                    if ($exception->getSubject()) {
                        echo ' with subject "<b>' . $exception->getSubject() . '</b>"';
                    }
                    echo '</div>';
                } catch (Exception $exception) {
                    echo '<div class="error outside">'.$exception->getMessage().'</div>';
                }
            }

        ?>
    </div>

    <div class="block grammar">
        <?php

            $grammar = new \ChrisKonnertz\StringCalc\Grammar\StringCalcGrammar();
            echo '<h4>Grammar rules</h4><pre>'.$grammar->__toString().'</pre>';

        ?>
    </div>
</body>
</html>