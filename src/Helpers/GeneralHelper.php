<?php
function view($path,$data) {
    include BASEPATH . "/src/Views/$path.php";
    header("content-type:text/html");
    exit();
}