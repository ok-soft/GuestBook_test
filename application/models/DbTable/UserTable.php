<?php

class Application_Model_DbTable_UserTable extends Zend_Db_Table_Abstract{

    protected $_name = 'user'; // ��� �������, � ������� ����� ��������

    // ����� ��� ���������� ����� ������
    public function addUser($name,$email){
		//  ��������� ������ ����������� ��������

		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		$time=time(); 
		$data = array(
			'name' => $name,
			'email' => $email,
			'http_user_agent' => $user_agent,
		);
			
      
        //  ��������� ������ � ������� �������������
        $rows = $this->insert($data);
		return $rows; 
    }
    
}