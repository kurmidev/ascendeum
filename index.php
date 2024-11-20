<?php

session_start();
function rollDice(){
    return rand(1,6);
}

function checkStatus($total,$choice,$balance,$betCharge){
    $result = 1;
    $balance = $balance - $betCharge;
    if($total<7 && $choice=="below7"){  
        $balance = $balance + 20;
    }else if($total>7 && $choice=="above7"){
        $balance = $balance + 20;
    }else if($total==7 && $choice=="7"){
        $balance = $balance + 30;
    }else{
        $result = 2;
    }
    $_SESSION['balance'] = $balance;
    return $result;
}

$defaultBalance =100;
$cases = !empty($_GET["action"])?$_GET["action"]:"";
$dice1 = $dice2 = $total = 0;
$betCharge = 10;

$_SESSION["balance"] = !empty($_SESSION['balance']) ? $_SESSION['balance'] : $defaultBalance;
$response  = "";

switch($cases){
    case "diceroll":
        if(!empty($_GET["value"])){
            $_SESSION["value"] = $_GET["value"];
            unset($_SESSION["dice1"]);
            unset($_SESSION["dice2"]);
            unset($_SESSION["total"]);
        }
        break;
    case "play":
        $dice1 = rollDice();
        $dice2 = rollDice();
        $total = $dice1 + $dice2;
        $_SESSION["dice1"] = $dice1;
        $_SESSION["dice2"] = $dice2;
        $_SESSION["total"] = $total;
        $choice = !empty($_SESSION["value"])?$_SESSION["value"]:"";
        $response = checkStatus($total,$choice, $_SESSION["balance"],$betCharge);
        break;
    case "reset":
        unset($_SESSION["dice1"]);
            unset($_SESSION["dice2"]);
            unset($_SESSION["total"]);
            $_SESSION['balance']=100;
        break;
    case "continue":
        unset($_SESSION["dice1"]);
        unset($_SESSION["dice2"]);
        unset($_SESSION["total"]);
        break;
}


?>

<!DOCTYPE html>
<htm>
    <head></head>
    <body>
    <table>
        <tr>
            <th colspan="4">
                Welcome to lucky 7 game
            </th>
        </tr>
        <tr>
            <td  colspan="4">
               Place your bet (Rs 10)
            </td>
        </tr>
        <tr>
            <td>
               <a href="http://localhost:8080/dice.php?action=diceroll&value=below7">[Below 7]</a>
            </td>
            <td>
               <a href="http://localhost:8080/dice.php?action=diceroll&value=7">[7]</a>
            </td>
            <td>
               <a href="http://localhost:8080/dice.php?action=diceroll&value=above7">[Above 7]</a>
            </td>
            <td>
               <a href="http://localhost:8080/dice.php?action=play">[Play]</a>
            </td>
        </tr>
        <tr>
            <td  colspan="4">
               Game Results
            </td>
        </tr>    
        <tr>
            <td  colspan="4">
               Dice 1 : <?=!empty($_SESSION["dice1"])?$_SESSION["dice1"]:""?><br>
               Dice 2 : <?=!empty($_SESSION["dice2"])?$_SESSION["dice2"]:""?><br>
               Total  : <?=!empty($_SESSION["total"])?$_SESSION["total"]:""?> <br>
            </td>
        </tr>    
        <tr>
            <td  colspan="4">
                <?php if($response!=""){
                    echo  ($response==1?("Congratulations! You win |"):("Sorry| You loose| ")). "Your balance is now ".$_SESSION["balance"]." Rs. ";
                }?>
               
            </td>
        </tr>    

        <tr>
            <td  colspan="2">
            <a href="http://localhost:8080/dice.php?action=reset"> Reset and Play Again</a>
            </td>
            <td  colspan="2">
            <a href="http://localhost:8080/dice.php?action=continue">Continue Playing</a>
            </td>
        </tr>    
    </table>
    </body>
</htm>
