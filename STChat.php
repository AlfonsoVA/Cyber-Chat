<!DOCTYPE HTML>
<html>
  <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <title>Copy-Chat Ver. 0.2</title>
  </head>
  <body style="background-color: #30302e">
    <div id="divUserLogin" class="container d-flex flex-column mt-5 w-25 p-4" style="background-color: #07093d; border-radius: 35px;">
      <div class="input-group ml-4">
        <span class="input-group-text" id="spanUser"><i class="fa-solid fa-user"></i></span>
        <input type="text" id="inputUser"class="form-control" placeholder="Ingresa un nombre de usuario" aria-label="Usuario" aria-describedby="spanUser" autocomplete="off">
      </div>
      <div class="input-group mt-2">
        <span class="input-group-text" id="spanPass"><i class="fa-solid fa-lock"></i></span>
        <input type="password" id="inputPass" class="form-control" placeholder="Ingresa tu password" aria-label="Password" aria-describedby="spanPass" autocomplete="off">
        <button class="btn btn-light" id="btnShowPass" onclick="showHidePass()"><i class="fas fa-eye"></i></button>
      </div>
      <div class="mx-auto mt-2">
        <button class="btn btn-primary" type="button" onclick="loginUser()">Ingresar</button>
      </div>
    </div>
    <div id="divChatContainer" class="container d-flex flex-column mt-5 w-50 h-80" style="background-color: #07093d; border-radius: 35px; opacity: 0.5">
      <div class="chatElement p-2" style="display:none">
        <img class="rounded-circle mx-auto d-block" src="img/profile.png" width="100">
      </div>
      <div class="p-2 text-center">
        <h3 style="color:white" id="headerUser"></h3>
      </div>
      <div id="chatContainer" class="container" style="background-color: #000000;color:white; max-height:300px; overflow: auto; border-radius: 15px 5px;">
      </div>
      <div class="p-5 d-flex justify-content-center">
        <textarea id="chatTextArea" class="form-control" rows="3" style="background-color: #30302e; color:white;" disabled></textarea>
      </div>
    </div>
  </body>
</html>
<script type="text/javascript">
  var user;
  $(document).ready(function(){
    let chat = document.getElementById("chatContainer");
    //Por cada enter se agrega el contenido al archivo html (o debería... usa funcion post? es necesario?)
    $("#chatTextArea").on('keypress', function(e){
      if(e.which == 13 && !e.shiftKey && $("#chatTextArea").val().trim() != ""){
        $.ajax({
          type: "POST",
          url: "STSendMessage.php",
          data: {msg: $("#chatTextArea").val(), user: user},
          success: function(){
            $("#chatTextArea").val('');
            getFeed();
          }
        });
      }
    });
  });

  /**
   * Muestra/Esconde el password del input de contraseña para acceso.
   */
  function showHidePass(){
    $("#btnShowPass").html($("#inputPass").attr("type") == "text" ? "<i class='fas fa-eye'></i>" : "<i class='fas fa-eye-slash'></i>");
    $("#inputPass").attr("type", $("#inputPass").attr("type") == "text" ? "password" : "text");
  }

  /**
   * Llama ajax + scroll para actualizar el feed del contenedor del chat.
   */
  function getFeed(){
    $.ajax({
      url: "chat.html",
      cache: false,
      success: function(html){
        $("#chatContainer").html(html);
        $("#chatContainer").animate({ scrollTop: $("#chatContainer").prop('scrollHeight') }, 1000);
      }
    });
  }

  /**
   * Accede con el usuario y contraseña agregada para mostrar el chat, en otro caso un alert de error.
   */
  function loginUser(){
    $.ajax({
      type: "POST",
      url: "STLogin.php",
      data: {user: $("#inputUser").val().trim(), pass: $("#inputPass").val().trim()},
      success: function(login){
        if(login){
          $("#divChatContainer").css("opacity","1");
          $(".chatElement").attr("display","block");
          $("#chatTextArea").prop("disabled",false);
          $("#headerUser").html("Bienvenid@ " + $("#inputUser").val().trim());
          user = $("#inputUser").val().trim();
          getFeed();
          $("#divUserLogin").fadeOut();
        }else{
          alert("Usuario o contrasena incorrecta");
        }
      }
    });
  }
</script>
<style>
</style>