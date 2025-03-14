<?php
function calculateExpression($expression)
{
    $number = '';
    $operator = '';
    $result = 0;

    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];
        if ($char >= '0' && $char <= '9') {
            $number .= $char;
        } else {
            if ($operator) {
                $num = $number;
                switch ($operator) {
                    case '+':
                        $result += $num;
                        break;
                    case '-':
                        $result -= $num;
                        break;
                    case '*':
                        $result *= $num;
                        break;
                    case '/':
                        $result = ($num != 0) 
                        ? $result/$num
                        : 'Cannot divide by zero';
                        break;
                }
            } else {
                $result = $number;
            }
            $operator = $char;
            $number = '';
        }
    }


    if ($number !== '') {
        $num = $number;
        switch ($operator) {
            case '+':
                $result += $num;
                break;
            case '-':
                $result -= $num;
                break;
            case '*':
                $result *= $num;
                break;
            case '/':
                $result = ($num != 0) 
                ? $result/$num 
                : 'Cannot divide by zero';
                break;
        }
    }
    return $result;
}

$expression = isset($_POST['expression'])
    ? $_POST['expression']
    : '';
$result = isset($_POST['result'])
    ? $_POST['result']
    : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clear'])) {
        $expression = $result = '';
    } elseif (isset($_POST['num'])) {
        $expression .= $_POST['num'];
    } elseif (isset($_POST['operator'])) {
        $length = strlen($expression);
        $lastChar = $length > 0 
        ? $expression[$length - 1] 
        : '';
        if ($expression !== '' && ($lastChar !== '+' && $lastChar !== '-' && $lastChar !== '*' && $lastChar !== '/')) {
            $result = calculateExpression($expression);
        }
        $expression .= $_POST['operator'];
    } elseif (isset($_POST['equals'])) {
        $length = strlen($expression);
        $lastChar = $length > 0
         ? $expression[$length - 1] 
         : '';
        if ($expression !== '' && ($lastChar !== '+' && $lastChar !== '-' && $lastChar !== '*' && $lastChar !== '/')) {
            $result = calculateExpression($expression);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .calculator {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .display {
            margin-bottom: 10px;
            padding: 10px;
            width: 90%;
            font-size: 20px;
            text-align: right;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #e0e0e0;
            word-wrap: break-word;
            min-height: 40px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        button {
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .num {
            background: #e0e0e0;
        }

        .operator {
            background: #28a745;
            color: white;
        }

        .operator:hover {
            background: #218838;
        }

        .clear {
            background: #dc3545;
            color: white;
        }

        .clear:hover {
            background: #c82333;
        }

        .equals {
            background: #007bff;
            color: white;
        }

        .equals:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="calculator">
        <h2>PHP Calculator</h2>
        <div class="display">
            <?= ($expression) ?>
        </div>
        <div class="display"><strong>Result: <?= $result; ?></strong></div>

        <form method="post">
            <input type="hidden" name="expression" value="<?= ($expression) ?>">
            <input type="hidden" name="result" value="<?= $result ?>">
            <div class="buttons">
                <button type="submit" name="num" value="1" class="num">1</button>
                <button type="submit" name="num" value="2" class="num">2</button>
                <button type="submit" name="num" value="3" class="num">3</button>
                <button type="submit" name="operator" value="+" class="operator">+</button>

                <button type="submit" name="num" value="4" class="num">4</button>
                <button type="submit" name="num" value="5" class="num">5</button>
                <button type="submit" name="num" value="6" class="num">6</button>
                <button type="submit" name="operator" value="-" class="operator">-</button>

                <button type="submit" name="num" value="7" class="num">7</button>
                <button type="submit" name="num" value="8" class="num">8</button>
                <button type="submit" name="num" value="9" class="num">9</button>
                <button type="submit" name="operator" value="*" class="operator">*</button>

                <button type="submit" name="num" value="0" class="num">0</button>
                <button type="submit" name="clear" class="clear">C</button>
                <button type="submit" name="equals" class="equals">=</button>
                <button type="submit" name="operator" value="/" class="operator">/</button>
            </div>
        </form>
    </div>
</body>

</html>
