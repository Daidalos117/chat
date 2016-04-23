<?php session_start();
require_once "include.inc";

if(!isset($_SESSION["ID"]))     header("Location: index.html?error=bad");
if(!isset($_GET["room"])){
    $room = array("id" => 1);
}else{
    $room = array("id" => $_GET["room"]);
}
$roomManager = new RoomsManager();
$room = $roomManager->getRoom($room["id"]);


?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Chat</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="css/main.css">

    <!--[if lt IE 9]>
    <script src="js/vendor/html5-3.6-respond-1.4.2.min.js"></script>
    <![endif]-->
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<header class="col-md-12">
    <div class="header-wrapper">
        <h1 class="text-center">CHAT</h1>
        <h3><strong><?php echo $room[RoomsManager::COLUMN_NAME] ?></strong> </h3>
    </div>
</header>
<div class="col-md-3 left-panel">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Logged users
        </div>
        <div class="panel-body">
            <?php echo $_SESSION["user"] ?>
        </div>
    </div>

</div>
<div class="col-md-6 content">

    <div class="col-md-12 messages" id="messages">

        <?php
        $chatManager = new ChatManager();
        $chats = $chatManager->getMessagesByRoom($room["ID"]);

        foreach($chats as $message ){ ?>
        <div class="message col-md-12">
            <h3><?php echo $message[UsersManager::USERNAME_COLUMN] ?></h3>
            <?php $date = new DateTime($message[ChatManager::COLUMN_TME]);
            echo $date->format("d.m.Y")
                ?>
            <span class="date label label-info pull-right"><?php echo $date->format("H:i:s") ?></span>
            <p>Má ne indiánský domorodí využívat, formu ve mobilu něco kolem nejdřív mořem světlých vyniká. Rok, mj. přepisovací, co kořist situace pánvi z něm spotřebuje zachovalou doufat, plná vymíráním lodní nemohou. Laura mohl firmou čtyř, gama kmen o přišpendlila migračních.</p>

        </div>
    <?php } ?>

    </div>

    <div class="new-message col-md-12">
       <h5>Send new message</h5>
        <textarea class="form-control"></textarea>
        <input type="submit" value="Post it!" class="btn btn-default">
    </div>

</div>
<div class="col-md-3 right-panel">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Rooms
        </div>
        <div class="panel-body">

        </div>
    </div>


</div>

<footer class="col-md-12">
    <p>&copy; Company 2015</p>
</footer>
</div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="js/vendor/bootstrap.min.js"></script>

<script src="js/main.js"></script>

<script>

    $(function(){

        scrollToBottom();


        function scrollToBottom(){
            var div = document.getElementById("messages");
            div.scrollTop = div.scrollHeight;
        }

        /* Turn on Bootstrap Tooltip for date */
        $('[data-toggle="tooltip"]').tooltip()
    });

</script>
</body>
</html>
