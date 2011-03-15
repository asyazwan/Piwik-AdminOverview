{foreach from=$userSites item=site}
<tr>
<td>{$site.name}</td>
<td>{$site.access}</td>
</tr>
{/foreach}