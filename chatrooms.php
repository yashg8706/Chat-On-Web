<?php
$title="Chatrooms";
    session_start();
    $error = $links = "";
    if(isset($_SESSION['username']))
    {
        $button = "<button type=\"submit\" onclick=\"signOut();\" class=\"btn btn-primary btn-lg\" style=\"\" name=\"logout\">LOGOUT</button>";
        $doc = new DOMDocument('1.0', 'utf-8');
        //the two lines below are what sets the auto-indenting
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        //load XML
        $xmlPath = "chatrooms.xml ";
        $doc->load($xmlPath);
        //get the channel
        $groups = $doc->getElementsByTagName('group');
        foreach ($groups as $group) {
            $links .= '<button type="button" class="btn btn-primary btn-lg btn-block"><a style="text-decoration:none; text-alogn:center;color:#fff;"  href="message.php?file=' .$group->nodeValue. '" name="message">' . $group->nodeValue . '</a></button>';
        }
    }
    else
    header("Location:index.php");
  
    require_once "header.php";
?>
<body>
<script>
    function signOut() {
        gapi.load('auth2', function() {
        gapi.auth2.init();
        });
        var auth2 = gapi.auth2.getAuthInstance();
        if(auth2!=0){
            auth2.disconnect();
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:8080/chatapi/logout.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() 
            {
                window.location.href="index.php";
            };
            xhr.send('logout=1');
        }
        auth2.signOut().then(function () {
        document.getElementById('profileInfo').innerHTML = "";
        });
    }
    function onLoad() 
    {
      gapi.load('auth2', function() {
        gapi.auth2.init();
      });
    }

</script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">   
    <a class="" style="color:#ffbf00; font-size:30px; text-decoration:none; font-family: 'Lateef', cursive;" href="chat.php">CHAT ON WEB</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <p class="nav-item" style="font-size:20px; margin-right:20px; color:#fff;">Welcome: <?php echo $_SESSION['username'] ?></p>
            <?php  
            echo $button;
            ?>
        </ul>
    </div>
            
</nav>

<div class="container">
    <h2>Chatrooms</h2>
    <?php 
        echo $links;
    ?>
    </div>
</body>
</html>