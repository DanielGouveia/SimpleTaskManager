<?php
    include("../mainlib.php");
    $project_id=$_POST['project_id'];
    
    //Remove as tarefas associadas ao projeto
    $result=mysql_query("DELETE FROM task WHERE task_project_id=$project_id");
    test_query_error($result);
    
    //Remove o projeto
    $result=mysql_query("DELETE FROM project WHERE project_id=$project_id");
    test_query_error($result);
    
    write_Manager();
?>
