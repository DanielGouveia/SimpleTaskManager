<?php
    include("../mainlib.php");
    $project_id=$_POST['project_id'];
    $text=$_POST['text'];
    
    $result=mysql_query("UPDATE project SET project_name='$text' WHERE project_id=$project_id");
    test_query_error($result);

    write_Manager();
?>
