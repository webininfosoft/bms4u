<?php
App::uses('CakeEmail', 'Network/Email'); // this should be placed before your Controller Class
Class OrdersController extends AppController 
{ 
    
    public $components = array('RequestHandler'); 
	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','Retailer','Product','Order');
	public $access = array('login');
	public $layout = 'company_login_layout';
	
		
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
	public function index()
	{
		
		$this->set('title_for_layout', 'Order List');
		$userdata=$this->Session->read('user'); 
		$intCompanyId=$userdata['User']['company_id'];	

		$query="select * from designations where company_id=".$intCompanyId."";
		$desgndata=$this->Retailer->query($query);
		
		while(list($key,$val)=each($desgndata))
		{
			$arrDesgn[$val['designations']['id']]=$val['designations']['designation'];
			
		}

		$query=" SELECT * From retailers as up join orders as o on up.sync_id=o.retailer_id where o.company_id=".$intCompanyId." order by date_time DESC";
	    $orderResult=$this->Retailer->query($query);

		
		while(list($key,$val)=each($orderResult))
		{
			$query="select role_id,first_name,last_name from users,user_profiles where users.id=user_profiles.user_id and users.id=".$val['o']['user_id'];
			$userdata=$this->Order->query($query);
			
			$desgnid=$userdata[0]['users']['role_id'];
			$orderResult[$key]['o']['fosname']=$userdata[0]['user_profiles']['first_name']." ".$userdata[0]['user_profiles']['last_name'];
			$orderResult[$key]['o']['fosdesg']=$arrDesgn[$desgnid];
			
		}
		
		$this->set('arrOrders', $orderResult);
	}
	
	
	public function viewallorderdeatil($id='')
	
{
        $userdata=$this->Session->read('user'); 
		$intCompanyId=$userdata['User']['company_id'];	

		$query="select * from designations";
		$desgndata=$this->Retailer->query($query);
		
		while(list($key,$val)=each($desgndata))
		{
			$arrDesgn[$val['designations']['id']]=$val['designations']['designation'];
			
		}

		$query=" SELECT * From retailers as up Join orders as o on up.sync_id=o.retailer_id where o.company_id=".$intCompanyId." && o.id=".$id."";
	    $orderResult=$this->Retailer->query($query);
		

		
		while(list($key,$val)=each($orderResult))
		{
			$query="select role_id,first_name,last_name from users,user_profiles where users.id=user_profiles.user_id and users.id=".$val['o']['user_id']."";
			$userdata=$this->Order->query($query);
			$desgnid=$userdata[0]['users']['role_id'];
			$orderResult[$key]['o']['fosname']=$userdata[0]['user_profiles']['first_name']." ".$userdata[0]['user_profiles']['last_name'];
			$orderResult[$key]['o']['fosdesg']=$arrDesgn[$desgnid];
		}
	$this->set('arrOrders', $orderResult);
	$productid=substr($orderResult['0']['o']['product_ids'],0,-1);
	$pid=array_filter( explode(",",$productid ) );
	$arrQty=array_filter( explode(",",substr($orderResult['0']['o']['qty'],0,-1) ) );
	$arrPrices=array_filter( explode(",",substr($orderResult['0']['o']['prices'],0,-1) ) );
	$arrDiscount=$orderResult['0']['o']['discount'];
	$arrCredit=$orderResult['0']['o']['credit'];
	$arrorderamount=$orderResult['0']['o']['net_amount'];
	$arrCash=$orderResult['0']['o']['cash_paid'];
	$arrCheque=$orderResult['0']['o']['cheque_paid'];
	$intTax=$orderResult['0']['o']['taxes'];
    $totalpaid=$arrCash+$arrCheque;
	$arrfinaldata=array();
	$orderamount=0;
	$netamount=0;
	while(list($key,$val)=each($pid))
	{
		$query="Select name FROM products where id=".$val."";
		$product=$this->Product->query($query);
		$arrfinaldata[$key]['id']=$key+1;
		$arrfinaldata[$key]['name']=$product['0']['products']['name'];
		$arrfinaldata[$key]['qty']=$arrQty[$key];
		$arrfinaldata[$key]['price']=$arrPrices[$key];
		$arrfinaldata[$key]['total']=$arrPrices[$key]*$arrQty[$key];
		$orderamount+=$arrfinaldata[$key]['total'];
		$netamount=$orderamount+ $intTax -$arrDiscount+$arrCredit;
		$totalBalence=$netamount-$totalpaid;
		
	}

	$this->set('orderamount', $orderamount);
    $this->set('productData', $arrfinaldata);
	$this->set('netamount', $netamount);
	$this->set('totalBalence',$totalBalence);
	
	
}

//email send to the user who palced order

         public function sendemil($id='')
		 {
			 
	         $userdata=$this->Session->read('user'); 
		     $intCompanyId=$userdata['User']['company_id'];
			 $query=" SELECT * From retailers as up Join orders as o on up.id=o.retailer_id where o.company_id=".$intCompanyId." && o.id=".$id."";
	         $orderResult=$this->Retailer->query($query);
			 while(list($key,$val)=each($orderResult)){
				
				 $emailaddress=$val['up']['email'];
				 
			 }
			 
			
			     //send an email to say that the user data was saved
                //Start email functionality
                $recipients = array($emailaddress);//multiple recipients can be defined in an array.
				print_r($recipients);exit;
    			$from = array('denis@blah.ie' => 'Denis Hogan'); // Say who the email is from if you wish to override the settings in your transport config.
				$subject = "New User added to this wonderful CakePHP application: ".$this->request->data['User']['name']; //Set your subject line.
				$viewVars = array('user_id'=>$newUserID,'user_name'=> $this->request->data['User']['name']);//pass an array of variables to the email view if required - no need for                 this in static messages.
				$template = 'new_user_template';// specify the name of the email template you wish to use.
				$this->sendMail($recipients, $from, $subject, $viewVars, $template);
				//End email functionality
                
				$this->Session->setFlash(__('The User has been saved'), 'default', array('class' => 'message success'));// set a flash message to confirm that the user details were saved.
				$this->redirect(array('action' => 'index')); //redirect back to 
			 
			 
			 
	   exit;
	
               }
			

public	 function  export()
	 
       {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	     $sql=" SELECT  * From  orders inner join retailers on orders.retailer_id=retailers.id WHERE orders.company_id='$intCompanyId'"; 
		  $OrderResult=$this->Order->query($sql);
		 
		  
		  echo   $header_row="Order ID\tCompany ID \tUser ID \tRetailer \tProducts ID \tQuantity\tPricess \tOrder Amount ID\tCheque Paid\tCash Paid\tCredit\tLatitude\t Longitude\tDate Time\tNet Amount \tDiscount\tRemarks\ttaxes\tOrder Source\n";
		  
		  foreach($OrderResult as $val){
			 
	
		   $header_row_data.= $val['orders']['id']."\t". $val['orders']['company_id'] ."\t".$val['orders']['user_id']."\t".$val['retailers']['shop_name']."\t".$val['orders']['product_ids']."\t".$val['orders']['qty']."\t".$val['orders']['prices']."\t".$val['orders']['order_amount']."\t".$val['orders']['cheque_paid']."\t".$val['orders']['cash_paid']."\t".$val['orders']['credit']."\t".$val['orders']['latitude']."\t".$val['orders']['longitude']."\t".$val['orders']['date_time']."\t".$val['orders']['net_amount']."\t".$val['orders']['discount']."\t".$val['orders']['remarks']."\t".$val['orders']['taxes']."\t" .$val['orders']['order_source']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }





public function add()
{      
             
	         $this->set('title_for_layout', 'Add order');
		     $userdata=$this->Session->read('user'); 
			 $userdata['User']['id'];
			 $userdata['User']['company_id'];
			 $this->set('Detail',$userdata);
		     $intCompanyId=$userdata['User']['company_id'];
	         $productResult = $this->Product->find('all', array('conditions' => array('company_id' => $intCompanyId)));
			 $this->set('arrProduct', $productResult);
			 $sql=" SELECT  * From retailers WHERE company_id=".$intCompanyId." order by id DESC";
		     $arrRetailer=$this->Retailer->query($sql);
             $this->set('Retailer', $arrRetailer);
			 $this->request->is('post');
			 $pids=$this->request->data['Order']['product_ids'];
			 $proids=implode(",", $pids);
			 $sql1="SELECT price From products WHERE id='".$proids."'";
			 $price=$this->Product->query($sql1);
			 $this->request->data['Order']['prices']=$price;
			 $quantity=$this->request->data['Order']['qty'];
			 while(list($key,$val)=each($pids))
	         {
	          $proids=implode(",", $pids);
			  $this->request->data['Order']['product_ids']=$proids;
			 
			 }
			

			 
			while(list($key,$val)=each($price)){
				 $proprice=implode(",",$price);
				 $this->request->data['Order']['prices']=$proprice;
				 
			}
			while(list($key,$val)=each($quantity)){
				$proquantity=implode(",",$quantity);
				$this->request->data['Order']['qty']=$proquantity;
				
			}
			  $this->Order->save($this->request->data['Order']);
}

     public function invoice($id='')
	 
	 {
		 
		$this->layout='default';
		$userdata=$this->Session->read('user');
		$this->set('userdata',$userdata);
		$intCompanyId=$userdata['User']['company_id'];	

		$query="select * from designations";
		$desgndata=$this->Retailer->query($query);
		
		while(list($key,$val)=each($desgndata))
		{
			$arrDesgn[$val['designations']['id']]=$val['designations']['designation'];
			
		}

		$query=" SELECT * From retailers as up Join orders as o on up.sync_id=o.retailer_id where o.company_id=".$intCompanyId." && o.id=".$id."";
	    $orderResult=$this->Retailer->query($query);

		
		while(list($key,$val)=each($orderResult))
		{
			$query="select role_id,first_name,last_name from users,user_profiles where users.id=user_profiles.user_id and users.id=".$val['o']['user_id']."";
			$userdata=$this->Order->query($query);
			$desgnid=$userdata[0]['users']['role_id'];
			$orderResult[$key]['o']['fosname']=$userdata[0]['user_profiles']['first_name']." ".$userdata[0]['user_profiles']['last_name'];
			$orderResult[$key]['o']['fosdesg']=$arrDesgn[$desgnid];
		}
	$this->set('arrOrders', $orderResult);
	$productid=substr($orderResult['0']['o']['product_ids'],0,-1);
	$pid=array_filter( explode(",",$productid ) );
	$arrQty=array_filter( explode(",",substr($orderResult['0']['o']['qty'],0,-1) ) );
	$arrPrices=array_filter( explode(",",substr($orderResult['0']['o']['prices'],0,-1) ) );
	$arrDiscount=$orderResult['0']['o']['discount'];
	$arrCredit=$orderResult['0']['o']['credit'];
	$arrorderamount=$orderResult['0']['o']['net_amount'];
	$arrCash=$orderResult['0']['o']['cash_paid'];
	$arrCheque=$orderResult['0']['o']['cheque_paid'];
    $totalpaid=$arrCash+$arrCheque;
	$arrfinaldata=array();
	$orderamount=0;
	$netamount=0;
	while(list($key,$val)=each($pid))
	{
		$query="Select name FROM products where id=".$val."";
		$product=$this->Product->query($query);
		$arrfinaldata[$key]['id']=$key+1;
		$arrfinaldata[$key]['name']=$product['0']['products']['name'];
		$arrfinaldata[$key]['qty']=$arrQty[$key];
		$arrfinaldata[$key]['price']=$arrPrices[$key];
		$arrfinaldata[$key]['total']=$arrPrices[$key]*$arrQty[$key];
		$orderamount+=$arrfinaldata[$key]['total'];
		$netamount=$orderamount-$arrDiscount+$arrCredit;
		$totalBalence=$netamount-$totalpaid;
		
	}

	$this->set('orderamount', $orderamount);
    $this->set('productData', $arrfinaldata);
	$this->set('netamount', $netamount);
	$this->set('totalBalence',$totalBalence);
	 
	 }
	 	 
}
?>
