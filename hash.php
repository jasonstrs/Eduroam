<?php

$hash = $_GET["mdp"];
echo sha1(md5($hash));



?>