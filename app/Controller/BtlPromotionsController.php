<?php



class BtlPromotionsController extends AppController {

	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','BtlPromotion');

	
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

	$sql="select * from btl_promotions as p join user_profiles as u on u.user_id=p.user_id  where p.company_id='".$intCompanyId."' order by p.id DESC limit 0,20";

//	$sql="select * from users as a join user_profiles as b on a.id=b.user_id join designations as d on a.role_id=d.id join btl_promotions as p  on a.id=p.user_id  where a.company_id='".$intCompanyId."' order by p.id DESC limit 0,20";
	$arrBtlPromotionDetail=$this->User->query($sql);

	$this->set('arrBtlPromotionDetail', $arrBtlPromotionDetail);
	}
	
	
	 public	 function  export()
	 
       {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From  btl_promotions WHERE company_id='$intCompanyId'"; 
		  $BtlResult=$this->BtlPromotion->query($sql);
		  
		  echo   $header_row="ID\tCompany ID \tUser ID \t Address \tEmail From \tLatitude\tLongitude \t Device ID\tCreated Date\n";
		  
		  foreach($BtlResult as $val){
			 
	
		   $header_row_data.= $val['btl_promotions']['id']."\t". $val['btl_promotions']['user_id'] ."\t".$val['btl_promotions']['company_id']."\t".$val['btl_promotions']['address']."\t".$val['btl_promotions']['from_email']."\t".$val['btl_promotions']['latitude']."\t".$val['btl_promotions']['longitude']."\t".$val['btl_promotions']['devid']."\t".$val['btl_promotions']['created_at']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }

        
	

	public function cronGetBtlPromotionAddress()

	{

		$sql="SELECT  * From btl_promotions where address IS NULL or address='' and user_id=337 order by id DESC";

		$arrBtlPromotion=$this->BtlPromotion->query($sql);

		while(list($key,$val)=each($arrBtlPromotion))

		{
			   if($val['btl_promotions']['latitude']!=0 )
			   {

					$url="https://maps.googleapis.com/maps/api/geocode/json?latlng=".$val['btl_promotions']['latitude'].",".$val['btl_promotions']['longitude']."&key=AIzaSyCPQAacV_4exfdD9qyLxxK0Ssypo0_odxs";
					
			
					$jsonData   = file_get_contents($url);

					$data = json_decode($jsonData);

				$address=$data->results[0]->formatted_address;


					$query="update btl_promotions set address='".mysql_escape_string($address)."' where id=".$val['btl_promotions']['id'];

					$this->BtlPromotion->query($query);

					
				}
		}

		echo "Suucessfull";exit;

	}



	public function delete($id = NULL) 

	{

		  $this->BtlPromotion->delete($id);

		  $this->Session->setFlash('The Designation has been deleted');

		  $this->redirect(array('action'=>'index'));

	} 

    function mapView($intBtlId)
	{

	$this->layout="blank";

	$sql="SELECT  * From btl_promotions WHERE id=$intBtlId ";

	$arrRetailer=$this->BtlPromotion->query($sql);

	
    $this->set("latcenter",$arrRetailer[0]['btl_promotions']['latitude']);
	$this->set("longcenter",$arrRetailer[0]['btl_promotions']['longitude']);

	}

	
	







}