<?php

session_start();
include("connectiondbfile.php");

function create_connectiondbfile($dbhost,$dbname,$user,$pass)
{
    $databasename=$dbname;
    
    //Criação da base de dados
    $connection = mysql_connect($dbhost,$user,$pass) or die ("Cannot access the database");
    $query=mysql_query("CREATE DATABASE IF NOT EXISTS ".$databasename,$connection);
    test_query_error($query);
    
    //Criação das tabelas
    mysql_select_db($databasename, $connection);
    $tableproject=mysql_query("CREATE TABLE IF NOT EXISTS `project` 
                                (`project_id` int(11) NOT NULL AUTO_INCREMENT,
                                `project_name` varchar(50) NOT NULL,
                                PRIMARY KEY (`project_id`)
                                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
    test_query_error($tableproject);
    
    $tabletask=mysql_query("CREATE TABLE IF NOT EXISTS `task` 
                            (`task_id` int(11) NOT NULL AUTO_INCREMENT,
                            `task_project_id` int(11) NOT NULL,
                            `task_parent` int(11) DEFAULT '0',
                            `task_order` int(11) DEFAULT NULL,
                            `task_name` varchar(100) NOT NULL,
                            `task_check` tinyint(1) DEFAULT '0',
                            PRIMARY KEY (`task_id`),
                            KEY `fk_project_task` (`task_project_id`)
                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;");
    test_query_error($tabletask);
    
    //Preparação do conteudo do ficheiro
    $data='<?php $connection = mysql_connect("'.$dbhost.'","'.$user.'","'.$pass.'") or die ("Cannot access the database");
           $bdlink = mysql_select_db("'.$databasename.'") or die ("Cannot access the table");
           mysql_set_charset("utf8",$connection); ?>';
    
    //Cria o ficheiro
    $my_file = 'connectiondbfile.php';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

    //Escreve no ficheiro
    fwrite($handle, utf8_encode($data));
    
    //Fecha o ficheiro
    fclose($handle);
}

function test_query_error($result)
{
    if (!$result) 
    {
        die('Invalid query: ' . mysql_error());
    }
}
function get_links()
{
    echo '<meta charset="UTF-8">
        <title> Simple Task Manager </title>
        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mainlib.js"></script>';
}
function write_Scriptshowonhover() 
{
    echo '<!-- Script para mostrar e ocultar os controlos -->
        <script>
            $(".task").hover(
                function () {
                    $(this).find(".show_on_hover").show();
                }, 
                function () {
                    $(this).find(".show_on_hover").hide();
                }
            );  
            $(".task").find(".show_on_hover").hide();
            
            $(".accordion-heading").hover(
                function () {
                    $(this).find(".show_on_hover").show();
                }, 
                function () {
                    $(this).find(".show_on_hover").hide();
                }
            );
            $(".accordion-group").find(".show_on_hover").hide();
        </script>';
}
function write_Manager()
{
    write_InsertProjectModal();
    echo '<div class="topcontrols">
            <a href="#InsertProjectModal" class="btn btn-mini btn-primary" data-toggle="modal" onclick="setfocusInsertProjectModal();">New group</a>
          </div>';
    $result=mysql_query("SELECT * FROM project");
    while($row=mysql_fetch_array($result))
    {
        $project_id=$row['project_id'];
        write_InsertTaskProjectModal($project_id);
        write_RemoveProjectModal($project_id);
        write_EditProjectModal($project_id);
        
        if(isset($_SESSION['colapsedprojects']))
        {
            $colapsedprojects=$_SESSION['colapsedprojects'];
        }
        else
        {
            $_SESSION['colapsedprojects']=array();
            $colapsedprojects=array();
        }
        if(in_array($project_id, $colapsedprojects))
        {
            echo '<div class="accordion-group">';
                echo '<div class="accordion-heading projectname">
                        <span id="IconProject'.$project_id.'">
                            <i class="icon-grey icon-minus pointer" data-toggle="collapse" data-target="#collapse'.$project_id.'" onclick="TogglePlusiconp('.$project_id.');"></i>
                        </span>
                        <a class="accordion-toggle">
                            '.$row['project_name'].'
                        </a>';
                        write_donetasksfromproject($project_id);
                 echo '<span class="show_on_hover">
                            <a href="#InsertTaskProjectModal'.$project_id.'" data-toggle="modal" onclick="setfocusInsertTaskProjectModal('.$project_id.');"><i class="icon-grey icon-plus-sign pointer"></i></a>
                            <a href="#RemoveProjectModal'.$project_id.'" data-toggle="modal"><i class="icon-grey icon-remove-sign pointer"></i></a>
                            <a href="#EditProjectModal'.$project_id.'" data-toggle="modal" onclick="setfocusEditProjectModal('.$project_id.');"><i class="icon-grey icon-pencil pointer"></i></a>
                        </span>
                        </div>';
                        echo '<div id="collapse'.$project_id.'" class="accordion-body in collapse" style="height: auto;">';
                    echo '  <div class="accordion-inner">';
                    write_tasks($project_id);
                echo '</div>
                    </div>';        
            echo '</div>';
        }
        else
        {
            echo '<div class="accordion-group">';
                echo '<div class="accordion-heading projectname">
                        <span id="IconProject'.$project_id.'">
                            <i class="icon-grey icon-plus pointer" data-toggle="collapse" data-target="#collapse'.$project_id.'" onclick="ToggleMinusiconp('.$project_id.');"></i>
                        </span>
                        <a class="accordion-toggle">
                            '.$row['project_name'].'
                        </a>';
                        write_donetasksfromproject($project_id);
                 echo '
                        <span class="show_on_hover">
                            <a href="#InsertTaskProjectModal'.$project_id.'" data-toggle="modal" onclick="setfocusInsertTaskProjectModal('.$project_id.');"><i class="icon-grey icon-plus-sign pointer"></i></a>
                            <a href="#RemoveProjectModal'.$project_id.'" data-toggle="modal"><i class="icon-grey icon-remove-sign pointer"></i></a>
                            <a href="#EditProjectModal'.$project_id.'" data-toggle="modal" onclick="setfocusEditProjectModal('.$project_id.');"><i class="icon-grey icon-pencil pointer"></i></a>
                        </span>
                        </div>';
                        echo '<div id="collapse'.$project_id.'" class="accordion-body collapse">';
                    echo '  <div class="accordion-inner">';
                    write_tasks($project_id);
                echo '</div>
                    </div>';        
            echo '</div>';
        }
    }
    //Script para mostrar e ocultar os controlos
    write_Scriptshowonhover();                    
}

function write_donetasksfromproject($id)
{
    $result=mysql_query("SELECT * FROM task WHERE task_project_id=$id");
    test_query_error($result);
    $checked=0;
    $total=0;
    while($row=mysql_fetch_array($result))
    {
        $task_id=$row['task_id'];
        $result2=mysql_query("SELECT * FROM task WHERE task_parent = $task_id");
        test_query_error($result2);
        $task_parent=mysql_num_rows($result2);
        if( $task_parent==0)
        {
            $total++;
            if($row['task_check']==1)
            {
                $checked++;
            }
        }
    }
    echo '<a class="style1">('.$checked.'/'.$total.')</a>';
}

//desativado para produzir um aspeto visual mais limpo
/*
 function write_donetasks($id)
{
    $result=mysql_query("SELECT * FROM task WHERE task_parent = $id");
    test_query_error($result);
    $checked=0;
    $total=0;
    while($row=mysql_fetch_array($result))
    {
        $task_id=$row['task_id'];
        $result2=mysql_query("SELECT * FROM task WHERE task_parent = $task_id");
        test_query_error($result2);
        $task_parent=mysql_num_rows($result2);
        if($task_parent==0)
        {
            $total++;
            if($row['task_check']==1)
            {
                $checked++;
            }
        }
    }
    if($total>0)
    {
        echo '<a class="style1">('.$checked.'/'.$total.')</a>';
    }
}
*/

$i=0; //Variavel de controlo para construir um array com as tasks ja escritas
$taskarray=array(); //Array com as tasks ja escritas

function write_tasks($project_id)
{
    global $i;
    $result2=mysql_query("SELECT * FROM task WHERE task_project_id=$project_id");
    while($row2=mysql_fetch_array($result2))
    {    
        test_task_parent($row2);
        $i++;
    }
}

function test_task_parent($row2)
{
    global $i;
    global $taskarray;
    $task_id=$row2['task_id'];
    $result3=mysql_query("SELECT * FROM task WHERE task_parent=$task_id ORDER BY task_id");
    $i++;
    if($result3)
    {
        if(mysql_num_rows($result3)>0)
        {
            if(!in_array($task_id, $taskarray))
            {
                $taskarray[$i]=$task_id;
                //escreve os Modal
                write_InsertTaskModal($task_id);
                write_RemoveTaskModal($task_id);
                write_EditTaskModal($task_id);
                //Escreve os grupos de tasks consoante entejam abertas ou fechadas
                if(isset($_SESSION['colapsedtasks']))
                {
                    $colapsedtasks=$_SESSION['colapsedtasks'];
                    //print_r($colapsedtask);
                }
                else
                {
                    $_SESSION['colapsedtasks']=array();
                    $colapsedtasks=array();
                }
                if(in_array($task_id, $colapsedtasks))
                {
                    echo '<div class="accordion-group">
                            <div class="accordion-heading taskgroup">
                                <span id="IconTask'.$task_id.'">
                                    <i class="icon-grey icon-minus pointer" data-toggle="collapse" data-target="#collapsegroup'.$row2['task_id'].'" onclick="TogglePlusicont('.$row2['task_id'].');"></i>
                                </span>
                                <a class="accordion-toggle">
                                    '.$row2['task_name'].'
                                </a>';
                                //write_donetasks($task_id);
                          echo '<span class="show_on_hover">
                                    <a href="#InsertTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusInsertTaskModal('.$task_id.');"><i class="icon-grey icon-plus-sign pointer"></i></a>
                                    <a href="#RemoveTaskModal'.$task_id.'" data-toggle="modal"><i class="icon-grey icon-remove-sign pointer"></i></a>
                                    <a href="#EditTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusEditTaskModal('.$task_id.');"><i class="icon-grey icon-pencil pointer"></i></a>
                                </span>
                                <span id="checkbox'.$task_id.'">';
                                if($row2['task_check']==1)
                                {
                                    echo '<span class="checkbox" onclick="unchecktask(\''.$task_id.'\')"><i class="icon-grey icon-ok"></i></span>';
                                }
                                else
                                {
                                    echo '<span class="checkbox" onclick="checktask(\''.$task_id.'\')"></span>';
                                }
                    echo '   </div>
                            <div id="collapsegroup'.$task_id.'" class="accordion-body in collapse taskgroup" style="height: auto;">
                                <div class="accordion-inner">';
                                    while($row3=mysql_fetch_array($result3))
                                    {
                                        test_task_parent($row3);
                                    }
                    echo       '</div>
                            </div>
                        </div>';
                }
                else
                {
                    echo '<div class="accordion-group">
                            <div class="accordion-heading taskgroup">
                                <span id="IconTask'.$task_id.'">
                                    <i class="icon-grey icon-plus pointer" data-toggle="collapse" data-target="#collapsegroup'.$row2['task_id'].'" onclick="ToggleMinusicont('.$row2['task_id'].');"></i>
                                </span>
                                <a class="accordion-toggle">
                                    '.$row2['task_name'].'
                                </a>';
                                //write_donetasks($task_id);
                          echo '<span class="show_on_hover">
                                    <a href="#InsertTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusInsertTaskModal('.$task_id.');"><i class="icon-grey icon-plus-sign pointer"></i></a>
                                    <a href="#RemoveTaskModal'.$task_id.'" data-toggle="modal"><i class="icon-grey icon-remove-sign pointer"></i></a>
                                    <a href="#EditTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusEditTaskModal('.$task_id.');"><i class="icon-grey icon-pencil pointer"></i></a>
                                </span>
                                <span id="checkbox'.$task_id.'">';
                                if($row2['task_check']==1)
                                {
                                    echo '<span class="checkbox" onclick="unchecktask(\''.$task_id.'\')"><i class="icon-grey icon-ok"></i></span>';
                                }
                                else
                                {
                                    echo '<span class="checkbox" onclick="checktask(\''.$task_id.'\')"></span>';
                                }
                    echo '   </div>
                            <div id="collapsegroup'.$task_id.'" class="accordion-body collapse taskgroup">
                                <div class="accordion-inner">';
                                    while($row3=mysql_fetch_array($result3))
                                    {
                                        test_task_parent($row3);
                                    }
                    echo       '</div>
                            </div>
                        </div>';
                }
            }
        }
        else
        {
            if(!in_array($task_id, $taskarray))
            {
                $taskarray[$i]=$task_id;
                write_InsertTaskModal($task_id);
                write_RemoveTaskModal($task_id);
                write_EditTaskModal($task_id);
                echo '<div class="task" id="task'.$task_id.'">
                        <span class="tasklabel">
                            <a>'.$row2['task_name'].'</a>
                            <span class="show_on_hover">
                                <a href="#InsertTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusInsertTaskModal('.$task_id.');"><i class="icon-grey icon-plus-sign pointer"></i></a>
                                <a href="#RemoveTaskModal'.$task_id.'" data-toggle="modal"><i class="icon-grey icon-remove-sign pointer"></i></a>
                                <a href="#EditTaskModal'.$task_id.'" data-toggle="modal" onclick="setfocusEditTaskModal('.$task_id.');"><i class="icon-grey icon-pencil pointer"></i></a>
                            </span>
                        </span>
                        <span id="checkbox'.$task_id.'">';
                        if($row2['task_check']==1)
                        {
                            echo '<span class="checkbox" onclick="unchecktask(\''.$task_id.'\')"><i class="icon-grey icon-ok"></i></span>';
                        }
                        else
                        {
                            echo '<span class="checkbox" onclick="checktask(\''.$task_id.'\')"></span>';
                        }
                echo '</span>
                    </div>';
            }
        }
    }

}
function write_InsertTaskModal($id)
{
   echo '<div class="modal hide fade" id="InsertTaskModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>New task</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <span id="RegAlertAccountModal"> </span>
                    <form class="simpleform">
                        <div class="row">
                            <input type="text" id="InputInsertTaskModal'.$id.'" maxlength="100">
                            <input type="submit" class="btn btn-primary focusonme" value="Save" onclick="InsertTask('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_RemoveTaskModal($id)
{
   $result=mysql_query("SELECT task_name FROM task WHERE task_id=$id");
   $row=mysql_fetch_row($result);
   $task_name=$row[0];
   echo '<div class="modal hide fade" id="RemoveTaskModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Remove task</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <label>Remove task \'<b>'.$task_name.'\'</b> ?</label>
                            <input type="button" class="btn btn-danger focusonme" value="Yes" onclick="RemoveTask('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_EditTaskModal($id)
{
   $result=mysql_query("SELECT task_name FROM task WHERE task_id=$id");
   $row=mysql_fetch_row($result);
   $task_name=$row[0];
   echo '<div class="modal hide fade" id="EditTaskModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Edit task</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <input type="text" id="InputEditTaskModal'.$id.'" maxlength="100" value="'.$task_name.'">
                            <input type="submit" class="btn btn-primary focusonme" value="Save" onclick="EditTask('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_InsertTaskProjectModal($id)
{
   echo '<div class="modal hide fade" id="InsertTaskProjectModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>New task</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <input type="text" id="InputInsertTaskProjectModal'.$id.'" maxlength="100">
                            <input type="submit" class="btn btn-primary focusonme" value="Save" onclick="InsertTaskProject('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_RemoveProjectModal($id)
{
   $result=mysql_query("SELECT project_name FROM project WHERE project_id=$id");
   $row=mysql_fetch_row($result);
   $project_name=$row[0];
   echo '<div class="modal hide fade" id="RemoveProjectModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Remove group</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <label>Remover o projeto \'<b>'.$project_name.'\'</b> e todas as sua tarefas ?</label>
                            <input type="button" class="btn btn-danger focusonme" value="Yes" onclick="RemoveProject('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_EditProjectModal($id)
{
   $result=mysql_query("SELECT project_name FROM project WHERE project_id=$id");
   $row=mysql_fetch_row($result);
   $project_name=$row[0];
   echo '<div class="modal hide fade" id="EditProjectModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Edit group name</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <input type="text" id="InputEditProjectModal'.$id.'" maxlength="100" value="'.$project_name.'">
                            <input type="submit" class="btn btn-primary focusonme" value="Save" onclick="EditProject('.$id.');">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function write_InsertProjectModal()
{
   echo '<div class="modal hide fade" id="InsertProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>New group</h3>
            </div>
            <div class="modal-body">
                <div class="tab-pane">
                    <form class="simpleform">
                        <div class="row">
                            <input type="text" id="InputInsertProjectModal" maxlength="50">
                            <input type="submit" class="btn btn-primary" value="Save" onclick="InsertProject();">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        ';
}
function set_colapsedproject($id)
{
    if(isset($_SESSION['colapsedprojects']))
    {
        //insere no fim do array
        $array=$_SESSION['colapsedprojects'];
        array_push($array,$id);
        $_SESSION['colapsedprojects']=$array;
    }
    else
    {
        $_SESSION['colapsedprojects']=array($id);
    }
}
function unset_colapsedproject($id)
{
    if(isset($_SESSION['colapsedprojects']))
    {
        //remove o id do projeto da lista de projetos abertos
        $array1=$_SESSION['colapsedprojects'];
        $array2=array($id);
        $_SESSION['colapsedprojects']=array_diff($array1, $array2);
    }
}
function set_colapsedtask($id)
{
    if(isset($_SESSION['colapsedtasks']))
    {
        //insere no fim do array
        $array=$_SESSION['colapsedtasks'];
        array_push($array,$id);
        $_SESSION['colapsedtasks']=$array;
    }
    else
    {
        $_SESSION['colapsedtasks']=array($id);
    }
}
function unset_colapsedtask($id)
{
    if(isset($_SESSION['colapsedtasks']))
    {
        //remove o id do projeto da lista de projetos abertos
        $array1=$_SESSION['colapsedtasks'];
        $array2=array($id);
        $_SESSION['colapsedtasks']=array_diff($array1, $array2);
    }
}
?>
