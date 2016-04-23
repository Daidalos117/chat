<?php
require_once "include.inc";
$userManager = new UsersManager();
if(!isset($_SESSION["ID"]) and $userManager->getUserByHash($_SESSION["ID"]))     header("Location: index.html?error=bad");
if(!isset($_GET["room"])){
    $room = array("id" => 1);
}else{
    $room = array("id" => $_GET["room"]);
}
$roomManager = new RoomsManager();
$room = $roomManager->getRoom($room["id"]);
if(!$room)  header("Location: 404.html");
$_SESSION["room"] = $room;


?>
<!doctype html>
<html class="no-js" lang="" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Chat</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

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
        <h1 class="text-center"><i class="fa fa-comment" aria-hidden="true"></i> CHAT</h1>
        <h3><strong><?php echo $room[RoomsManager::COLUMN_NAME] ?></strong> </h3>
    </div>
</header>
<div class="col-md-3 left-panel">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-users" aria-hidden="true"></i>
            Logged users
        </div>
        <div class="panel-body">
            <?php echo $_SESSION["user"] ?>
        </div>
    </div>

</div>
<div class="col-md-6 content">

    <div class="col-md-12 messages" id="messages">
        <div class="message hidden col-md-12" data-id="">
            <div class="col-md-1">
                <img src="https://api.adorable.io/avatars/50/@adorable.io.png" alt="avatar" class="img-rounded">
            </div>
            <div class="col-md-11">
            <h3></h3>
                <span class="date label label-info pull-right" data-toggle="tooltip" data-placement="top" title=""></span>
                <p></p>
            </div>
        </div>


        <?php
        $chatManager = new ChatManager();
        $chats = $chatManager->getMessagesByRoom($room["ID"]);

        foreach($chats as $message ){ ?>
        <div class="message col-md-12" data-id="<?php echo $message["ID"] ?>">
            <div class="col-md-1 img">
                <img src="https://api.adorable.io/avatars/44/<?php echo $message[UsersManager::USERNAME_COLUMN] ?>@adorable.io.png" alt="avatar" class="img-circle">
            </div>
            <div class="col-md-11 mes">
                <h3><?php echo $message[UsersManager::USERNAME_COLUMN] ?></h3>
                <?php $date = new DateTime($message[ChatManager::COLUMN_TME]) ?>
                <span class="date pull-right" data-toggle="tooltip" data-placement="top" title="<?php echo $date->format("d.m.Y") ?>">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <span class="actual-time">
                        <?php echo $date->format("H:i:s") ?>
                    </span>
                </span>
                <p><?php echo $message[ChatManager::COLUMN_MESSAGE] ?></p>
            </div>
        </div>
    <?php } ?>

    </div>

    <div class="new-message col-md-12">
       <h5>Send new message</h5>
        <form id="newMessage">
            <textarea class="form-control" name="message"></textarea>
            <input type="hidden" value="<?php echo $room["ID"] ?>" name="room" id="room-id">
            <input type="submit" value="Post it!" class="btn btn-default" id="sendMessage">

        </form>
    </div>

</div>
<div class="col-md-3 right-panel">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-sitemap" aria-hidden="true"></i>
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

        console.log(  $(".message.hidden").clone() );

        scrollToBottom();

        setInterval(function(){
            getMessages();
        },10000 );






        $('#newMessage').submit(function(e) {
            e.preventDefault();

            var formData = $('#newMessage').serialize();

            $.ajax({
                    type        : 'POST',
                    url         : 'new-message.php',
                    data        : formData,
                    dataType    : 'json'
                })

                .done(function(data) {

                    if(data ){
                        $('#newMessage')[0].reset();
                        var date = new Date();
                        data.date = date.getDate()+"."+date.getMonth()+"."+date.getYear();
                        data.time = date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                        addMessage(data);
                    }


                    /*
                    $alert = $(".alert");
                    $alert.removeClass("alert-danger");
                    $alert.removeClass("alert-success");
                    if(data.error){
                        $alert.addClass("alert-danger");
                        $alert.html(data.error);
                    }
                    if(data.succes){
                        $alert.addClass("alert-success");
                        $alert.html(data.succes);
                        $('.register-form')[0].reset();
                        $(".sign-up").slideUp(500);
                    }

                    $(".alert-wrapper").slideDown(500);
                    setTimeout(function(){
                        $(".alert-wrapper").slideUp(500);
                    }, 3000);
                    */

                });

        });


        function addMessage(message){
            var last = findLastMessage();
            var template = $(".message.hidden").clone();
            template.removeClass("hidden");
            template.children("h3").html(message.user);
            template.children("p").html(message.message);
            template.children("span").html(message.time);
            template.data("id",message.ID);
            template.children("span").data("original-title",message.date);

            last.hide().after(template).fadeIn(500);
            scrollToBottom(200);

        }

        function getMessages(){

            var lastId = findLastMessage().data("id");
            var data = {};
            data.id = lastId;
            $.ajax({
                    type        : 'POST',
                    url         : 'messages.php',
                    data        : data,
                    dataType    : 'json'
                })

                .done(function(data) {
                    if(data){

                    }
                });
        }




        function findLastMessage(){
            return $(".message").last();
        }

        function scrollToBottom(time = 0){
            setTimeout(function(){
                var div = document.getElementById("messages");
                div.scrollTop = div.scrollHeight;
            },time);
        }

        /* Turn on Bootstrap Tooltip for date */
        $('[data-toggle="tooltip"]').tooltip()
    });

</script>
</body>
</html>
