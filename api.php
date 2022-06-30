<?php

$fgc = file_get_contents("https://my-json-server.typicode.com/furkancnr/Jsondb/db");
$json = json_decode($fgc,true);
print ($json);
