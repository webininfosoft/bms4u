<?php
Class AdminsController extends AppController
{ 
	var $name='Admins';
	public $uses= array('User','Authentication','CompanyModule', 'Designation');
	
	 public function beforeFilter()
    {	
	
		$this->layout='default';
		$action = $this->params->params['action'];

/*		if(!in_array($action,$this->access))
		{
			if(!$this->Session->read('user'))
			{
				$this->redirect('/admins/adminlogin');
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
		}*/
    }
	
	public function index($user_type_id='')
	{

		//$userpermission=$this->Session->read('user.permissions');
		$compnayid=$this->Session->read('user');
		$intCompanyid=$compnayid['User']['company_id'];
		$sql1="SELECT * FROM company_module,modules where modules.id=company_module.module_id and company_id='".$intCompanyid."'";
		$modules=$this->CompanyModule->query($sql1);
		
	    $this->set('modules',$modules);

		if($this->request->is('post'))
		{			
			$data = $this->request->data;
			$user_type_id = $data['user_type_id'];
			
			// Delete existing permissions
			$query = "delete from authentications where user_type_id='$user_type_id' and company_id=$intCompanyid";
			$this->Authentication->query($query);
			
			// Add latest permissions
			while(list($key,$val)=each($modules))
			{
				$temp = array();
				$temp['id'] = ''; 
				$temp['user_type_id'] = $user_type_id;
				$temp['module_id'] = $val['company_module']['module_id'];
				$temp['company_id'] = $intCompanyid;
				$temp['perm_view'] = $data['perm'][$key]['perm_view']?1:0;
				$temp['perm_add'] = $data['perm'][$key]['perm_add']?1:0;
				$temp['perm_update'] = $data['perm'][$key]['perm_update']?1:0;
				$temp['perm_delete'] = $data['perm'][$key]['perm_delete']?1:0;

			//	$temp['perm_app_online'] = $data['perm'][$key]['perm_app_online']?$data['perm'][$key]['perm_app_online']:0;
				$temp['perm_app_offline'] = $data['perm'][$key]['perm_app_offline']?1:0;

				$this->Authentication->save($temp,false);	
			}

			$this->set('message','Privilidges updated');	
		}				
		
		// Find all user types
		$userTypes = $this->Designation->find('all', array('conditions' => array('company_id' =>$intCompanyid)));
		$this->set('userTypes',$userTypes);
		
		// Find all privilidges of this user type
		$permissions = $this->Authentication->findAllByUserTypeId($user_type_id);					
		$existingPerms = array();
		while(list($key,$val)=each($permissions))
		{
			$existingPerms[$val['Authentication']['module_id']] = $val['Authentication'];
		}		
		$this->set('permissions',$existingPerms);
		$this->set('user_type_id',$user_type_id);		
	}	


	public function companyModules($intCompanyID='1')
	{
		$arrModule = $this->Module->find('all',array('conditions'=>array('parent_id'=>0)));
		$this->set('arrModule', $arrModule);


	if($this->request->is('post'))
	{
		
		 $this->CompanyModule->deleteAll(array('CompanyModule.company_id' => $intCompanyID), false);

		  while(list($key,$val)=each($this->request->data['module_id']))
          {
			   $arData=array();
			   $arData['CompanyModule']['id']="";
			   $arData['CompanyModule']['company_id']=$intCompanyID;
			   $arData['CompanyModule']['module_id']=$val;
			   $arData['CompanyModule']['created_ts']=date('Y-m-d H:i:s');
			   $this->CompanyModule->save($arData,false);
	      }

	 }
	   $arrCompanyModule = $this->CompanyModule->find('all',array('conditions'=>array('company_id'=>$intCompanyID)));

		while(list($key,$val)=each($arrCompanyModule))
		{
				$arrExistModule[]=$val['CompanyModule']['module_id'];
		}
		$this->set('arrExistModule', $arrExistModule);

		$arrCompanies = $this->User->find('all',array('conditions'=>array('role'=>'COMPANY')));
		$this->set('arrCompanies', $arrCompanies);

		$this->set('intcompanyId', $intCompanyID);


	
	}
	public function adminlogin()
	{		
		$this->layout='login_layout';
		if($this->Session && $this->Session->check('user'))
		$this->redirect('/Users/userProfile');	
		
		if($this->request->is('post'))	
		{

			 $user = $this->User->find('first',array('conditions'=>array('User.user_password'=>$this->request->data['password'],'AND'=>array('User.user_name'=>$this->request->data['username']))));
			

			
			if($user)
			{		
		    		
				$permissions = array();
				if($user['User']['role_id']=='' || $user['User']['role_id']=='')
					$admin = true;
					
				if(!$admin)			// Not Super Admin
				{
					$query = "select * from designations where id='".$user['User']['role_id']."'";
					$roleData = $this->User->query($query);
					$user['Designation'] = $roleData[0]['designations'];
					

					$query = "select * from authentications where user_type_id='".$user['User']['role_id']."' and company_id=".$user['User']['company_id'];					
					$details = $this->User->query($query,false);
					if(!$details)
					{
						//$query = "select * from authentications as a join modules as m on a.module_id=m.id where a.user_type_id='".$user['Designation']['parent_designation_id']."'";					
						//$details = $this->User->query($query,false);
					}
						
					while(list($key,$val)=each($details))
					{

						$permissions[$val['authentications']['module_id']]['perm_view'] = $val['authentications']['perm_view'];
						$permissions[$val['authentications']['module_id']]['perm_add'] = $val['authentications']['perm_add'];
						$permissions[$val['authentications']['module_id']]['perm_update'] = $val['authentications']['perm_update'];
						$permissions[$val['authentications']['module_id']]['perm_delete'] = $val['authentications']['perm_delete'];
					}					
				}else{
					// Super Admin case
					$modules = $this->CompanyModule->find('all',array("conditions"=>array('company_id'=>$user['User']['company_id'])));
					//print_r($modules);
					while(list($key,$val)=each($modules))
					{

						$permissions[$val['CompanyModule']['module_id']]['perm_view'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_add'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_update'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_delete'] = 1;
					}

				}

			 $user['permissions'] = $permissions;	// Final Array
		 
	     $this->Session->write('user',$user);
		 $this->redirect('/Users/userProfile');
			}
			else
			{		   

				$this->Session->setFlash('invalid Username password');
			   $this->set('flagWrong', '1'); 
	
			
			}
		}	
		
		
	}
	


	public function companyList($page,$companyid)
	{
	
	    $this->set('smallinfo', 'you can manage your companies Here');
		$this->set('title_for_layout', 'Companies ');
		$this->set('permissions',$permissions);
		//$this->layout='login_layout';


		$str .= 'role="COMPANY"';		

		$Currentuserid=$this->Session->read('user.User.id');

		if(!$page)
			$page=1;	

		
		
			$query = "select count(*) as total from users as a where $str";
			$totalEmp = $this->User->query($query);

			if($totalEmp[0][0]['total']>0)
		   {
				$offset = ($page-1)*1;	
				$totalPages = ceil($totalEmp[0][0]['total']/1);
			
				$query = "select * from users as a join user_profiles as b on a.id=b.user_id where a.id!=$Currentuserid and $str limit ".$offset.", 20";
				$employeeResult = $this->User->query($query);
		   }
		   else
			   $employeeResult =array();


			print_r($employeeResult);exit;
			if(count($employeeResult)>0)
		    {

			  $arrDesignations = $this->Designation->find('all',array("conditions" => array("company_id"=>$companyid)));
			  while(list($key,$val)=each($arrDesignations))
			  {
				$arrDesig[$val['Designation']['id']]=$val['Designation']['designation'];
			  }
			  $this->set('arrDesig',$arrDesig);
		    }

			$this->set('employeeResults', $employeeResult);

			$this->set('totalPages',$totalPages);						
			$this->set('page',$page);	
			$this->set('first_name',$first_name);
			$this->set('last_name',$last_name);
			
			$this->set('email',$email);
			$this->set('city',$city);
			$this->set('phone',$phone);
			
			$multiMarker = $this->UserProfile->find('all');
			$this->set('multiMarker', $multiMarker);
			
	}

}
?>