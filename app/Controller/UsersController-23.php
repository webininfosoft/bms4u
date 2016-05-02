<?php
Class UsersController extends AppController 
{ 
    var $components = array('Email','Core');
    var $name='Users';  
	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation','BtlPromotion', 'CompanyModule','Module','Retailer','Order');
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
	}
	public function index()
	{
	}
	public function home()
	{
				$this->layout='blank';
	}

	
	public function login()
	{		
		$this->layout='login_layout';
		if($this->Session->check('user'))
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
				}
				else		// Super Admin case
				{
					$modules = $this->CompanyModule->find('all',array("conditions"=>array('company_id'=>$user['User']['company_id'])));
					while(list($key,$val)=each($modules))
					{

						$permissions[$val['CompanyModule']['module_id']]['perm_view'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_add'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_update'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_delete'] = 1;
					}

				}

			 $user['permissions'] = $permissions;  		// Final Array
		 
	     $this->Session->write('user',$user);
		 $this->redirect('/Users/userProfile');
			}
			else
			{		   
			//$this->Session->setFlash('invalid Username password');
		   $this->set('flagExist', '1'); 
	
			
			}
		}	
		
		
	}
	
	public function userProfile()
	{	
		$arrBreadcrumbs[]=array("label"=>"User Profile" ,"link" => "");
		$this->set('arrBreadcrumbs', $arrBreadcrumbs);
		$this->set('smallinfo', 'Info');
		$userDetail = $this->Session->read('user');		
		$companyid=$this->Session->read('user.User.company_id');	

		$title=$userDetail['UserProfile']['first_name']." Profile";
		$this->set('title_for_layout', $title);
		
		$countRetailers= $this->Retailer->find('count', array('conditions' => array('Retailer.company_id =' => $companyid)));
	
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
		if($this->request->data['User']['id'])
			{				
				$existUser = $this->User->findByUserName($this->request->data['User']['user_name']);
				
			}
			else
				$existUser = false;
							
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
				
                $this->request->data['User']['user_name']=$this->request->data['UserProfile']['phone'];
				$this->request->data['User']['user_password']=123456;
				$this->request->data['User']['company_id'] = $intCompanyId;
				$this->User->save($this->request->data['User']);
				$this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'] ? $this->request->data['User']['id'] : $this->User->getLastInsertId();
				$this->UserProfile->save($this->request->data['UserProfile']);
				//$this->set('message','Employee Added Succssfuly');
				
			}
			else
			{
				$this->set('message2','Please Try Another User name');
			}
			
			  if($this->request->data['User']['id'] && $this->request->data['UserProfile']['id'])
        
	{ 
	          
              $this->User->save($this->request->data['User']);
			  $this->UserProfile->save($this->request->data['UserProfile']);
			  $this->set('message', 'Employee update Succsesfuly!');
			  
	}
	else {
		$this->set('message1','Employee Added Succssfuly');
	}
			
		}
		else
		{
			if($id)
			{	
				// Find Employee Details
				$employeeDetails = $this->User->findById($id);
			    $this->set('employeeDetail',$employeeDetails);
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
		}
		
		$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
		$this->set('arrData', $designationResult);
		
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
		$userId = $this->User->findAllByCompanyId($this->Session->read('user.User.company_id'));
		$Currentuserid=$this->Session->read('user.User.id');
		
		if($userId)
		{			if(!$page)
				$page=1;	
	$query = "select count(*) as total from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."' ".$str;
			$totalEmp = $this->User->query($query);
			$offset = ($page-1)*20;	
			$totalPages = ceil($totalEmp[0][0]['total']/20);
			$query = "select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id where a.company_id='".$companyid."'  AND user_id NOT IN ('$Currentuserid')  limit ".$offset.", 20";
		}
		else
		{
			
			$userId = $this->User->findByCompanyId($this->Session->read('user.User.company_id'));
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
		}
			$this->set('totalPages',$totalPages);						
			$this->set('page',$page);	
			$this->set('first_name',$first_name);
			$this->set('last_name',$last_name);
			
			$this->set('email',$email);
			$this->set('city',$city);
			$this->set('phone',$phone);
			$employeeResult = $this->User->query($query);
			$this->set('employeeResults', $employeeResult);
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
	   $this->User->delete($id);
	   $this->Session->setFlash('The Employee has been deleted', 'default', array(), 'delete');
       $this->redirect(array('action'=>'usersList'));  
		 
	} 		
	public function logOut()
	{
		$this->Session->delete('user');
		$this->redirect('/login');	
	}
	
	public function loadDesignation()
	{
		$this->layout = '';
		$selected = $_POST['selected'];
		$result = $this->Designation->findById($_POST['designation_id']);
		$resultData = $result['Designation']['parent_designation_id'];
		$resultFinal = $this->User->findAllByRoleId($resultData);
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
					$msg='Dear '.$name.'<br/>'; 
					$msg.="<p>Your New Password is:".$newPass.'</p><br/>';
		
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
			$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
			$this->set('arrData', $designationResult);
			
			//$companyid=$this->Session->read('user.User.company_id');
			//$Currentuserid=$this->Session->read('user.User.id');
			//$result = $this->User->findByRoleId($_POST['designation_id']);
			//$resultData = $result['User']['role_id'];
	
		}
	
	    public function newTrack($id='')
		{

			$userdata=$this->Session->read('user');	
			$intCompanyId=$userdata['User']['company_id'];
			$designationResult = $this->Designation->find('all', array('conditions' => array('company_id' => $intCompanyId)));
			$this->set('arrData', $designationResult);

			$start=date("Y-m-d 00:00:00");
			$end=date("Y-m-d 23:59:59");
			
			 $ssql = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$id."' order by b.date_time DESC Limit 0,10";
			 //$arrRetailer=$this->User->query($query);
			 $arrUsers=$this->User->query($ssql,false);

			 
			 $arrUsersExist=array();$finaldata=array();
			// Iterate through the rows, printing XML nodes for each
			reset($arrUsers);
			while (list($key,$val)=each($arrUsers)){
			
 				  $data=array("source"=> $val['up']['first_name'].' '.$val['up']['last_name'], "source_type"=> "entry_created","latitude"=> $val['b']['latitude'],"longitude"=> $val['b']['longitude'],"location"=> "Unknown","title"=> $val['b']['id'].") Time: ".date("F j, Y, g:i a",strtotime($val['b']['date_time'])));
				  $data["createdAt"]=array("date"=>date("F j, Y, g:i a",strtotime($val['b']['date_time'])),"timezone_type"=> 3,"timezone"=>"AsiaKolkata");
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
		$query = "select * from users as a join user_current_locations as b on a.id=b.user_id  where a.company_id='".$companyid."' && role_id='".$roleid."' order by date_time DESC";
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
		$Currentuserid=$this->Session->read('user.User.id');
		
		$query = "select * from users as a,user_profiles as up  where  a.id=up.user_id and a.role_id='".$roleid."' ";
		$arrUsers=$this->User->query($query);
	
		// Start XML file, echo parent node
		echo '<markers>';
		
		$arrUsersExist=array();
		// Iterate through the rows, printing XML nodes for each
		while (list($key,$val)=each($arrUsers)){
			
			$query="select latitude,longitude,date_time from user_current_locations where user_id=".$val['a']['id']." order by id desc";
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
		
		$query = "select * from users as a,user_profiles as up, user_current_locations as b where  a.id=up.user_id and a.id=b.user_id and a.id='".$intUserId."' and b.date_time>='$startdate' and b.date_time<='$enddate' order by b.date_time DESC ";
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
					  echo 'time="' . $this->parseToXML(date("F j, Y, g:i a",strtotime($val['b']['date_time']))) . '" ';
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
		 $header_row_data.= $val['a']['id']."\t". $val['a']['company_id'] ."\t".$val['up']['user_id']."\t".$val['up']['first_name']."\t".$val['up']['last_name']."\t".$val['b']['latitude']."\t".$val['b']['longitude']."\t".$val['b']['date_time']."\t \n"; 
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
		
		$query = "select * from users as a, user_current_locations as b where  a.id=b.user_id and a.id='".$intUserId."' order by b.date_time DESC";
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
		$result = $this->User->findByRoleId($_POST['designation_id']);
		$resultData = $result['User']['role_id'];
		$resultFinal = $this->User->findAllByRoleId($resultData);
		
		$str = '<select id="userslist" name="data[User][parent_id]" class="form-control" required onchange = "loadUserMap(this.value);">';		
		$str .= "<option value='0'>---Select User---</option>";
		while(list($key,$val)=each($resultFinal))
		{
			if($resultData==$val['User']['id'])
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

public function forgot_pass(){
	
	
	die;
	}

}
?>
