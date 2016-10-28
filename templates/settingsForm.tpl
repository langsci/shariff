{**
 * plugins/generic/shariff/templates/settingsForm.tpl
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Web feeds plugin settings
 *
 *}
<div id="shariffSettings">
<!--<div id="description">{translate key="plugins.generic.shariff.description"}</div>-->

<h3>{translate key="plugins.generic.shariff.settings"}</h3>

<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#shariffSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="shariffSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="shariffSettingsFormNotification"}

	{fbvFormArea id="myText" class="border" title="plugins.generic.shariff.settings.title"}
		{* Choose social media services *}
		{fbvFormSection list="true"}
			<p class="pkp_help"></p> 
			
			{fbvElement type="checkbox" name="facebook" id="facebook" label="plugins.generic.shariff.form.facebook" checked=$facebook content=$content inline=true}
		
			{fbvElement type="checkbox" name="twitter" id="twitter" label="plugins.generic.shariff.form.twitter" checked=$twitter content=$content inline=true}
		
			{fbvElement type="checkbox" id="googleplus" label="plugins.generic.shariff.form.googleplus" checked=$googleplus content=$content inline=true}
			
			{fbvElement type="checkbox" id="info" label="plugins.generic.shariff.form.info" checked=$info content=$content inline=true}
			
		{/fbvFormSection}
		
		{* Choose Language *}
		{fbvFormSection label="plugins.generic.shariff.settings.language"}
			
			{fbvElement type="select"  id="selectedLanguage" from=$languages selected=$selectedLanguage size=$fbvStyles.size.MEDIUM}
		
		{/fbvFormSection}
		
		{* Choose theme *}
		{fbvFormSection label="plugins.generic.shariff.settings.theme" }
	
			{fbvElement type="select" id="selectedTheme" from=$themes selected=$selectedTheme size=$fbvStyles.size.MEDIUM}
			
		{/fbvFormSection}
		
		{* Add backend url *}
		{fbvFormSection label="plugins.generic.shariff.settings.backend"}
			<p class="pkp_help">{translate key="plugins.generic.shariff.settings.backend.info"}</p> 
			
			{fbvElement type="text" id="backend" value=$backend maxlength="100" size=$fbvStyles.size.MEDIUM}
			
		{/fbvFormSection}
	
	{/fbvFormArea}
	
	<!--
	{fbvFormArea id="shariffSettingsFormArea"}
		{fbvFormSection list=true}
			{fbvElement type="radio" id="displayPage-all" name="displayPage" value="all" checked=$displayPage|compare:"all" label="plugins.generic.shariff.settings.all"}
			{fbvElement type="radio" id="displayPage-homepage" name="displayPage" value="homepage" checked=$displayPage|compare:"homepage" label="plugins.generic.shariff.settings.homepage"}
		{/fbvFormSection}

		{fbvFormSection list=true}
			{fbvElement type="text" id="recentItems" value=$recentItems label="plugins.generic.shariff.settings.recentBooks" size=$fbvStyles.size.SMALL}
		{/fbvFormSection}
	{/fbvFormArea}
	-->
	
	{fbvFormButtons}
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</div>
