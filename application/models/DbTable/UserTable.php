<?php

class Application_Model_DbTable_UserTable extends Zend_Db_Table_Abstract{

    protected $_name = 'user'; // »м€ таблицы, с которой будем работать

    // ћетод дл€ добавление новой записи
    public function addUser($name,$email){
		//  ‘ормируем массив вставл€емых значений

		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		$time=time(); 
		$data = array(
			'name' => $name,
			'email' => $email,
			'http_user_agent' => $user_agent,
		);
			
      
        //  ƒобавл€ем запись в таблицу пользователей
        $rows = $this->insert($data);
		return $rows; 
    }
    
}