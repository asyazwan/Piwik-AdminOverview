{assign var=showSitesSelection value=false}
{assign var=showPeriodSelection value=false}
{include file="CoreAdminHome/templates/header.tpl"}

{literal}
<style>
div.overview_item {
    margin-bottom: 5px;
}
div.overview_item table {
    margin: 3px 0;
}
#access td, #users td {
	spacing: 0px;
	padding: 2px 5px 5px 4px;
	border: 1px solid #660000;
	width: 100px;
}
#access tr {
	cursor: pointer;
}
</style>
<script>
    $(function(){
        $('#user').ajaxStart(function(){$('#ajaxLoading').show()})
                   .ajaxStop(function(){$('#ajaxLoading').hide()});
    });
    function getUserSites(user) {
        $('.overview_item').show();
        $('#tb tr').remove();
        $.get('index.php?module=AdminOverview&action=getUserSites', {'login' : user}, function(data){
            $('#selectedUser').text(': ' + user);
            $('#tb').append(data);
        });
    }
</script>
{/literal}
<div class="overview_item">
    {'AdminOverview_UserAccessDescription'|translate|sprintf:$usersCount:$sitesCount}
    <table class="admin" id="access">
    <thead>
    <tr>
        <th>{'AdminOverview_User'|translate}</th>
        <th>{'AdminOverview_ViewCount'|translate}</th>
        <th>{'AdminOverview_AdminCount'|translate}</th>
        <th>{'AdminOverview_AccessCount'|translate}</th>
    </tr>
    </thead>

    <tbody>
    {foreach from=$usersAccess key=login item=user}
    <tr onclick="getUserSites('{$login}');">
        <td class='login'>{$login}</td>
        <td class='viewCount'>{$user.view|default:'0'}</td>
        <td class='adminCount'>{$user.admin|default:'0'}</td>
        <td class='accessCount'>{$user.view + $user.admin}</td>
    </tr>
    {/foreach}
    </tbody>
    </table>
</div>
<div class="overview_item" style="display: none;">
    {'AdminOverview_UserSitesDescription'|translate}<span id="selectedUser"></span>
    <table class="admin" id="user">
    <thead>
    <tr>
        <th>{'AdminOverview_Site'|translate}</th>
        <th>{'AdminOverview_Access'|translate}</th>
    </tr>
    </thead>

    <tbody id="tb">
        <tr></tr>
    </tbody>
    </table>
    
    {ajaxLoadingDiv}
    {ajaxRequestErrorDiv}
</div>

{include file="CoreAdminHome/templates/footer.tpl"}
