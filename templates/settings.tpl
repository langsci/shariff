{**
 * templates/settings.tpl
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * The basic setting tab for the Shariff plugin.
 *}

<script src="{$baseUrl}/{$pluginJavaScriptPath}/ShariffSettingsFormHandler.js"></script>
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#shariffPluginSettingsForm').pkpHandler('$.pkp.plugins.generic.shariff.ShariffSettingsFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="shariffPluginSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="plugin" category="generic" plugin=$pluginName verb="settings" tab="basic" save="true"}">
	{include file="common/formErrors.tpl"}

	{fbvFormArea id="shariffPluginSettings" class="border" title="plugins.generic.shariff.settings.title"}

		{* Choose social media services *}
		{fbvFormSection list="true" label="plugins.generic.shariff.settings.services" }
		<table>
		<tbody>
			{foreach from=$services item=service name=services}
				{foreach from=$service key=id item=title}
					{if in_array($id, $selectedServices)}
						{assign var="checked" value=true}
					{else}
						{assign var="checked" value=false}
					{/if}
					<tr>
					<td>
						{fbvElement type="checkbox" name="selectedServices[]" id=$id value=$id label=$title checked=$checked}
						<input type="hidden" name="services[][{$id|escape}]" value="{$title|escape}" />
					</td>
					</tr>
				{/foreach}
			{/foreach}
		</tbody>
		</table>
		{/fbvFormSection}

		{* Choose theme *}
		{fbvFormSection label="plugins.generic.shariff.settings.theme" }
			{fbvElement type="select" id="selectedTheme" from=$themes selected=$selectedTheme size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{* Choose orientation *}
		{fbvFormSection label="plugins.generic.shariff.settings.orientation" }
			{fbvElement type="select" id="selectedOrientation" from=$orientations  selected=$selectedOrientation size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{* Choose button position on the press web site *}
		{assign var="footerValue" value=$smarty.const.SHARIFF_POSITION_FOOTER}
		{assign var="blockValue" value=$smarty.const.SHARIFF_POSITION_BLOCK}
		{assign var="bookValue" value=$smarty.const.SHARIFF_POSITION_BOOKSHARETAB}
		{if $position eq $smarty.const.SHARIFF_POSITION_FOOTER}
			{assign var="footerChecked" value=true}
		{/if}
		{if $position eq $smarty.const.SHARIFF_POSITION_BLOCK}
			{assign var="blockChecked" value=true}
		{/if}
		{if $position eq $smarty.const.SHARIFF_POSITION_BOOKSHARETAB}
			{assign var="bookChecked" value=true}
		{/if}
		{fbvFormSection list="true" label="plugins.generic.shariff.settings.buttonsPosition" }
			{fbvElement type="radio" id="position-$footerValue" name="position" required="true" value=$footerValue checked=$footerChecked label="plugins.generic.shariff.settings.buttonsPosition.footer"}
			{fbvElement type="radio" id="position-$blockValue" name="position" required="true" value=$blockValue checked=$blockChecked label="plugins.generic.shariff.settings.buttonsPosition.block"}
			{fbvElement type="radio" id="position-$bookValue" name="position" required="true" value=$bookValue checked=$bookChecked label="plugins.generic.shariff.settings.buttonsPosition.bookView"}
		{/fbvFormSection}

		{* Add backend url *}
		{fbvFormSection label="plugins.generic.shariff.settings.backend"}
			<p class="pkp_help">{translate key="plugins.generic.shariff.settings.backend.info"}</p>
			{fbvElement type="text" id="backendUrl" value=$backendUrl maxlength="100" size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

	{/fbvFormArea}

	{fbvFormButtons submitText="common.save"}

</form>

