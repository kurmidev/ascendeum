<?php


function getDiceOutput()
{
    return rand(1, 6);
}




function getGridCordinate($gridsize)
{
    $grid = [];
    $c = 0;
    for ($i = 0; $i < $gridsize; $i++) {
        $c++;
        if ($c % 2 == 0) {
            for ($j = $gridsize - 1; $j > -1; $j--) {
                $grid[] = "($j,$i)"; //["y"=>$i,"x"=>$j,1];
            }
        } else {
            for ($j = 0; $j < $gridsize; $j++) {
                $grid[] = "($j,$i)"; //["x"=>$j,"y"=>$i,2];
            }
        }
    }
    return $grid;
}

function iniitalPlaySetup()
{
    return [
        "currentPosition" => 0,
        "positionHistory" => [],
        "coordinateHistory" => [],
        "dicerollHistory" => [],
        "isWinners" => false,
    ];
}

$playerDetails = [];
if (!empty($_POST)) {
    $gridsize = !empty($_POST['grid_size']) ? $_POST['grid_size'] : 4;
    $players = !empty($_POST['players']) ? $_POST['players'] : 3;
    $winnerNumber = $gridsize * $gridsize;
    
    $gridCordinate = getGridCordinate($gridsize);

    $isWinner = false;
    
    while (!$isWinner) {
        for ($p = 0; $p < $players; $p++) {
            $dice = getDiceOutput();
            if (empty($playerDetails[$p])) {
                $playerDetails[$p] = iniitalPlaySetup();
            }

            $currentPosition = $playerDetails[$p]["currentPosition"];
            $newPosition = $currentPosition + $dice;
            if ($newPosition > $winnerNumber) {
                $playerDetails[$p]["currentPosition"] = $currentPosition;
            } else if ($newPosition <= $winnerNumber) {
                $playerDetails[$p]["currentPosition"] = $newPosition;
            }


            $playerDetails[$p]["positionHistory"][] = $playerDetails[$p]["currentPosition"];
            $playerDetails[$p]["dicerollHistory"][] = $dice;
            $playerDetails[$p]["coordinateHistory"][] = $gridCordinate[$playerDetails[$p]["currentPosition"] - 1];

            if ($newPosition == $winnerNumber && !$isWinner) {
                $playerDetails[$p]["isWinners"] = true;
                $isWinner = true;
                break;
            }
        }
    }
}


?>

<html>

<head>

</head>

<body>
    <form method="post" action="">
        <table>
            <tr>
                <td colspan="3">
                    <strong>User Input</strong>
                    <input type="text" name="grid_size" value="<?= !empty($_POST["grid_size"])?$_POST["grid_size"]:"" ?>">
                </td>
                <td colspan="3">
                    <strong>Players Input</strong>
                    <input type="text" name="players" value="<?= !empty($_POST["players"])?$_POST["players"]:"" ?>">
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <input type="submit" value="Play">
                </td>
            </tr>
            <tr>
                <td colspan="6">
            <tr>
                <td>
                    <table  border="1px" padding="2px">
                        <tr>
                            <th>Player no</th>
                            <th>Dice Roll History</th>
                            <th>Position History</th>
                            <th>Coordinate History</th>
                            <th>Winner Status</th>
                        </tr>
                        <?php foreach ($playerDetails as $p => $pd) { ?>
                            <tr>
                                <td> <?= ($p + 1) ?></td>
                                <td><?= implode(",", $pd["dicerollHistory"]) ?></td>
                                <td><?= implode(",", $pd["positionHistory"]) ?></td>
                                <td><?= implode(",", $pd["coordinateHistory"]) ?></td>
                                <td><?= ($pd["isWinners"]) ? "Winner" : "" ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>
