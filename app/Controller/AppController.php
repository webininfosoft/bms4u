<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Html', 'Form');
	public $uses = array('UserProfile','User','UserToken','Branch', 'Designation', 'CompanyModule','Module');

	public function getAllCompanyModules($permission)
	{
		$companyid=$this->Session->read('user.User.company_id');
		$query="select * from company_module,modules where company_module.company_id=$companyid and modules.slug=company_module.module_id and web=1";
		$arrModules=$this->User->query($query);
		
		$arrFinalArray=array();
		$k=0;
		
		while(list($key,$val)=each($arrModules))
		{

			if(array_key_exists($val['modules']['slug'], $permission))
			{
				if($permission[$val['modules']['slug']]['perm_view']==1)
				{
					$arrFinalArray[$k]['modules']=$val['modules'];
					if($val['modules']['submenu']==1)
					{
						$query="select * from modules where parent_id=".$val['modules']['id'];
						$arrSubModules=$this->User->query($query);


						$arrSubmenu=array();
						while(list($key1,$val1)=each($arrSubModules))
						{
							switch($val1['modules']['module_type'])
							{
								case "add": 
									if($permission[$val['modules']['slug']]['perm_add'])	
										$arrSubmenu[$key1]=$val1;
								break;
								case "view": 
									if($permission[$val['modules']['slug']]['perm_view'])	
										$arrSubmenu[$key1]=$val1;
								break;

							}
						}

						$arrFinalArray[$k]['modules']['submenu']=$arrSubmenu;

					}
					$k++;
				}
			}
		}

		return $arrFinalArray;

	}
	Public function sendMail($strEmail,$strMessage,$strSubject,$from)
	  {

			$this->Email->to = $strEmail; 
			$this->Email->subject = $strSubject; 
			$this->Email->replyTo =  $from; 
			$this->Email->from = $from;
			$message=$strMessage;

			$send=$this->Email->send($message);
			return $send;

	  }

}
