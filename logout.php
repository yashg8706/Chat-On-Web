<?php
//FILE FOR LOGOUT OPERATION
session_start();
if($_POST['logout']==1)
{
    session_destroy();
}
