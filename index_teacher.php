<?php 
//error_reporting(E_ALL);
require_once('common.php');
require_once "current_session.php";
require_once('wizards.php');
require_once('results.php');

function redirect_php($url, $timer = 0) {
    echo '<meta http-equiv="refresh" content="' . $timer . '; url=' . $url . '">';
}

if (isset($_GET['logout'])) {
	session_write_close();
	session_destroy();
    redirect_php('index.php');
	
} else if (isset($_GET['login'])) {
	$_SESSION['username'] = 'Prepodavatel';
	$_SESSION['password'] = '3';
	$_SESSION['profile_title_ru']   = 'Преподаватель';
	$_SESSION['profile_fakultet']     = 'ФЭВТ';

}


?>


<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
        <title>infoDB - Преподаватель</title>
    </head>
    <body>


        <div id="ribbon_panel">
            <div class="inline"><img src="img/infodb_banner_v.png" /></div>

            <div id="button_block">

			    <a href="index_teacher.php?wizards=t_kontrols" class="a.without_decoration">
                    <div class="box">
                        <div><img src="img/binary_ball.png"/></div>
                        <div><span>Экзамены/Зачёты</span></div>
                    </div>
                </a>
				
                <a href="index_teacher.php?wizards=t_others" class="a.without_decoration">
                    <div class="box">
                        <div><img src="img/spinning_beach_ball.png"/></div>
                        <div><span>Другое</span></div>
                    </div>
                </a>
            </div><!-- end button block -->


            <div id="logout_panel">
                <span>Вы зашли как</span><br />
                <p>
                <div class="inline"><img src="img/teacher_32.png" alt="Преподаватель"></div>
                <div id="tip_qmark" class="tip" data-title="Преподаватель имеет возможность просматривать записи ведомости и изменять их">
                    <img src="img/question.png" alt="" />
                </div>
                <br />

                <span><?php echo $_SESSION['profile_title_ru'];
						?></span>

                </p> 
                <a href="index_teacher.php?logout">Выйти</a>
            </div>

        </div>


        <div id="wizard"><?php

			echo wizardFor($_GET);
			
		?></div>

        <div id="result">
		
         <?php
		 if (isShowResult($_GET)){
		 
			echo resultFor($_GET);
		   }else{
			
		   }
          ?>
           
        </div> 
    </body>
</html>