<?php

class RetailersController extends AppController {
            public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','Retailer','UserRetailer');
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

    public function add($id=''){
	     $this->set('smallinfo', 'you can manage your all site here');
		 $userDetail = $this->Session->read('user');
		 $intCompanyId=$userDetail['User']['company_id'];
         $userDetail['User']['token_id'];
	     $userDetail['User']['role']="Retailer";
	     $userDetail['User']['created_at']=date('Y-m-d H:i:s');
		 $userDetail['User']['company_id']=$intCompanyId;
		 $this->set('Detail',$userDetail);
		 $allFosId=$this->Designation->AllFOS($intCompanyId);
		 if(!empty($allFosId)){
		 	$allFosUser=$this->User->find('all',array('conditions'=>array('User.role_id'=>$allFosId,'User.company_id'=>$intCompanyId)));
			$this->set('AllFos',$allFosUser);
		 }
		 

		 $retailers = $this->Retailer->find('all', array('conditions' => array('id' => $id)));
		 
         $this->set('Details', $retailers[0]);
        if($this->request->is('post')){
	   if ($this->request->data['Retailer'] && $this->request->data['User']){

		   $existUser=$this->User->find('first',array('conditions'=>array('User.user_name'=>$this->request->data['User']['user_name'])));

		   	if(empty($existUser))
            {
				
				if(!$id){
						$this->User->save($this->request->data['User']);
						$retuserid=$this->User->id;
				}else
				{
					 $retuserid=$retailers[0]['Retailer']['user_id'];
				}
			   $image = $this->request->data['Retailer']['owner_image'];
			   $image1 = $this->request->data['Retailer']['shop_image'];
			   if($image['name'])
			   		$this->request->data['Retailer']['owner_image']= $this->imgupload($image);
			   else
			   		$this->request->data['Retailer']['owner_image']=$this->request->data['Retailer']['old_owner_image'];
			   
			   if($image1['name'])
			   		$this->request->data['Retailer']['shop_image']= $this->imgupload($image1);
			   else
			   		$this->request->data['Retailer']['shop_image']=$this->request->data['Retailer']['old_shop_image'];
			   
			   $this->request->data['Retailer']['user_id'] = $retuserid;
			   $this->request->data['Retailer']['company_id']=$this->request->data['User']['company_id'];
			   $this->request->data['Retailer']['created_at']=$this->request->data['User']['created_at'];
			   $this->request->data['Retailer']['latitude']=$this->request->data['Retailer']['web_latitude'];
			   $this->request->data['Retailer']['longitude']=$this->request->data['Retailer']['web_longitude'];
			   $this->Retailer->save($this->request->data['Retailer']);
               $retailerid=$this->Retailer->id;
			   $arrFOS=explode(",",substr($this->request->data['Retailer']['FOS'],0,-1));
			   
					while(list($key,$val)=each($arrFOS))
					{	
						if($val)
						{
						   $arruid=explode("-",$val);
						   $uid=$arruid[1];
						  
						  $this->User->query("insert into user_retailers(retailer_id,user_id) values('$retailerid','".$uid."')");
						  
						   $flagtrue=1;
						   while($flagtrue)	
						   {
								$sql="select parent_id from users where id=$uid";
								$arrParentData=$this->User->query($sql);

								if(count($arrParentData)>0)
								{
									if($arrParentData[0]['users']['parent_id'])
									{
										$sql="select * from user_retailers where retailer_id=$retailerid and user_id=".$arrParentData[0]['users']['parent_id'];
										$arrEsists=$this->User->query($sql);
										if(count($arrEsists)>0)
										{
											
										}
										else{
											$this->User->query("insert into user_retailers(retailer_id,user_id) values('$retailerid','".$arrParentData[0]['users']['parent_id']."')");
										}
										$uid=$arrParentData[0]['users']['parent_id']; 
										$flagtrue=1;	
									}
									else
										  $flagtrue=0;	
								}
								else
								 $flagtrue=0;
						   }
						}
					}
					if($this->request->data['Retailer']['id']){
						$this->set('message', 'Update Successfully!');
					}else{
				             $this->UserRetailer->save(array('UserRetailer'=>array('retailer_id'=>$retailerid,'user_id'=>$retuserid)));
						$this->set('message', 'Retailer Added Sucssessfuly!');
					}
				}else{
			 	$this->set('message', 'This user allready exist');
			 }
	  		 }
		}
		if($id){
	     $Details=$this->Retailer->findById($id);
		 $this->set('arrRetailer', $Details);
		}
	}



      public function imgupload($image)

	  {

		

		//allowed image types

                $imageTypes = array("image/gif", "image/jpeg", "image/png");

                //upload folder - make sure to create one in webroot

                $uploadFolder = "apis/uploads/retailers";
		
                //full path to upload folder

                 $uploadPath = WWW_ROOT . $uploadFolder;
	
		 //check if image type fits one of allowed types

                foreach ($imageTypes as $type) 

				{

                    if ($type == $image['type']) 

				     {

                      //check if there wasn't errors uploading file on serwer

                        if ($image['error'] == 0) 

						{

                             //image file name

                            $imageName = $image['name'];

                            //check if file exists in upload folder

                            if (file_exists($uploadPath . '/' . $imageName))

							 {

  							                //create full filename with timestamp

                                $imageName = date('His') . $imageName;

                            }

                            //create full path with image name

                           $full_image_path = $uploadPath . '/' . $imageName;
						  

							

							

                            //upload image to upload folder

                            if (move_uploaded_file($image['tmp_name'], $full_image_path)) {

                           

                                $this->set('imageName',$imageName);

                            } 

                        }

                        

                    } 

                }

				return $imageName;

            }



	public function index($id='')

	{

	    $this->set('smallinfo', 'you can manage your all sites here');
        $this->set('title_for_layout', 'Sites');
	    $userDetail = $this->Session->read('user');
		$intCompanyId=$userDetail['User']['company_id'];
		$intUserId=$userDetail['User']['id'];
		$role=$userDetail['User']['role'];
		if($role=='COMPANY')
			$sql=" SELECT  * From retailers,users WHERE users.id=retailers.user_id and retailers.company_id=$intCompanyId order by retailers.id DESC";
		else
		{
			$sql = "SELECT * from retailers,user_retailers,users where retailers.user_id=users.id and user_retailers.retailer_id=retailers.id and user_retailers.user_id=$intUserId order by retailers.id DESC";	
			
		}

		$arrRetailer=$this->Retailer->query($sql);
        $this->set('Retailer', $arrRetailer);
	}
	
	public function dailyVisits($retailerid='')
	{
	    $this->set('smallinfo', 'you can see retailer visits.');
        $this->set('title_for_layout', 'Retailer Visits');
	    $userDetail = $this->Session->read('user');
		$intCompanyId=$userDetail['User']['company_id'];
		$sql=" SELECT  * From retailer_daily_visits WHERE retailer_id='".$retailerid."' order by id DESC";
	  	$arrRetailerVisits=$this->Retailer->query($sql);
		
        $this->set('Retailer', $arrRetailerVisits);
	}
		
	public	 function  export()
   {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From  retailers inner join user_profiles on retailers.user_id=user_profiles.user_id WHERE company_id='$intCompanyId'"; 
		  $RetailerResult=$this->Retailer->query($sql);
	
		  echo   $header_row="ID\tCompany ID \tLatitude \tLongitude \tShop Name \tOwner Name\tEmail \tPhone\tAddress\tProfile Image\tShop Photo \tCreated Date \tDistributer \tFOS \tDeal in\tcategories\tTurn Over \tAlternamte Mobile \tCredit\n";
		  foreach($RetailerResult as $val){
			 
	
		   $header_row_data.= $val['retailers']['id']."\t". $val['retailers']['company_id'] ."\t".$val['retailers']['latitude']."\t".$val['retailers']['longitude']."\t".$val['retailers']['shop_name']."\t".$val['retailers']['owner_name']."\t".$val['retailers']['email']."\t".$val['retailers']['phone']."\t".$val['retailers']['address']."\t".$val['retailers']['owner_image']."\t".$val['retailers']['shop_image']."\t".$val['retailers']['created_at']."\t".$val['retailers']['distributer']."\t".$val['user_profiles']['first_name']."\t".$val['retailers']['deal_in']."\t".$val['retailers']['categories']."\t".$val['retailers']['turn_over']."\t".$val['retailers']['alt_mobile']."\t".$val['retailers']['credit']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }
	
	

public function getCountryCombo($cls='',$intCountryId='')

	{

		$country="SELECT * from country order by country";

		$arrcountry=$this->Retailer->query($country);
		echo "<select id='cmbCountry' class='$cls' name='data[Retailer][country]'><option value=''>--Select--</option>"	;

		

		while(list($key,$val)=each($arrcountry))

		{
			if($val['country']['id']==$val['country']['id'])

				$selected='Selected';

			else

				$selected='';

			

			echo "<option  $selected value='".$val['country']['id']."'>".$val['country']['country']."</option>";

		}		

		echo "</select>"	;

		

	}
	

	

	function getStateCombo($cls='',$intCountryId='',$intStateId='')

	{

		if($intCountryId)

			$where=" where country=$intCountryId";

			

		

		$sql="SELECT * from states $where order by state";

		$arrSates=$this->Retailer->query($sql);

		echo "<select id='cmbState' class='$cls' name='data[Retailer][state]'><option value=''>--Select--</option>"	;

		

		while(list($key,$val)=each($arrSates))

		{

			if($intStateId==$val['states']['id'])

				$selected='Selected';

			else

				$selected='';

			

			echo "<option  $selected value='".$val['states']['state']."'>".$val['states']['state']."</option>";

		}		

		echo "</select>";



	}

	

	function getCityCombo($cls='',$intStateId='',$intCityId)

	{

		if($intStateId)

			$where=" where stateid=$intStateId";

			

		

		$sql="SELECT * from city $where order by city";

		$arrSates=$this->Retailer->query($sql);

		echo "<select id='cmbState' class='$cls' name='data[Retailer][city]'><option value=''>--Select--</option>"	;

		

		while(list($key,$val)=each($arrSates))

		{

			if($intCityId==$val['city']['id'])

				$selected='Selected';

			else

				$selected='';

			

			echo "<option  $selected value='".$val['city']['city']."'>".$val['city']['city']."</option>";

		}	


		echo "</select>";

		

	}

public function delete($id = NULL) 
	{
		  $this->Retailer->delete($id);
		  $this->Session->setFlash('The Designation has been deleted.', 'default', array(), 'bad');
		  
		  //$this->set('message', 'The Retailer  has been deleted');
		  $this->redirect(array('action'=>'index'));
	} 
public function map_view($retailerid='')
{
	if($retailerid)
	$this->layout="blank";
	$userDetail = $this->Session->read('user');
	$intCompanyId=$userDetail['User']['company_id'];

	if($retailerid)
		$sql=" SELECT  * From retailers WHERE id=$retailerid ";
	else
		$sql=" SELECT  * From retailers WHERE company_id=$intCompanyId ";

	$arrRetailer=$this->Retailer->query($sql);

	
	// Iterate through the rows, printing XML nodes for each
	while (list($key,$val)=each($arrRetailer)){
		if($val['retailers']['latitude'])
		$data[] = array($val['retailers']['latitude'], $val['retailers']['longitude']);
		else if($val['retailers']['web_latitude'])
		$data[] = array($val['retailers']['web_latitude'],$val['retailers']['web_longitude']);
		
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

	$userDetail = $this->Session->read('user');
	$intCompanyId=$userDetail['User']['company_id'];
	$sql=" SELECT  * From retailers WHERE company_id=$intCompanyId ";
	$arrRetailer=$this->Retailer->query($sql);
	
	// Start XML file, echo parent node
	echo '<markers>';
	
	// Iterate through the rows, printing XML nodes for each
	while (list($key,$val)=each($arrRetailer)){
	  // ADD TO XML DOCUMENT NODE
	  if($val['retailers']['latitude']){
	  echo '<marker ';
	  echo 'name="' . $this->parseToXML($val['retailers']['shop_name']) . '" ';
	  echo 'address="' .  $this->parseToXML($val['retailers']['address']) . '" ';
	  echo 'lat="' . $val['retailers']['latitude'] . '" ';
	  echo 'lng="' . $val['retailers']['longitude'] . '" ';
	  echo 'type="' . $val['retailers']['Categories'] . '" ';
	  echo '/>';
	  }
	  else if($val['retailers']['web_latitude'])
	  echo '<marker ';
	  echo 'name="' . $this->parseToXML($val['retailers']['shop_name']) . '" ';
	  echo 'address="' .  $this->parseToXML($val['retailers']['address']) . '" ';
	  echo 'lat="' . $val['retailers']['web_latitude'] . '" ';
	  echo 'lng="' . $val['retailers']['web_longitude'] . '" ';
	  echo 'type="' . $val['retailers']['Categories'] . '" ';
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

}