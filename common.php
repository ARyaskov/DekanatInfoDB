<?php

   
function connect_to_db()
{
    $hostname = "localhost";
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $dbName = 'infodb';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
    }
	$_SESSION['cur_connection'] = $conn;
    mysqli_set_charset($conn, 'utf8');
	
	$query_opt = 'SET FOREIGN_KEY_CHECKS=0;';
	$result = mysqli_query($conn, $query_opt);
	if (!$result){
		echo mysqli_error();
	}
	
    return $conn;
}


function createInputForType($type='text', $name, $value='')
{
	$output = '';
	
	if ($value == ''){
		$output .= sprintf('<input type="%s" name="%s"> </input>',$type, $name);
		
	}else{
		$output .= sprintf('<input type="%s" name="%s" value="%s"> </input>',$type, $name, $value);
		
	}
	
	return $output;
}



function createRadioGroup($name, $arrOfValAndText, $checked_value='')
{
	$output = '';
	
	
	foreach ($arrOfValAndText as $val => $text)
	{
		if ($checked_value == '')
			$output .= sprintf('<input type="radio" name="%s" value="%s">%s</input>',$name, $val, $text);
		else{
			if ($checked_value==$val)
			{
				$output .= sprintf('<input type="radio" name="%s" value="%s" checked>%s</input>',$name, $val, $text);
			}else{

				$output .= sprintf('<input type="radio" name="%s" value="%s">%s</input>',$name, $val, $text);
			}
		}
	}
	
	return $output;
}

function createLabelForField($value='')
{
	$output = '';

	$output .= '<label>'. $value.'</label>';
	
	return $output;
}

/* Field as assoc array of 1 value (key => value)*/
function createInputForField($field, $is_fk, $defaults_arr=array())
{
	$output = '';
	$output .= '<div class="field">';
	$output .= createLabelForField($field->name);
	
	if (!$is_fk){
		switch($field->type)
		{

			// int 
			case MYSQLI_TYPE_LONG: {
				$output .= createInputForType('number', $field->name, $defaults_arr[$field->name]);
			}break;
			case MYSQLI_TYPE_VAR_STRING: {
				if ($field->name == 'pol'){
				
					$output .= createRadioGroup('pol', array('муж'=>'Мужской','жен' => 'Женский'), $defaults_arr['pol']);
				}else{   
					$output .= createInputForType('text', $field->name, $defaults_arr[$field->name]);
				}
			}break;
			case MYSQLI_TYPE_YEAR:{
				$output .= createInputForType('text', $field->name, $defaults_arr[$field->name]);
			}break;
			case MYSQLI_TYPE_DATE:{
				$output .= createInputForType('date', $field->name, $defaults_arr[$field->name]);
			}break;
			
			default:
				$output .= '<span>Ошибка в createInputForField</span>';
		}
	}else{
		$output .= getHtmlSelectFromFK( $field->name, 'id', getDisplayNameForTable($field->name), $defaults_arr);
	}
	
	$output .= '</div>';
	return $output;
}

function createInputForTable($table_name, $defaults_arr=array())
{
	$output = '';
	
	fillForeignKeyTable();
	
	$conn = connect_to_db();

    $query = 'SELECT * FROM '.$table_name.';';
    $result = mysqli_query($conn, $query);
	$finfo = mysqli_fetch_fields($result);
	$size = count($finfo);
	
	$output .= '<div class="fields_block">';
	for ($i=1;$i<$size;++$i)
	{
		$output .= createInputForField($finfo[$i], is_foreign_key($table_name, $finfo[$i]->name), $defaults_arr);
		
	}
	$output .= '</div>';
	
    mysqli_free_result($result);
    mysqli_close($conn);

	
	
	
	
	return $output;
}


function is_foreign_key($table_name,$col_name)
{
	$res = false;
	$table_name = strtolower($table_name);
	$col_name =  strtolower($col_name);
	$fk_table = $_SESSION['foreign_table'];
	
	foreach($fk_table as $key => $val)
	{
		$arr1 = explode(':',$key);
	
		if ($arr1[0] == $col_name && $arr1[1]==$table_name)
		{
			
			$res = true;
			break;
		}
	}
	
	
		
	return $res;

}

/* Заменяет имена столбцов в множественном числе на единственное число*/
function generate_alias($in_str)
{
	$output = '';
	
	switch($in_str)
	{
		case 'bak_diplomi':{
			$output .= 'bak_diplom';
		}break;
		case 'dekanati':{
			$output .= 'dekanat';
		}break;
		case 'disciplini':{
			$output .= 'disciplina';
		}break;
		case 'doktorsky_disseri':{
			$output .= 'doktorskaya_disser';
		}break;
		case 'fakulteti':{
			$output .= 'fakultet';
		}break;
		case 'gruppi':{
			$output .= 'gruppa';
		}break;
		case 'individ_raboti':{
			$output .= 'individ_rabota';
		}break;
		case 'kafedri':{
			$output .= 'kafedra';
		}break;
		case 'kandidatskie_disseri':{
			$output .= 'kandidatskaya_disser';
		}break;
		case 'konsultacii':{
			$output .= 'konsultacia';
		}break;
		case 'kontroli':{
			$output .= 'kontrol';
		}break;		
		case 'kursovie_raboti':{
			$output .= 'kursovaya_rabota';
		}break;	
		case 'lab_raboti':{
			$output .= 'lab_rabota';
		}break;
		case 'lekcii':{
			$output .= 'lekcia';
		}break;
		case 'magister_disseri':{
			$output .= 'magister_disser';
		}break;
		case 'prepodavateli':{
			$output .= 'prepodavatel';
		}break;
		case 'seminari':{
			$output .= 'seminar';
		}break;
		case 'soiskateli_kandidatskoi':{
			$output .= 'soiskatel_kandidatskoi';
		}break;
		case 'studenti':{
			$output .= 'student';
		}break;
		case 'uchebny_poruchenia':{
			$output .= 'uchebnoe_poruchenie';
		}break;
		case 'uchebny_plani':{
			$output .= 'uchebny_plan';
		}break;
		case 'vedomosti':{
			$output .= 'vedomost';
		}break;
		case 'zapisi_vedomosti':{
			$output .= 'zapis_vedomosti';
		}break;
		
		
		default:
			$output = $in_str;
			
	}
	
	
	return $output;
}


function getValueFromFK($ref_table, $ref_id)
{
	if ($ref_id != NULL){
		fillForeignKeyTable();
		$val = '';
		$conn = connect_to_db();
		
		$alias = generate_alias($ref_table);
	
		$ref_field_name_arr = getDisplayNameForTable($alias);

		
		$newStr = implode(',', $ref_field_name_arr);
		
		$query = 'SELECT '.$newStr.' FROM '.$alias.' WHERE id='.$ref_id;
		
		$result = mysqli_query($conn, $query);
		
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		
		$val = $row[0];

		mysqli_free_result($result);
		mysqli_close($conn);
	}
	return $val;
}


function fillForeignKeyTable()
{

	$conn = connect_to_db();

    $query = 'SELECT CONSTRAINT_NAME, TABLE_NAME, REFERENCED_TABLE_NAME
				FROM information_schema.referential_constraints
				WHERE constraint_schema = "infodb"';
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $constraint_name = $row['CONSTRAINT_NAME'];
		$table_name = $row['TABLE_NAME'];
		$ref_table_name = $row['REFERENCED_TABLE_NAME'];
        
		$field_name = substr($constraint_name, 3+strlen($table_name)+1, strlen($constraint_name)-3+strlen($table_name)+1);
		
		$ref_field_name_arr = getDisplayNameForTable($ref_table_name);
		
		
		$str1 = implode(':',array($field_name, $table_name));
		$str2 = implode(':',array($ref_field_name_arr[0], $ref_table_name));
		
		$fk_table[$str1] = $str2;
		
    }

	
	$_SESSION['foreign_table'] = $fk_table;
	
    mysqli_free_result($result);
    mysqli_close($conn);
	
}

function getHtmlSelectFromFK($table_name, $option_id, $option_nazvanie_arr, $defaults_arr=array())
{
	
	$conn = connect_to_db();

    $query = 'SELECT * FROM '.$table_name;
    $result = mysqli_query($conn, $query);
	
    $output = '<select name="'.$table_name.'">';
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	    if($row['id'] == $defaults_arr['gruppa']){
				$output .= sprintf('<option selected value="%s">',  $row['id']);
				for($i=0;$i<count($option_nazvanie_arr);++$i)
				{
					$output .= sprintf('%s ', $row[$option_nazvanie_arr[$i]]);
				}
				$output .= '</option>';
			}else{
				$output .= sprintf('<option value="%s">',  $row['id']);
				for($i=0;$i<count($option_nazvanie_arr);++$i)
				{
					$output .= sprintf('%s ', $row[$option_nazvanie_arr[$i]]);
				}
				$output .= '</option>';
			}
    }
    $output .= '</select>';
    mysqli_free_result($result);
    mysqli_close($conn);

	return $output;
}



/* Возвращает имя, которое нужно показывать в поле выбора по внешнему ключу для таблицы
т.е. для таблицы Студент output == array('fio') */
function getDisplayNameForTable($table_name)
{
	$output = '';
	
	switch($table_name)
	{
		case 'bak_diplom':{
			$output .= 'reg_nomer';
			$output .= '+tema';
		}break;
		case 'dekanat':{
			$output .= 'fakultet:nazvanie';
		}break;
		case 'disciplina':{
			$output .= 'nazvanie';
		}break;
		case 'doktorskaya_disser':{
			$output .= 'id';
		}break;
		case 'fakultet':{
			$output .= 'abbr';
		
		}break;
		case 'gruppa':{
			$output .= 'nazvanie';
		}break;
		case 'individ_rabota':{
			$output .= 'chasov';
		}break;
		case 'kafedra':{
			$output .= 'nazvanie';
		}break;
		case 'kandidatskaya_disser':{
			$output .= 'tema';
		}break;
		case 'konsultacia':{
			$output .= 'chasov';
			$output .= '+prepodavatel';
		}break;
		case 'kontrol':{
			$output .= 'tip';
			$output .= 'date';
		}break;		
		case 'kursovaya_rabota':{
			$output .= 'chasov';
			$output .= '+prepodavatel';
		}break;	
		case 'lab_rabota':{
			$output .= 'chasov';
			$output .= '+prepodavatel';
		}break;
		case 'lekcia':{
			$output .= 'chasov';
			$output .= '+prepodavatel';
		}break;
		case 'magister_disser':{
			$output .= 'id';
		}break;
		case 'prepodavatel':{
			$output .= 'fio';
			$output .= '+kafedra';
		}break;
		case 'seminar':{
			$output .= 'chasov';
			$output .= '+prepodavatel';
		}break;
		case 'soiskatel_kandidatskoi':{
			$output .= 'id';
		}break;
		case 'student':{
			$output .= 'fio';
			$output .= '+gruppa';
		}break;
		case 'uchebnoe_poruchenie':{
			$output .= 'id';
		}break;
		case 'uchebny_plan':{
			$output .= 'id';
		}break;
		case 'vedomost':{
			$output .= 'id';
		}break;
		case 'zapis_vedomosti':{
			$output .= 'id';
		}break;
		
		
		default:
			$output = 'Ошибка в getDisplayNameForTable';
	}
	
	$outputArr = explode('+', $output);
	
	return $outputArr;
}


/* Просеивает GET запрос, составляя ассоциативный массив, в котором ключ - это имя столбца,
а значение - значение в ячейки. Используется при INSERT*/
function siftGETRequest($get_arr, $table_name)
{
	$_SESSION['reserved_requests']=array('request', 'wizards', 'is_end', 'step');
	
	foreach ($_SESSION['reserved_requests'] as $val)
		unset($get_arr[$val]);
		
	
	return $get_arr;
}

function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function isShowResult($get_array)
{
	$res = false;
	$contents = file_get_contents('permissions.ini');
	
	$arr_contents = explode('#', $contents);
	
	$user = $_SESSION['username'];
	$wizard = $get_array['wizards'];
	$request = $get_array['request'];
	$step = $get_array['step'];
	
	$concate_string = implode('::', array($user,$wizard,$request,$step) );
	
	foreach ($arr_contents as $val)
	{
		$val = trim($val);
		if (startsWith($val, $concate_string)){
			if (endsWith($val, 'y')){
				$res = true;
			}
		}
	}
	
	
	
	return $res;
}




function createDelDialogForTable($table_name)
{
	$output = '';
	$conn = connect_to_db();
	
	
    $query = 'SELECT * FROM '.$table_name.';';
    $result = mysqli_query($conn, $query);
	
	$output .= '<select name="'.$table_name.'">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Для удаления записи выберите её в списке и нажмите "Удалить"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';


    mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function createSelUpdDialogForTable($table_name)
{
	$output = '';
	$conn = connect_to_db();
	
	
    $query = 'SELECT * FROM '.$table_name.';';
    $result = mysqli_query($conn, $query);
	
	$output .= '<select name="'.$table_name.'">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Для изменения записи выберите её в списке и нажмите "Далее"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';


    mysqli_free_result($result);
    mysqli_close($conn);
	
	
	
	$output .= '<div class="fields_block">';
	for ($i=1;$i<$size;++$i)
	{
		$output .= createInputForField($finfo[$i], is_foreign_key($table_name, $finfo[$i]->name));
		
	}
	$output .= '</div>';
	
	return $output;
}

function createUpdDialogForTable($table_name)
{
	$output = '';
	
	fillForeignKeyTable();
	
	$conn = connect_to_db();

    $query = 'SELECT * FROM '.$table_name.' WHERE id='.$_SESSION['last_get']['Kontrol'].';';
	
    $result = mysqli_query($conn, $query);
	
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
	foreach($row as $key => $val){
		$defaults_arr[$key] = $val;
	}
	
	
	
	$finfo = mysqli_fetch_fields($result);
	$size = count($finfo);
	$output .= '<div class="fields_block">';
	for ($i=1;$i<$size;++$i)
	{
		$output .= createInputForField($finfo[$i], is_foreign_key($table_name, $finfo[$i]->name), $defaults_arr );
		
	}
	$output .= '</div>';
	
    mysqli_free_result($result);
    mysqli_close($conn);
	

	
	return $output;
}


function ui_get_lekcia_teacher()
{
	
	$conn = connect_to_db();
    $query = 'SELECT * FROM Disciplina;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Disciplina">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите дисциплину и нажмите "Узнать"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';
	
	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function ui_get_hours_for_disciplina()
{
	
	$conn = connect_to_db();
    $query = 'SELECT * FROM Disciplina;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Disciplina">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите дисциплину и нажмите "Узнать"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';
	
	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function ui_is_lab_rabota_in_disciplina()
{
	$conn = connect_to_db();
    $query = 'SELECT * FROM Disciplina;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Disciplina">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите дисциплину и нажмите "Узнать"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';
	
	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function ui_get_balls_list()
{
	$conn = connect_to_db();
    $query = 'SELECT * FROM Kontrol;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Kontrol">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите контроль, группу и нажмите "Получить"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';

	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function ui_get_kafedras_kan_dissers()
{
		$conn = connect_to_db();
    $query = 'SELECT * FROM Kafedra;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Kafedra">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите кафедру и нажмите "Получить"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';

	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

function ui_get_exam_dates()
{
	$conn = connect_to_db();
    $query = 'SELECT * FROM Prepodavatel;';
    $result = mysqli_query($conn, $query);
	
	$output .= '<div class="fields_block">';
	$output .= '<select name="Prepodavatel">';
	$output .= sprintf('<option selected disabled value="" >%s</option>',  'Выберите преподавателя и нажмите "Узнать"');
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	    $id = $row[0];
		unset($row[0]);
		$newStr = implode('|', $row);
		
		$output .= sprintf('<option value="%s" >%s</option>', $id, $newStr );
    }
	$output .= '</select>';

	$output .= '</div>';
	
	mysqli_free_result($result);
    mysqli_close($conn);
	
	return $output;
}

?>
