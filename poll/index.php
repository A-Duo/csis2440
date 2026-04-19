<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Incredible Poll</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="main-container">
<?php
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    session_start();

    if ($_SERVER['HTTP_HOST'] == 'localhost')
	{
		define('HOST',  'localhost');
		define('USER',  'root');
		define('PASS',  '1550');
		define('DB',    'pollDB');
	}
	else
	{
		define('HOST',  'sql208.infinityfree.com');
		define('USER',  'if0_39026963');
		define('PASS',  'To75hucRBh');
		define('DB',    'if0_39026963_pollDB');
	}

    $conn = mysqli_connect(HOST,USER,PASS,DB) or die('No connection to mysql.');

if ($_POST == null): 
    $results = mysqli_query($conn, 'SELECT id, message FROM answers;');
    ?>
    <h1>Welcome to my <img src="img/cooltext.gif" style="height:3ch;margin-bottom:-.8ch;filter:hue-rotate(190deg) brightness(1.3)"> page!!</h1>
    <br>
    <h2 class="unveil">Please answer my important question:</h2>
    <h3 class="spin" style="--delay:1.8s">What is the best flavor of <span class="pizza-text"><h3>pizza?</h3></span></h3>

    <form method="POST" class="unveil" style="--delay:3.5s;--duration:2s">
        <fieldset>
            <?php while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)): ?>
                <div style="display:block">
                    <input type="radio" name="answer" id="q<?=$row['id']?>" value="q<?=$row['id']?>">
                    <label for="q<?=$row['id']?>"><?= $row['message'] ?></label>
                </div>
            <?php endwhile ?>
        </fieldset>
        <div>
            <input type="submit" value="Submit  " class="button">
            <input type="reset" class="button">
        </div>
    </form>
<?php elseif (preg_match('/^q(\d*)$/i', $_POST['answer'], $rgx_groups)): #fits the question id format
    #Makes sure the selected answer exists
    $choice = $rgx_groups[1];
    $results = $conn->query('SELECT id FROM answers WHERE id='.$choice.' LIMIT 1;');
    if ($results-> num_rows == 0) die("Invalid Form Input");

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        #Log which answer was chosen.
        #The db has a trigger to update the relevant counts so no extra code is needed here.
        $conn->query('INSERT INTO submissions (ssid, choice) VALUES ("'.session_id().'", '.$choice.') ON DUPLICATE KEY UPDATE choice = '.$choice);
    } else {
        # Infinity free disabled trigger functions so I have to redo everything including the code that I already had here from before that did 90% of what the trigger based method did but I refactored, I'm so done AHHHHHHHHH
        $results = $conn->query('SELECT choice FROM submissions WHERE ssid="'.session_id().'";');
        if ($results->num_rows > 0) {
            $old_choice = $results->fetch_row()[0];
            if ($old_choice != $choice) {
                $conn->multi_query(
                    'UPDATE submissions SET choice = '.$choice.' WHERE ssid="'.session_id().'"; '.
                    'UPDATE answers SET count = count - 1 WHERE id='.$old_choice.'; '.
                    'UPDATE answers SET count = count + 1 WHERE id='.$choice.';'
                ); do {} while ($conn->next_result());
            }
        } else {
            $conn->multi_query(
                'INSERT INTO submissions (ssid, choice) VALUE ("'.session_id().'", '.$choice.'); '.
                'UPDATE answers SET count = count + 1 WHERE id='.$choice.';'
            ); do {} while ($conn->next_result());
        }
        //I was overreacting wasn't that bad.
    }

    $total = (int)($conn->query('SELECT COUNT(*) FROM submissions'))->fetch_row()[0];
    ?>
    <h1>The results are IN!</h1>
    <table><tbody>
    <?php
    $results = $conn->query('SELECT * FROM answers ORDER BY count DESC;');
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)):
    ?>
        <tr>
            <td><?=$row['message']?></td>
            <td>
                <div class="bar" style="width:calc(<?=($row['count']/$total)*100?>% - 5ch)"></div>
                (<?=$row['count']?>)
            </td>
        </tr>
    <?php endwhile ?>
    </tbody></table>
<?php else: ?>
    Invalid Form Input
<?php endif ?>
        </div> 
    </body>
</html>