<?php
  Class CompanySettingsController extends AppController 
{ 
    public $name = 'CompanySettings';
    public $uses = array('UserProfile','User','UserToken', 'CompanySetting', 'Module', 'Authentication');
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

    public function add($id='')
	 {
	   $userDetail = $this->Session->read('user');
       $intCompanyId=$userDetail['User']['company_id'];
       $this->set('userDetail', $userDetail);
       $this->set('title_for_layout', 'General Settings');
       if($this->request->is('post'))
       {
           
			$this->request->data['CompanySetting']['company_id']= $intCompanyId;
            $arrDesign=$this->CompanySetting->findByCompanyId($intCompanyId);


			if($this->request->data['CompanySetting']['retailer_radius_enable']=='on')
				$this->request->data['CompanySetting']['retailer_radius_enable']=1;
			else
				$this->request->data['CompanySetting']['retailer_radius_enable']=0;

            if(count($arrDesign)==0)
			{
				$this->request->data['CompanySetting']['company_id']=$userDetail['User']['company_id'];
                $this->CompanySetting->save($this->request->data['CompanySetting']);
                $this->set('message', 'Company Setting Updated Successfuly!');

			}

			if($this->request->data['CompanySetting']['id'])
			{ 
				  $this->CompanySetting->save($this->request->data['CompanySetting']);
				  $this->set('message', 'CompanySetting update Succsesfuly!');
			}
				
        
		}


			$Details = $this->CompanySetting->findByCompanyId($intCompanyId);
				
            $this->set('Detail', $Details);	

	}



	public function index($id='')

   {

          $this->set("smallinfo","here you can see the office locations");
          $this->set('title_for_layout', 'CompanySettings');
          $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id'];
          $sql=" SELECT  * From CompanySettings WHERE company_id='$intCompanyId'";
          $CompanySettingResult=$this->CompanySetting->query($sql);
          $this->set('CompanySettingResults', $CompanySettingResult);
		  

     }
	 
public	 function  export()
   {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From CompanySettings WHERE company_id='$intCompanyId'"; 
		  $CompanySettingResult=$this->CompanySetting->query($sql);
		echo   $header_row="Id\t Company ID \t Comapny Nmae \t Company Email \t Company Phone Number\t Company City \t Company State\t Company Address\t Company Latitude\t Comany Longitude\n";
		  foreach($CompanySettingResult as $val){
		   $header_row_data.= $val['CompanySettings']['id']."\t". $val['CompanySettings']['company_id'] ."\t".$val['CompanySettings']['first_name']."\t".$val['CompanySettings']['email']."\t".$val['CompanySettings']['phone']."\t".$val['CompanySettings']['city']."\t".$val['CompanySettings']['state']."\t".$val['CompanySettings']['address']."\t".$val['CompanySettings']['latitude']."\t".$val['CompanySettings']['longitude']."\t\n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		
		 
   }
 


	public function delete($id = NULL) 

	{
       $this->CompanySetting->delete($id);
       $this->Session->setFlash('The CompanySetting has been deleted', 'default', array(), 'delete');
       $this->redirect(array('action'=>'index'));



	} 



}



?>