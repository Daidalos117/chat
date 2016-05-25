
$(function(){


    scrollToBottom();

    runEmoji();



    setInterval(function(){
        getMessages();
    },1000 );

    setInterval(function(){
        loggedIn();
        setTimeout(function(){
            getLogged();
        },200);
        getRooms();
    },20000 );


    turnOnTooltip();

    /** Submits new message */
    $('#newMessage').submit(function(e) {
        e.preventDefault();

        var formData = $('#newMessage').serialize();

        $.ajax({
                type        : 'POST',
                url         : 'ajax/new-message.php',
                data        : formData,
                dataType    : 'json'
            })

            .done(function(data) {

                if(data ){
                    $('#newMessage')[0].reset();
                    var date = new Date();
                    var readable = getReadableDate(date);

                    data.date = readable.date;
                    data.time = readable.time;
                    addMessage(data);
                }



            });

    });

    /** Submits new room */
    $('#newRoomForm').submit(function(e) {
        e.preventDefault();

        var formData = $('#newRoomForm').serialize();

        $.ajax({
                type        : 'POST',
                url         : 'ajax/new-room.php',
                data        : formData,
                dataType    : 'json'
            })

            .done(function(data) {

                if(data ){
                    $('#newRoomForm')[0].reset();
                    getRooms();
                }



            });

    });

    /**
     * Shows input for new room
     */
    $(".add-room").on("click",function(e){
        e.preventDefault();
        $(".new-room-div").slideToggle(500);
    });


    /**
     * Returns readable date and time
     * */
    function getReadableDate(dateObj){
        var data = {};
        data.date = dateObj.getDate()+"."+dateObj.getMonth()+"."+dateObj.getFullYear();
        data.time = dateObj.getHours()+":"+dateObj.getMinutes()+":"+dateObj.getSeconds();
        return data;
    }


    /**
     * Gets currently logged users
     * */
    function getLogged(){
        $.ajax({
            url         : 'ajax/get-logged-users.php',
            dataType    : 'json'
        }).done(function(data) {
            if(data){
                var $list = $(".logged-list");
                $list.html("");
                $.each(data,function(key,value){
                    $list.append("<li><span>"+value.username+"</span></li>");
                })
            }

        });
    }

    /**
     * Gets currently logged users
     * */
    function getRooms(){
        console.log("getrooms");
        $.ajax({
            url         : 'ajax/get-rooms.php',
            dataType    : 'json'
        }).done(function(data) {
            console.log(data);
            if(data){
                var $list = $("#rooms-list tbody");
                $list.html("");
                var html = "";
                $.each(data,function(key,value){
                    html += "<tr>";
                    html += "<td><a href='?room="+value.ID+"'>"+value.name+"</a></td>";
                    if(value.delete){
                        html += "  <td><a id='delete-room' data-room-id='"+value.ID+"'><i class='fa fa-trash-o' ></i></a></td>";
                    }else{
                        html += "<td></td>";
                    }
                    html += "</tr>";
                })
                $list.html(html);

            }

        });
    }

    /**
     * Loggin of user
     * */
    function loggedIn(){
        $.ajax({
            url         : 'ajax/logged-in.php'
        })
    }


    /**
     * Adds message to message wrapper
     * */
    function addMessage(message){
        var last = findLastMessage();
        var template = $(".message.hidden").clone();
        template.removeClass("hidden");
        template.find("h3").html(message.username);
        template.find("p").html(message.message);
        template.find("span.actual-time").html(message.time);
        template.attr("data-id",message.ID);
        template.find("span.date").attr("data-title",message.date);
        template.find("img").attr("src","https://api.adorable.io/avatars/50/" + message.username + "@adorable.io.png")

        last.hide().after(template).fadeIn(500);

        scrollToBottom(200);
        turnOnTooltip();
        runEmoji();
    }



    /**
     * Gets new messages based on last id
     * */
    function getMessages(){

        var lastId = findLastMessage().data("id");
        var data = {};
        data.id = lastId;
        $.ajax({
                type        : 'POST',
                url         : 'ajax/messages.php',
                data        : data,
                dataType    : 'json'
            })

            .done(function(data) {
                if(data){
                    var time = 0;
                    $.each(data, function(index, message){
                        date = new Date(message.time);
                        var readable = getReadableDate(date);
                        message.date = readable.date;
                        message.time = readable.time;
                        setTimeout(function(){
                            addMessage(message);
                        },time);
                        time += 300;
                        console.log(date);
                    })
                }
            });
    }

    /** Delete room */
    $("#rooms-list").on("click","#delete-room",function(){
        var id = $(this).data("room-id");
        $.ajax({
                type        : 'POST',
                url         : 'ajax/delete-room.php',
                data        : "id="+id,
                dataType    : 'json'
            })

            .done(function(data) {
                getRooms();

            });
    });

    /** Finds last Message */
    function findLastMessage(){
        return $(".message").last();
    }

    /** Scrooll to bottom */
    function scrollToBottom(time = 0){
        setTimeout(function(){
            var div = document.getElementById("messages");
            div.scrollTop = div.scrollHeight;
        },time);
    }

    /** Turn on Bootstrap Tooltip for date */
    function turnOnTooltip(){
        $('[data-toggle="tooltip"]').tooltip();
    }

    function runEmoji(){
        emojify.run(document.getElementById('content'));
    }

});

