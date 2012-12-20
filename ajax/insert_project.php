<?php
    include("../mainlib.php");
    $text=$_POST['text'];
    
    $result=mysql_query("INSERT INTO project (project_name) VALUES ('$text')");
    test_query_error($result);

    write_Manager();
?>
