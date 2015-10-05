{**
 * templates/shariffBlock.tpl
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Shariff social media buttons block.
 *}
<div class="block plugins_generic_shariff" id="shariff">
<div class="shariff" data-lang="{$iso1Lang|escape}"
		data-services="[{$dataServicesString|escape}]"
		data-backend-url="{$backendUrl|escape}"
		data-theme="{$selectedTheme|escape}"
		data-orientation="{$smarty.const.SHARIFF_ORIENTATION_V}"
		data-url="{$requestedUrl|escape}">
		</div>
		<script src="{$jsUrl|escape}"></script>
</div>
</div>
