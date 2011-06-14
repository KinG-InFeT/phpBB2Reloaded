<div class="maintitle">{L_AUTH_TITLE}</div>
<br />
<div class="subtitle">{L_USER_OR_GROUPNAME}: {USERNAME}</div>
<br />
<form method="post" action="{S_AUTH_ACTION}">

<!-- BEGIN switch_user_auth -->
<p>{USER_CAL_LEVEL}</p>	<!-- MOD Calendar -->
{USER_LEVEL}<br />
<br />
{USER_GROUP_MEMBERSHIPS}<br />
<!-- END switch_user_auth -->

<!-- BEGIN switch_group_auth -->
<p>{USER_CAL_LEVEL}</p>	<!-- MOD Calendar -->
{GROUP_MEMBERSHIP}<br />
<!-- END switch_group_auth -->

<div class="subtitle">{L_PERMISSIONS}</div>

<div class="genmed">{L_AUTH_EXPLAIN}</div>
<br />
  
<table cellspacing="1" cellpadding="3" border="0" align="center" class="forumline">
<tr> 
<th width="30%">{L_FORUM}</th>
<!-- BEGIN acltype -->
<th>{acltype.L_UG_ACL_TYPE}</th>
<!-- END acltype -->
<th>{L_MODERATOR_STATUS}</th>
</tr>
<!-- BEGIN forums -->
<tr> 
<td class="{forums.ROW_CLASS}" align="center">{forums.FORUM_NAME}</td>
<!-- BEGIN aclvalues -->
<td class="{forums.ROW_CLASS}" align="center">{forums.aclvalues.S_ACL_SELECT}</td>
<!-- END aclvalues -->
<td class="{forums.ROW_CLASS}" align="center">{forums.S_MOD_SELECT}</td>
</tr>
<!-- END forums -->
<tr> 
<td colspan="{S_COLUMN_SPAN}" class="row1" align="center"><span class="gensmall">{U_SWITCH_MODE}</span></td>
</tr>
<tr> 
<td colspan="{S_COLUMN_SPAN}" class="cat" align="center">{S_HIDDEN_FIELDS} 
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" class="button" name="reset" />
</td>
</tr>
</table>
</form>
