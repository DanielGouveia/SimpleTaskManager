<!--
    PROJECT NAME: SimpleTaskManager
    AUTOR       : Daniel Gouveia
    DATE        : 19-12-2012
-->

<?php 
  include("mainlib.php");
?>

<!DOCTYPE HTML>
<html>
    <head>
        <?php
            get_links();
        ?>
    </head>
    <body>
        <!-- Modal -->
        <div id="LoadingPageModal" class="centerpage hide fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div id="LoadingReg" class="progress progress-striped active">
                <div class="bar" style="width: 100%;"></div>
            </div>
        </div>
        <div class="content">
            <header>
                Simple Task Manager <a class="info">v1.0</a>
            </header>
            <section id="SectionContent" class="installsection"><br>
                <div class="center">
                    <a class="style2">Installation process</a>
                </div><br>
                <?php
                    if(isset($_POST['submit']))
                    {
                        $dbhost=$_POST['input1'];
                        $dbname=$_POST['input2'];
                        $dbuser=$_POST['input3'];
                        $dbpass=$_POST['input4'];

                        if($dbhost=="" || $dbname=="" || $dbuser=="")
                        {
                            echo '<div class="alert alert-error">
                                      <strong>Error:</strong> Some fields are empty (*)
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  </div>';
                            echo '<br>
                                    <form method="POST" class="form-horizontal" name="frminstall">
                                        <div class="control-group">
                                            <label class="control-label" for="Input1">Database host</label>
                                            <div class="controls">
                                                <input type="text" id="Input1" name="input1" placeholder="ex: localhost" value="'.$dbhost.'"> *
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Input2">Database name</label>
                                            <div class="controls">
                                                <input type="text" id="Input2" name="input2" placeholder="ex: taskmanager" value="'.$dbname.'"> *
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Input3">Database user</label>
                                            <div class="controls">
                                                <input type="text" id="Input3" name="input3" placeholder="ex: root" value="'.$dbuser.'"> *
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Input4">Database password</label>
                                            <div class="controls">
                                                <input type="password" id="Input4" name="input4" placeholder="ex: 1234">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <!--<button type="submit" class="btn btn-primary" onclick="valida_instalacao();">Guardar</button>-->
                                                <button type="submit" name="submit" class="btn btn-primary"> Save </button>
                                            </div>
                                        </div>
                                    </form>';
                        }
                        else
                        {
                            create_connectiondbfile($dbhost,$dbname,$dbuser,$dbpass);
                            echo '<div class="alert alert-success">
                                      <strong>Installation complete!</strong> You can now use the manager
                                      
                                  </div>
                                  <div class="center">
                                    <a href="index.php" class="btn btn-primary"> Go to the manager </a>
                                  </div>';
                        }
                    }
                    else
                    {
                        echo '<br>
                                <form method="POST" class="form-horizontal" name="frminstall">
                                    <div class="control-group">
                                        <label class="control-label" for="Input1">Database host</label>
                                        <div class="controls">
                                            <input type="text" id="Input1" name="input1" placeholder="ex: localhost"> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="Input2">Database name</label>
                                        <div class="controls">
                                            <input type="text" id="Input2" name="input2" placeholder="ex: taskmanager"> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="Input3">Database user</label>
                                        <div class="controls">
                                            <input type="text" id="Input3" name="input3" placeholder="ex: root"> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="Input4">Database password</label>
                                        <div class="controls">
                                            <input type="text" id="Input4" name="input4" placeholder="ex: 1234">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <!--<button type="submit" class="btn btn-primary" onclick="valida_instalacao();">Guardar</button>-->
                                            <button type="submit" name="submit" class="btn btn-primary"> Save </button>
                                        </div>
                                    </div>
                                </form>';
                    }
                ?>
            </section>
            <footer>
                <b>Powered by:</b> DanielGouveia
            </footer>
        </div>
    </body>
</html>