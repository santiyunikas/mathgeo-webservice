<?php
$db = \Config\Database::connect();
$db = db_connect();

if(isset($_GET['email'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
                 
    $query = $db->query('YOUR QUERY HERE');
    $search = mysql_query("SELECT email FROM is_verified_member WHERE email='".$email) or die(mysql_error()); 
    $match  = mysql_num_rows($search);
                  
    if($match > 0){
        // We have a match, activate the account
        mysql_query("UPDATE is_verified_member SET active='1' WHERE email='".$email."'AND active='0'") or die(mysql_error());
        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
    }else{
        // No match -> invalid url or account has already been activated.
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
    }
                  
}else{
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}
?>