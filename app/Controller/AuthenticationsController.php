<?php
Class AuthenticationsController extends AppController
{ 
	var $name='Authentications';
	public $uses= array('User','Authentication','CompanyModule', 'Designation');
	
	 public function beforeFilter()
    {	
	
		$this->layout='default';
		$action = $this->params->params['action'];

		if(!in_array($action,$this->access))
		{
			if(!$this->Session->read('user'))
			{
				$this->redirect('/login');
			}
			else
			{
				$userDetail = $this->Session->read('user');		
				$title=$userDetail['UserProfile']['first_name']." Profile";
				$this->set('title_for_layout', $title);
				$this->set('userDetail',$userDetail);
				$this->set('permissions',$userDetail['permissions']);
				$arrCompanyModules=$this->getAllCompanyModules($userDetail['permissions']);

				$this->set('arrCompanyModules',$arrCompanyModules);
			}
		}
    }
	
	public function index($user_type_id='')
	{

		$compnayid=$this->Session->read('user');
		$intCompanyid=$compnayid['User']['company_id'];
		$sql1="SELECT * FROM company_module,modules where modules.slug=company_module.module_id and company_id='".$intCompanyid."'";
		$modules=$this->CompanyModule->query($sql1);
	    $this->set('modules',$modules);

		if($this->request->is('post'))
		{			
			$data = $this->request->data;
			$user_type_id = $data['user_type_id'];
			
			// Delete existing permissions
			$query = "delete from authentications where authentications.auth_type='WEB' and user_type_id='$user_type_id' and company_id=$intCompanyid";
			$this->Authentication->query($query);
			
			// Add latest permissions
			while(list($key,$val)=each($modules))
			{
				$temp = array();
				$temp['id'] = ''; 
				$temp['user_type_id'] = $user_type_id;
				$temp['module_id'] = $val['company_module']['module_id'];
				//$temp['slug'] = $val['company_module']['slug'];
				$temp['company_id'] = $intCompanyid;
				$temp['perm_view'] = $data['perm'][$key]['perm_view']?1:0;
				$temp['perm_add'] = $data['perm'][$key]['perm_add']?1:0;
				$temp['perm_update'] = $data['perm'][$key]['perm_update']?1:0;
				$temp['perm_delete'] = $data['perm'][$key]['perm_delete']?1:0;
				$temp['auth_type']='WEB';
				$this->Authentication->save($temp,false);	
			}

			$this->set('message','Privilidges updated');	
		}				
		
		// Find all user types
		$userTypes = $this->Designation->find('all', array('conditions' => array('company_id' =>$intCompanyid)));
		$this->set('userTypes',$userTypes);
		
		// Find all privilidges of this user type
		$permissions = $this->Authentication->find("all",array(
		"conditions"=>array('user_type_id'=>$user_type_id,'auth_type'=>'WEB')
			));						
		$existingPerms = array();
		while(list($key,$val)=each($permissions))
		{
			$existingPerms[$val['Authentication']['module_id']] = $val['Authentication'];
		}		
		$this->set('permissions',$existingPerms);
		$this->set('user_type_id',$user_type_id);		
	}	
	public function mobileApp($user_type_id='')
	{

		//$userpermission=$this->Session->read('user.permissions');
		$compnayid=$this->Session->read('user');
		$intCompanyid=$compnayid['User']['company_id'];
		$sql1="SELECT * FROM company_module,modules where modules.slug=company_module.module_id and company_id='".$intCompanyid."'";
		$modules=$this->CompanyModule->query($sql1);
	    $this->set('modules',$modules);

		if($this->request->is('post'))
		{			
			$data = $this->request->data;
			$user_type_id = $data['user_type_id'];
			
			// Delete existing permissions
			$query = "delete from authentications where authentications.auth_type='MOBILE' and user_type_id='$user_type_id' and company_id=$intCompanyid";
			$this->Authentication->query($query);
			
			// Add latest permissions
			while(list($key,$val)=each($modules))
			{
				$temp = array();
				$temp['id'] = ''; 
				$temp['user_type_id'] = $user_type_id;
				$temp['module_id'] = $val['company_module']['module_id'];
				//$temp['slug'] = $val['company_module']['slug'];
				$temp['company_id'] = $intCompanyid;
				$temp['perm_view'] = $data['perm'][$key]['perm_view']?1:0;
				$temp['perm_add'] = $data['perm'][$key]['perm_add']?1:0;
				$temp['auth_type']='MOBILE';
			//	

				$this->Authentication->save($temp,false);	
			}

			$this->set('message','Privilidges updated');	
		}				
		
		// Find all user types
		$userTypes = $this->Designation->find('all', array('conditions' => array('company_id' =>$intCompanyid)));
		$this->set('userTypes',$userTypes);
		
		// Find all privilidges of this user type
		$permissions = $this->Authentication->find("all",array(
		"conditions"=>array('user_type_id'=>$user_type_id,'auth_type'=>'MOBILE')
			));					
		$existingPerms = array();
		while(list($key,$val)=each($permissions))
		{
			$existingPerms[$val['Authentication']['module_id']] = $val['Authentication'];
		}		
		$this->set('permissions',$existingPerms);
		$this->set('user_type_id',$user_type_id);		
	}	
}
?>