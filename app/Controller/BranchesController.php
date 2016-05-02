<?php
  Class BranchesController extends AppController 
{ 
    public $name = 'Branches';
    public $uses = array('UserProfile','User','UserToken', 'Branch', 'Module', 'Authentication');
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
       $this->set('title_for_layout', 'Add Branch');
       if($this->request->is('post'))
       {


			$this->request->data['Branch']['company_id']= $intCompanyId;
            $arrDesign=$this->Branch->find("all",array("conditions"=>array("first_name"=>$this->request->data['Branch']['first_name'],"company_id"=>$intCompanyId
																		  )
				                                      )
				                            );

			if(count($arrDesign)==0)
     		{
			    $this->request->data['Branch']['company_id']=$userDetail['User']['company_id'];
                $this->Branch->save($this->request->data['Branch']);
                $this->set('message', 'Branch Added Successfuly!');
			}
			else 
			{
				  $this->set('message1', 'Duplicate Branch Try Diffrent Name');
			}
  
		  if($this->request->data['Branch']['id'])
			{ 
					  $this->Branch->save($this->request->data['Branch']);
					  $this->set('message', 'Branch update Succsesfuly!');
			}
        
        
	   }

		if($id)
		{	
			$Details = $this->Branch->findById($id);
            $this->set('Detail', $Details);	
		}

	}



	public function index($id='')

   {

          $this->set("smallinfo","here you can see the office locations");
          $this->set('title_for_layout', 'Branches');
          $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id'];
          $sql=" SELECT  * From branches WHERE company_id='$intCompanyId'";
          $BranchResult=$this->Branch->query($sql);
          $this->set('BranchResults', $BranchResult);
		  

     }
	 
public	 function  export()
   {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From branches WHERE company_id='$intCompanyId'"; 
		  $BranchResult=$this->Branch->query($sql);
		echo   $header_row="Id\t Company ID \t Comapny Nmae \t Company Email \t Company Phone Number\t Company City \t Company State\t Company Address\t Company Latitude\t Comany Longitude\n";
		  foreach($BranchResult as $val){
		   $header_row_data.= $val['branches']['id']."\t". $val['branches']['company_id'] ."\t".$val['branches']['first_name']."\t".$val['branches']['email']."\t".$val['branches']['phone']."\t".$val['branches']['city']."\t".$val['branches']['state']."\t".$val['branches']['address']."\t".$val['branches']['latitude']."\t".$val['branches']['longitude']."\t\n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		
		 
   }
 


	public function delete($id = NULL) 

	{
       $this->Branch->delete($id);
       $this->Session->setFlash('The Branch has been deleted', 'default', array(), 'delete');
       $this->redirect(array('action'=>'index'));



	} 



}



?>