<?php
$title="Login";
    session_start();
    $groups = $group = $chatrooms = "";
    
    if(isset($_POST['login'])){
        
        //$_SESSION['username']=$_POST['username'];
        //$user = $_SESSION['username'];
        $userdoc = new DOMDocument('1.0', 'utf-8');
        $userdoc->preserveWhiteSpace = false;
        $userdoc->formatOutput = true;
        $usersPath = "users.xml";
        $userdoc->load($usersPath);
        $users = $userdoc->getElementsByTagName('user');
        $present = 0;
        if(sizeof($users) > 0)
        {   
            foreach($users as $user)
            {   
                if(strtolower($user->nodeValue) == strtolower($_POST['username']) && password_verify($_POST['password'], $user->getAttribute('password')))
                {
                    $_SESSION['username'] = $user->nodeValue;
                    $present = 1;
                    break;
                }
            }
            if($present==1)
            {
                header("Location:chatrooms.php"); 
                exit($user->nodeValue);
            }
            else
            {
                header("Location:register.php");
            }
        }
        else{
            header("Location:register.php");
        }
    }
    require_once "header.php";
?>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">   
    <a class="" style="color:#ffbf00; font-size:30px; text-decoration:none; font-family: 'Lateef', cursive;" href="chat.php">CHAT ON WEB</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" style="font-size:20px;" href="register.php">Register</a>
            </li>
        </ul>
    </div>
            
</nav>
<div class="container">
    <div class="col" style="width:500px; margin:auto;">
        <form method=POST action="#">
        <h2>Login</h2>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            
        <div class="g-signin2" id="signin" data-onsuccess="onSignIn" style="margin-top:10px; margin-left:150px;"></div>
        </form>
    </div>
</div> 
<div id='div-session'></div>
<div id="profileInfo"></div>
<script>
     function onSignIn(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost:8080/chatapi/tokensignin.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
        console.log('Signed in as: ' + xhr.responseText);
        window.location.href="chatrooms.php";
        };
        xhr.send('idtoken=' + id_token);
    }
</script>
<script src="login.js"></script>
<br />
</body>
</html>