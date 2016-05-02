<?php
  //generic php function to send GCM push notification
   function sendPushNotificationToGCM($registatoin_ids, $message) {
    //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
    // Google Cloud Messaging GCM API Key
    define("GOOGLE_API_KEY", "AIzaSyBxrDQouVdWPwqhppa7EdCQsyXBEiZdaiA");    
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
?>
<?php
   
  //this block is to post message to GCM on-click
  $pushStatus = ""; 
  if(!empty($_GET["push"])) { 
   
		require "database/db_mysql.inc";	
	    $intCompanyId="275";	

	    $sql = "SELECT * from users where users.company_id='$intCompanyId' and gcmid is NOT NULL";	
		$db->query($sql);
		$gcmRegIds = array();
		while ($db->next_record())
		{
			$gcmRegIds[] =$db->f("gcmid");
		}
    $pushMessage = $_POST["message"]; 
    if ( isset($pushMessage)) {    
      
      $message = array("m" => $pushMessage); 
      $pushStatus = sendPushNotificationToGCM($gcmRegIds, $message);
    }   
  }
   
  
?>
<html>
    <head>
        <title>Google Cloud Messaging (GCM) Server in PHP</title>
    </head>
  <body>
    <h1>Google Cloud Messaging (GCM) Server in PHP</h1> 
    <form method="post" action="?push=1">                                      
      <div>                                
        <textarea rows="2" name="message" cols="23" placeholder="Message to transmit via GCM"></textarea>
      </div>
      <div><input type="submit"  value="Send Push Notification via GCM" /></div>
    </form>
    <p><h3><?php echo $pushStatus; ?></h3></p>        
    </body>
</html>