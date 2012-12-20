<?php
    include("../mainlib.php");
    $task_id=$_POST['task_id'];
    
    //Remove as tarefas dependentes recursivamente
    remove_task_dependencies($task_id);

    write_Manager();
    
    
    //Função para remover as tarefas recursivamente
    function remove_task_dependencies($task_id)
    {
        //Elimina a tarefa
        $result=mysql_query("DELETE FROM task WHERE task_id=$task_id");
        test_query_error($result);
            
        $result=mysql_query("SELECT * FROM task WHERE task_parent=$task_id ORDER BY task_id");
        test_query_error($result);
        
        if(mysql_num_rows($result)>0)
        {
            while($row=mysql_fetch_array($result))
            {
                $subtask_id=$row['task_id'];
                remove_task_dependencies($subtask_id);
            } 
        }
    }
?>
