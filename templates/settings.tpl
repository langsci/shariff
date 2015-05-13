{**
 * plugins/generic/shariff/settings.tpl
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * The basic setting tab for the Shariff plugin.
 *}


<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#shariffPluginSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>


<form class="pkp_form" id="shariffPluginSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="plugin" category="generic" plugin=$pluginName verb="settings" tab="basic" save="true"}">

	<input type="hidden" name="tab" value="settings" />

	{fbvFormArea id="myText" class="border" title="plugins.generic.shariff.settings.title"}
	
		{* Choose social media services *}
		{fbvFormSection list="true"}
			<p class="pkp_help"></p> 
			
			{fbvElement type="checkbox" name="facebook" id="facebook" label="plugins.generic.shariff.form.facebook" checked=$facebook content=$content inline=true}
		
			{fbvElement type="checkbox" name="twitter" id="twitter" label="plugins.generic.shariff.form.twitter" checked=$twitter content=$content inline=true}
		
			{fbvElement type="checkbox" id="googleplus" label="plugins.generic.shariff.form.googleplus" checked=$googleplus content=$content inline=true}
			
		{*	{fbvElement type="checkbox" id="mail" label="plugins.generic.shariff.form.mail" checked=$mail content=$content inline=true} *}
			
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
		
		{* Choose orientation 
		{fbvFormSection list="true" label="plugins.generic.shariff.settings.orientation"}
			
			{fbvElement type="radio" name="orientation" id="horizontal" label="plugins.generic.shariff.form.orientation.horizontal" checked=$horizontal content=$content inline=true}
			{fbvElement type="radio" name="orientation" id="vertical" label="plugins.generic.shariff.form.orientation.vertical" checked=$vertical content=$content inline=true}
			
		{/fbvFormSection}
		*}
		
		{* Add backend url *}
		{fbvFormSection label="plugins.generic.shariff.settings.backend"}
			<p class="pkp_help">{translate key="plugins.generic.shariff.settings.backend.info"}</p> 
			
			{fbvElement type="text" id="backend" value=$backend maxlength="100" size=$fbvStyles.size.MEDIUM}
			
		{/fbvFormSection}
		
		
	{/fbvFormArea}
	
	{fbvFormButtons submitText="common.save"}

</form>

