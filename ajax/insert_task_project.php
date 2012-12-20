<?php
    include("../mainlib.php");
    $project_id=$_POST['project_id'];
    $text=$_POST['text'];
    
    $result=mysql_query("INSERT INTO task (task_project_id, task_name) 
                                VALUES ($project_id, '$text')");
    test_query_error($result);

    write_Manager();
?>
