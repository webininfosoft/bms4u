<?php

class UserTokensController extends AppController 

{ 

	var $name='UserTokens';

	var $components = array('Email','Core','ImageUpload');

	public $access = array('index', 'success','registration','companymodule');

	public $uses = array('UserProfile','User','UserToken', 'Module','CompanyModule','Designation');
	public function beforeFilter()
	{		
	/*	$action = $this->params->params['action'];		
		if(!in_array($action,$this->access))
		{
			if(!$this->Session->read('userToken'))
			{
				$this->redirect('/');
 $this->Session->write('user',$user);
			}
		}
		*/
	}
	public function index()

	{

		$this->layout='login_layout';
		$arrModule = $this->Module->find('all',array('conditions'=>array('parent_id'=>0)));
		$this->set('arrModule', $arrModule);
	

		if($this->request->is('post'))
		{

				$userName = $this->request->data['user_name'];
				$userPass = $this->request->data['user_password'];
				$arrExist = $this->UserToken->find('first', array(
																'conditions' => array(	"user_name" =>$userName,
																						"password" =>$userPass
																					) 
															  )
												);
			    if(count($arrExist)==0)
				{
						$arrResults=array("response"=>'error',"message"=>"Invalid username or password.");

				}

			else

				{

					if($arrExist['UserToken']['status']==1)

						$arrResults=array("response"=>'error',"message"=>"Username already activated.");	

					else

						$arrResults=array("response"=>'success',"message"=>"Login Successfully","tokenid"=>$arrExist['UserToken']['id']);	

				
					$this->Session->write('userToken',$arrExist['UserToken']['id']) ;

	

				}

				echo json_encode($arrResults);

				exit;

		}	


	}



	public function insertRandomUsername()

	{

	

		for($i=0;$i<1000;$i++)

		{

			$userName = $this->randomNumber();

			$userPass = $this->randomNumber();

			$data['UserToken']['id']='';

			$data['UserToken']['user_name']=$userName;

			$data['UserToken']['password']=$userPass;

			$arrExist=$this->UserToken->find('all', array(

															'conditions' => array("user_name" =>$userName) 

														  )

											);

			if(count($arrExist)==0)

				$this->UserToken->save($data);

		}

		

	}

	

	function randomNumber() 

	{

		$username = "ABCDEFGHIJKLMNOPQRSTUWXYZ";

		$user = array();

		$alphaLengthUser = strlen($username) - 1;

		for ($i = 0; $i < 8; $i++) {

			$n = rand(0, $alphaLengthUser);

			$user[] = $username[$n];

		}

		return implode($user);

	}

	

	public function registration()

	{

			while(list($key,$val)=each($this->request->data))
			{
				$arData['UserProfile'][$key]=$val;
				$arData['User'][$key]=$val;
			}
			
			
			$userTokenID = $this->Session->read('userToken');

			$arData['User']['role']="COMPANY";

			$arData['User']['created_at']=date('Y-m-d H:i:s');

			$arData['User']['token_id']=$userTokenID;

			//$this->request->data['User']['username']=$this->request->data['username'];

	                $user=$arData['User']['user_name'];

			$sql="SELECT user_name FROM users WHERE user_name='$user'";	

			$existUser=$this->User->query($sql);




			if(count($existUser)>0)
			{		

					$arrResults=array("response"=>'error',"message"=>"Username already activated.");

					  echo json_encode($arrResults);
				      exit;

					//$this->set('message', '* Please try another Username');

				}
				else

				{

					$existUser = false;

				}

					

			if(!$existUser)

			{	

				$this->User->save($arData);
				$userid=$this->User->getLastInsertId();
				$this->Session->write('userid',$userid);
                $arData['UserProfile']['user_id']=$userid;
                $this->UserProfile->save($arData);
                $sql="update users set company_id=".$userid." where id=".$userid;
				$this->UserToken->query($sql);				
				
                $user = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));			
				if($user)
				{				    		

					$admin = false;					
					$this->Session->write('user',$user);
				
					$this->UserToken->query("UPDATE user_tokens SET status = 1 WHERE id =$userTokenID");
					$arrResults=array("response"=>'success',"message"=>"Save Successfully","company_id"=>$userid,"tokenid"=>$arrExist['UserToken']['id']);


				
						$strUserName=$user['User']['user_name'];
						$strPassword=$user['User']['user_password'];
						$strSubject='New Client Sign Up';
						$strMessage='<html> 
<head> 
<title>Your New Account</title> 
</head> 
<body> 
<p><font face="Arial" size="2">Congratulations on setting up your new account. <br> 
<br> 
<br> 
Please log into your account and set up you account profile.<br> 
<br> 
<b>Account Details:</b><br> 
Username: '. $strUserName.'<br> 
Password: '.$strPassword.'<br> 
<u><font color="#0000FF"></font></u></font></p> 
<p><font face="Arial" size="2">Thank you,<br> 
<a href="'. $_SERVER[ 'REQUEST_URI' ].'">'. $_SERVER[ 'REQUEST_URI' ].'</a>
</font></p><p><font face="Arial" size="2">';

						$strAdminMessage='<html> 
<head> 
<title>New Company Sign Up Notification</title> 
</head> 
<body> 
<b>Account Details:</b><br> 
Name:'.$user['UserProfile']['first_name'].'<br>
Username: '. $strUserName.'<br> 
Password: '.$strPassword.'<br> 
Email: '.$user['UserProfile']['email'].'<br>
Phone No: '.$user['UserProfile']['phone'].'
<u><font color="#0000FF"></font></u></font></p> 
<p><font face="Arial" size="2">Thank you,<br> 
</font></p><p><font face="Arial" size="2">';

					$from='info@bms4u.com';
				//	$this->sendMail($user['UserProfile']['email'],$strMessage,$strSubject,$from);
				//	$this->sendMail('sukhpal1988@gmail.com',$strAdminMessage,$strSubject,$from);

					echo json_encode($arrResults); exit;

			    }		

			

			}	
			else	
			{
				$this->set('message','* Please Try Another User name');			
			}	

	}

	



public function companymodule()
{
	if($this->request->is('post'))
	{
		
		  while(list($key,$val)=each($this->request->data['module_id']))
          {
			   $arData=array();
			   $arData['CompanyModule']['id']="";
			   $arData['CompanyModule']['company_id']=$this->request->data['company_id'];
			   $arData['CompanyModule']['module_id']=$val;
			   $arData['CompanyModule']['created_ts']=date('Y-m-d H:i:s');
			   $this->CompanyModule->save($arData,false);
			   if($val==6){
			   		$retail['Designation']['company_id']=$this->request->data['company_id'];
					$retail['Designation']['parent_designation_id']=0;
					$retail['Designation']['designation']='Retailer';
					$this->Designation->create();
					$this->Designation->save($retail,false);
			   }
			   
          }
		  $arrResults=array("response"=>'success',"message"=>"added_successfully");
		  
		  $modules = $this->CompanyModule->find('all',array("conditions"=>array('company_id'=>$this->request->data['company_id'])));
					while(list($key,$val)=each($modules))
					{

						$permissions[$val['CompanyModule']['module_id']]['perm_view'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_add'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_update'] = 1;
						$permissions[$val['CompanyModule']['module_id']]['perm_delete'] = 1;
					}
					
			 //$user['permissions'] = $permissions;		
		  $this->Session->write('user.permissions',$permissions);
          echo json_encode($arrResults);exit;
	}
	
}
	public function success()

	{		

		$this->Session->delete('userToken');

	}
	
	

}

?>