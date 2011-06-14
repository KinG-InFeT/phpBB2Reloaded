<p align="center"><a href="portale.php" class="nav">[ Portal ]</a></p>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td valign="bottom" class="gensmall">
<!-- BEGIN switch_user_logged_in -->
{LAST_VISIT_DATE}<br />
<!-- END switch_user_logged_in -->
{CURRENT_TIME}<br />
<a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
<td align="right" valign="bottom" class="gensmall">
<a href="{U_SEARCH_UNANSWERED}">{L_SEARCH_UNANSWERED}</a><br />
<!-- BEGIN switch_user_logged_in -->
<a href="{U_SEARCH_NEW}">{L_SEARCH_NEW}</a><br />
<a href="{U_MARK_READ}"><strong>{L_MARK_FORUMS_READ}</strong></a>
<!-- END switch_user_logged_in -->
</td>
</tr>
</table>
<!-- BEGIN catrow -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<tr>
<td class="cat" colspan="6"><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></td>
</tr>
<tr>
<th colspan="2">{L_FORUM}</th>
<th>{L_TOPICS}</th>
<th>{L_POSTS}</th>
<th>{L_LASTPOST}</th>
</tr>
<!-- BEGIN forumrow -->
<tr>
<td class="row1" height="45"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
<td class="row1" width="100%"><a href="{catrow.forumrow.U_VIEWFORUM}" class="nav">{catrow.forumrow.FORUM_NAME}</a><br />
<span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
</span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
<td class="row2" align="center"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
<td class="row2" align="center"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
<td class="row2" align="center" nowrap="nowrap"><span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
</tr>
<!-- END forumrow -->
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td></td></tr></table>
<br />
<!-- END catrow -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<tr>
<td class="cat" colspan="2"><a href="{U_VIEWONLINE}">{L_WHO_IS_ONLINE}</a></td>
</tr>
<tr>
<td class="row1" rowspan="3"><img src="templates/DarkBlack/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" width="49" height="48" class="imgfolder" title="{L_WHO_IS_ONLINE}" />
</td>
<td class="row1" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />
{TOTAL_USERS}<br />
{NEWEST_USER}</span></td>
</tr>
<tr>
<td class="row1"><span class="gensmall">{TOTAL_USERS_ONLINE}   [ <strong>{L_WHOSONLINE_ADMIN}</strong> 
]   [ <strong>{L_WHOSONLINE_MOD}</strong> ]<br />
{RECORD_USERS}<br />
{LOGGED_IN_USER_LIST}</span></td>
</tr>
<tr>
<td height="20" class="row1"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>
<!-- BEGIN switch_user_logged_out -->
<br />
<form method="post" action="{S_LOGIN_ACTION}">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr>
<td class="cat">{L_LOGIN_LOGOUT}</td>
</tr>
<tr>
<td class="row1" align="center">
<table border="0" cellspacing="0" cellpadding="2">
<tr> 
<td class="gensmall">{L_USERNAME}: </td>
<td><input class="post" type="text" name="username" size="10" /></td>
<td class="gensmall">   {L_PASSWORD}:</td>
<td><input class="post" type="password" name="password" size="10" maxlength="32" /></td>
<td class="gensmall">   {L_AUTO_LOGIN}</td>
<td><input class="text" type="checkbox" name="autologin" /></td>
<td>  <input type="submit" class="mainoption" name="login" value="{L_LOGIN}" /></td>
</tr>
</table></td>
</tr>
</table>
</form>
<!-- END switch_user_logged_out -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td class="nav"><a href="{U_INDEX}">{L_INDEX}</a></td>
</tr>
</table>
<br />
<table border="0" align="center" cellpadding="0" cellspacing="3">
<tr>
<td><img src="{FORUM_NEW_IMG}" alt="{L_NEW_POSTS}" title="{L_NEW_POSTS}" /></td>
<td class="gensmall">{L_NEW_POSTS}</td>
<td>&nbsp;</td>
<td><img src="{FORUM_IMG}" alt="{L_NO_NEW_POSTS}" title="{L_NO_NEW_POSTS}" /></td>
<td class="gensmall">{L_NO_NEW_POSTS}</td>
<td>&nbsp;</td>
<td><img src="{FORUM_LOCKED_IMG}" alt="{L_FORUM_LOCKED}" title="{L_FORUM_LOCKED}" /></td>
<td class="gensmall">{L_FORUM_LOCKED}</td>
</tr>
</table>
