<?php

class CustomFunctionsComponent extends Object {

    function initialize(&$controller) 
    {        // saving the controller reference for later use        
            $this->controller =& $controller;    
    }
	 function checkAltUserId($intAuthId)
	{

	 	$intUserId = $GLOBALS['_COOKIE']['intUserId'];
		if($intUserId!='')
			return($intUserId);
		else
			return($intAuthId);
	}
	 function checkAltUserRoll($strAuthRoll)
	{

	 	$strUserRoll = $GLOBALS['_COOKIE']['strUserRoll'];
		if($strUserRoll!='')
			return($strUserRoll);
		else
			return($strAuthRoll);
	}
function checkGETValueForNull($strGetVal="",$strKeyName="")
     {
		
		if($strKeyName)
         {

			if($strKeyName == "intAdminId" || $strKeyName == "intBookId" ||$strKeyName=="strLoggedInUserName"|| $strKeyName == "intSourceId"||$strKeyName=="strEntityIds"||$strKeyName=="arrTripIds")
			{
				$strGetVal = $this->controller->Session->read($strKeyName);
			}
             if(!$strGetVal)
             {
                 if(isset($this->controller->params["form"][$strKeyName]))
                    $strGetVal = @$this->controller->params["form"][$strKeyName];
                 elseif(isset($this->controller->params["named"][$strKeyName]))
                    $strGetVal = @$this->controller->params["named"][$strKeyName];                  
                 else
                    $strGetVal = @$this->controller->params[$strKeyName];                  
             }
         }
         
         $strGetVal = ($strGetVal=="NULL")?"":$strGetVal;
         return($strGetVal);
     }
     
      // grab possible SET/ENUM values and return an array
        function getPossibleEnumValuesArray(&$objDBObject,$field)
        {           
        
            $query = "SHOW COLUMNS FROM ".$objDBObject->table." LIKE '$field'";
            $arrResultRecord = $objDBObject->query($query);
			if(isset($arrResultRecord[0]['COLUMNS']["Type"]))
			{
	            $strEnumFields = str_replace(array('enum','(',')',"'"),array(""),$arrResultRecord[0]['COLUMNS']["Type"]);           
			}
			else
			{
	            $strEnumFields = str_replace(array('enum','(',')',"'"),array(""),$arrResultRecord[0][0]["Type"]);           
			}
            $arrOptions = explode(",",$strEnumFields );

			if($field=='time_zone')
				$arrReturnVals["Timezone"] = "Timezone";

            while(list($key,$val) = each($arrOptions))
            {
                $arrReturnVals[$val]=$val;
            }
            return $arrReturnVals;
         
        }
 	  function makeArray()
      {
      	  	$arrMonths=array(1 =>'01',2 => '02',3 => '03',4 => '04',5 => '05',6 => '06',7 => '07',8 => '08',9 => '09',10 =>'10',11 =>'11',12 =>'12');
      	  	return($arrMonths);
      }
	 function makeYearArray()
      {
      		$intCurrentYear=date("Y");
      		$i=$intCurrentYear;
      		$j=$intCurrentYear+19;
      		//$arrYears[0]='Year';
      		while($i<$j)
      		{
      			$arrYears[$i]=$i;
      			$i++;
      		}
      	  	
      	  	return($arrYears);
      }
	  function makeStateDropdown($selected)
      {
      		
			<option value="">----Select State----</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option><option value="Andhra Pradesh">Andhra Pradesh</option><option value="Arunachal Pradesh">Arunachal Pradesh</option><option value="Assam">Assam</option><option value="Bihar">Bihar</option><option value="Chandigarh">Chandigarh</option><option value="Chhattisgarh">Chhattisgarh</option><option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option><option value="Daman and Diu">Daman and Diu</option><option value="Delhi">Delhi</option><option value="Goa">Goa</option><option value="Gujarat">Gujarat</option><option value="Haryana">Haryana</option><option value="Himachal Pradesh">Himachal Pradesh</option><option value="Jammu and Kashmir">Jammu and Kashmir</option><option value="Jharkhand">Jharkhand</option><option value="Karnataka">Karnataka</option><option value="Kerala">Kerala</option><option value="Lakshadweep">Lakshadweep</option><option value="Madhya Pradesh">Madhya Pradesh</option><option value="Maharashtra">Maharashtra</option><option value="Manipur">Manipur</option><option value="Meghalaya">Meghalaya</option><option value="Mizoram">Mizoram</option><option value="Nagaland">Nagaland</option><option value="Orissa">Orissa</option><option value="Pondicherry">Pondicherry</option><option value="Punjab">Punjab</option><option value="Rajasthan">Rajasthan</option><option value="Sikkim">Sikkim</option><option value="Tamil Nadu">Tamil Nadu</option><option value="Tripura">Tripura</option><option value="Uttaranchal">Uttaranchal</option><option value="Uttar Pradesh">Uttar Pradesh</option><option value="West Bengal">West Bengal</option>

      		while($i<$j)
      		{
      			$arrYears[$i]=$i;
      			$i++;
      		}
      	  	
      	  	return($arrYears);
      }
      
} 
?>