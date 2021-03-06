<?php
class EliteModel extends AppModel {
	var $name = 'EliteModel';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $actsAs = array('Sluggable' => array('label' => 'name', 'length' => 150));

	var $hasMany = array(
		'ModelImage' => array(
			'className' => 'ModelImage',
			'foreignKey' => 'elite_model_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Booking' => array(
			'className' => 'Booking',
			'foreignKey' => 'elite_model_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public $validate = array(
		'name'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a name for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 255),
				'message'	=> 'Maximum length of 255 characters for Name'
			)
		),
		'age'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter an age for the Elite Model'
			),
			'numeric'	=> array(
				'rule'		=> 'numeric',
				'message'	=> 'Invalid value for Age - Please enter a numeric value'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 3),
				'message'	=> 'Maximum length of 3 characters for Age'
			)
		),
		'height'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a height for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 50),
				'message'	=> 'Maximum length of 50 characters for Height'
			)
		),
		'bust_cup_size'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a Bust Cup Size for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 30),
				'message'	=> 'Maximum length of 30 characters for Bust Cup Size'
			)
		),
		'size'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a dress size for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 3),
				'message'	=> 'Maximum length of 3 characters for Dress Size'
			),
			'numeric'	=> array(
				'rule'		=> 'numeric',
				'message'	=> 'Invalid input for Dress Size - Only numeric characters allowed. Please try again'
			)
		),
		'hair_colour'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a Hair Colour for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 15),
				'message'	=> 'Maximum length of 15 characters for Hair Colour'
			)
		),
		'eye_colour'	=> array(
			'notEmpty'	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter an Eye Colour for the Elite Model'
			),
			'maxLength'	=> array(
				'rule'		=> array('maxLength', 10),
				'message'	=> 'Maximum length of 10 characters for Eye Colour'
			)
		),
		'cost'	=> array(
			'notEmpty'		=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Please enter a cost for the Elite Model'
			),
			'numeric'	=> array(
				'rule'		=> 'numeric',
				'message'	=> 'Invalid input for cost - Only numeric characters allowed. Please try again'
			)
		),
		'rank'	=> array(
			'numeric'		=> array(
				'rule'			=> 'numeric',
				'required'		=> false,
				'allowEmpty'	=> true
			)
		)
	);
	
	public function handleUploads($data)
	{
		$imageUploads = array();
		$errors = false;
		for ($i = 0; $i < count($data['ModelImage']); $i++) {
			if (isset($data['ModelImage'][$i]['location'])) {
				if (!$this->validateUploadFile($data['ModelImage'][$i])) {
					$errors = true;
					break;
				}
				$imageUploads[] = $data['ModelImage'][$i]['location'];
			}
		}
		
		if ($errors)
			return false;
		
		return $imageUploads;
	}
	
	public function preSaveHandleUploads($data = null)
	{
		if (is_null($data))
			$data = $this->data;
		if (!$images = $this->handleUploads($data)) 
			return false;
		
		$modelsDir = 'models' . DS;
		$uploadDir = 'img' . DS . $modelsDir;
		unset($this->data['ModelImage']);
		$id = 0;
		foreach ($images as $image) {
			extract($image, EXTR_OVERWRITE);
			$fileName = $uploadDir . '_' . time() . '_' . $name;
			
			$_modelImageLocation = array();
			if ($size && !$error)
				if (!move_uploaded_file($tmp_name, $fileName))
					return false;
				else {
					$this->data['ModelImage'][$id]['location'] = $fileName;
					$id++;
				}
		}
		
		return $this->data;
	}
	
	/* Stopped working on this as it was taking too long - this will enable additional images to edit screen
	public function checkImagesAndHandle($id, $data)
	{
		if (!$id && !$data || !isset($data['ModelImage']))
			return true;
		
		$countHowManyCurrentImages = $this->ModelImage->find('count', array(
			'conditions'		=> array('elite_model_id' => $id)
		));
		
		if (count($data['ModelImage']) > $countHowManyCurrentImages) {
			var_dump($data['ModelImage']['location']['error']);
			var_dump($countHowManyCurrentImages);
			die('additional image');
			// User has uploaded additional images - take care of this
			
			// Only save the images that are new
			$newImages = array();
			for ($i = 0; $i < count($data['ModelImage']); $i++)
				$newImages[] = $data['ModelImage'][$i];
			
			if (!$this->preSaveHandleUploads(array('ModelImage' => $newImages)))
				return false;
		}
		return true;
	}
	*/
	
	public function UpdateHits($slug)
	{
		$fieldToInc = 'viewed';
		$this->updateAll(array('EliteModel.' . $fieldToInc => 'EliteModel.' . $fieldToInc . '+1'), array('EliteModel.slug' => $slug));
	}

	public function beforeSave()
	{
		if (isset($this->data['EliteModel']['cost'])) {
			// Set the class of the model
			$classes = array(
				'Gold'		=> array('min' => 500, 'max' => 800),
				'Platinum'	=> array('min' => 801, 'max' => 1500),
				'Celebrity'	=> array('min' => 1501, 'max' => 10000)
			);
		
			$cost = $this->data['EliteModel']['cost'];
			$modelClass = '';
		
			foreach ($classes as $class => $prices) {
				if ($cost >= $prices['min'] && $cost <= $prices['max']) {
					$modelClass = $class;
					break;
				}
			}
		
			if ($modelClass !== '')
				$this->data['EliteModel']['class'] = $modelClass;
		}
		
		return true;
	}
}
?>