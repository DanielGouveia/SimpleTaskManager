<?php
    include("../mainlib.php");
    $task_id=$_POST['task_id'];
    $text=$_POST['text'];
    
    $result=mysql_query("UPDATE task SET task_name='$text' WHERE task_id=$task_id");
    test_query_error($result);

    write_Manager();
?>
