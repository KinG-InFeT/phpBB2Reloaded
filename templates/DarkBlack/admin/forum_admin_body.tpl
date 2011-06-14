<div class="maintitle">{L_FORUM_TITLE}</div>
<br />
<div class="genmed">{L_FORUM_EXPLAIN}</div>
<br />
<form method="post" action="{S_FORUM_ACTION}">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
<th colspan="7">{L_FORUM_TITLE}</th>
</tr>
<!-- BEGIN catrow -->
<tr> 
<td class="cat" colspan="3"><a href="{catrow.U_VIEWCAT}">{catrow.CAT_DESC}</a></td>
<td class="cat" align="center"><a href="{catrow.U_CAT_EDIT}">{L_EDIT}</a></td>
<td class="cat" align="center"><a href="{catrow.U_CAT_DELETE}">{L_DELETE}</a></td>
<td class="cat" align="center" nowrap="nowrap"><a href="{catrow.U_CAT_MOVE_UP}">{L_MOVE_UP}</a> 
<a href="{catrow.U_CAT_MOVE_DOWN}">{L_MOVE_DOWN}</a></td>
<td class="cat">&nbsp;</td>
</tr>
<!-- BEGIN forumrow -->
<tr> 
<td class="row2"><a href="{catrow.forumrow.U_VIEWFORUM}" target="_new">{catrow.forumrow.FORUM_NAME}</a><br />
<span class="gensmall">{catrow.forumrow.FORUM_DESC}</span></td>
<td class="row1" align="center">{catrow.forumrow.NUM_TOPICS}</td>
<td class="row2" align="center">{catrow.forumrow.NUM_POSTS}</td>
<td class="row1" align="center"><a href="{catrow.forumrow.U_FORUM_EDIT}">{L_EDIT}</a></td>
<td class="row2" align="center"><a href="{catrow.forumrow.U_FORUM_DELETE}">{L_DELETE}</a></td>
<td class="row1" align="center"><a href="{catrow.forumrow.U_FORUM_MOVE_UP}">{L_MOVE_UP}</a> 
<br />
<a href="{catrow.forumrow.U_FORUM_MOVE_DOWN}">{L_MOVE_DOWN}</a></td>
<td class="row2" align="center"><a href="{catrow.forumrow.U_FORUM_RESYNC}">{L_RESYNC}</a></td>
</tr>
<!-- END forumrow -->
<tr> 
<td colspan="7" class="row2"> 
<input type="text" name="{catrow.S_ADD_FORUM_NAME}" class="post" />
<input type="submit" class="button"  name="{catrow.S_ADD_FORUM_SUBMIT}" value="{L_CREATE_FORUM}" />
</td>
</tr>
<tr> 
<td colspan="7" height="1" class="spacerow"><img src="../images/spacer.gif" alt="" width="1" height="1" /></td>
</tr>
<!-- END catrow -->
<tr> 
<td colspan="7" class="cat"> 
<input type="text" name="categoryname" class="post" />
<input type="submit" class="button"  name="addcategory" value="{L_CREATE_CATEGORY}" />
</td>
</tr>
</table>
</form>
