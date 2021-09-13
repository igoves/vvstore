<table border="0" cellpadding="5" cellspacing="0" height="100%" width="100%" style="background: #fff; padding: 3px; color: #000000; border: 1px solid #cccccc; border-collapse: collapse;">
	<thead>
		<tr style="border-bottom:1px solid #ccc;">
			<th>№</th>
			<th>Фото</th>
			<th>Название</th>
			<th>К-во</th>
			<th>Цена</th>
			<th>Всего</th>
		</tr>
	</thead>
	<tbody>
		{list}
		<tr style="font-size:24px">
			<td colspan="5" style="text-align:right">
				Всего к оплате:
			</td>
			<td style="border-top: 1px solid #cccccc; text-align:right;">
				{total_cost} {cur}
			</td>
		</tr>
		{noty}
	</tbody>
</table>
