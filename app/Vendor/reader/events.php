<?php
function addevent($data,$uploadData)
{
	if($data['event_name'])
	{
		$data['event_date']=date('Y-m-d h:i:s',strtotime($data['event_date']));
		

		mkdir($data['event_name'],0755);
		
		//mkdir($data['event_name']."/Agenda");
		global $db;
		$query="INSERT INTO `events` (`name`, `date`, `client`) VALUES ('".mysql_real_escape_string($data['event_name'])."', '".mysql_real_escape_string($data['event_date'])."', '".mysql_real_escape_string($data['event_client'])."')";
		$db->query($query);
		$insert_id=$db->insert_id();
		uploadData($uploadData,$insert_id);
		addEventGroup($data['event_content_group_arr'],$insert_id);
		$url="content_group_data.php?id=$insert_id";
		redirect($url);
	}
	else
	{
		return 'Event Name is required.';
	}
}
function addEventGroup($event_content_group_arr,$id)
{
	global $db;
	$contentgroupdata=getContentGroupByEventId($id);
	/*$query="DELETE FROM `content_group` WHERE `event_id` = ".$id;
	$db->query($query);*/
	$eventArr=getEventById($id);
	$event_name=$eventArr['event_name'];
	$eventGroupArr=array_unique(explode(',',$event_content_group_arr));
	$current_date = date("Y-m-d H:i:s");
	if($event_content_group_arr)
	{
		if(count(($eventGroupArr))>0)
		{
			while(list($key,$val)=each($eventGroupArr))
			{
				if(!in_array($val,$contentgroupdata))
				{
					mkdir($event_name."/".$val,0755);
					$query="INSERT INTO `content_group` (`group_name`, `event_id`, `ts`) VALUES ('".mysql_real_escape_string($val)."', '".mysql_real_escape_string($id)."', '".mysql_real_escape_string($current_date)."')";
					$db->query($query);
				}
			}
		}
	}
	
	//Remove old entries
	reset($contentgroupdata);
	if(count(($contentgroupdata))>0)
	{
		while(list($key1,$val1)=each($contentgroupdata))
		{
			reset($eventGroupArr);
			if(!in_array($val1,$eventGroupArr) && $val1!='Agenda')
			{
				deleteFolder($event_name."/".$val1);
				$query="DELETE FROM `content_group` WHERE `event_id` = ".$id." and `group_name` = '".$val1."'";
				$db->query($query);
				$query="DELETE FROM `agenda` WHERE `event_id` = ".$id." and `group_name` = '".$val1."'";
				$db->query($query);
			}
		}
	}

	//For  Agenda Folder
	if(!in_array('Agenda',$contentgroupdata))
	{
		mkdir($event_name."/Agenda",0755);
		$query="INSERT INTO `content_group` (`group_name`, `event_id`, `ts`) VALUES ('Agenda', '".mysql_real_escape_string($id)."', '".mysql_real_escape_string($current_date)."')";
		$db->query($query);
	}
	if(!in_array('Flex',$contentgroupdata))
	{
		mkdir($event_name."/Flex",0755);
		$query="INSERT INTO `content_group` (`group_name`, `event_id`, `ts`) VALUES ('Flex', '".mysql_real_escape_string($id)."', '".mysql_real_escape_string($current_date)."')";
		$db->query($query);
	}
}
function uploadData($data,$id)
{
	global $db;
	if ($_FILES["event_attendees"]["error"] == 0)
	{

		$query="DELETE FROM `user_data` WHERE `event_id` = ".$id;
		$db->query($query);


		$filename=$_FILES["event_attendees"]["name"];
		move_uploaded_file($_FILES["event_attendees"]["tmp_name"],
		"tempUploadData/" . $_FILES["event_attendees"]["name"]);
		include 'reader/readExcel.php';
		$filename="tempUploadData/".$filename;
		$participant=parseExcel($filename);

		if(count($participant)>0)
		{
			while(list($key,$val)=each($participant))
			{
				if($key!=0)
				{

				
					$query="INSERT INTO `user_data` (`last_name`, `first_name`, `unique_user_id`, `content_group_id`, `event_id`,`group_id1`,`group_id2`,`group_id3`,`group_id4`,`group_id5`,`group_id6`,title,email,`pointtally`,`role`,pointtally_participant) VALUES ('".mysql_real_escape_string($val['0'])."', '".mysql_real_escape_string($val['1'])."', '".mysql_real_escape_string($val['2'])."', '".mysql_real_escape_string($val['3'])."', '".mysql_real_escape_string($id)."', '".mysql_real_escape_string($val[4])."', '".mysql_real_escape_string($val[5])."', '".mysql_real_escape_string($val[6])."', '".mysql_real_escape_string($val[7])."', '".mysql_real_escape_string($val[8])."', '".mysql_real_escape_string($val[9])."', '".mysql_real_escape_string($val[10])."', '".mysql_real_escape_string($val[11])."','".mysql_real_escape_string($val[13])."','".mysql_real_escape_string($val[12])."','".mysql_real_escape_string($val[14])."')";


					$db->query($query);
				}
			}
		}
		@unlink($filename);
	}
}
function updateEvent($data,$id,$uploadData)
{
	if($data['event_name'])
	{
		global $db;
		$eventdata=getEventById($id);


		$data['event_date']=date('Y-m-d h:i:s',strtotime($data['event_date']));
		$query="UPDATE `events` SET `name` = '".mysql_real_escape_string($data['event_name'])."', `date` = '".mysql_real_escape_string($data['event_date'])."', `client` = '".mysql_real_escape_string($data['event_client'])."' WHERE `id` ='".$id."'";
		$db->query($query);
		


		// Renames the directory
		rename($eventdata['event_name'],$data['event_name']);




		uploadData($uploadData,$id);
		addEventGroup($data['event_content_group_arr'],$id);
		$url="single_event.php?id=$id";
		redirect($url);
	}
	else
	{
		return 'Event Name is required.';
	}
}
function getEvents()
{
	global $db;
	$query="SELECT * FROM `events` where active='1' ORDER BY `id` DESC";
	$db->query($query);
	$arrEvents=array();
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$arrEvents[$i]['event_id']=$db->f('id');
			$arrEvents[$i]['event_name']=$db->f('name');
			$arrEvents[$i]['event_date']=$db->f('date');
			$arrEvents[$i]['event_client']=$db->f('client');
			$arrEvents[$i]['content_group']=getContentGroupByEventId($db->f('id'));
			$arrEvents[$i]['content_group_implode']=implode(',',$arrEvents[$i]['content_group']);
			$i++;
		}
	}
	return $arrEvents;
}
function getEventById($id,$contentGroupType='')
{
	global $db;
	$query="SELECT * FROM `events` WHERE `id` ='".$id."' and `active`=1 LIMIT 0,1";
	$db->query($query);
	$arrEvents=array();
	if($db->num_rows()>0)
	{
		if($db->next_record())
		{
			$arrEvent['event_id']=$db->f('id');
			$arrEvent['event_name']=$db->f('name');
			$arrEvent['event_date']=$db->f('date');
			$arrEvent['event_client']=$db->f('client');
			$arrEvent['content_group']=getContentGroupByEventId($id,$contentGroupType);
			$arrEvent['content_group_with_id']=getContentGroupByEventIdWithId($id,$contentGroupType);
			$arrEvent['content_group_implode']=implode(',',$arrEvent['content_group']);
		}
	}
	return $arrEvent;
}
function getContentGroupByEventId($id,$contentGroupType='')
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$id."' order by group_name ASC";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		while($ndb->next_record())
		{
			if($contentGroupType=='tag' && $ndb->f('group_name')=='Agenda')
			{
			}
			else
			{
				$contentGroup[]=$ndb->f('group_name');
			}
		}
	}
	return $contentGroup;
}
function getContentGroupByEventIdWithId($id,$contentGroupType='')
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$id."' order by group_name ASC";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		while($ndb->next_record())
		{
			if($contentGroupType=='tag' && $ndb->f('group_name')=='Agenda')
			{
			}
			else
			{
				$contentGroup[$ndb->f('id')]=$ndb->f('group_name');
			}
		}
	}
	return $contentGroup;
}
function deleteFile($file_id,$event_name)
{
	global $ndb;
	global $db;
	$query="SELECT * FROM `agenda` WHERE `id` ='".$file_id."'";
	$ndb->query($query);
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$groupname=$ndb->f('group_name');
			$event_id=$ndb->f('event_id');
			$file=$ndb->f('file');
			$path=$event_name."/".$groupname."/".$file;
			@unlink($path);
			$query="DELETE FROM `agenda` WHERE `id` ='".$file_id."'";
			$db->query($query);
		}
	}
	return getgroupId($groupname,$event_id);
}
function getgroupId($groupname,$event_id)
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$event_id."' and group_name='".$groupname."'";
	$ndb->query($query);
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$id=$ndb->f('id');
		}
	}
	return $id;
}
function deleteEvent($id)
{
	global $db;
	$eventArr=getEventById($id);
	$status=deleteFolder($eventArr['event_name']);
	if($status)
	{
		redirect();
	}
	$query="DELETE FROM `content_group` WHERE `event_id` ='".$id."'";
	$db->query($query);
	$query="DELETE FROM `events` WHERE `id` ='".$id."'";
	$db->query($query);
	$query="DELETE FROM `user_data` WHERE `event_id` ='".$id."'";
	$db->query($query);

	$query="DELETE FROM `agenda` WHERE `event_id` ='".$id."'";
	$db->query($query);
}
function redirect($url='')
{
	if(!$url)
		echo '<script>window.location="index.php";</script>';
	else
		echo '<script>window.location="'.$url.'";</script>';
}
function uploadGroupContentFile($data,$uploadData)
{
	global $db;
	$eventArr=getEventById($data['event_id']);
	$event_name=$eventArr['event_name'];
	$current_date = date("Y-m-d H:i:s");
	if(count($uploadData["content_group_file"]["name"])> 0)
	{
		$i=0;
		while(list($key,$val)=each($uploadData["content_group_file"]["name"]))
		{
			if ($uploadData["content_group_file"]["error"][$key] == 0)
				{
					$tempfilename=$uploadData["content_group_file"]["tmp_name"][$key];
					$filepath=$event_name."/".getContentGroupNameByItsId($data['content_group'])."/" . $val;
					move_uploaded_file($tempfilename,$filepath);
				}
		}
	}
	reset($data);
	insertDataIntoAgendaFolder($data,$uploadData);
}
function getContentGroupFilenameByEventId($id,$content_group)
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$id."' and `group_name`='".$content_group."' order by file_name ASC";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$fileArray=$ndb->f('file_name');
		}
	}
	return unserialize($fileArray);
}
function getContentGroupFilenameByEventIdWithId($id,$content_group)
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$id."' and `id`='".$content_group."' order by file_name ASC";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$fileArray=$ndb->f('file_name');
		}
	}
	return unserialize($fileArray);
}
function getEventAttendees($event_id)
{
	global $db;
	$query="SELECT * FROM `user_data` WHERE `event_id` ='".$event_id."' order by last_name ASC";
	$db->query($query);
	$attendeesArray=array();
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$attendeesArray[$i]['id']=$db->f('id');
			$attendeesArray[$i]['last_name']=$db->f('last_name');
			$attendeesArray[$i]['first_name']=$db->f('first_name');
			$attendeesArray[$i]['unique_user_id']=$db->f('unique_user_id');
			$attendeesArray[$i]['content_group_id']=$db->f('content_group_id');
			$attendeesArray[$i]['group_id1']=$db->f('group_id1');
			$attendeesArray[$i]['group_id2']=$db->f('group_id2');
			$attendeesArray[$i]['group_id3']=$db->f('group_id3');
			$attendeesArray[$i]['group_id4']=$db->f('group_id4');
			$attendeesArray[$i]['group_id5']=$db->f('group_id5');
			$attendeesArray[$i]['group_id6']=$db->f('group_id6');
			$attendeesArray[$i]['title']=$db->f('title');
			$attendeesArray[$i]['email']=$db->f('email');
			$attendeesArray[$i]['pointtally']=$db->f('pointtally');
			$attendeesArray[$i]['pointtally_participant']=$db->f('pointtally_participant');
			$attendeesArray[$i]['role']=$db->f('role');
			$i++;
		}
	}
	return $attendeesArray;
}
function getUserDataByUniqueId($user_unique_id,$event_id='')
{
		global $db;
		$query="SELECT * FROM `user_data` WHERE `unique_user_id` ='".$user_unique_id."' and event_id='".$event_id."' LIMIT 0,1";
		$db->query($query);
		$attendeesArray=array();
		if($db->num_rows()>0)
		{
			if($db->next_record())
			{
				$attendeesArray['id']=$db->f('id');
				$attendeesArray['last_name']=$db->f('last_name');
				$attendeesArray['first_name']=$db->f('first_name');
				$attendeesArray['unique_user_id']=$db->f('unique_user_id');
				$attendeesArray['content_group_id']=$db->f('content_group_id');
				$attendeesArray['event_id']=$db->f('event_id');
				$attendeesArray['group_id5']=$db->f('group_id5');
				
			}
		}
	
	   return $attendeesArray;
}
function getAgendaFolderDataByEventId($event_id,$content_group)
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$event_id."' and `group_name`='".$content_group."' order by file_name ASC";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$fileArray['filename']=unserialize($ndb->f('file_name'));
			$fileArray['ts']=$ndb->f('ts');
		}
	}
	return $fileArray;
}
function getContentGroupFiles($event_id)
{
	global $ndb;
	$query="SELECT * FROM `content_group` WHERE `event_id` ='".$event_id."' ";
	$ndb->query($query);
	$contentGroup=array();
	if($ndb->num_rows()>0)
	{
		$i=0;
		while($ndb->next_record())
		{
			$fileArray[$i]['id']=$ndb->f('id');
			$fileArray[$i]['group_name']=$ndb->f('group_name');
			$fileArray[$i]['filename']=getFilenameByGroupNameEventId($ndb->f('group_name'),$event_id);
			$fileArray[$i]['ts']=$ndb->f('ts');
			$i++;
		}
	}
	return $fileArray;
}
function getFilenameByGroupNameEventId($group_name,$event_id)
{
	global $db;
	$query="SELECT * FROM `agenda` WHERE `event_id` ='".$event_id."' and `group_name`='".$group_name."' order by file ASC";
	$db->query($query);
	$contentGroup=array();
	if($db->num_rows()>0)
	{
		$j=0;
		while($db->next_record())
		{
			$fileArray[$j]['id']=$db->f('id');
			$fileArray[$j]['filename']=$db->f('file');
			$fileArray[$j]['ts']=$db->f('ts');
			$fileArray[$j]['version']=$db->f('version');
			$j++;
		}
	}
	return $fileArray;
}
function getTimeDifferencr($ltime,$gtime='')
{
	if($gtime)
		$gstrtime=strtotime($gtime);
	else
		$gstrtime=time();

	$lstrtime=strtotime($ltime);

	$timediff = $gstrtime - $lstrtime;
	return round($timediff/60);
}
function getContentGroupNameByItsId($content_id)
{
	global $db;
	$query="SELECT group_name FROM `content_group` WHERE `id` ='".$content_id."'";
	$db->query($query);
	$attendeesArray=array();
	if($db->num_rows()>0)
	{
		if($db->next_record())
		{
			$group_name=$db->f('group_name');
		}
	}
	return $group_name;
}
function checkContentGroupExist($name,$oldFilenameArray)
{
	$return=1;
	if(count($oldFilenameArray)>0 && is_array($oldFilenameArray))
	{
		while(list($key,$val)=each($oldFilenameArray))
		{
			if($val['filename']==$name)
			{
				$return=$return+$val['version'];
			}
		}
	}
	return $return;

}
function changeFileVersion($oldFilenameArray,$name,$version)
{
	if(count($oldFilenameArray)>0 && is_array($oldFilenameArray))
	{
		while(list($key,$val)=each($oldFilenameArray))
		{
			if($val['filename']==$name)
			{
				$oldFilenameArray[$key]['version']=$version;
			}
		}
	}
	return $oldFilenameArray;
}
function chechValidId($id)
{
	$eventArr=getEventById($id);
	if(!$eventArr)
	{
		redirect();
	}
}
function checkIdExist($id)
{
	$return=true;
	$eventArr=getEventById($id);
	if(!$eventArr)
	{
		$return=false;
	}
	return $return;
}
function deleteFolder($dirname)
{
	 if (is_dir($dirname))
        $dir_handle = opendir($dirname);
        if (!$dir_handle)
        return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
                else
                {
                    $a=$dirname.'/'.$file;
                    deleteFolder($a);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
}
function insertDataIntoAgendaFolder($data,$uploadData)
{
	global $db;
	$eventArr=getEventById($data['event_id']);
	$group_name=getContentGroupNameByItsId($data['content_group']);
	$event_name=$eventArr['event_name'];
	$current_date = date("Y-m-d H:i:s");
	if(count($uploadData["content_group_file"]["name"])> 0)
	{	while(list($key,$val)=each($uploadData["content_group_file"]["name"]))
		{
			$data1=getDataFromAgendaFolder($data['event_id'],$val,$group_name);
			if(count($data1)>0)
			{
				if ($uploadData["content_group_file"]["error"][$key] == 0)
				{
					$tempfilename=$uploadData["content_group_file"]["tmp_name"][$key];
					$filepath=$event_name."/".getContentGroupNameByItsId($data['content_group'])."/" . $val;
					move_uploaded_file($tempfilename,$filepath);

					$query="UPDATE `agenda` SET `version`=version+1, `ts`='".$current_date."' WHERE `event_id` ='".$data['event_id']."' and `id`='".$data1['id']."'";
					$db->query($query);
				}
			}
			else
			{
				if ($uploadData["content_group_file"]["error"][$key] == 0)
				{
					$tempfilename=$uploadData["content_group_file"]["tmp_name"][$key];
					$filepath=$event_name."/".getContentGroupNameByItsId($data['content_group'])."/" . $val;
					move_uploaded_file($tempfilename,$filepath);

					$query="INSERT INTO `agenda` (`event_id`, `group_name`, `file`, `version`, `ts`) VALUES ('".mysql_real_escape_string($data['event_id'])."', '".mysql_real_escape_string($group_name)."', '".mysql_real_escape_string($val)."', '1', '$current_date')";
					$db->query($query);
				}
			}
		}
	}
}
function getDataFromAgendaFolder($event_id,$file,$group_name='')
{
	global $ndb;
	
	if($group_name)
		$query="SELECT * FROM `agenda` WHERE `event_id` ='".$event_id."' and `file`='".$file."' and `group_name`='".$group_name."'";
	else
		$query="SELECT * FROM `agenda` WHERE `event_id` ='".$event_id."' and `file`='".$file."'";
	$ndb->query($query);
	$data=array();
	if($ndb->num_rows()>0)
	{
		if($ndb->next_record())
		{
			$data['id']=$ndb->f('id');
			$data['file']=$ndb->f('file');
			$data['version']=$ndb->f('version');
			$data['ts']=$ndb->f('ts');
		}
	}
	return $data;
}
function getDataFromContentGroupFolder($event_id,$group_name)
{
	global $ndb;
	$query="SELECT * FROM `agenda` WHERE `event_id` ='".$event_id."' and `group_name`='".$group_name."' order by file ASC";
	$ndb->query($query);
	$data=array();
	if($ndb->num_rows()>0)
	{
		$i++;
		while($ndb->next_record())
		{
			$data[$i]['id']=$ndb->f('id');
			$data[$i]['file']=$ndb->f('file');
			$data[$i]['version']=$ndb->f('version');
			$data[$i]['ts']=$ndb->f('ts');
			$i++;
		}
	}
	return $data;
}
function getDataFromFlexFolder($event_id,$file)
{
	global $ndb;

	$query="SELECT * FROM `agenda` WHERE `event_id` ='".$event_id."' and `file` like '".$file."%' and `group_name`='Flex'";

	$ndb->query($query);
	$data=array();
	$i=0;
	if($ndb->num_rows()>0)
	{
		while($ndb->next_record())
		{
			$data[$i]['id']=$ndb->f('id');
			$data[$i]['file']=$ndb->f('file');
			$data[$i]['version']=$ndb->f('version');
			$data[$i]['ts']=$ndb->f('ts');
			$i++;
		}
	}

	return $data;
}

function addUserAccess($wwid,$eventid,$type)
{
	 global $ndb;
	 $query="insert into user_access_records(user_id,event_id,timestamp,type) values('$wwid',$eventid,NOW(),'$type')";
	 $ndb->query($query);

}

?>