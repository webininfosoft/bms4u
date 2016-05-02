<?php
Class UsersController extends AppController 
{ 
    var $components = array('Email','Core','ImageUpload');
    var $name='Users';  
	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation','BtlPromotion', 'CompanyModule','Module','Retailer','Order','DesignationsParent');
	public $access = array('login','ForgotPassword');
	public $layout = 'company_login_layout';
	
	
	public function beforeFilter()
	{	
		$this->layout='default';
		$action = $this->params->params['action'];

		if($_SERVER["REQUEST_URI"]!="/")
		{
			if(!in_array($action,$this->access))
			{
				if(!$this->Session->read('user'))
				{
					$this->redirect('/');
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
	}
	public function index()
	{
	}
	public function home()
	{
				$this->layout='blank';
	}

		
	public function  exportUserAttendance($userid,$datefrom,$dateto)
   {
	   
	  
	 
			$sql1="";
			/*$whr="p.company_id=".$intCompanyId ;
			if($_POST['designation_id'])
			{
				$whr.=" AND u.role_id=".$_POST['designation_id'];
			} */
			
			if($userid && $userid!='undefined')
			{
				$whr.=" ua.user_id='".$userid."' and ";
			}
			
	        
			if($datefrom && $dateto)
			{
				$dat1= date("Y-m-d 00:00:00", strtotime($datefrom));
				$dat2= date("Y-m-d 23:59:59", strtotime($dateto));
				
			}
			else if($datefrom=='' && $dateto!='')
			{
				$dat1= date("Y-m-d 00:00:00", strtotime($dateto));
				$dat2= date("Y-m-d 23:59:59", strtotime($dateto));
			}
			else if($datefrom!='' && $dateto=='')
			{
				$dat1= date("Y-m-d 00:00:00", strtotime($datefrom));
				$dat2= date("Y-m-d 23:59:59", strtotime($datefrom));
			}
				
			$whr.=" ua.time between '".$dat1."' and '".$dat2."'";
			
			$sql1="select * from  users as u , user_attendance as ua join user_profiles as UserProfile on ua.user_id=UserProfile.user_id where ua.user_id=u.id and $whr order by ua.time desc ";
			//echo $sql1;
			$allUsers=$this->User->query($sql1);
			 
			  while (list($key,$val)=each($allUsers))
			 {
			
				 $dat= date("d-m-Y", strtotime($val['ua']['time']));
				 $tim= date("h:i a", strtotime($val['ua']['time']));
				$finalarrcheckin[$dat][$val['ua']['user_id']][$val['ua']['status']]=array("name"=> $val['UserProfile']['first_name'],"branch"=> $val['UserProfile']['branch'],"phone"=>$val['UserProfile']['phone'],"img"=> $val['ua']['user_image'],"tim"=>$tim,"latitude"=> $val['ua']['latitude'],"longitude"=> $val['ua']['longitude']);
			 }
			 

	
		    $header_row_data="Sr\tName\tReporting Manager\tBranch\tProject\tdate\tTime_Check In\tTime_Check Out\n";
		  
		  
		   while(list($key1,$val1)=each($finalarrcheckin))
			 {
					while(list($key,$val)=each($val1))
					{
						
					 $projects=$this->getUserSites($key);
					 if(!$projects)
						 $projects='NA';
					 
					 $datenow=date("d M", strtotime($key1));;
					 $reporting="Satish Kumar";
					 $header_row_data.= $key."\t". $val['checkout']['name'] ."\t".$reporting."\t".$val['checkin']['branch']."\t".$projects."\t".$datenow."\t".$val['checkin']['tim']."\t".$val['checkout']['tim']."\t\n";
					
					}
				  
			 }
			 
				 $filename = WWW_ROOT."tempUploadData/export_".date("Y.m.d").".xls";
$fp= fopen($filename,'w');
fwrite($fp,$header_row_data);
fclose($fp);
$file=$filename;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

exit;
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=$filename");
header("Cache-Control: max-age=0");
				 echo($header_row_data);
			         exit;	  
		  
   }
	public function getUserSites($userid)
	{
		$sql="select * from user_retailers,retailers where user_retailers.retailer_id=retailers.id and user_retailers.user_id=$userid";
		$arrUserProjects = $this->User->query($sql);
		
		while(list($key2,$val2)=each($arrUserProjects))
		 {
			 $strprojects[$val2['retailers']['id']]=$val2['retailers']['shop_name'];
		 }
		 
		 return implode(",",$strprojects);
		
	}
	public function login()
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
	
	public function userProfile(){
		
		$arrBreadcrumbs[]=array("label"=>"User Profile" ,"link" => "");
		$this->set('arrBreadcrumbs', $arrBreadcrumbs);
		$this->set('smallinfo', 'Info');
		$userDetail = $this->Session->read('user');		
		$companyid=$this->Session->read('user.User.company_id');	
		
		$role=$userDetail['User']['role'];
		


		$title=$userDetail['UserProfile']['first_name']." Profile";
		$this->set('title_for_layout', $title);
		if($role=='COMPANY')
			$countRetailers= $this->Retailer->find('count', array('conditions' => array('Retailer.company_id =' => $companyid)));
		else
		{
		
			$query="select count(1) as numCount from user_retailers where user_id=".$userDetail['UserProfile']['user_id'];
			$countRetailer=$this->Retailer->query($query);
			$countRetailers=$countRetailer[0][0]['numCount'];

		}
		$countBtl= $this->BtlPromotion->find('count', array('conditions' => array('BtlPromotion.company_id =' => $companyid)));
	
		$countOrders= $this->Order->find('count', array('conditions' => array('company_id =' => $companyid)));


		$this->set('countBtl',$countBtl);
		$this->set('countOrders',$countOrders);
		$this->set('countRetailers',$countRetailers);		
		$this->set('userDetail',$userDetail);
		if(empty($this->request->data)) {
		    $this->data = $this->UserProfile->read(NULL, $id);
			}
			else {
		
			 if($this->UserProfile->save($this->data)) {
				   $this->Session->setFlash('The User has been updated');
				   $this->redirect(array('action'=>'userProfile'));
				  }
		}
		
	}
	public function add($id='')
	{
		$this->set('title_for_layout', 'Add Employee');
		$userdata=$this->Session->read('user');
	    $userdata['User']['role']="Retailer";
		$userdata['User']['token_id'];
	    $userdata['User']['role']="Employee";
		$userdata['User']['created_at']=date('Y-m-d H:i:s');
	    $this->set('Detail',$userdata); 
		
	  if($userdata['User']['company_id']=='0')
		  	$intCompanyId=$userdata['User']['id'];	
	  else
		  $intCompanyId=$userdata['User']['company_id'];

		  $permissions = $this->Session->read('user.permissions.'.$this->name);
		  $this->set('permissions',$permissions);
		
 
 
     if($this->request->is('post'))
	{
			
			$barnches=$this->request->data['UserProfile']['branch'];
			$this->set('Branch','$barnches');
			   
			$this->request->data['User']['user_name']=$this->request->data['UserProfile']['phone'];


			if(!$this->request->data['User']['id'])
			{ 

					$existUser = $this->User->find('all',
														 array('conditions'=>
																   array(
																		'user_name'=>$this->request->data['User']['user_name']
											
																		  )
															   )
												   );
					if(!$existUser)
					{

						if($this->request->data['Designation']['id'])
						{
							$this->request->data['User']['parent_id'] = $this->request->data['User']['parent_id'];
							$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
						}
						else
						{
							$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
						 }
						
						$this->request->data['User']['user_password']=123456;
						$this->request->data['User']['company_id'] = $intCompanyId;

						$this->User->save($this->request->data['User']);
						$lastuserid=$this->User->getLastInsertId();

						$this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'] ? $this->request->data['User']['id'] :$this->User->getLastInsertId();
						$this->UserProfile->save($this->request->data['UserProfile']);
						

						if($this->request->data['User']['parent_id'])
						{
							   $flagtrue=1;
							   $parentid=$this->request->data['User']['parent_id'];
							   $this->User->query("insert into users_parent(user_id,parent_id,company_id) values('$lastuserid',$parentid,$intCompanyId)");
							   
							   while($flagtrue)	
							   {
									$sql="select parent_id from users where id=$parentid";
									$dataparent=$this->User->query($sql);
									$parentid=$dataparent[0]['users']['parent_id']; 
									if($parentid)
									{
										$this->User->query("insert into users_parent(user_id,parent_id,company_id) values('$lastuserid',$parentid,$intCompanyId)");
									}
									else
									 $flagtrue=0;
								
							   }
						}

						 $this->set('message','Employee Added Succssfuly');	
					}
					else
					{
						$employeeDetails =	$this->request->data;

						$this->set('message1','Phone no is already registered with other employee. Please try another phone no.');
					}
			}

		    if($this->request->data['User']['id'] && $this->request->data['UserProfile']['id'])
			{ 
			  $id=$this->request->data['User']['id'];		  

			  if($this->request->data['Designation']['id'])
				{
					$this->request->data['User']['parent_id'] = $this->request->data['User']['parent_id'];
					$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
				}
				else
				{
					$this->request->data['User']['role_id'] = $this->request->data['User']['parent_role_id'];
				 }

			  $this->User->save($this->request->data['User']);
			  $this->UserProfile->save($this->request->data['UserProfile']);
			  $this->set('message', 'Employee Updated Succsesfuly!');
						  
			}
	}

		if($id)
		{	
			// Find Employee Details
			$employeeDetails = $this->User->findById($id);

			if($employeeDetails['User']['parent_id'])
			{
				$selectedRole = $employeeDetails['User']['role_id'];
				$selectedUser = $employeeDetails['User']['parent_id'];
				$selectedCompany = $employeeDetails['User']['company_id'];
				$this->set('selectedCompany',$selectedCompany);
				$this->set('selectedUser',$selectedUser);
			}
			else				
				$selectedRole = $employeeDetails['User']['role_id'];				
				$this->set('selectedRole',$selectedRole);
			 }
		
		$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
		$this->set('arrData', $designationResult);

	    $this->set('employeeDetail',$employeeDetails);
		 //get All company Branches	
		$arrBranches=$this->Branch->find('all',array('conditions'=>array('company_id'=>$intCompanyId)));
		$this->set('arrBranches', $arrBranches);
		$this->set('userdata', $userdata);
		
		 
	}
	
	public function usersList($page,$first_name='',$last_name='',$email='',$phone='',$role='',$city='')
	{
	
	   $this->set('smallinfo', 'you can manage your all Employee Here');
		$this->set('title_for_layout', 'Employees Detail ');
		$companyid=$this->Session->read('user.User.company_id');			
		$this->set('permissions',$permissions);
			//$this->layout='login_layout';
		$str = '';
			
			if($first_name && $first_name!='all')
				$str .= " and first_name = '".$first_name."'";
			if($last_name && $last_name!='all')
				$str .= " and last_name = '".$last_name."'";
			if($email && $email!='all')
				$str .= " and email = '".$email."'";
			if($phone && $phone!='all')
				$str .= " and phone = '".$phone."'";
			if($role && $role!='all')
				$str .= " and role = '".$role."'";
			if($city && $city!='all')
				$str .= " and city = '".$city."'";		
				
		$str .= ' and 1';		

		$Currentuserid=$this->Session->read('user.User.id');

		if(!$page)
			$page=1;	

		
	/*	if($userId)
		{		
			if(!$page)
				$page=1;	
		
			$query = "select count(*) as total from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."' ".$str;
			$totalEmp = $this->User->query($query);
			$offset = ($page-1)*20;	
			$totalPages = ceil($totalEmp[0][0]['total']/20);
			$query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."'  AND user_id NOT IN ('$Currentuserid')  limit ".$offset.", 20";
		}*/
		
			
/*			$userId = $this->User->findByCompanyId($this->Session->read('user.User.company_id'));
		if($userId['User']['company_id'])
			{	
				$query = "select count(*) as total from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.parent_id=d.id where a.role_id='".$userId['User']['role_id']."' ".$str;
				$totalEmp = $this->User->query($query);
				$offset = ($page-1)*20;	
				$totalPages = ceil($totalEmp[0][0]['total']/20);
			    
				$query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.role_id='".$userId['User']['role_id']."' ".$str." limit ".$offset.", 20";
			}
			else
			{
	
				 $query = "select count(*) as total from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."' ".$str;
				$totalEmp = $this->User->query($query);
				$offset = ($page-1)*1;	
				$totalPages = ceil($totalEmp[0][0]['total']/1);
			
				$query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."' ".$str." limit ".$offset.", 20";
			}
	*/	


			if($companyid!=$Currentuserid)
			{
				$query = "select count(*) as total from users_parent as a where  a.role!='Retailer' and  a.company_id=".$companyid." and a.parent_id=$Currentuserid ".$str;
				$totalEmp = $this->User->query($query);
			
				if($totalEmp[0][0]['total']>0)
				{
					$offset = ($page-1)*1;	
					$totalPages = ceil($totalEmp[0][0]['total']/1);
				
					$query = "select * from users as a join user_profiles as b on a.id=b.user_id join users_parent as d on a.id=d.user_id where  a.id != $Currentuserid and d.parent_id=$Currentuserid and d.company_id=".$companyid." ".$str." limit ".$offset.", 20";
					$employeeResult = $this->User->query($query);
				}
				else
					$employeeResult =array();
			}
			else
			{
				$query = "select count(*) as total from users as a where a.role!='Retailer' and a.id!=$Currentuserid and a.company_id=".$companyid." ".$str;
				$totalEmp = $this->User->query($query);

				if($totalEmp[0][0]['total']>0)
			   {
					$offset = ($page-1)*1;	
					$totalPages = ceil($totalEmp[0][0]['total']/1);
				
					$query = "select * from users as a join user_profiles as b on a.id=b.user_id where  a.role!='Retailer' and a.id!=$Currentuserid and  a.company_id=".$companyid." ".$str." limit ".$offset.", 20";
					$employeeResult = $this->User->query($query);
			   }
			   else
				   $employeeResult =array();

			}

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
	
	
	
	public	 function  export()
    {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From users  WHERE company_id='$intCompanyId'"; 
		  $UserResult=$this->User->query($sql);
		 
		echo   $header_row="Id\t GCM ID \t User Nmae \t User Password \t Confirm Password \t Role\t Company id \t Device ID\t Created Date\t \n";
		  foreach($UserResult as $val){
		   $header_row_data.= $val['users']['id']."\t". $val['users']['gcmid'] ."\t".$val['users']['user_name']."\t".$val['users']['user_password']."\t".$val['users']['confirm_password']."\t".$val['users']['role']."\t".$val['users']['company_id']."\t".$val['users']['devid']."\t".$val['users']['created_at']."\t\n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
    }
			
	public function delete($id) 
	{		  
	   if($this->User->delete($id)){
	   		
	   }
	   
	   $this->Session->setFlash('The Employee has been deleted', 'default', array(), 'delete');
       $this->redirect(array('action'=>'usersList')); 
	    
		 
	} 		
	public function logOut(){
		$this->Session->destroy();
		$this->redirect('/');
	}
	
	public function loadDesignation()
	{
		$this->layout = '';
	    $userDetail = $this->Session->read('user');
	    $intCompanyId=$userDetail['User']['company_id']; 

		$selected = $_POST['selected'];

		$result = $this->Designation->findById($_POST['designation_id']);
		$parent_designation_id = $result['Designation']['parent_designation_id'];
		$resultFinal = $this->User->find('all',array("conditions" => array("role_id"=>$parent_designation_id,"company_id"=>$intCompanyId)));

		$str = '<select name="data[User][parent_id]" class="small-full" required >';		
		$str .= "<option value='0'>---Select User---</option>";
		while(list($key,$val)=each($resultFinal))
		{
			if($selected==$val['User']['id'])
			{
				$str .= "<option selected value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
			}
			else
			{
			$str .= "<option value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
			}
		}
		$str .= "</select>";
		echo $str;
		exit;
	}
	
  public function ForgotPassword()
	{
		
			if($this->request->is('post'))
			
			{
				//print_r($this->request->data);
				//die;
			$postemail=$this->request->data['Email'];
			$arrData=$this->User->query("SELECT users.id,user_profiles.email,user_profiles.first_name FROM users INNER JOIN user_profiles ON  users.id=user_profiles.user_id where email='".$postemail."'");
			
			$id=$arrData['0']['users']['id'];
			$email=$arrData['0']['user_profiles']['email'];
			$name=$arrData['0']['user_profiles']['first_name'];
			$newPass=$this->Core->generatePassword();
		if($postemail==$email)
				{
			  
					$this->Email->to = $this->request->data['Email']; 
					$this->Email->subject = 'Reset Password Link'; 
					$this->Email->replyTo =  $this->request->data['Email']; 
					$this->Email->from = 'admin@avdhi.com';
					$message='Dear '.$name.'<br/>'; 
					$message.="<p>Your New Password is:".$newPass.'</p><br/>';
		
					 $send=$this->Email->send($message);
					 if ($send){
							$arrData=array('User'=>array('user_password'=>$newPass));
							$this->User->validation=null;
							$this->User->id=$id;
							$this->User->save($arrData,false);
						//$this->Session->setFlash('Password Reset Link Sent on your Email ID.','default', array(), 'Succsess');
						//$this->redirect(array('controller' => 'Users', 'action' => 'login','1'));
						echo '<div role="alert" class="alert alert-success ">Password Reset Link Sent on your Email ID.</div>';
					 }
				}else{
					echo '<div role="alert" class="alert alert-danger ">Provide Your Register Email ID.</div>';
					
					//$this->Session->setFlash('Provide Your Register Email ID.','default', array(), 'Fail');
					//$this->redirect(array('controller' => 'Users', 'action' => 'login','0'));
			  }
			}
			die;  
	}

	
    public function  resetpassword()
	 {
			$arr=$this->params['url'];
			$postid=implode("",$arr);
			$this->layout='login_layout';
	
		if($this->request->is('post'));
		{
		  $password1=$this->request->data['newpass'];
		  $password2=$this->request->data['cpassword'];
			 }
	
				if($password1===$password2)
	
			   {		
					   $sql="UPDATE users SET user_password='".$password1."', confirm_password='".$password2."' WHERE id='".$postid."'";
					   $succses=$this->User->query($sql);
					  
					   
		
				 }
				 if($succses){
					  $this->Session->setFlash('Password Reset Successfully Click Hera to Login<a href="/">Login</a>.','default', array(), 'Succs');
					  
				 }
			
						  else
						  {
							   $this->Session->setFlash('Password does not Match .','default', array(), 'fa');
							   
								 
						   }
	
						   
				
				
	    }
				   	
		public function map_view()
		{
			
			$companyid=$this->Session->read('user.User.company_id');
			$Currentuserid=$this->Session->read('user.User.id');
		 $query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."'  AND user_id NOT IN ('$Currentuserid')";	
			$arrRetailer=$this->User->query($query);
		
			// Iterate through the rows, printing XML nodes for each
			while (list($key,$val)=each($arrRetailer)){
				if($val['b']['latitude'])
						$data[] = array($val['b']['latitude'], $val['b']['longitude']);
			}
		
			$center=$this->GetCenterFromDegrees($data);
		
			$this->set("latcenter",$center[0]);
			$this->set("longcenter",$center[1]);
			
		
		}
		function parseToXML($htmlStr)
		{
			$xmlStr=str_replace('<','&lt;',$htmlStr);
			$xmlStr=str_replace('>','&gt;',$xmlStr);
			$xmlStr=str_replace('"','&quot;',$xmlStr);
			$xmlStr=str_replace("'",'&#39;',$xmlStr);
			$xmlStr=str_replace("&",'&amp;',$xmlStr);
			return $xmlStr;
		}

		public function getxmldata()
		{
			
			header("Content-type: text/xml");
			$companyid=$this->Session->read('user.User.company_id');
			$Currentuserid=$this->Session->read('user.User.id');
			$query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."'  AND user_id NOT IN      ('$Currentuserid')";	
			$arrRetailer=$this->User->query($query);
		
			// Start XML file, echo parent node
			echo '<markers>';
			
			// Iterate through the rows, printing XML nodes for each
			while (list($key,$val)=each($arrRetailer)){
			  // ADD TO XML DOCUMENT NODE
			  echo '<marker ';
			  echo 'name="' . $this->parseToXML($val['a']['user_name']) . '" ';
			  echo 'address="' .  $this->parseToXML($val['b']['address']) . '" ';
			  echo 'lat="' . $val['b']['latitude'] . '" ';
			  echo 'lng="' . $val['b']['longitude'] . '" ';
			  echo 'type="' . $val['b']['phone'] . '" ';
			  echo '/>';
			}
			echo '</markers>';
			
			exit;
		}

		function GetCenterFromDegrees($data)
		{
			if (!is_array($data)) return FALSE;
		
			$num_coords = count($data);
		
			$X = 0.0;
			$Y = 0.0;
			$Z = 0.0;
		
			foreach ($data as $coord)
			{
				$lat = $coord[0] * pi() / 180;
				$lon = $coord[1] * pi() / 180;
		
				$a = cos($lat) * cos($lon);
				$b = cos($lat) * sin($lon);
				$c = sin($lat);
		
				$X += $a;
				$Y += $b;
				$Z += $c;
			}
		
			$X /= $num_coords;
			$Y /= $num_coords;
			$Z /= $num_coords;
		
			$lon = atan2($Y, $X);
			$hyp = sqrt($X * $X + $Y * $Y);
			$lat = atan2($Z, $hyp);
		
			return array($lat * 180 / pi(), $lon * 180 / pi());
		}
		
		public function track($id='')
		{

			$userdata=$this->Session->read('user');	

			$intCompanyId=$userdata['User']['company_id'];
			$intRoleId=$userdata['User']['role_id'];
			
			
		 if($intRoleId)
		 {
		   $flagtrue=1;
		   $arrDesignationIDs=array();
		   $parentid=$intRoleId;
		   while($flagtrue)	
		   {
				$sql="select designation_id from designations_parents where parent_id=$parentid";
				$dataparent=$this->User->query($sql);
				$parentid=$dataparent[0]['designations_parents']['designation_id']; 
				if($parentid)
				{
						$arrDesignationIDs[]=$parentid;
				}
				else
				 $flagtrue=0;
			
		   }
			   $designationResult = $this->Designation->find('all', array('conditions' => array('id'=>$arrDesignationIDs)));
		 }else
		 {
				$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
		}

			$this->set('arrData', $designationResult);
			
	
		}
	
	
//-------------------------------------------------User Attendance start----------------------------------------------------------------------------------------------------

public function userAttendance($id='')
		{

			$userdata=$this->Session->read('user');	

			$intCompanyId=$userdata['User']['company_id'];
			 $intRoleId=$userdata['User']['role_id'];
			
			
		 if($intRoleId)
		 {
		   $flagtrue=1;
		   $arrDesignationIDs=array();
		   $parentid=$intRoleId;
		   while($flagtrue)	
		   {
				$sql="select designation_id from designations_parents where parent_id=$parentid";
				$dataparent=$this->User->query($sql);
				$parentid=$dataparent[0]['designations_parents']['designation_id']; 
				if($parentid)
				{
						$arrDesignationIDs[]=$parentid;
				}
				else
				 $flagtrue=0;
			
		   }
			   $designationResult = $this->Designation->find('all', array('conditions' => array('id'=>$arrDesignationIDs)));
		 }else
		 {
				$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
		}

			$this->set('arrData', $designationResult);
			
	
		}
		
		
		public function mapAttendanceView($userid,$lat,$long)
        {
			if($userid)
			$this->layout="blank";
			// Iterate through the rows, printing XML nodes for each
			$data[] = array($lat, $long);
			$center=$this->GetCenterFromDegrees($data);
			
			$this->set("latcenter",$center[0]);
			$this->set("longcenter",$center[1]);
			$this->set("lat",$lat);
			$this->set("long",$long);
	
	
        }
		
		
		
		
		
		
		
		public function loadUserByroleid1()
	{
		$this->layout = '';
		$userRole=$this->Session->read('user.User.role');
		$Currentuserid=$this->Session->read('user.User.id');
	    $companyid=$this->Session->read('user.User.company_id');

		if($userRole=='COMPANY')
		{
			$resultFinal = $this->User->findAllByRoleId($_POST['designation_id']);
		}
		else
		{
			$query = "select * from users as User join user_profiles as UserProfile on User.id=UserProfile.user_id join users_parent as d on User.id=d.user_id where  d.parent_id=$Currentuserid and d.company_id=".$companyid." and User.role_id='".$_POST['designation_id']."' ";
			
			$resultFinal = $this->User->query($query);
		}

	
		$str = '<select id="userslist" name="data[User][parent_id]" class="form-control" required onchange = "useridonchange1();">';		
		$str .= "<option value='0'>---Select User---</option>";
		while(list($key,$val)=each($resultFinal))
		{
			/*if($resultData==$val['User']['id'])
			{
				$str .= "<option selected value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
			}
			else*/
			//{
			$str .= "<option value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
		//	}
		}
		$str .= "</select>";
		echo $str;
		exit;
		
	}
		
		
		 public function allUser($id='')
		{
			//echo "$id";
			//echo "amit solanki";
			
			$userdata=$this->Session->read('user');	

			$intCompanyId=$userdata['User']['company_id'];
			$intRoleId=$userdata['User']['role_id'];
			
			$this->layout='blank';
			$companyid=$this->Session->read('user.User.company_id');
			$Currentuserid=$this->Session->read('user.User.id');
			//$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));   as p  where p.company_id='".$companyid."'
			//$start1=date("Y-m-d 00:00:00");
			//$end1=date("Y-m-d 23:59:59");
			$start1=date("Y-m-d 2014-12-17");
			$end1=date("Y-m-d 2014-12-19");
			 //$sql1="select * from user_attendance as p, users as u  where p.user_id=u.id and p.time between '$start1' and '$end1'";
			 //$sql1="select * from user_attendance as p, users as u  where p.user_id=u.id and p.time between '2014-12-17 12:48:31' and '2014-12-17 12:48:46'";
			 $sql1="";
			$whr="p.company_id=".$intCompanyId ;
			if($_POST['designation_id'])
			{
				$whr.=" AND u.role_id=".$_POST['designation_id'];
			}
			
			if($_POST['userid'])
			{
				$whr.=" AND p.user_id='".$_POST['userid']."'";
			}
			if($_POST['start_date']){
			 $date1=$_POST['start_date'];
		 $date2=$_POST['end_date'];
		 
		 //$startdate=date("Y-m-d 00:00:00",strtotime($date));
		//$enddate=date("Y-m-d 23:59:59",strtotime($date));
		 
		 $dat1= date("Y-m-d 00:00:00", strtotime($date1));
		 $dat2= date("Y-m-d 23:59:59", strtotime($date2));
			$whr.="and p.time between '".$dat1."' and '".$dat2."'";
			}
			$sql1="select * from  users as u , user_attendance as p join user_profiles as UserProfile on p.user_id=UserProfile.user_id where p.user_id=u.id and $whr order by p.time desc ";
			//echo $sql1;
			 $allUsers=$this->User->query($sql1);
			 
			 while (list($key,$val)=each($allUsers))
			 {
			
				 $dat= date("d-m-Y", strtotime($val['p']['time']));
				 $tim= date("H:i:s", strtotime($val['p']['time']));
				$finalarrcheckin[$dat][$val['p']['user_id']][$val['p']['status']]=array("name"=> $val['UserProfile']['first_name'],"phone"=>$val['UserProfile']['phone'],"img"=> $val['p']['user_image'],"tim"=>$tim,"latitude"=> $val['p']['latitude'],"longitude"=> $val['p']['longitude']);
				
				
			 }
			//print_r($finalarrcheckin);
			
			$this->set('allUser', $allUsers);
			$this->set('finalarrcheckin', $finalarrcheckin);
			
		}
		
		
		

public	function selectedUserAttendance($designation_id,$userid,$date1,$date2)
	{
	         //$userID=$intUserId;
		 $date1=$_POST['start_date'];
		 $date2=$_POST['end_date'];
		 
		 //$startdate=date("Y-m-d 00:00:00",strtotime($date));
		//$enddate=date("Y-m-d 23:59:59",strtotime($date));
		 
		 $dat1= date("Y-m-d 00:00:00", strtotime($date1));
		 $dat2= date("Y-m-d 23:59:59", strtotime($date2));
		 echo $dat1.$dat2;
			//echo $intuid="'".$intUserId."'" ;	 
		 //order by '$userID'
		 //echo $sql2="select * from user_attendance as p, users as u  where p.user_id=u.id and p.user_id='".$intUserId."'";
		 $sql2="select * from  users as u , user_attendance as p join user_profiles as UserProfile on p.user_id=UserProfile.user_id where p.user_id=u.id and u.role_id='".$_POST['designation_id']."' and p.company_id=".$intCompanyId." and p.user_id='".$_POST['userid']."' and p.time between '".$dat1."' and '".$dat2."'";
			 $selectedUsers=$this->User->query($sql2);
			 
			  while (list($key,$val)=each($selectedUsers))
			 {
			 $tim= date("H:i:s", strtotime($val['p']['time']));
				 
				$finalarrcheckin[$dat1][$val['p']['user_id']][$val['p']['status']]=array("name"=> $val['u']['user_name'],"img"=> $val['p']['user_image'],"tim"=>$tim,"latitude"=> $val['p']['latitude'],"longitude"=> $val['p']['longitude']);
				
				
			 }
                 
			/*	 print_r($finalarrcheckin);
			exit;
			while (list($key1,$val1)=each($finalarrcheckin))
			 {
				 echo $key1;
				 
				 
				  foreach($val1 as $stime1)
				  {
					foreach($stime1 as $stime2)
				  {
					  
			//echo $stime2[tim];
			exit;
				  }
				  }
			 }
				 */
				 
             $this->set('selectedUsers', $selectedUsers);
			$this->set('finalarrcheckin', $finalarrcheckin);
            

		  //exit;	
		  
			
			
			
	}


//------------------------------------------------User Attendence End---------------------------------------------------------------------------------------------------------
	
	
	    public function newTrack($id='')
		{

			$userdata=$this->Session->read('user');	
			$intCompanyId=$userdata['User']['company_id'];
			$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
			$this->set('arrData', $designationResult);

			$start=date("Y-m-d 00:00:00");
			$end=date("Y-m-d 23:59:59");
			
			 $ssql = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$id."' order by b.created_at DESC Limit 0,10";
			 //$arrRetailer=$this->User->query($query);
			 $arrUsers=$this->User->query($ssql,false);

			 
			 $arrUsersExist=array();$finaldata=array();
			// Iterate through the rows, printing XML nodes for each
			reset($arrUsers);
			while (list($key,$val)=each($arrUsers)){
			
 				  $data=array("source"=> $val['up']['first_name'].' '.$val['up']['last_name'], "source_type"=> "entry_created","latitude"=> $val['b']['latitude'],"longitude"=> $val['b']['longitude'],"location"=> "Unknown","title"=> $val['b']['id'].") Time: ".date("F j, Y, g:i a",strtotime($val['b']['created_at'])));
				  $data["createdAt"]=array("date"=>date("F j, Y, g:i a",strtotime($val['b']['created_at'])),"timezone_type"=> 3,"timezone"=>"AsiaKolkata");
				  $finaldata[]=$data;
				  $arrUsersExist[]=$val['b']['user_id'];

			}

		 $arrLocations=json_encode($finaldata);
		
		$this->set("arrLocations",$arrLocations);
	
		}
	  function getCenterByRoleId($roleid='')
	  {

		$companyid=$this->Session->read('user.User.company_id');
		$Currentuserid=$this->Session->read('user.User.id');
		$query = "select * from users as a join user_current_locations as b on a.id=b.user_id  where a.company_id='".$companyid."' && role_id='".$roleid."' order by created_at DESC";
		$arrRetailer=$this->User->query($query);
		$arrUsersExist=array();
		while (list($key,$val)=each($arrRetailer)){
			
			if(!in_array($val['b']['user_id'],$arrUsersExist))	
			{
				if($val['b']['latitude'])
				{
					$data[] = array($val['b']['latitude'], $val['b']['longitude']);
					$arrUsersExist[]=$val['b']['user_id'];
				}
					
			}
		}
	
		$center=$this->CenterFromDegrees($data);
		$arresults=array("lat"=>$center[0],"long"=>$center[1]);
		echo json_encode($arresults); exit;
	}
	
	public function getuserbyroleid($roleid='')
	{
		$this->layout = '';
		header("Content-type: text/xml");
		$companyid=$this->Session->read('user.User.company_id');
		$userRole=$this->Session->read('user.User.role');
		$Currentuserid=$this->Session->read('user.User.id');
		
		

		if($userRole=='COMPANY')
		{
			$query = "select * from users as a,user_profiles as up  where  a.id=up.user_id and a.role_id='".$roleid."' ";
		}
		else
		{
			$query = "select * from users as a join user_profiles as b on a.id=b.user_id join users_parent as d on a.id=d.user_id where  a.id != $Currentuserid and d.parent_id=$Currentuserid and d.company_id=".$companyid." and a.role_id='".$roleid."' ";
		}
		$arrUsers=$this->User->query($query);
	
		// Start XML file, echo parent node
		echo '<markers>';
		
		$arrUsersExist=array();
		// Iterate through the rows, printing XML nodes for each
		while (list($key,$val)=each($arrUsers)){
			
			$query="select latitude,longitude,created_at from user_current_locations where user_id=".$val['a']['id']." order by id desc";
			$arrUserLastLocation=$this->User->query($query);	
			
		  // ADD TO XML DOCUMENT NODE
		  echo '<marker ';
		  echo 'name="' . $this->parseToXML($val['up']['first_name']." ".$val['up']['last_name']) . '" ';
		  echo 'address="' .  $this->parseToXML($val['up']['phone']) . '" ';
		  echo 'lat="' . $arrUserLastLocation[0]['user_current_locations']['latitude'] . '" ';
		  echo 'lng="' . $arrUserLastLocation[0]['user_current_locations']['longitude'] . '" ';
		  //echo 'type="' . $val['b']['phone'] . '" ';
		  echo '/>';
		  $arrUsersExist[]=$val['b']['user_id'];
			
		}
		echo '</markers>';
		
		exit;
	}

	function getUserCurrentLocations($intUserId,$date,$flagreturn=0)
	{
		if($flagreturn!=1)
		{
		header("Content-type: text/xml");
		echo '<markers>';
		}
		
		if(!$date)
			$date=date("Y-m-d");

		$startdate=date("Y-m-d 00:00:00",strtotime($date));
		$enddate=date("Y-m-d 23:59:59",strtotime($date));
		
		$query = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$intUserId."' and b.created_at>='$startdate' and b.created_at<='$enddate' order by b.created_at DESC ";
		$arrUsers=$this->User->query($query);
		
		$arrPrevousLoation=array();
		// Start XML file, echo parent node
		
		$Miles= 0.05;
		$arrReturnData=array();
		// Iterate through the rows, printing XML nodes for each
		while (list($key,$val)=each($arrUsers))
		{
				$flagSame="NO";
		
				if($arrPrevousLoation['lat'])
				{
					$Latitude=$arrPrevousLoation['lat'];
					$Longitude=$arrPrevousLoation['long'];
					$arrLocation=$this->RadiusCheck($Latitude, $Longitude, $Miles);

					if(($val['b']['latitude'] >= $arrLocation['minLat'] && $val['b']['latitude']<= $arrLocation['maxLat']) && ($val['b']['longitude'] >= $arrLocation['minLong'] && $val['b']['longitude']<= $arrLocation['maxLong']))
					{

							$flagSame="YES";
					}
					else
					{
							$flagSame="NO";
						  $arrPrevousLoation['lat']=$val['b']['latitude'];
						  $arrPrevousLoation['long']=$val['b']['longitude'];

					}
			
				}
				else
				{
					  $arrPrevousLoation['lat']=$val['b']['latitude'];
					  $arrPrevousLoation['long']=$val['b']['longitude'];
	  			}

				if($flagSame=='NO')
				{
				
				  if($flagreturn)
				  {
					$arrReturnData[]=$val;
				  }
				  else
				  {
					  // ADD TO XML DOCUMENT NODE
					  echo '<marker ';
					  echo 'name="' . $this->parseToXML($val['up']['first_name']." ".$val['up']['last_name']) . '" ';
					  echo 'time="' . $this->parseToXML(date("F j, Y, g:i a",strtotime($val['b']['created_at']))) . '" ';
					  echo 'address="' .  $this->parseToXML($val['up']['phone']) . '" ';
					  echo 'lat="' . $val['b']['latitude'] . '" ';
					  echo 'lng="' . $val['b']['longitude'] . '" ';
					  echo 'provider="' . $val['b']['provider'] . '" ';
					  //echo 'type="' . $val['b']['phone'] . '" ';
					  echo '/>';
				  }
				}
		
		}
	   if($flagreturn)
	   {
			return $arrReturnData;
		}
		echo '</markers>';
		exit;
	}
public	function exportUserCurrentLocations($intUserId,$date)
	{
			if(!$date)
			$date=date("Y-m-d");
			$arrLocationsData=$this->getUserCurrentLocations($intUserId,$date,1);
			 echo   $header_row="ID\tCompany ID \tUser ID\t First Name\tLast Name\t Latitude\tLongitude\tDate Time\n";
		   foreach($arrLocationsData as $val){
		 $header_row_data.= $val['a']['id']."\t". $val['a']['company_id'] ."\t".$val['up']['user_id']."\t".$val['up']['first_name']."\t".$val['up']['last_name']."\t".$val['b']['latitude']."\t".$val['b']['longitude']."\t".$val['b']['created_at']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
			
			
			
	}
	function getUserRetailers($intUserId)
	{

		$this->layout = '';
		header("Content-type: text/xml");
		$companyid=$this->Session->read('user.User.company_id');
		$Currentuserid=$this->Session->read('user.User.id');
		
		$query = "select * from retailers,user_retailers where user_retailers.retailer_id=retailers.id  AND  user_retailers.user_id='".$intUserId."'";
		$arrUsers=$this->User->query($query);
	
		// Start XML file, echo parent node
		echo '<markers>';

		// Iterate through the rows, printing XML nodes for each
		while (list($key,$val)=each($arrUsers)){
			
		  // ADD TO XML DOCUMENT NODE
		  echo '<marker ';
		  echo 'name="' . $this->parseToXML($val['retailers']['shop_name']).'" ';
		  echo 'address="' .  $this->parseToXML($val['retailers']['phone']) . '" ';
		  echo 'lat="' . $val['retailers']['latitude'] . '" ';
		  echo 'lng="' . $val['retailers']['longitude'] . '" ';
		  //echo 'type="' . $val['b']['phone'] . '" ';
		  echo '/>';
			
		}
		echo '</markers>';
		
		exit;
	}
	function RadiusCheck($Latitude, $Longitude, $Miles) 
	{
		$EQUATOR_LAT_MILE = 69.172;
		$maxLat = $Latitude + $Miles / $EQUATOR_LAT_MILE;
		$minLat = $Latitude - ($maxLat - $Latitude);
		$maxLong = $Longitude + $Miles / (cos($minLat * M_PI / 180) * $EQUATOR_LAT_MILE);
		$minLong = $Longitude - ($maxLong - $Longitude);
		return(array("minLat"=>$minLat,"maxLat"=>$maxLat,"minLong"=>$minLong,"maxLong"=>$maxLong));
	}
	function getUserCurrentLocationsCenter($intUserId)
	{
		
		$query = "select * from users as a, user_current_locations as b where  a.id=b.user_id and a.id='".$intUserId."' order by b.created_at DESC";
		$arrUsers=$this->User->query($query);
	
		while (list($key,$val)=each($arrUsers)){
			if($val['b']['latitude'])
				$data[] = array($val['b']['latitude'], $val['b']['longitude']);
		}
		
		$center=$this->CenterFromDegrees($data);
		$arresults=array("lat"=>$center[0],"long"=>$center[1]);
		echo json_encode($arresults);exit;
		
	}
	
	public function loadUserByroleid()
	{
		$this->layout = '';
		$userRole=$this->Session->read('user.User.role');
		$Currentuserid=$this->Session->read('user.User.id');
	    $companyid=$this->Session->read('user.User.company_id');

		if($userRole=='COMPANY')
		{
			$resultFinal = $this->User->findAllByRoleId($_POST['designation_id']);
		}
		else
		{
			$query = "select * from users as User join user_profiles as UserProfile on User.id=UserProfile.user_id join users_parent as d on User.id=d.user_id where  d.parent_id=$Currentuserid and d.company_id=".$companyid." and User.role_id='".$_POST['designation_id']."' ";
			
			$resultFinal = $this->User->query($query);
		}

	
		$str = '<select id="userslist" name="data[User][parent_id]" class="form-control" required onchange = "loadUserMap(this.value);">';		
		$str .= "<option value='0'>---Select User---</option>";
		while(list($key,$val)=each($resultFinal))
		{
			/*if($resultData==$val['User']['id'])
			{
				$str .= "<option selected value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
			}
			else*/
			//{
			$str .= "<option value='".$val['User']['id']."'>".$val['UserProfile'][
				'first_name']." ".$val['UserProfile']['last_name']."</option>";	
		//	}
		}
		$str .= "</select>";
		echo $str;
		exit;
		
	}
	
	function CenterFromDegrees($data)
	{
			if (!is_array($data)) return FALSE;
		
			$num_coords = count($data);
		
			$X = 0.0;
			$Y = 0.0;
			$Z = 0.0;
		
			foreach ($data as $coord)
			{
				$lat = $coord[0] * pi() / 180;
				$lon = $coord[1] * pi() / 180;
		
				$a = cos($lat) * cos($lon);
				$b = cos($lat) * sin($lon);
				$c = sin($lat);
		
				$X += $a;
				$Y += $b;
				$Z += $c;
			}
		
			$X /= $num_coords;
			$Y /= $num_coords;
			$Z /= $num_coords;
		
			$lon = atan2($Y, $X);
			$hyp = sqrt($X * $X + $Y * $Y);
			$lat = atan2($Z, $hyp);
		
			return array($lat * 180 / pi(), $lon * 180 / pi());
	}

	
	function parsToXML($htmlStr)
	{
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
	}
	

  function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);


  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }

  }
  
public function edit_profile(){
	
		$arrBreadcrumbs[]=array("label"=>"User Edit Profile" ,"link" => "");
		$this->set('arrBreadcrumbs', $arrBreadcrumbs);
		$userDetail = $this->Session->read('user');
		$companyid=$this->Session->read('user.User.company_id');
		$title=$userDetail['UserProfile']['first_name']." Profile";
		$this->set('title_for_layout', $title);
		if($this->request->data){
			if($this->request->data['User']['profVal']){
				
				if($this->request->data['User']['user_password']==$this->request->data['User']['cnpassword']){
					$this->User->id=$userDetail['User']['id'];
					//print_r($this->request->data);
					if($this->User->save($this->request->data['User'])){
						$this->Session->setFlash(__('Your password is changed'),'default',array('class'=>'alert alert-success'));
						$this->redirect(array('action' => 'userProfile'));
					}else{
						$this->Session->setFlash(__('Your password does not match, please try again '),'default',array('class'=>'alert alert-danger'));
					}
				}else{
					$this->Session->setFlash(__('Your password dose not match.'),'default',array('class'=>'alert alert-danger'));
					
				}
				
			}else{
			$this->UserProfile->id=$userDetail['UserProfile']['id'];
			$this->request->data['UserProfile']['user_id']=$userDetail['User']['id'];
			//print_r($this->request->data);
			if($this->UserProfile->save($this->request->data)){
				$this->User->id=$userDetail['User']['id'];
				$this->User->save($this->request->data);
				$userNewData=$this->User->findById($userDetail['User']['id']);
				$this->Session->write('user.User',$userNewData['User']);
				$this->Session->write('user.UserProfile',$userNewData['UserProfile']);
				$this->Session->setFlash(__('Your Deatils is updated '),'default',array('class'=>'alert alert-success'));
				$this->redirect(array('action' => 'userProfile'));
			}else{
				$this->Session->setFlash(__('Your Deatils is not updated '),'default',array('class'=>'alert alert-danger'));
			}
			}
		}else{
			$this->request->data=$userDetail;
		}
}

public function fileUpload(){
	if($this->request->form){
		$fname=$this->ImageUpload->upload_image_and_thumbnail($this->request->form['avatar'],195,124,180,200, "ProfileImages");
		if($fname){
			$oldImg=$this->Session->read('user.UserProfile.profile_image');
			$userPId=$this->Session->read('user.UserProfile.id');
			$userImg=array('UserProfile'=>array('id'=>$userPId,'profile_image'=>$fname));
			if($this->UserProfile->save($userImg)){
				$this->ImageUpload->delete_image($oldImg,'ProfileImages');
				$this->Session->write('user.UserProfile.profile_image',$fname);
				echo 'Image Uploaded.';
			}else{
				echo 'Image Not Uploaded.';
			}
			
		}
	}
		
	die;
}

public function loadAllParent(){
	 $userDetail = $this->Session->read('user');
	 $intCompanyId=$userDetail['User']['company_id'];
     $dId=$this->request->data['designation_id'];
     $selecteduser=$this->request->data['selectedUser'];
	

	 $allPars=$this->DesignationsParent->find("all",array('conditions'=>array("designation_id"=>$dId,"company_id"=>$intCompanyId)));

	if($allPars){
		foreach($allPars as $pr){
			$allParIds[]=$pr['DesignationsParent']['parent_id'];
		}
	}
if(count($allParIds)==0)
	$allParUsers=array();
else
		$allParUsers=$this->User->find('all',array('conditions'=>array('User.role_id'=>$allParIds,'User.company_id'=>$intCompanyId)));
	if($allParUsers){
		$opt.='<option value="">Select A User</option>';
		foreach($allParUsers as $par){
			if($selecteduser==$par['User']['id'])
				$selected="selected";
			else
				$selected="";

			$opt.='<option '.$selected.' value="'.$par['User']['id'].'">'.$par['UserProfile']['first_name'].'</option>';
		}
	}
	else
		$opt.='<option value="">No Parent found</option>';
	echo $opt;
	exit;
}


}


?>
