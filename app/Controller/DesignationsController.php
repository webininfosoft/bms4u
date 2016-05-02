<?php
Class DesignationsController extends AppController 
{ 
	public $name = 'Designations';
	public $uses = array('UserProfile','User','UserToken', 'Designation', 'Module', 'Authentication','DesignationsParent');

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
		//get user details everywhere like this.. 
		$userDetail = $this->Session->read('user');
		$intCompanyId=$userDetail['User']['company_id'];
		$this->set('userDetail', $userDetail);
		
		
		$this->set('title_for_layout', 'Add Designation');
		if($this->request->is('post'))
		{
			
			//print_r($this->request->data);
			//die;
			
			$this->request->data['Designation']['company_id'] = $intCompanyId;
			
			$arrDesign = $this->Designation->find('first',array('conditions'=>array('Designation.designation'=>$this->request->data['Designation']['designation'],'AND'=>array('Designation.company_id'=>$intCompanyId))));
			
			if(count($arrDesign)==0)
			{
				$this->request->data['Designation']['company_id'] = $intCompanyId;
				if($this->Designation->save($this->request->data['Designation']))
				{
				    if(!empty($this->request->data['Designation']['parent_designation_id']))
					{
					
						$parentid=$this->request->data['Designation']['parent_designation_id'];
						$desgnid=$this->Designation->id;	
						$pdata['DesignationsParent']['designation_id']=$desgnid;
						$pdata['DesignationsParent']['parent_id']=$parentid;
						$pdata['DesignationsParent']['company_id']=$intCompanyId;
						$allDesData[]=$pdata;
						$flagtrue=1;
						
						while($flagtrue)	
						{
							$sql="select  parent_id from designations_parents where designation_id=$parentid";
							$dataparent=$this->Designation->query($sql);
							$parentid=$dataparent[0]['designations_parents']['parent_id']; 
							if($parentid)
							{
									$pdata['DesignationsParent']['designation_id']=$desgnid;
									$pdata['DesignationsParent']['parent_id']=$parentid;
									$pdata['DesignationsParent']['company_id']=$intCompanyId;
									$allDesData[]=$pdata;
							}
							else
							 $flagtrue=0;
					   }

					   $this->DesignationsParent->saveAll($allDesData);
						
						
						$this->set('message', 'Designation Added Succsesfuly!');
					}
				
			   }
			   else
			   {
					 if(!$id){
						$this->set('message1', 'Duplicate Designation! Try Diffrent Name');
					 }
			   }
			}
			
			if($this->request->data['Designation']['id'])
			{
				if($this->Designation->save($this->request->data['Designation']))
				{
					if(!empty($this->request->data['Designation']['parent_designation_id']))
					{
					
							$parentid=$this->request->data['Designation']['parent_designation_id'];
							
							$desgnid=$this->request->data['Designation']['id'];	
							$pdata['DesignationsParent']['designation_id']=$desgnid;
							$pdata['DesignationsParent']['parent_id']=$parentid;
							$pdata['DesignationsParent']['company_id']=$intCompanyId;
							$allDesData[]=$pdata;
							$flagtrue=1;	
							while($flagtrue)	
							{
								$sql="select  parent_id from designations_parents where designation_id=$parentid";
								$dataparent=$this->Designation->query($sql);
								$parentid=$dataparent[0]['designations_parents']['parent_id']; 
								if($parentid)
								{
										$pdata['DesignationsParent']['designation_id']=$desgnid;
										$pdata['DesignationsParent']['parent_id']=$parentid;
										$pdata['DesignationsParent']['company_id']=$intCompanyId;
										$allDesData[]=$pdata;
								}
								else
								 $flagtrue=0;
						   }
						   $this->DesignationsParent->saveAll($allDesData);
					
					}
				}
				$this->set('message', 'Designation update Succsesfuly!');
			}
		}
		  if($id){
			   $desdata = $this->Designation->findById($id);
			 //  print_r($desdata);
			   $this->set('des', $desdata);
		  }
		    $designationAll = $this->Designation->findAllByCompanyId($intCompanyId);
	        $this->set('designation', $designationAll);		
	}
	
	public function index(){
	   $this->set('smallinfo', 'you can manage your all Designations here');
	   $this->set('title_for_layout', 'Designations');	   	   
	   $userDetail = $this->Session->read('user');		
	   $intCompnayId=$userDetail['User']['company_id'];
	   
	   	$this->paginate = array('conditions'=>array('Designation.company_id'=>$intCompnayId));
		$this->paginate=array('limit'=>2);
	 
	    $designationResult = $this->Designation->find('all', array('conditions'=>array('Designation.company_id'=>$intCompnayId)));
	 
	   $this->set('des', $designationResult);
	   $index = 0;
	   foreach($designationResult as $val) 
	   {
				$new[$index]['id'] = $val['Designation']['id'];
				$new[$index]['name'] = $val['Designation']['designation'];
				if($val['Designation']['designation']=='Retailer' && empty($val['DesignationsParent'])){
					$this->Session->setFlash('Please asign a Parent for Retailer.','default', array(), 'Succsess');
				}
				$index++;
	   }

	  $this->set('designationResults', $designationResult);
	
	}
	
	public function delete($id = NULL) 
	{
		 if($this->Designation->delete($id)){
			$this->DesignationsParent->deleteAll(array('DesignationsParent.designation_id'=>$id),false);
			$this->Session->setFlash('The Designation has been deleted', 'default', array(), 'delete');		   
			$this->redirect(array('action'=>'index'));
		 }
	} 
}
?>