<?php

class IndexController extends Zend_Controller_Action{
    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
		// Создаём форму
		$form = new Application_Form_GuestBook();
		
		// Создаём объект модели
		$messages = new Application_Model_DbTable_GuestBook();
		
		// Создаём пагинатор
		$num = 5;  // Число записей на страницу
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
		
		// если пришел Post запрос, обрабатываем
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost(); // принимаем данные
			if ($form->isValid($formData)) { // Если форма заполнена верно
				// Извлекаем данные
				$name = $form->getValue('name');
				$email = $form->getValue('email');
				$title = $form->getValue('title');
				$text = $form->getValue('text');
				// Вызываем метод модели addMessage для вставки новой записи
				$messages->addMessage($name,$email,$title,$text);	
				// Очищаем поля формы
				$form = new Application_Form_GuestBook();
			}
		}
		
		// Создаём список сообщений
		$this->view->messages = $messages->getMessages($start,$num,$sort);
		
		// Передаём форму в view
		$this->view->form = $form;
		
    }
	

	


}
