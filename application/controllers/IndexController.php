<?php

class IndexController extends Zend_Controller_Action{
    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
		// ������ �����
		$form = new Application_Form_GuestBook();
		
		// ������ ������ ������
		$messages = new Application_Model_DbTable_GuestBook();
		
		// ������ ���������
		$num = 5;  // ����� ������� �� ��������
		$currentPage = $this->_getParam('page');
		if($currentPage<1 or empty($currentPage)){
			$currentPage = 1;
		}
		$start = $currentPage*$num-$num;
		$totalCount = $messages->getCount();
		$maxPages = $totalCount / $num + 1;

		$this->view->currentPage = $currentPage;
		$this->view->maxPages = $maxPages;
		
		$sort = $this->_getParam('sort');
		if ($sort > 0){
			session_start(); $_SESSION['sort']=$sort;
			$start = 0; 
		}
		
		// ���� ������ Post ������, ������������
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost(); // ��������� ������
			if ($form->isValid($formData)) { // ���� ����� ��������� �����
				// ��������� ������
				$name = $form->getValue('name');
				$email = $form->getValue('email');
				$title = $form->getValue('title');
				$text = $form->getValue('text');
				// �������� ����� ������ addMessage ��� ������� ����� ������
				$messages->addMessage($name,$email,$title,$text);	
				// ������� ���� �����
				$form = new Application_Form_GuestBook();
			}
		}
		
		// ������ ������ ���������
		$this->view->messages = $messages->getMessages($start,$num,$sort);
		
		// ������� ����� � view
		$this->view->form = $form;
		
    }
	

	


}
