<?php
class  AuthenticationsController extends AppController
{ 
 var $name='Authentications';
     public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','Retailer', 'Authentication','CompanyModule');
	 public $layout = 'default';
	 
    
     public function beforeFilter()
	{	
	
	 $xyz=$this->sidebar();
	 
	 $this->set('modules',$xyz);
	if(!$this->Session->read('user'))
		   { 
					$this->redirect('/');
		   }
		   
		   
	}

 public function sidebar()
{
   $userDetail = $this->Session->read('user');
   $intCompanyId=$userDetail['User']['id'];	
   $sql="SELECT * from company_module where company_id='".$intCompanyId."'";
   $module=$this->CompanyModule->query($sql);
   return $module;
	
	
}


    public function index($user_type_id='')
    {
        $this->layout='default';
		$userpermission=$this->Session->read('user.permissions');
		$compnayid=$this->Session->read('user');
		$intCompanyid=$compnayid['User']['company_id'];
		$sql1="SELECT * FROM company_module where company_id='".$intCompanyid."'";
		$modules=$this->CompanyModule->query($sql1);
	    $this->set('modules',$modules);
		if($this->request->is('post'))
		{			

			$data = $this->request->data;
			$data1=$data['Authentication']['user_type_id'];
			print_r($data1);
			exit;
			while(list($key,$val)=each($data))
			{
			
				
				
			}
			exit;
		    $this->Authentication->save($data ,false);
		
			

			$query = "delete from authentications where user_type_id='$user_type_id'";
            $this->Authentication->query($query);
			$this->set('message','Privilidges Assaingned');	


		}				


		// Find all user types

        $userdata=$this->Session->read('user'); 
		$intCompanyId=$userdata['User']['company_id'];	
		$userTypes = $this->Designation->find('all', array('conditions' => array('company_id' =>$intCompanyId)));
		$this->set('userTypes',$userTypes);
		// Find all privilidges of this user type


		//$permissions = $this->Authentication->findAllByUserTypeId($user_type_id);					
        //$existingPerms = array();
		while(list($key,$val)=each($permissions))
		{
			$existingPerms[$val['Authentication']['module_id']] = $val['Authentication'];
		}		

		$this->set('permissions',$existingPerms);
		$this->set('user_type_id',$user_type_id);		
	}
	
	
}
?>