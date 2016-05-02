<?php



class UserAttendanceController extends AppController {

	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','UserAttendance');

	
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



   

	public function index($id='')
	{



	   $this->set('smallinfo', 'you can manage your all BTL Promotion Here');



	    $this->set('title_for_layout', 'BTL Promotions	');

	    $userDetail = $this->Session->read('user');

	$intCompanyId=$userDetail['User']['company_id'];

	$sql="select * from  user_attendance as p  where p.company_id='".$intCompanyId."' order by p.id DESC limit 0,20";

//	$sql="select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id join  user_attendance as p  on a.id=p.user_id  where a.company_id='".$intCompanyId."' order by p.id DESC limit 0,20";
	$arrUserAttendanceDetail=$this->User->query($sql);

	$this->set('arrUserAttendanceDetail', $arrUserAttendanceDetail);
	}
	
	
	 public	 function  export()
	 
       {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From   user_attendance WHERE company_id='$intCompanyId'"; 
		  $BtlResult=$this->UserAttendance->query($sql);
		  
		  echo   $header_row="ID\tCompany ID \tUser ID \t Address \tEmail From \tLatitude\tLongitude \t Device ID\tCreated Date\n";
		  
		  foreach($BtlResult as $val){
			 
	
		   $header_row_data.= $val[' user_attendance']['id']."\t". $val[' user_attendance']['user_id'] ."\t".$val[' user_attendance']['company_id']."\t".$val[' user_attendance']['address']."\t".$val[' user_attendance']['from_email']."\t".$val[' user_attendance']['latitude']."\t".$val[' user_attendance']['longitude']."\t".$val[' user_attendance']['devid']."\t".$val[' user_attendance']['created_at']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }

        
	

	public function cronGetUserAttendanceAddress()

	{

		$sql="SELECT  * From  user_attendance where address IS NULL or address='' and user_id=337 order by id DESC";

		$arrUserAttendance=$this->UserAttendance->query($sql);

		while(list($key,$val)=each($arrUserAttendance))

		{
			   if($val[' user_attendance']['latitude']!=0 )
			   {

					$url="https://maps.googleapis.com/maps/api/geocode/json?latlng=".$val[' user_attendance']['latitude'].",".$val[' user_attendance']['longitude']."&key=AIzaSyCPQAacV_4exfdD9qyLxxK0Ssypo0_odxs";
					
			
					$jsonData   = file_get_contents($url);

					$data = json_decode($jsonData);

				$address=$data->results[0]->formatted_address;


					$query="update  user_attendance set address='".mysql_escape_string($address)."' where id=".$val[' user_attendance']['id'];

					$this->UserAttendance->query($query);

					
				}
		}

		echo "Suucessfull";exit;

	}



	public function delete($id = NULL) 

	{

		  $this->UserAttendance->delete($id);

		  $this->Session->setFlash('The Designation has been deleted');

		  $this->redirect(array('action'=>'index'));

	} 

    function mapView($intBtlId)
	{

	$this->layout="blank";

	$sql="SELECT  * From  user_attendance WHERE id=$intBtlId ";

	$arrRetailer=$this->UserAttendance->query($sql);

	
    $this->set("latcenter",$arrRetailer[0][' user_attendance']['latitude']);
	$this->set("longcenter",$arrRetailer[0][' user_attendance']['longitude']);

	}

	
	







}