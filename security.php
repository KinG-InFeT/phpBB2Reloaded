<?php
/***************************************************************************
 *                               security.php
 *                            -------------------
 *   begin                : Lunedì, Nov. 01 2010
 *   copyright            : (C) 2010 By KinG-InFeT
 *   email                : info@kinginfet.net
 *
 ***************************************************************************/
 
/***************************************************************************
 *
 * phpBB2 v2.0.23 Reload Version
 * @author KinG-InFeT
 * @project site http://salviamophpbb2.webnet32.com/
 *
 ***************************************************************************/
 
 if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function csrf_attemp() {
	@$post = join($_POST);
	if(@$post != "" && $_SERVER['HTTP_REFERER'] != "") {
	  	if(preg_match("/www\./i",$_SERVER['HTTP_HOST'])) {
       		$exp  = explode("www.",$_SERVER['HTTP_HOST']);
        	$host = $exp[1];
        }else{
        	$host = $_SERVER['HTTP_HOST'];
        }
                        
        if(!preg_match('/(http|https):\/\/(www\.)?'.$host.'/i',$_SERVER['HTTP_REFERER']) 
        && !preg_match('/(http|https):\/\/'.$_SERVER['SERVER_ADDR'].'/i',$_SERVER['HTTP_REFERER'])) 
        {
           	die("CSRF Attemp");
		}
	}
}
?>
