<?php
	App::import('Vendor', 'reader/readExcel'); //import statement
	class ProductsController extends AppController

	{

		public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'Module','Retailer','Product');

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

		}

		

		public function add($intProductId=''){



			$userDetail= $this->Session->read('user');

			$this->set('userDetail',$userDetail);

			

			if($this->request->is('post'))

			

			{

				//$image= $this->request->data['Product']['product_image'];

				//$this->request->data['Product']['product_image']=$this->imgupload($image);

				$this->request->data['Product']['company_id']=$userDetail['User']['company_id'];		

				$this->request->data['Product']['created_at']=date("Y-m-d H:i:s");

				$image1 = $this->request->data['Product']['product_image'];

				$this->request->data['Product']['product_image']= $this->imgupload($image1);

				$this->Product->save($this->data);

				//$this->Product->save($this->request->data['Product']['discount']);

				

				

				if($this->request->data['Product']['id'])

					$this->set('message', 'Product Update Successfully!');

				else

					$this->set('message', 'Product Add Succsesfuly!');

			}

			if($intProductId)

			{

				$arrProduct=$this->Product->find("first",array("conditions"=>array("id"=>$intProductId)));
				

				$this->set('arrProduct',$arrProduct['Product']);

			}

			

		}

		

		public function listProduct()

		{

			$this->set('smallinfo', 'you can manage your all Product Here');

			$this->set('title_for_layout', 'Product');
            $userdata=$this->Session->read('user');
			$userdata['User']['company_id'];
			$intCompanyId=$userdata['User']['company_id'];
			$arrProduct = $this->Product->find('all', array("conditions"=>array("company_id"=>$intCompanyId)));
			$this->set('arrProduct', $arrProduct);

			$index = 0;

			

			while(list($key,$val)=each($arrProduct))

			{

				$new[$index]['id'] = $val['Product']['id'];

				$new[$index]['product_name'] = $val['Product']['product_name'];

				$index++;

			}

			$this->set('productResults',$new);

			

		}
		
		   public	 function  export()
       {
		  $userDetail = $this->Session->read('user');
          $intCompanyId=$userDetail['User']['company_id']; 
	      $sql=" SELECT  * From  products WHERE company_id='$intCompanyId'"; 
		  $productResult=$this->Retailer->query($sql);
		 
	
		  echo   $header_row="ID\tCompany ID \tSKU Number \t Quantity In stock \tProduct Name \tPrice\tDescription \tCreated Date\tUpdate On\tDiscount\tRemark\tProduct Image \n";
		  
		  foreach($productResult as $val){
			 
	
		   $header_row_data.= $val['products']['id']."\t". $val['products']['company_id'] ."\t".$val['products']['sku']."\t".$val['products']['qty_in_stock']."\t".$val['products']['name']."\t".$val['products']['price']."\t".$val['products']['description']."\t".$val['products']['created_at']."\t".$val['products']['updated_at']."\t".$val['products']['discount']."\t".$val['products']['shop_photo']."\t".$val['products']['created_at']."\t".$val['products']['distributer']."\t".$val['products']['first_name']."\t".$val['products']['deal_in']."\t".$val['products']['remark']."\t".$val['products']['product_image']."\t \n"; 
         $filename = "export_".date("Y.m.d").".xls";
         header('Content-type: application/ms-excel');
         header('Content-Disposition: attachment; filename="'.$filename.'"');
         echo($header_row_data);
			  
			  }
			  
		  exit;	
		  
   }
	
	
	public  function import()
	
	{
			$this->set('smallinfo', 'you can upload your all Product Here');

			$this->set('title_for_layout', 'Product Import');
            $userdata=$this->Session->read('user');
			$userdata['User']['company_id'];
			$intCompanyId=$userdata['User']['company_id'];
	
			 if ($this->request->is('post'))
			  {
					 $filename=$_FILES["xlfile"]["name"];
			 
					 move_uploaded_file($_FILES["xlfile"]["tmp_name"],"tempUploadData/" . $_FILES["xlfile"]["name"]);
					$fp = fopen("tempUploadData/".$filename,'r') or die("can't open file");
			
					$participant=parseExcel("tempUploadData/".$filename);
					
					while (list($key,$val)=each($participant)) 
					{
			
							if($key>0)
							{
					
								
								$arrProduct=$this->Product->find("first",array("conditions"=>array("sku"=>$val[0])));
						
								if(count($arrProduct)==0)
								{
									$this->request->data['Product']['id'] ="";
									$this->request->data['Product']['created_at'] = date("Y-m-d H:i:s");
								}
								else
									$this->request->data['Product']['id'] =$arrProduct['Product']['id'];
								
								$this->request->data['Product']['company_id'] =$intCompanyId;

								$this->request->data['Product']['sku'] = $val[0];
								$this->request->data['Product']['qty_in_stock'] = $val[1];
								$this->request->data['Product']['name'] = $val[2];
								$this->request->data['Product']['price'] = $val[3];
								$this->request->data['Product']['description'] =$val[4];
								$this->request->data['Product']['discount'] = $val[5];
								$this->request->data['Product']['remark'] =$val[6];
								$this->request->data['Product']['updated_at'] =date("Y-m-d H:i:s");
                                $this->Product->save($this->request->data,false);
								$this->set('message', 'Uplode Successfully!');
									
							}
						}
				fclose($fp) or die("can't close file");
				@unlink("tempUploadData/".$filename);
			  }
				

  }

		
		
		
		
				public function delete($id = NULL) 
	{
		  $this->Product->delete($id);
		  $this->Session->setFlash('The Product has been deleted.', 'default', array(), 'delete');
		  
		  //$this->set('message', 'The Retailer  has been deleted');
		  $this->redirect(array('action'=>'listProduct'));
	} 


		    public function imgupload($image)



	  {



		



		//allowed image types



                $imageTypes = array("image/gif", "image/jpeg", "image/png");



                //upload folder - make sure to create one in webroo
                $uploadFolder = "images/upload/product";

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
           


}

?>