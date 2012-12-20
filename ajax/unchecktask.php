<?php
    include("../mainlib.php");
    $task_id=$_POST['task_id'];  
    $result=mysql_query("UPDATE task SET task_check=0 WHERE task_id=$task_id");
    if($result)
    {
        echo '<span class="checkbox"  onclick="checktask(\''.$task_id.'\')"></span>';
    }
?>
