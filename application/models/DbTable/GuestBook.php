<?php

class Application_Model_DbTable_GuestBook extends Zend_Db_Table_Abstract{

    protected $_name = 'message'; // Имя таблицы, с которой будем работать

	// Запрос списка сообщений из объединения двух таблиц
	public function getMessages($start,$limit,$sort){
		$order = 'message_id DESC';
		session_start();
		if ($sort==2 || $_SESSION['sort']==2){
			$order = 'title';
		}
		$sql=$this->select()
            ->setIntegrityCheck(false)
            ->from(array('m' => 'message'),array('message_id','time', 'user_id','title','text'))               
            ->join(array('u' => 'user'),'m.user_id = u.user_id',array('name','email'))  
            ->where('1')   
			->limit($limit,$start)
            ->order($order);          

        $rows = $this->fetchAll($sql);
        return $rows; 

	}
	
	// Получение числа записей
	public function getCount(){
		$sql=$this->select()
            ->from('message','message_id');               

        $r = $this->fetchAll($sql);
		$rows=count($r);
		
        return $rows; 	
    }
	
    
    // Метод для добавление новой записи
    public function addMessage($name,$email,$title, $text){
		// 1. Проверяем по email есть ли пользователь в базе
		$sql=$this->select()
			->setIntegrityCheck(false)
            ->from('user',array('user_id','email'))
			->where("email='$email'");               
	
        $r = $this->fetchRow($sql);
		if (count($r) > 0){ // Пользователь есть, получаем id
			$uid = $r[user_id];
		}else{				// Пользователя нет - добавляем
			$user = new Application_Model_DbTable_UserTable();
			$uid = $user->addUser($name,$email);
		}

		
        // 2. Формируем массив вставляемых значений
        $data = array(
			'user_id' => $uid,
            'text' => $text,
            'title' => $title,
        );
        
        // 3. Добавляем запись в таблицу сообщений
        $this->insert($data);
    }
    
}