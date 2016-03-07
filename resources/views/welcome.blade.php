<!DOCTYPE HTML>

<html lang="es" >

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Alert Movies </title>

    <link rel="stylesheet" href="{{ URL::asset('node_modules/bootstrap/dist/css/bootstrap.css') }}">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>


	<div class="container">
	<div class="row">
        <div class="span12">
        	<h1></h1>
            <div class="form-inline">
            	<p style="font-family: Helvetica; font-size: 20 px; font-weight: 500; margin-bottom: 10px; ">Search the movies of your favorite actors!</p>
                <input id="nameAct" class="span5" type="text"  placeholder="Actor: Brad Pitt"/>
                <button type="button" id="srch_btn" class="btn btn-primary" >Search</button>
                </div>
                <div class="classing" style="display: inline-block; background-color: rgb(200,200,200); width: 40%; padding-top: 15px"></div>
                <div id="description" style="display: inline-block; width: 40%; vertical-align: top; font-family: Helvetica;
                                              font-size: 12px; padding-left: 8px; background-color: rgb(230,230,230); padding-bottom: 8px;"></div>
                <div style="width:40%; display: inline-block;"></div>
                <div id="biography" style="display: inline-block; width: 40%; vertical-align: top;"></div>

            
        </div>
    </div>
</div>

<script type="text/javascript">
    
$( document ).ready(function() {
    console.log( "ready!" );
    
    $("#srch_btn").click(function(){
        $('.classing').empty();
        var name  = $("#nameAct").val();
        var json;
        var url = "find/"+name;
        console.log(url);
         $.ajax({ url: url,
                  type:'GET',
                  dataType: 'json', 
         }).done(function(data){
            console.log(data.value[0]);
            var length = data.value.length;
            console.log(length);
            var html = "";
            for (var i = 0; i<length; i++){
                //var strReplace = data.value[i].replace(" ","-");
             html += '<li style=" padding-left: 3px; list-style: none; font-family: Helvetica; "><a class="description" style=" font-size: 14px; color: rgb(50, 50, 50);text-decoration: none; " href="javascript:;">'+data.value[i]+'</a></li>';
            }
            $('.classing').append(html);
            $('.description').click(function(){
                $('#description').empty();
                var nameMovie = $(this).text();
                var url = "description/"+nameMovie;
                $.ajax({
                    url: url,
                    type:'GET',
                    dataTpe:'json'
                }).done(function(json){
                    console.log(json);
                    $('#description').append('<p style="font-size: 14px; font-weight: bold;">Description</p><p>'+json.overview+'</p>');
                    var cast= '<p>Cast</p>';
                    var content= json.cast.length;
                    for (var i =0; i < content; i++) {
                        cast += '<li style="list-style: none;"><a style="color: rgb(70,70,70); text-decoration: none;" class="biography" href="javascript:;">'+json.cast[i]+'</a></li>'
                    }
                    $('#description').append(cast);

                    $('.biography').click(function () {
                        var nameOfActor= $(this).text();
                        var urlBio = "biography/"+nameOfActor;
                        $.ajax({
                            url:urlBio,
                            type:'GET',
                            dataType:'json'
                        }).done(function(transfer){
                            $('#description').empty();
                            $('#description').append("<p><h3>Information</h3></p>");
                            $('#description').append("<p> Biography: "+transfer.biography+"</p>");
                            $('#description').append("<p>Birthday: "+transfer.birthday+"</p>");
                            $('#description').append("<p>Popularity:"+transfer.popularity+"</p>");
                        });
                    })
                });
            });
         });
    });
});
</script>

</body>

</html>