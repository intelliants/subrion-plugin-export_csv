<form method="post" action="{$smarty.const.IA_SELF}" enctype="multipart/form-data" class="sap-form form-horizontal">
	{preventCsrf}

	<div class="wrap-list">
		<div class="wrap-group">
			<div class="wrap-group-heading">
				<h4>{lang key='options'}</h4>
			</div>

			{*
			<div class="row">
				<label class="col col-lg-2 control-label">{lang key='save_to_server'}</label>

				<div class="col col-lg-4">
					{html_radio_switcher value=$smarty.post.attachment name='attachment'}
				</div>
			</div>
			*}

			<div class="row">
				<label class="col col-lg-2 control-label" for="input-items">{lang key='available_items'}</label>
				<div class="col col-lg-2">
					<select name="items" id="input-items">
						<option value="">{lang key='_select_'}</option>
							{foreach $items_list as $one_item}
								<option value="{$one_item}" {if isset($smarty.post.items) && $smarty.post.items == $one_item}selected="selected"{/if}>{lang key=$one_item}</option>
							{/foreach}
					</select>
				</div>

				<button id="getFields" class="btn btn-primary">{lang key='getfields'}</button>
			</div>

			<div class="row">
				<label class="col col-lg-2 control-label" for="input-delimiter">{lang key='delimiter'}</label>
				<div class="col col-lg-1">
					<input type="text" name="delimeter" id="input-delimiter" maxlength="1" value="{if isset($smarty.post.delimeter)}{$smarty.post.delimeter|htmlentities}{else},{/if}">
				</div>
			</div>

			<div class="row">
				<label class="col col-lg-2 control-label" for="input-enclosure">{lang key='enclosure'}</label>
				<div class="col col-lg-1">
					<input type="text" name="enclosure" id="input-enclosure" maxlength="1" value="{if isset($smarty.post.enclosure)}{$smarty.post.enclosure|htmlentities}{else}&#34;{/if}">
				</div>
			</div>

			<div class="row">
				<label class="col col-lg-2 control-label" for="input-start">{lang key='start_from'}</label>
				<div class="col col-lg-1">
					<input type="text" name="start" size="5" id="input-start" value="{if isset($smarty.post.start)}{$smarty.post.start}{else}0{/if}">
				</div>
			</div>

			<div class="row">
				<label class="col col-lg-2 control-label" for="input-limit">{lang key='limit'}</label>
				<div class="col col-lg-1">
					<input type="text" name="limit" size="5" id="input-limit" value="{if isset($smarty.post.limit)}{$smarty.post.limit}{else}1000{/if}">
				</div>
			</div>

			<div class="row " id="fieldsListBox" style="display:none;">
				<label class="col col-lg-2 control-label" for="input-fields">{lang key='items_fields'}</label>

				<div class="col col-lg-3" id="fieldsList">
					<div class="box-simple fieldset"></div>
					<a href="#" class="label label-default pull-right" id="toggle-pages"><i class="i-lightning"></i> {lang key='select_all'}</a>
				</div>
			</div>
		</div>

		<div class="form-actions inline">
			<input type="hidden" id="tableName" name="tableName" value="">
			<input type="submit" name="download" class="btn btn-primary" value="{lang key='generate'}">
		</div>
	</div>
</form>

{ia_print_js files='_IA_URL_plugins/export_csv/js/admin/index'}