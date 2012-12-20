/* 
* 
*   PROJECT NAME: SimpleTaskManager
*   AUTOR       : Daniel Gouveia
*   DATE        : 19-12-2012
*
*/

function setfocusInsertTaskModal(id)
{
    $('#InsertTaskModal'+id).on('shown', function() {
        $("#InputInsertTaskModal"+id).focus();
    });
}
function setfocusEditTaskModal(id)
{
    $('#EditTaskModal'+id).on('shown', function() {
        $("#InputEditTaskModal"+id).focus();
    });
}
function setfocusInsertTaskProjectModal(id)
{
    $('#InsertTaskProjectModal'+id).on('shown', function() {
        $("#InputInsertTaskProjectModal"+id).focus();
    });
}
function setfocusEditProjectModal(id)
{
    $('#EditProjectModal'+id).on('shown', function() {
        $("#InputEditProjectModal"+id).focus();
    });
}
function setfocusInsertProjectModal(id)
{
    $('#InsertProjectModal').on('shown', function() {
        $("#InputInsertProjectModal").focus();
    });
}
function checktask(task_id)
{
    element=$("#checkbox"+task_id);
    $.post('ajax/checktask.php',
            {task_id:task_id},
            function(data) 
            {
                element.html(data); 
            });
}
function unchecktask(task_id)
{
    element=$("#checkbox"+task_id);
    $.post('ajax/unchecktask.php',
            {task_id:task_id},
            function(data) 
            {
                element.html(data); 
            });
}
function TogglePlusiconp(project_id)
{
    element=$("#IconProject"+project_id);
    data='<i class="icon-grey icon-plus pointer" data-toggle="collapse" data-target="#collapse'+project_id+'" onclick="ToggleMinusiconp('+project_id+');"></i>';
    element.html(data);
    //Remove o id do projeto á lista de projetos abertos
    $.post('ajax/unset_colapsedproject.php', {id:project_id});
}
function ToggleMinusiconp(project_id)
{
    element=$("#IconProject"+project_id);
    data='<i class="icon-grey icon-minus pointer" data-toggle="collapse" data-target="#collapse'+project_id+'" onclick="TogglePlusiconp('+project_id+');"></i>';
    element.html(data);
    //Adiciona o id do projeto á lista de projetos abertos
    $.post('ajax/set_colapsedproject.php', {id:project_id});
}
function TogglePlusicont(project_id)
{
    element=$("#IconTask"+project_id);
    data='<i class="icon-grey icon-plus pointer" data-toggle="collapse" data-target="#collapsegroup'+project_id+'" onclick="ToggleMinusicont('+project_id+');"></i>';
    element.html(data);  
    //Remove o id das tasks á lista de tasks abertas
    $.post('ajax/unset_colapsedtask.php', {id:project_id});
}
function ToggleMinusicont(project_id)
{
    element=$("#IconTask"+project_id);
    data='<i class="icon-grey icon-minus pointer" data-toggle="collapse" data-target="#collapsegroup'+project_id+'" onclick="TogglePlusicont('+project_id+');"></i>';
    element.html(data);  
    //Adiciona o id das tasks á lista de tasks abertas
    $.post('ajax/set_colapsedtask.php', {id:project_id});
}
function InsertTask(id)
{ 
    $('#InsertTaskModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    text=$("#InputInsertTaskModal"+id).val();
    $.post('ajax/insert_task.php',
            {
                task_id:id,
                text:text
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide');
}
function RemoveTask(id)
{
    $('#RemoveTaskModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    $.post('ajax/remove_task.php',
            {
                task_id:id
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide');
}
function EditTask(id)
{
    $('#EditTaskModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    text=$("#InputEditTaskModal"+id).val();
    $.post('ajax/edit_task.php',
            {
                task_id:id,
                text:text
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide'); 
}
function InsertTaskProject(id)
{
    $('#InsertTaskProjectModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    text=$("#InputInsertTaskProjectModal"+id).val();
    $.post('ajax/insert_task_project.php',
            {
                project_id:id,
                text:text
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide');
}
function RemoveProject(id)
{
    $('#RemoveProjectModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    $.post('ajax/remove_project.php',
            {
                project_id:id
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide');
}
function EditProject(id)
{
    $('#EditProjectModal'+id).modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    text=$("#InputEditProjectModal"+id).val();
    $.post('ajax/edit_project.php',
            {
                project_id:id,
                text:text
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide'); 
}
function InsertProject()
{ 
    $('#InsertProjectModal').modal('hide');
    $('#LoadingPageModal').modal('show');
    element=$("#SectionContent");
    text=$("#InputInsertProjectModal").val();
    $.post('ajax/insert_project.php',
            {
                text:text
            },
            function(data) 
            {
                element.html(data); 
            });
   $('#LoadingPageModal').modal('hide'); 
}
function valida_instalacao()
{
    input1=$('#Input1');
    input2=$('#Input2');
    input3=$('#Input3');
    input4=$('#Input4');
    
    if(input1.val()=="")
        {input1.css("border","1px solid red");}
    if(input2.val()=="")
        {input2.css("border","1px solid red");}
    if(input3.val()=="")
        {input3.css("border","1px solid red");}
    if(input4.val()=="")
        {input4.css("border","1px solid red");}

}