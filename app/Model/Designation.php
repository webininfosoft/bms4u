<?php

class Designation extends AppModel {

	var $name = 'Designation';

	var $validate = array(

	    'designation'=>array(

		     'title_must_not_be_blank'=>array(

			      'rule'=>'notEmpty',

				  'message'=>'This Designation is missing a title!'

			 )

		)

	);
	
	public $hasMany = array(
        'DesignationsParent' => array(
            'className' => 'DesignationsParent',
			'foreignKey'=>'designation_id'
        )
    );
		 
public function AllFOS($cId){
			$fos=$this->find('all',array('conditions'=>array('designation'=>'Fos','company_id'=>$cId)));
			if($fos){
				foreach($fos as $fo){
					$allFosId[]=$fo['Designation']['id'];
				}
				return $allFosId;
			}
	}
}

?>