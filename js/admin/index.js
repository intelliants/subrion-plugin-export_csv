$(document).ready(function()
{
	$('#toggle-pages').data('checked', true).click(function(e)
	{
		e.preventDefault();

		var checked = $(this).data('checked');

		if (checked)
		{
			$(this).html('<i class="i-lightning"></i> ' + _t('select_none'));
			$('input[name="fields[]"]').prop('checked', true);
		}
		else
		{
			$(this).html('<i class="i-lightning"></i> ' + _t('select_all'));
			$('input[name="fields[]"]').prop('checked', false);
		}
		$(this).data('checked', !checked);
	});

	$('#getFields').click(function(e)
	{
		e.preventDefault();

		$.get(intelli.config.admin_url + '/export_csv.json?', {action: 'getFields', item: $('#input-items').val()}, function(data)
		{

			if (data)
			{
				var html = '';

				$(data.fields).each(function(key, value)
				{
					html += '<label class="checkbox" for="field_' + value + '">';
					html += '<input type="checkbox" name="fields[]" id="field_' + value + '" value="' + value + '" /> ' + value + '';
					html += '</label>';
				});

				$('#fieldsListBox').css("display", "block");
				$('#fieldsList .box-simple').html(html);
				$('#tableName').val(data.table);
			}
		});
	});
});