<?php
    include("../mainlib.php");
    $task_id=$_POST['task_id'];
    $text=$_POST['text'];
    
    $result=mysql_query("SELECT task_project_id FROM task WHERE task_id=$task_id");
    $row=  mysql_fetch_row($result);
    $project_id=$row[0];
    
    $result=mysql_query("INSERT INTO task (task_project_id, task_parent,task_name) 
                                VALUES ($project_id,$task_id,'$text')");
    test_query_error($result);

    write_Manager();
?>
