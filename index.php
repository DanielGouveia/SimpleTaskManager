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
            <section id="SectionContent">
                <?php
                    write_Manager();
                ?>
            </section>
            <footer>
                <a href="http://joblovr.com/profile/1701" class="link">DanielGouveia</a>
            </footer>
        </div>
    </body>
</html>