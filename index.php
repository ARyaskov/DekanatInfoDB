<?php 
           require_once('wizards.php'); 
        ?>
<!DOCTYPE html>
<html>
        
    <head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
        <title>infoDB - Информационная система ВУЗа</title>
    </head>
    <body>
    
        <div id="welcome_die">
            <span class="header1">infoDB - Информационная система ВУЗа</span><br />
            <span>Данная система позволяет облегчить труд работников деканата,
            методистов кафедр и преподавателей, путём предоставления им различных 
            данных, касающихся процессов ВУЗа.<br />
            Вы должны зайти под одним из 3 профилей:<br /></span>
           
            
            <div id="user_list_panel">
                <div class="person_die">
                    <div id="sotrudnik_dekanata">
                       <p><a href="index_dekanat.php?login">
                              <img src="img/dekanat_32.png" alt="Сотрудник деканата"/><br />
                              <span>Сотрудник деканата</span>
                          </a>
                       </p> 
                    </div>
                </div>
                
                <div class="person_die">
                   <p><a href="index_metodist.php?login">
                           <img src="img/metodist_32.png" alt="Методист кафедры"><br />
                           <span>Методист кафедры</span>
                      </a>
                   </p> 
                </div>
                
                <div class="person_die">
                   <p><a href="index_teacher.php?login">
                           <img src="img/teacher_32.png" alt="Преподаватель"><br />
                           <span>Преподаватель</span>
                      </a>
                   </p> 
                </div>
            </div>
            
            <div id="wizard">
                <?php
                    echo wizardFor($_GET);
                ?>
            </div>
            
        </div>
        
 
    </body>
</html>
