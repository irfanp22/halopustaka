<?php
function passGen($pass)
{
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    echo $pass;
}
passGen('mahasiswa');
?>