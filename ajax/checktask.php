<?php
    include("../mainlib.php");
    $task_id=$_POST['task_id'];  
    $result=mysql_query("UPDATE task SET task_check=1 WHERE task_id=$task_id");
    if($result)
    {
        echo '<span class="checkbox" onclick="unchecktask(\''.$task_id.'\')"><i class="icon-grey icon-ok"></i></span>';
    }
?>
