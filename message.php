<?php
$title="Message";
$user = $groupname = $group = $button = $chatroom = $str = "";
    session_start();
    if(isset($_SESSION['username']))
    {
        date_default_timezone_set("Canada/Eastern"); 
        $button = "<button type=\"submit\" onclick=\"signOut();\" class=\"btn btn-primary btn-lg\" style=\"margin-left:10px;\" name=\"logout\">LOGOUT</button>";
        $groupname = $_GET['file'];
        $chatroom = "<h1>Group: " . $groupname . "</h1>";
        $user = $_SESSION['username'];
        //echo "Code testing";
        //echo "<h1>" . $user ."</h1>";
        //exit();
        
        $doc = new DOMDocument('1.0', 'utf-8');
        //the two lines below are what sets the auto-indenting
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        //load XML
        $xmlPath = $groupname . ".xml";
        
        $doc->load($xmlPath);
        //get the channel
        $messages = $doc->getElementsByTagName('message');
        foreach($messages as $message){
                $str.= "<div><p><strong>" . $message->nodeValue . "</strong></p><p>         -Sent by<i> " . $message->getAttribute("sender") .  "</i> On- " .$message->getAttribute("messagedate") . " - ".$message->getAttribute("messagetime") . " </p></div><br />";
           }
        
        if(isset($_POST['logout'])){
            session_destroy();
            header("Location:index.php");
        }

        if (isset($_POST['submit'])) {
            //session_start();
            echo $_POST['message'] . "< br/>";
            $user = $_SESSION['username'];
            //echo $user;
            $groupname = $_GET['file'];
            $messagedate = date("Y/d/m");
            $messagetime = date("h:i a");
            $doc = new DOMDocument('1.0', 'utf-8');
            //the two lines below are what sets the auto-indenting
            $doc->preserveWhiteSpace = false;
            $doc->formatOutput = true;
        
            //load XML
            $xmlPath = $groupname . ".xml";
            $doc->load($xmlPath);
            //get the channel
            $group = $doc->getElementsByTagName("group")[0]; //there's only one channel
            //create a new <item> element
            //create <title>
            $message = $doc->createElement("message");
            $messageText = $doc->createTextNode(filter_var($_POST['message'], FILTER_SANITIZE_STRING)); //this should be sanitized
            $message->appendChild($messageText);
    
            $sender = $doc->createAttribute('sender');
            $sender->value = $user;
            $message->appendChild($sender);
    
            $date = $doc->createAttribute('messagedate');
            $date->value = $messagedate;
            $message->appendChild($date);

            $time = $doc->createAttribute('messagetime');
            $time->value = $messagetime;
            $message->appendChild($time);

            $group->appendChild($message);
            //save the file
            $doc->save($xmlPath);
            header("Location:message.php?file=" . $groupname  );

        }
    }
    else
    header("Location:index.php");

    
        
    require_once "header.php";
?>

<body>
<script>
    function signOut() {
        gapi.load('auth2', function() 
        {
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
    <?php echo $chatroom;
        //echo "<h2>Welcome:" . $user . "</h2>"; ?>
   <div style=" padding:5px; margin-top:10px; font-family: 'Kalam', cursive; margin:auto; margin-bottom:10px; background-color:#f9c23d; width:700px; height:400px; overflow: scroll; border: 4px solid  ; border-radius:10px;">
   <?php
    echo $str;
   ?>
   </div>
   <form method=POST >
   <div class="row">
            <input  name="message" style="width:400px; margin-left:300px; background-color:#BEBEBE; color:#000;" class="form-control" type="text"/>
        <div class="col-4">
            <button type="submit" class="btn btn-success" name="submit">SEND</button>
        </div>
    <div>
   </form>
</div>
</body>
</html>