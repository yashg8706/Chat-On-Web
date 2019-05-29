<?php
$title="Register";
    session_start();
    $groups = $group = $chatrooms = "";
    
    if(isset($_POST['register']))
    {   
        $userdoc = new DOMDocument('1.0', 'utf-8');
        $userdoc->preserveWhiteSpace = false;
        $userdoc->formatOutput = true;
        $usersPath = "users.xml";
        $userdoc->load($usersPath);
        $users = $userdoc->getElementsByTagName('user');
        
       
        $xuser = $userdoc->getElementsByTagName("users")[0]; 
        $userElement = $userdoc->createElement("user");
        $userElementText = $userdoc->createTextNode(filter_var($_POST['username'], FILTER_SANITIZE_STRING)); 
        $userElement->appendChild($userElementText);
       
        $passAttribute = $userdoc->createAttribute('password');

        // Value for the created attribute
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $passAttribute->value =$hash ;

        // Don't forget to append it to the element
        $userElement->appendChild($passAttribute);
        $xuser->appendChild($userElement);
        $userdoc->save($usersPath);
        header("Location:index.php");
    }
    require_once "header.php";
?>
<body>
<nav class="navbar navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" style="margin-left:1000px; " href="chat.php">Login</a>
  </div>
</nav>
<h1 style="color:#306fe5;"><strong>Chat over web</strong></h1>
<div class="container">
    <div class="row">
        <div class="col" style="width:500px; margin:auto;">
            <form method=POST>
            <h2>Registration</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter username">
                
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>