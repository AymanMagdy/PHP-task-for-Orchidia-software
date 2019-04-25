<?php
function insert($id,$username,$email){
    include_once ('connect.php');

    $listFeed->insert([
        'id' => $id,
        'username' => $username,
        'email' => $email
    ]);

    echo "The data entered to the sheet..";
}