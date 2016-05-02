<?php
Class BroadcastsController extends AppController 
{ 
	public $name = 'Broadcasts';
	public $uses = array('UserProfile','User','UserToken', 'Broadcast', 'Module','Designations', 'Authentication');

	 public function beforeFilter()
    {	
	
		$this->layout='default';
		$action = $this->params->params['action'];

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
	public function add($designationid='')
	{
		//get user details everywhere like this.. 
		$userDetail = $this->Session->read('user');
		$intCompanyId=$userDetail['User']['company_id'];
		$this->set('userDetail', $userDetail);
		$sql="SELECT * From designations where company_id='".$intCompanyId."'";
		$desingnation=$this->Designations->query($sql);
		
		$this->set('designation',$desingnation);
		

		if($designationid)	
		{
			$sql="SELECT * FROM users as  u join user_profiles as up on u.id=up.user_id join designations as d on u.role_id=d.id where u.company_id='".$intCompanyId."' and u.role_id=".$designationid." and u.role NOT IN ('COMPANY') and u.gcmid IS NOT NULL";
		}
		else
		{
			$sql="SELECT * FROM users as  u join user_profiles as up on u.id=up.user_id join designations as d on u.role_id=d.id where u.company_id='".$intCompanyId."' and u.role NOT IN ('COMPANY') and u.gcmid IS NOT NULL";
		}

		$userlist=$this->User->query($sql);
		$this->set('userlist', $userlist);
	$this->set('designationid',$designationid);
	    
		
		$this->set('title_for_layout', 'Add Broadcast');
		if($this->request->is('post'))
				{
					
				$this->request->data['Broadcast']['company_id'] = $intCompanyId;
				$this->request->data['Broadcast']['date_time']=date("Y-m-d H:i:s");
				$this->Broadcast->save($this->request->data['Broadcast']);
				$this->set('message', 'Broadcast Added Succsesfuly!');
			
				$gcmRegIds = $this->request->data['Broadcast']['gcmids'];
				$pushMessage = $this->request->data['Broadcast']['message']; 
				if ( isset($pushMessage)) {    
				  
				  $message = array("m" => $pushMessage); 
				  $pushStatus = $this->sendPushNotificationToGCM($gcmRegIds, $message);
				}   
			
		}
		
		  /*if($id)
		  {	
			
			 $desdata = $this->Broadcast->findById($id);
			 $this->set('des', $desdata);
		   
		  }
		   
		    $BroadcastAll = $this->Broadcast->findAllByCompanyId($intCompanyId);
	        $this->set('Broadcast', $BroadcastAll);		
      */
	   
	}
	public function index()
	{
	   $this->set('smallinfo', 'you can manage your all Broadcasts here');
	   $this->set('title_for_layout', 'Broadcasts');
	   $userDetail = $this->Session->read('user');
	   $intCompnayId=$userDetail['User']['company_id'];		
	   $BroadcastResult = $this->Broadcast->findAllBycompany_id($intCompnayId);
	   $this->set('BroadcastResult', $BroadcastResult);
	  
	}
	
	   public	 function  export()
       {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From  broadcasts WHERE company_id='$intCompanyId'"; 
		  $BrodcastResult=$this->Broadcast->query($sql);
		  echo   $header_row="ID\tCompany ID \t Message\tdate Time\n";
		  
		  foreach($BrodcastResult as $val){
			 
	
		   $header_row_data.= $val['broadcasts']['id']."\t". $val['broadcasts']['company_id'] ."\t".$val['broadcasts']['message']."\t".$val['broadcasts']['date_time']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }
	
	
	
	
	public function delete($id = NULL) 
	{
		  $this->Broadcast->delete($id);
		  $this->Session->setFlash('The Broadcast has been deleted', 'default', array(), 'delete');		   
		  $this->redirect(array('action'=>'index'));
	} 

	   function sendPushNotificationToGCM($registatoin_ids, $message) {
    //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
    // Google Cloud Messaging GCM API Key
    define("GOOGLE_API_KEY", "AIzaSyBxrDQouVdWPwqhppa7EdCQsyXBEiZdaiA");    
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

}
?>