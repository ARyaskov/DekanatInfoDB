<?php

require_once('common.php');

function resultFor($in_array) {
    $output = '';
    $req = $in_array['request'];
	$_SESSION['last_get'] = $in_array;
	
    $req_array = explode('+', $req);

    foreach ($req_array as $val) {

        switch ($val) {
            case '':
                break;
            case 'get_student_list': {
                $output = res_get_smth_list('SELECT * FROM Student', 'Student');
                }break;
            case 'get_student_with_children_list': {
                    $output = res_get_smth_list('SELECT * FROM Student WHERE kolichestvo_detei>0', 'Student');
                }break;
            case 'add_student':{
                $output = res_add_smth('Student');
            }break;
		    case 'del_student':{
                $output = res_del_smth('Student');
            }break;
			case 'upd_student':{
                $output = res_upd_smth('Student');
            }break;
			case 'get_teacher_list':{
                $output = res_get_smth_list('SELECT * FROM Prepodavatel', 'Prepodavatel');
            }break;
			case 'get_teacher_with_kandidatskaya':{
                $output = res_get_smth_list('SELECT * FROM Prepodavatel WHERE kandidatskaya_disser IS NOT NULL', 'Prepodavatel');
            }break;
			case 'get_teacher_with_2_and_more_bach':{
                $output = res_get_teacher_with_2_and_more_bach();
            }break;
			case 'add_teacher':{
                $output = res_add_smth('Prepodavatel');
            }break;
			case 'upd_teacher':{
                $output = res_upd_smth('Prepodavatel');
			}break;
			case 'del_teacher':{
				$output = res_del_smth('Prepodavatel');
            }break;
			 case 'get_gruppas_list': {
                $output = res_get_smth_list('SELECT * FROM Gruppa', 'Gruppa');
                }break;
            case 'add_gruppa':{
                $output = res_add_smth('Gruppa');
            }break;
		    case 'del_gruppa':{
                $output = res_del_smth('Gruppa');
            }break;
			case 'upd_gruppa':{
                $output = res_upd_smth('Gruppa');
            }break;
			 case 'get_kafedras_list': {
                $output = res_get_smth_list('SELECT * FROM Kafedra', 'Kafedra');
                }break;
			case 'get_kafedras_kan_dissers':{
				$output = res_get_smth_list('SELECT * FROM Kandidatskaya_disser WHERE soiskatel IN 
												(SELECT id FROM Prepodavatel WHERE kafedra='.$_SESSION['last_get']['Kafedra'].')', 'Kandidatskaya_disser');
			}break;
            case 'add_kafedra':{
                $output = res_add_smth('Kafedra');
            }break;
		    case 'del_kafedra':{
                $output = res_del_smth('Kafedra');
            }break;
			case 'upd_kafedra':{
                $output = res_upd_smth('Kafedra');
            }break;
		    case 'get_disciplinas_list': {
                $output = res_get_smth_list('SELECT * FROM Disciplina', 'Disciplina');
                }break;
            case 'add_disciplina':{
                $output = res_add_smth('Disciplina');
            }break;
		    case 'del_disciplina':{
                $output = res_del_smth('Disciplina');
            }break;
			case 'upd_disciplina':{
				 $output = res_upd_smth('Disciplina');
            }break;
			case 'get_kontrols_list': {
                $output = res_get_smth_list('SELECT * FROM Kontrol', 'Kontrol');
                }break;
            case 'add_kontrol':{
                $output = res_add_smth('Kontrol');
            }break;
		    case 'del_kontrol':{
                $output = res_del_smth('Kontrol');
            }break;
			case 'upd_kontrol':{
				 $output = res_upd_smth('Kontrol');
            }break;
			case 'get_balls_list':{
				 $output = res_get_smth_list('SELECT * FROM Zapis_vedomosti WHERE id IN 
												(SELECT zapisi FROM Vedomost WHERE kontrol='.$_SESSION['last_get']['Kontrol'].');',
												'Zapis_vedomosti');
            }break;
			case 'get_lekcia_teacher':{
				$output = res_get_lekcia_teacher($_SESSION['last_get']['Disciplina']);
			}break;
			case 'get_hours_for_disciplina':{
				$output = res_get_hours_for_disciplina($_SESSION['last_get']['Disciplina']);
			}break;
			case 'get_list_uchebny_poruch':{
				$output = res_get_smth_list('SELECT * FROM Uchebnoe_poruchenie' ,'Uchebnoe_poruchenie');
			}break;
			case 'get_list_uchebny_poruch':{
				$output = res_get_smth_list('SELECT * FROM Uchebnoe_poruchenie' ,'Uchebnoe_poruchenie');
			}break;
			case 'is_lab_rabota_in_disciplina':{
				$output = res_is_lab_rabota_in_disciplina($_SESSION['last_get']['Disciplina']);
			}break;
			case 'get_exam_dates':{
				$output = res_get_smth_list('SELECT * FROM Kontrol WHERE (tip="Экзамен") AND (prepodavatel='.$_SESSION['last_get']['Prepodavatel'].
											') AND (date >  CURDATE());' ,'Kontrol');
			}break;
            default:
                $output = '<br /><div id="null_wizard"><span>Ошибка в запросе</span></div>';
        }
    }

    return $output;
}

function res_get_teacher_with_2_and_more_bach()
{
	$conn = connect_to_db();

	$query = 'CREATE TEMPORARY TABLE goldTeacher SELECT rukovoditel, COUNT(*) FROM Bak_diplom;
				select * from goldTeacher;
					DROP TABLE goldTeacher;	';
    $result = mysqli_query($conn, $query);
	
    $output = '<table class="result_table">';
    $output .= get_header_for_table( $table_name);
    $odd_test = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		var_dump($row);
        if ($odd_test % 2) {// odd type of tr
            $output .= '<tr class="odd">';
        } else {
            $output .= '<tr>';
        } 
        ++$odd_test;
        foreach($row as $key => $val) {	
			if (is_foreign_key($table_name, $key))
			{
				$fk_val = getValueFromFK($key, $val);
				$output .= sprintf('<td>%s</td>', $fk_val);
			}else{
				$output .= sprintf('<td>%s</td>', $val);
			}
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_get_'. $table_name.'_list"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}

function res_is_lab_rabota_in_disciplina($id_disciplina)
{
	$conn = connect_to_db();

	$query = 'SELECT infoDB.is_lab_rabota_in_disciplina('.$id_disciplina.');';
	
    $result = mysqli_query($conn, $query);

	if ($result)
	{
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if ($row[0])
			echo '<span>Да, лабораторные работы по данной дисциплине есть</span>';
		else{
			echo '<span>Нет, лабораторных работ по данной дисциплине нет</span>';
		}
	}else{
		echo mysqli_error($conn);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_get_'. $table_name.'_list"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}


function res_get_hours_for_disciplina($id_disciplina)
{
	$conn = connect_to_db();

	$query = 'SELECT infoDB.get_hours_for_disciplina('.$id_disciplina.');';
	
    $result = mysqli_query($conn, $query);

	if ($result)
	{
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		
		echo 'Итоговое количество часов - '.$row[0];
	}else{
		echo mysqli_error($conn);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_get_'. $table_name.'_list"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}

function res_get_lekcia_teacher($id_disciplina)
{
	$conn = connect_to_db();

	$query = 'SELECT infoDB.get_lekcia_teacher('.$id_disciplina.');';
	
    $result = mysqli_query($conn, $query);

	if ($result)
	{
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if ($row[0])
			echo '<span>Итак, это '.$row[0].'</span>';
		else
		{	
			echo '<span>Лектор не задан</span>';
		}
	}else{
		echo mysqli_error($conn);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_get_'. $table_name.'_list"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}



function res_get_smth_list($query, $table_name) {
    $conn = connect_to_db();

    $result = mysqli_query($conn, $query);

    $output = '<table class="result_table">';
    $output .= get_header_for_table( $table_name);
    $odd_test = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
        if ($odd_test % 2) {// odd type of tr
            $output .= '<tr class="odd">';
        } else {
            $output .= '<tr>';
        } 
        ++$odd_test;
        foreach($row as $key => $val) {	
			if (is_foreign_key($table_name, $key))
			{
				$fk_val = getValueFromFK($key, $val);
				$output .= sprintf('<td>%s</td>', $fk_val);
			}else{
				$output .= sprintf('<td>%s</td>', $val);
			}
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_get_'. $table_name.'_list"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}

function res_add_smth($table_name) {
     $conn = connect_to_db();
	
	$query = form_insert_request($table_name);
	
    $result =  mysqli_query($conn, $query);
	
	
	if ($result)
		$output = '<span>Добавлено!</span>';
	else
	{
		$output .= '<span>Добавление не удалось:</span><br />';
		$output .= mysqli_error($_SESSION['cur_connection']);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_add_'.strtolower($table_name).'"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}


function get_header_for_table($table_name) {
    $output = '';
	$conn = connect_to_db();

    $query = 'SELECT * FROM '.$table_name.';';
    $result = mysqli_query($conn, $query);
	$finfo = mysqli_fetch_fields($result);
	$output .= '<tr><th>';
	$size = count($finfo);
	for ($i=1; $i<$size; ++$i) {
        $output .= '<th>'.$finfo[$i]->name.'</th>';
    }
	$output .= '</th></tr>';
	

    return $output;
}



function form_insert_request($table_name)
{
	$query = 'INSERT INTO '.$table_name.' (';
	
	$filteredGET = siftGETRequest($_SESSION['last_get'], $table_name);
	
	foreach ($filteredGET as $key => $val)
	{
		$query .= $key.',';
	}
	$query = rtrim($query, ',');
	$query .= ') VALUES(';
	foreach ($filteredGET as $key => $val)
	{
		if (is_numeric($val))
		{
			$query .= $val.',';
		}else{
			$query .= '"'.$val.'",';
		}
	}
    $query = rtrim($query, ',');
	$query .= ');';
	
	return $query;
}

function form_update_request($table_name)
{
	$query = 'UPDATE '.$table_name.' SET ';
	
	$filteredGET = siftGETRequest($_SESSION['last_get'], $table_name);
	
	foreach ($filteredGET as $key => $val)
	{
		if (is_numeric($val))
			$query .= $key.'='.$val.',';
		else{
			$query .= $key.'='.'"'.$val.'",';
			}
	}
	$query = rtrim($query, ',');
	
	$query .= ' WHERE id='.$_SESSION['Student_id'];

	$query .= ';';
	
	return $query;
}


function form_del_request($table_name, $del_id)
{
	$query = 'DELETE FROM '.$table_name.' WHERE id='.$del_id;
	
	return $query;
}

function res_del_smth($table_name) {
    $conn = connect_to_db();
	$del_id = $_SESSION['last_get'][$table_name];
	$query = form_del_request($table_name, $del_id);
	
    $result =  mysqli_query($conn, $query);
	
	
	if ($result)
		$output = '<span>Удалено</span>';
	else
	{
		$output .= '<span>Удаление не удалось:</span><br />';
		$output .= mysqli_error($_SESSION['cur_connection']);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_del_'.strtolower($table_name).'"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}

function res_upd_smth($table_name) {
    $conn = connect_to_db();

	
	$query = form_update_request($table_name, $_SESSION[$table_name]);

    $result = mysqli_query($conn, $query);
	
	
	if ($result)
		$output = '<span>Запись обновлена</span>';
	else
	{
		$output .= '<span>Обновление не удалось:</span><br />';
		$output .= mysqli_error($_SESSION['cur_connection']);
	}
    mysqli_free_result($result);
    mysqli_close($conn);

    $output_div = '<div id="res_upd_'.strtolower($table_name).'"><br />';
    $output_div .= $output;
    $output_div .= '</div><br />';

    return $output_div;
}
