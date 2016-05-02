<?php


class User extends AppModel {
	var $name='User';
	 public $hasOne  = array(
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_id',
        ),
		 'Designation' => array(
            'className' => 'Designation',
            'foreignKey' => 'id',
			'associationForeignKey' => 'role_id',
        )
    );


	// public $hasOne = 'UserProfile';


	//	var $validate = array(


//	    'First Name'=>array(


//		     'title_must_not_be_blank'=>array(


//			      'rule'=>'notEmpty',


//				  'message'=>'This Employee is missing a first name!'


//			 )


//		),


//		'Last Name'=>array(


//		     'title_must_not_be_blank'=>array(


//			      'rule'=>'notEmpty',


//				  'message'=>'This Employee is missing a first name!'


//			 )


//		),


//		'Email' => array(


//            'email' => array(


//                'rule' => array('email'),


//                'message' => 'Invalid email address',


//                'allowEmpty' => false,


//            )


//        ),


//		'Phone' => array(


//           'phone_no_should_be_numeric'=>array(


//                   'rule' => 'numeric',


//				   'allowEmpty' => true,


//                   'message'=>'Phone number should be numeric'


//            )


//        )


//	);


//


//	public $hasOne = array(


//		'UserProfile'=>array(


//			'className'=>'UserProfile',


//			'dependent'=> true,


//			'foreign_key'=>'user_id'


//		)


//	


//	);	


}


?>