<table id="external_link" class="form-table sell-media-item-table">
	<tr>
		<th><label>Not for sale</label></th>
		<td>
			<input id="external_media_disabled_sale" name="external_media_disabled_sale" type="checkbox" value="1" <?php checked( '1', $not_for_sale ); ?> /> item not for sale
		</td>
	</tr>
	<tr>
		<th><label>External sales link</label></th>
		<td>
			<input id="external_media_sales_link" name="external_media_sales_link" type="text" value="<?php echo $sale_link; ?>" size="120"/>
		</td>
	</tr>
</table>	