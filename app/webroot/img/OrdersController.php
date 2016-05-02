<?php
Class OrdersController extends AppController 
{ 
    
      
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

		$query=" SELECT * From retailers as up Join orders as o on up.id=o.retailer_id where o.company_id=".$intCompanyId." order by date_time DESC";
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

		$query=" SELECT * From retailers as up Join orders as o on up.id=o.retailer_id where o.company_id=".$intCompanyId." && o.id=".$id."";
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
}
?>
