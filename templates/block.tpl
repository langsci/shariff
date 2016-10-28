{**
 * plugins/generic/shariff/templates/block.tpl
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Feed plugin navigation sidebar.
 *
 *}
<div class="pkp_block block_web_feed">
	<!--<span class="title">{translate key="plugins.generic.shariff.newcontent"}</span>-->
	<div class="content">
	
		<div class="shariff" data-lang="en"
		data-services='["facebook","twitter","googleplus","info"]'  
		data-theme="grey" 
		data-url="{$baseUrl}"
		data-orientation="vertical">
		</div>
	
		<!--<ul>		
			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="gateway" op="plugin" path="shariffGatewayPlugin"|to_array:"atom"}">
					<img src="{$baseUrl}/plugins/generic/shariff/templates/images/atom10_logo.gif" alt="{translate key="plugins.generic.shariff.atom.altText"}">
				</a>
			</li>
			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="gateway" op="plugin" path="shariffGatewayPlugin"|to_array:"rss2"}">
					<img src="{$baseUrl}/plugins/generic/shariff/templates/images/rss20_logo.gif" alt="{translate key="plugins.generic.shariff.rss2.altText"}">
				</a>
			</li>
			<li>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="gateway" op="plugin" path="shariffGatewayPlugin"|to_array:"rss"}">
					<img src="{$baseUrl}/plugins/generic/shariff/templates/images/rss10_logo.gif" alt="{translate key="plugins.generic.shariff.rss1.altText"}">
				</a>
			</li>
		</ul>-->
	</div>
</div>
