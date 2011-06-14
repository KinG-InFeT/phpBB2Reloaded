<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'config.'.$phpEx);

$ref = htmlentities($_SERVER['HTTP_REFERER']);

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
// End session management

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_topic_data);

if ( !$userdata['session_logged_in'] )
{
        message_die(GENERAL_MESSAGE,"Attenzione - Devi essere loggato per poter inserire un voto");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
}

//
// End auth check
//

$key = "00";
$uid = crypt($userdata['user_id'],$key);

$voted = mysql_real_escape_string(htmlspecialchars($_GET['voted']));
$voter = mysql_real_escape_string($_GET['voter']);
$vote  = htmlentities($_GET['vote']);

if ($voter == "00T4VBLgHKsI2")  {
        message_die(GENERAL_MESSAGE,"Attenzione - Devi essere loggato per poter inserire un voto");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if (strcmp($uid,$voter))  {
        message_die(GENERAL_MESSAGE,"Errore - ID votante e ID di sessione non coincidono");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if (crypt($voted,$key) == $voter)  {
        message_die(GENERAL_MESSAGE,"Errore - Non puoi votarti da solo");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if (strcmp(intval($voted),$voted))  {
	message_die(GENERAL_MESSAGE,"Errore - Utente votato non valido".
		'<br><meta http-equiv="Refresh" content="3;url='.$ref.'">');
	die();
}

if (!($db=mysql_connect($dbhost,$dbuser,$dbpass)))  {
        message_die(GENERAL_MESSAGE,"Errore di connessione al database - Impossibile inserire il voto\n");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if (!mysql_select_db($dbname,$db))  {
        message_die(GENERAL_MESSAGE,"Errore di connessione al database - Impossibile inserire il voto\n");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if ($vote === "plus")
        $update = "UPDATE ".$table_prefix."users SET user_karma=user_karma+1 WHERE user_id='{$voted}'";
elseif ($vote === "minus")
        $update = "UPDATE ".$table_prefix."users SET user_karma=user_karma-1 WHERE user_id='{$voted}'";
else  {
        message_die(GENERAL_MESSAGE,"Errore - Modalit&agrave; di voto non valida\n");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

$query = "INSERT INTO ".$table_prefix."karma (voted,voter) values ('{$voted}','{$voter}')";

if (!mysql_query($query))  {
        message_die(GENERAL_MESSAGE,"Errore nell' inserimento del voto (forse hai gi&agrave; votato quest' utente?)\n");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

if (!mysql_query($update))  {
        message_die(GENERAL_MESSAGE,"Errore nell'inserimento del voto\n");
        print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
        die();
}

message_die(GENERAL_MESSAGE,"Voto inserito con successo!\n");
print '<meta http-equiv="Refresh" content="3;url='.$ref.'">';
mysql_close($db);
?>
