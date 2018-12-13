<?php

class Application_Form_GuestBook extends Zend_Form{
    public function init(){
        $this->setName('message');
        $isEmptyMessage = 'Поле является обязательным для заполнения';
		$notValidName = 'Поле содержит недопустимый символ';
        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Имя')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
			->addValidator('regex', false, array('/^[^+]*$/i'))
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => $isEmptyMessage)))
			->setErrorMessages(array('Поле должно быть корректно заполнено'))
			;
			
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
			->addValidator('regex', false, array('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i'))
			->setErrorMessages(array('Поле должно содержать Email'))
			;			
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Тема')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
			
        $text = new Zend_Form_Element_textarea ('text');
        $text->setLabel('Текст')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );			
        
        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить');
        $this->addElements(array($name, $email, $title, $text, $submit));

    }
}