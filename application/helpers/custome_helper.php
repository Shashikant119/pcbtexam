<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed');
 
if (! function_exists('isUserPackage')) {
	function isUserPackage($uid,$pack_id)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('user_package',['user_id'=>$uid,'package_id'=>$pack_id]);
	  if($q->num_rows()>0)
	  {
	   return true;
	  }
	   else
	   	return false;
	}

}
 function isJson($string) {
                             json_decode($string);
                             return (json_last_error() == JSON_ERROR_NONE);
   }
function getExcerpt($str, $startPos=0, $maxLength=100) {
    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, $startPos, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
    }
    
    return $excerpt;
}
if (! function_exists('getEmail')) {
	function getEmail($uid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_users',['user_id'=>$uid]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->email;
	  }
	   else
	   	return false;
	}

}
if (! function_exists('getUName')) {
	function getUName($uid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_users',['user_id'=>$uid]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->username;
	  }
	   else
	   	return false;
	}

}
if (! function_exists('getProfilePic')) {
	function getProfilePic($uid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_users',['user_id'=>$uid]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->profile_pic;
	  }
	   else
	   	return '';
	}

}
if (! function_exists('getPackPrice')) {
	function getPackPrice($id)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_packages',['package_id'=>$id]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->package_price;
	  }
	   else
	   	return '';
	}

}
if (! function_exists('getPackageDates')) {
	function getPackageDates($uid,$packid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('user_package',['user_id'=>$uid,'package_id'=>$packid]);
	  //echo $CI->db->last_query();die;
	  if($q->num_rows()>0)
	  {
	   return ['start_date'=>$q->row()->package_start,
	            'end_date'=>$q->row()->package_end,
	            'entrydate'=>$q->row()->enterydate,
	            'status'=>$q->row()->status];
	  }
	   else
	   	return '';
	}

}
if (! function_exists('getName')) {
	function getName($uid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_users',['user_id'=>$uid]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->name;
	  }
	   else
	   	return '';
	}

}
if (! function_exists('getPackName')) {
	function getPackName($pid)
	{
       $CI = get_instance();
	  $q=$CI->db->get_where('qms_packages',['package_id'=>$pid]);
	  if($q->num_rows()>0)
	  {
	   return $q->row()->package_name;
	  }
	   else
	   	return '';
	}

}
if (! function_exists('isPackFree')) {
	function isPackFree($pid)
	{
      $CI = get_instance();
	  $q=$CI->db->get_where('qms_packages',['package_id'=>$pid]);
	  if($q->num_rows()>0)
	  {
		   if($q->row()->package_type=='Free')
		     return true;
		    else
               false;
	  }
	   else
	   	return false;
	}

}
if (! function_exists('isPackValid')) {
	function isPackValid($uid,$pack_id)
	{
       $CI = get_instance();
	  $q=$CI->db->order_by('id','DESC')->get_where('user_package',['user_id'=>$uid,'package_id'=>$pack_id]);
	  if($q->num_rows()>0)
	  {
	     $tday_date=date("Y-m-d");
	     $end_date=$q->row()->package_end;
	     $diff=strtotime($end_date)-strtotime($tday_date);
	     if($diff>0)
	     {
             return true;
	     }
	    else
	    	return false;
	  }
	   else
	   	return false;
	}

}