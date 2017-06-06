<?php
require_once('common.php');
session_start();




function wizardFor($in_array)
{
    $output = '';
    $wiz = $in_array['wizards'];
    
	$_SESSION['last_get'] = $in_array;
	
    $wiz_array = explode('+', $wiz);
    
    foreach ($wiz_array as $val) {
        
        switch ($val)
        {
            case '':
                break;
            case 'select_fakultet':{
                $output = wiz_select_facultet();
            }break;
            case 'd_students':{
				if ($_SESSION['last_get']['Student'])
					$_SESSION['last_id'] = $_SESSION['last_get']['Student'];
					
					//$_SESSION['last_id'] = $_SESSION['last_get']['Student'];
					$output = wiz_students($in_array['step'], $in_array['request']);
					
            }break;
			case 'd_teachers':{
				$output = wiz_teachers($in_array['step'], $in_array['request']);
			}break;
			case 'd_gruppas':{
				$output = wiz_gruppas($in_array['step'], $in_array['request']);
			}break;
		    case 'd_kafedras':{
					$output = wiz_kafedras($in_array['step'], $in_array['request']);
					
            }break;
			case 'd_disciplinas':{
					$output = wiz_disciplinas($in_array['step'], $in_array['request']);
			}break;
			case 'd_kontrols':{
					$output = wiz_kontrols($in_array['step'], $in_array['request']);
			}break;
			case 'm_teachers':{
					$output = wiz_m_teachers($in_array['step'], $in_array['request']);
			}break;
			case 'm_disciplinas':{
					$output = wiz_m_disciplinas($in_array['step'], $in_array['request']);
			}break;
			case 'm_others':{
					$output = wiz_m_others($in_array['step'], $in_array['request']);
			}break;
			case 't_kontrols':{
					$output = wiz_t_kontrols($in_array['step'], $in_array['request']);
			}break;
            default:
                $output = '<div id="null_wizard"><span>Ошибка в запросе</span></div>';
        }
    }
    
    return $output;
    
}



function wiz_t_kontrols($step=0,$request='')
{
	$category_title = 'Экзамены/Зачёты';
	switch($step)
	{
		case 0:{
			$output .= '<div id="t_kontrols">
            <form action="index_teacher.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_exam_dates">Получить даты экзаменов, которые необходимо провести </option>
					
					
                    <option disabled>Транзакционные запросы</option>
                   
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="t_kontrols">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				case 'get_exam_dates':{
					$output .= '<div id="t_kontrols">
					<form action="index_teacher.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_exam_dates()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Узнать--">
					<input  type="hidden" name="wizards" value="t_kontrols">
					<input  type="hidden" name="request" value="get_exam_dates">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
			


				
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="upd_student">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}




function wiz_select_facultet()
{
    $output = '<div id="select_fakultet"> 
            <form action="index_dekanat.php" name="form_select_fakultet">
            <h3>Выбор факультета</h3>
            <p><select size="3" name="fakultet">
            <option value="ФАТ">Факультет автомобильного транспорта (ФАТ)</option>
            <option selected value="ФЭВТ">Факультет электронно-вычислительной техники (ФЭВТ)</option>
            <option value="ФЭУ">Факультет экономики и управления (ФЭУ)</option>
            </select></p>
            <input type="hidden" name="login" /> 
            <input type="submit" value="Далее ->">
            </form>
        </div>';
    
    return $output;
}

function wiz_m_others($step=0,$request='')
{
	$category_title = 'Другое';
	switch($step)
	{
		case 0:{
			$output .= '<div id="m_others">
            <form action="index_metodist.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_list_uchebny_poruch">Получить список учебных поручений</option>
                    
                    <option disabled>Транзакционные запросы</option>
                   
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="m_others">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				case 'get_list_uchebny_poruch':{
					$output .= '<div id="m_others">
					<form action="index_metodist.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_lekcia_teacher()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Узнать--">
					<input  type="hidden" name="wizards" value="m_others">
					<input  type="hidden" name="request" value="get_lekcia_teacher">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;

				
			}
		}break;
		case 2:{
			$output .= $_SESSION['prev_wizard'];	
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}

function wiz_m_teachers($step=0,$request='')
{
	$category_title = 'Преподаватели';
	switch($step)
	{
		case 0:{
			$output .= '<div id="m_teachers">
            <form action="index_metodist.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_lekcia_teacher">Узнать, кто ведёт лекции по некоторой дисциплине у конкретной группы</option>
                    
                    <option disabled>Транзакционные запросы</option>
                   
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="m_teachers">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				case 'get_lekcia_teacher':{
					$output .= '<div id="m_teachers">
					<form action="index_metodist.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_lekcia_teacher()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Узнать--">
					<input  type="hidden" name="wizards" value="m_teachers">
					<input  type="hidden" name="request" value="get_lekcia_teacher">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;

				
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="upd_student">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}

function wiz_m_disciplinas($step=0,$request='')
{
	$category_title = 'Дисциплины';
	switch($step)
	{
		case 0:{
			$output .= '<div id="m_disciplinas">
            <form action="index_metodist.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_hours_for_disciplina">Получить текущее количество часов, отводимое на дисциплину</option>
					<option value="is_lab_rabota_in_disciplina">Узнать, есть ли лабораторные по некоторой дисциплине</option>
					
                    <option disabled>Транзакционные запросы</option>
                   
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="m_disciplinas">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				case 'get_hours_for_disciplina':{
					$output .= '<div id="m_disciplinas">
					<form action="index_metodist.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_hours_for_disciplina()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Узнать--">
					<input  type="hidden" name="wizards" value="m_disciplinas">
					<input  type="hidden" name="request" value="get_hours_for_disciplina">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'is_lab_rabota_in_disciplina':{
					$output .= '<div id="m_disciplinas">
					<form action="index_metodist.php">
					<h3>'.$category_title.'</h3>'.
					ui_is_lab_rabota_in_disciplina()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Узнать--">
					<input  type="hidden" name="wizards" value="m_disciplinas">
					<input  type="hidden" name="request" value="is_lab_rabota_in_disciplina">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;


				
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="upd_student">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}


function wiz_students($step=0,$request='')
{
	$category_title = 'Студенты';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_students">
            <form action="index_dekanat.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_student_list">Получить список студентов</option>
                    <option value="get_student_with_children_list">Получить список студентов, имеющих детей</option>
                    <option disabled>Транзакционные запросы</option>
                    <option value="add_student">Добавить студента</option>
					<option value="upd_student">Изменить студента</option>
					<option value="del_student">Удалить студента</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_students">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_student_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'get_student_with_children_list':{
					 	
						$output .= $_SESSION['prev_wizard'];
					
				}break;
				case 'add_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Добавить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="add_student">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'del_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createDelDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Удалить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="del_student">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="upd_student">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_student':{
					$output .= '<div id="d_students">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Student')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_students">
					<input  type="hidden" name="request" value="upd_student">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}



function wiz_teachers($step=0,$request='')
{
	$category_title = 'Преподаватели';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_teachers">
            <form action="index_dekanat.php">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_teacher_list">Получить список преподавателей</option>
                    <option value="get_teacher_with_kandidatskaya">Получить список преподавателей, защитивщих кандидатскую диссертацию</option>
					<option value="get_teacher_with_2_and_more_bach">Получить список преподавателей, у которых защитились 2 или более бакалавра</option>
					
					<option disabled>Транзакционные запросы</option>
                    <option value="add_teacher">Добавить преподавателя</option>
					<option value="upd_teacher">Изменить преподавателя</option>
					<option value="del_teacher">Удалить преподавателя</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_teachers">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_teacher_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'get_teacher_with_kandidatskaya':{
					 	
						$output .= $_SESSION['prev_wizard'];
					
				}break;
				case 'get_teacher_with_2_and_more_bach':{
					 	
						$output .= $_SESSION['prev_wizard'];
					
				}break;
				case 'add_teacher':{
					$output .= '<div id="d_teachers">
					<form action="index_dekanat.php"">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Prepodavatel')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Добавить ->">
					<input  type="hidden" name="wizards" value="d_teachers">
					<input  type="hidden" name="request" value="add_teacher">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_teacher':{
					$output .= '<div id="d_teacher">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Prepodavatel')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_teacher">
					<input  type="hidden" name="request" value="upd_teacher">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
			}
		}break;
		case 2:{
		switch($request)
			{
				case 'upd_teacher':{
					$output .= '<div id="d_teacher">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Prepodavatel')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_teacher">
					<input  type="hidden" name="request" value="upd_teacher">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
			}
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}



function wiz_gruppas($step=0,$request='')
{
	$category_title = 'Группы';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_gruppas">
            <form action="index_dekanat.php"">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_gruppas_list">Получить список групп</option>
                    <option disabled>Транзакционные запросы</option>
                    <option value="add_gruppa">Добавить группу</option>
					<option value="upd_gruppa">Изменить группу</option>
					<option value="del_gruppa">Удалить группу</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_gruppas">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_gruppas_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'add_gruppa':{
					$output .= '<div id="d_gruppas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Gruppa')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Добавить--">
					<input  type="hidden" name="wizards" value="d_gruppas">
					<input  type="hidden" name="request" value="add_gruppa">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'del_disciplina':{
					$output .= '<div id="d_gruppas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createDelDialogForTable('Gruppa')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Удалить--">
					<input  type="hidden" name="wizards" value="d_gruppas">
					<input  type="hidden" name="request" value="del_gruppa">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_disciplina':{
					$output .= '<div id="d_gruppas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Gruppa')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_gruppas">
					<input  type="hidden" name="request" value="upd_kgruppa">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_kafedra':{
					$output .= '<div id="d_gruppas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Gruppa')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_gruppas">
					<input  type="hidden" name="request" value="upd_gruppa">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}



function wiz_kafedras($step=0,$request='')
{
	$category_title = 'Кафедры';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_kafedras">
            <form action="index_dekanat.php"">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_kafedras_list">Получить список кафедр</option>
					<option value="get_kafedras_kan_dissers">Получить темы кандидатских диссертаций преподавателей кафедры</option>
                    <option disabled>Транзакционные запросы</option>
                    <option value="add_kafedra">Добавить кафедру</option>
					<option value="upd_kafedra">Изменить кафедру</option>
					<option value="del_kafedra">Удалить кафедру</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_kafedras">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_kafedras_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'add_kafedra':{
					$output .= '<div id="d_kafedras">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Kafedra')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Добавить--">
					<input  type="hidden" name="wizards" value="d_kafedras">
					<input  type="hidden" name="request" value="add_kafedra">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'del_student':{
					$output .= '<div id="d_kafedras">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createDelDialogForTable('Kafedra')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Удалить--">
					<input  type="hidden" name="wizards" value="d_kafedras">
					<input  type="hidden" name="request" value="del_kafedra">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_kafedra':{
					$output .= '<div id="d_kafedras">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Kafedra')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_kafedras">
					<input  type="hidden" name="request" value="upd_kafedra">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
				case 'get_kafedras_kan_dissers':{
					$output .= '<div id="d_kafedras">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_kafedras_kan_dissers()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Получить ->">
					<input  type="hidden" name="wizards" value="d_kafedras">
					<input  type="hidden" name="request" value="get_kafedras_kan_dissers">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
					
				}break;
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_kafedra':{
					$output .= '<div id="d_kafedras">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Kafedra')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_kafedras">
					<input  type="hidden" name="request" value="upd_kafedra">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}


function wiz_disciplinas($step=0,$request='')
{
	$category_title = 'Дисциплины';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_disciplinas">
            <form action="index_dekanat.php"">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_disciplinas_list">Получить список дисциплин</option>
                    <option disabled>Транзакционные запросы</option>
                    <option value="add_disciplina">Добавить дисциплину</option>
					<option value="upd_disciplina">Изменить дисциплину</option>
					<option value="del_disciplina">Удалить дисциплину</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_disciplinas">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_kafedras_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'add_disciplina':{
					$output .= '<div id="d_disciplinas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Disciplina')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Добавить--">
					<input  type="hidden" name="wizards" value="d_disciplinas">
					<input  type="hidden" name="request" value="add_disciplina">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'del_disciplina':{
					$output .= '<div id="d_disciplinas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createDelDialogForTable('Disciplina')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Удалить--">
					<input  type="hidden" name="wizards" value="d_disciplinas">
					<input  type="hidden" name="request" value="del_disciplina">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_disciplina':{
					$output .= '<div id="d_disciplinas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Disciplina')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_disciplinas">
					<input  type="hidden" name="request" value="upd_disciplina">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_kafedra':{
					$output .= '<div id="d_disciplinas">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Disciplina')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_disciplinas">
					<input  type="hidden" name="request" value="upd_disciplina">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}



function wiz_kontrols($step=0,$request='')
{
	$category_title = 'Экзамены/Зачёты';
	switch($step)
	{
		case 0:{
			$output .= '<div id="d_kontrols">
            <form action="index_dekanat.php"">
            <h3>'.$category_title.'</h3>
            <span>Выберите задачу:</span>
            <select name="request">
                    <option disabled>Справочные запросы</option>
                    <option value="get_kontrols_list">Получить список экзаменов и зачётов</option>
					<option value="get_balls_list">Получить список баллов по некоторой дисциплине у группы</option>
                    <option disabled>Транзакционные запросы</option>
                    <option value="add_kontrol">Добавить экзамен или зачёт</option>
					<option value="upd_kontrol">Изменить экзамен или зачёт</option>
					<option value="del_kontrol">Удалить экзамен или зачёт</option>
            </select>
            <input  type="submit" value="Далее ->">
            <input  type="hidden" name="wizards" value="d_kontrols">
			<input  type="hidden" name="step" value="1">
			
            </form>
			</div>';
		}break;
		case 1:{
			switch($request)
			{
				case '':{
					
				}break;
				
				case 'get_kontrols_list':{
					 	$output .= $_SESSION['prev_wizard'];
						
					
				}break;
				case 'add_kontrol':{
					$output .= '<div id="d_kontrols">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createInputForTable('Kontrol')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Добавить--">
					<input  type="hidden" name="wizards" value="d_kontrols">
					<input  type="hidden" name="request" value="add_kontrol">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'del_kontrol':{
					$output .= '<div id="d_kontrols">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createDelDialogForTable('Kontrol')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Удалить--">
					<input  type="hidden" name="wizards" value="d_kontrols">
					<input  type="hidden" name="request" value="del_kontrol">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				case 'upd_kontrol':{
					$output .= '<div id="d_kontrols">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createSelUpdDialogForTable('Kontrol')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="Далее ->">
					<input  type="hidden" name="wizards" value="d_kontrols">
					<input  type="hidden" name="request" value="upd_kontrol">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="n">
					</div>
					</form>
					</div>';
					
					
				}break;
				case 'get_balls_list':{
					$output .= '<div id="d_kontrols">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					ui_get_balls_list()
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Получить--">
					<input  type="hidden" name="wizards" value="d_kontrols">
					<input  type="hidden" name="request" value="get_balls_list">
					<input  type="hidden" name="step" value="2">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
			}
		}break;
		case 2:{
			switch ($request)
			{
				case 'upd_kontrol':{
					$output .= '<div id="d_kontrols">
					<form action="index_dekanat.php">
					<h3>'.$category_title.'</h3>'.
					createUpdDialogForTable('Kontrol')
					.'<br />
					<div class="supplement">
					<input  type="submit" value="--Обновить--">
					<input  type="hidden" name="wizards" value="d_kontrols">
					<input  type="hidden" name="request" value="upd_kontrol">
					<input  type="hidden" name="step" value="3">
					<input  type="hidden" name="is_end" value="y">
					</div>
					</form>
					</div>';
					
				}break;
				default:{
					$output .= $_SESSION['prev_wizard'];
					}
			}
			
		}break;
		case 3:{
			$output .= $_SESSION['prev_wizard'];		
		}break;
		default:
			$output .= 'Ошибка в wizard.php';
	}
	
	$_SESSION['prev_wizard'] = $output;
    return $output;
}


function incStep($div_with_step)
{
	
	$pos = strpos($div_with_step, '<input  type="hidden" name="step" value=');
	$num = intval(substr($div_with_step, $pos+$strlen('<input  type="hidden" name="step" value='), 1));
	$num += 1;
	$output = substr($div_with_step, 0, $pos+1);
	$output .= strval($num);
	$output .= substr($div_with_step, $pos+strlen('<input  type="hidden" name="step" value=')+1, 1);
	
	return $output;
	
}

function isEndTo($div_with_is_end, $bool_to)
{
	$output = '';
	if ($bool_to)
		$output = str_replace('<input  type="hidden" name="is_end" value="n">',
		'<input  type="hidden" name="is_end" value="y">',
		$div_with_is_end);
	else{
		$output = str_replace('<input  type="hidden" name="is_end" value="y">',
		'<input  type="hidden" name="is_end" value="n">',
		$div_with_is_end);
	}
	
	return $output;
}


?>
