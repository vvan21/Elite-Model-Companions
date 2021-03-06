<?php
	App::import('Sanitize');
	class ContactsController extends AppController {
		public $name = 'Contacts';
		public $components = array('Email');
		//var $scaffold;
		
		public function index() 
		{
			if ($this->RequestHandler->isPost()) {
				$this->data = Sanitize::clean($this->data);
		        $this->Contact->set($this->data);
		        if ($this->Contact->validates()) {
		            //send email using the Email component
		            $this->Email->to = Configure::read('eliteModelsOwner');
					$this->Email->bcc = Configure::read('eliteModelsAdmins');
		            $this->Email->subject = 'Contact message from ' . $this->data['Contact']['full_name'];  
		            $this->Email->from = $this->data['Contact']['email'];
					//$this->Email->delivery = 'debug';
					// $msgContent = "You have received a contact submission\n\nFull Name: " . $this->data['Contact']['full_name'] . "\nEmail: " . $this->data['Contact']['email'] . "\nContact Number: " . $this->data['Contact']['contact_number'] . "\nEnquiry: " . $this->data['Contact']['enquiry'];
					$this->Email->template = 'contactEmail';
					$this->Email->sendAs = 'both';
					$this->set('Contact', $this->data);
		            $this->Email->send();
					$this->Contact->save();
		        	$this->set('submitted', 'Your enquiry has been submitted');
					unset($this->data['Contact']);
				} else {
					$this->set('errors', $this->Contact->validationErrors);
				}
		    }
			$metaDescription = "Please submit emails to Elite Model Companions by completing the form below. All communications will be kept strictly confidential and private. Alternatively you can send an email to info@elitemodelcompanions.com.au";
			$metaKeywords = array('Elite Model Companions', 'Contact Elite Model Companions', 'Email Elite Model Companions');
			$this->set('page_for_layout', 'contacts_item');
			$this->set(compact('metaDescription', 'metaKeywords'));
		}
		
    }