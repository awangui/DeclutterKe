<?php
function check_login($con)
{
    if(isset ($_SESSION['user_id']))
    {
        $id= $_SESSION['user_id'];
        $query = "select * from users where user_id ='$id' limit 1";

    }
}