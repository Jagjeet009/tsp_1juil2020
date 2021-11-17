<?php
$section_style=(array) json_decode($section[0]['style']);
//print_r($section_style);
if(!(sizeof($section_style)>0)){
	$section_style=array(
		"section_font_size"=> "25",
		"section_font_color"=> "#000000",
		"section_background"=> "#ffffff",
		"section_align"=> "left",
		"section_font_weight"=> "normal",
		"section_font_style"=> "normal",
		"section_text_transform"=> "",
		"section_text_decoration"=> "none",
		"section_border_color"=> "#000000",
		"section_border_style"=>"none",
		"section_border_top"=> "0",
		"section_border_right"=> "0",
		"section_border_bottom"=> "0",
		"section_border_left"=> "0",
		"section_margin_top"=> "0",
		"section_margin_right"=> "0",
		"section_margin_bottom"=> "0",
		"section_margin_left"=> "0",
		"section_padding_top"=> "0",
		"section_padding_right"=> "0",
		"section_padding_bottom"=> "0",
		"section_padding_left"=> "0"	
	);
}
?>
<form method="post" name="section_style" id="section_style" action="<?php echo base_url()."survey/section/style/save/".$section[0]['title_url']; ?>">
	<div class="tablespace row">
		<div class="col-lg-6">
			<table border="0">
				<tr>
					<td><label>Font Size</label></td>
					<td>
						<select name="section_font_size" class="form-control">
							<option value="">Select</option>
							<?php for($i=10;$i<=50;$i++){?>
							<option <?php if(isset($section_style['section_font_size']) && $section_style['section_font_size']==$i){echo "selected";}?> value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Font Color</label></td>
					<td><input type="text" name="section_font_color" value="<?php if(isset($section_style['section_font_color']) && $section_style['section_font_color']!=''){echo $section_style['section_font_color'];}?>" class="form-control jscolor" /></td>
				</tr>
				<tr>
					<td><label>Background Color</label></td>
					<td><input type="text" name="section_background" value="<?php if(isset($section_style['section_background']) && $section_style['section_background']!=''){echo $section_style['section_background'];}?>" class="form-control jscolor" /></td>
				</tr>
				<tr>
					<td><label>Align</label></td>
					<td>
						<select name="section_align" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_align']) && $section_style['section_align']=="left"){echo "selected";} ?> value="left">Left</option>
							<option <?php if(isset($section_style['section_align']) && $section_style['section_align']=="center"){echo "selected";} ?> value="center">Center</option>
							<option <?php if(isset($section_style['section_align']) && $section_style['section_align']=="right"){echo "selected";} ?> value="right">Right</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Font Weight</label></td>
					<td>
						<select name="section_font_weight" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="normal"){echo "selected";} ?> value="normal">Normal</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="bold"){echo "selected";} ?> value="bold">Bold</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="bolder"){echo "selected";} ?> value="bolder">Bolder</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="lighter"){echo "selected";} ?> value="lighter">Lighter</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="100"){echo "selected";} ?> value="100">100</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="200"){echo "selected";} ?> value="200">200</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="300"){echo "selected";} ?> value="300">300</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="400"){echo "selected";} ?> value="400">400</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="500"){echo "selected";} ?> value="500">500</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="600"){echo "selected";} ?> value="600">600</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="700"){echo "selected";} ?> value="700">700</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="800"){echo "selected";} ?> value="800">800</option>
							<option <?php if(isset($section_style['section_font_weight']) && $section_style['section_font_weight']=="900"){echo "selected";} ?> value="900">900</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Font Style</label></td>
					<td>
						<select name="section_font_style" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_font_style']) && $section_style['section_font_style']=="normal"){echo "selected";} ?> value="normal">Normal</option>
							<option <?php if(isset($section_style['section_font_style']) && $section_style['section_font_style']=="italic"){echo "selected";} ?> value="italic">Italic</option>
							<option <?php if(isset($section_style['section_font_style']) && $section_style['section_font_style']=="oblique"){echo "selected";} ?> value="oblique">Oblique</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Text Transform</label></td>
					<td>
						<select name="section_text_transform" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_text_transform']) && $section_style['section_text_transform']=="uppercase"){echo "selected";} ?> value="uppercase">Uppercase</option>
							<option <?php if(isset($section_style['section_text_transform']) && $section_style['section_text_transform']=="lowercase"){echo "selected";} ?> value="lowercase">Lowercase</option>
							<option <?php if(isset($section_style['section_text_transform']) && $section_style['section_text_transform']=="capitalize"){echo "selected";} ?> value="capitalize">Capitalize</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label>Text Decoration</label></td>
					<td>
						<select name="section_text_decoration" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_text_decoration']) && $section_style['section_text_decoration']=="none"){echo "selected";} ?> value="none">None</option>
							<option <?php if(isset($section_style['section_text_decoration']) && $section_style['section_text_decoration']=="underline"){echo "selected";} ?> value="underline">Underline</option>
							<option <?php if(isset($section_style['section_text_decoration']) && $section_style['section_text_decoration']=="overline"){echo "selected";} ?> value="overline">Overline</option>
							<option <?php if(isset($section_style['section_text_decoration']) && $section_style['section_text_decoration']=="line-through"){echo "selected";} ?> value="line-through">Line Through</option>
						</select>
					</td>
				</tr>								
				<tr>
					<td><label>Border Color</label></td>
					<td><input type="text" name="section_border_color" value="<?php if(isset($section_style['section_border_color']) && $section_style['section_border_color']!=''){echo $section_style['section_border_color'];}?>" class="jscolor" /></td>
				</tr>   
				<tr>
					<td><label>Border Style</label></td>
					<td>
						<select name="section_border_style" class="form-control">
							<option value="">Select</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="none"){echo "selected";} ?> value="none">None</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="dotted"){echo "selected";} ?> value="dotted">Dotted</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="dashed"){echo "selected";} ?> value="dashed">Dashed</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="solid"){echo "selected";} ?> value="solid">Solid</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="double"){echo "selected";} ?> value="double">Double</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="groove"){echo "selected";} ?> value="groove">Groove</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="ridge"){echo "selected";} ?> value="ridge">Ridge</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="inset"){echo "selected";} ?> value="inset">Inset</option>
							<option <?php if(isset($section_style['section_border_style']) && $section_style['section_border_style']=="outset"){echo "selected";} ?> value="outset">Outset</option>
						</select>
					</td>
				</tr>				 			
			</table>
			<input type="submit" class="style-save-button" value="Save" />
		</div>
		<div class="col-lg-6">
			<table border="0">		
				<tr>
				  <td style="vertical-align:middle;">Border</td>
				  <td><table border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td align="center">Top</td>
						<td align="center">Right</td>
						<td align="center">Bottom</td>
						<td align="center">Left</td>
					  </tr>
					  <tr>
						<td><input class="thickness form-control" type="text" name="section_border_top" value="<?php if(isset($section_style['section_border_top']) && $section_style['section_border_top']!=''){echo $section_style['section_border_top'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_border_right" value="<?php if(isset($section_style['section_border_right']) && $section_style['section_border_right']!=''){echo $section_style['section_border_right'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_border_bottom" value="<?php if(isset($section_style['section_border_bottom']) && $section_style['section_border_bottom']!=''){echo $section_style['section_border_bottom'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_border_left" value="<?php if(isset($section_style['section_border_left']) && $section_style['section_border_left']!=''){echo $section_style['section_border_left'];}?>" /></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>
				<tr>
				  <td style="vertical-align:middle;">Margin</td>
				  <td><table border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td align="center">Top</td>
						<td align="center">Right</td>
						<td align="center">Bottom</td>
						<td align="center">Left</td>
					  </tr>
					  <tr>
						<td><input class="thickness form-control" type="text" name="section_margin_top" value="<?php if(isset($section_style['section_margin_top']) && $section_style['section_margin_top']!=''){echo $section_style['section_margin_top'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_margin_right" value="<?php if(isset($section_style['section_margin_right']) && $section_style['section_margin_right']!=''){echo $section_style['section_margin_right'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_margin_bottom" value="<?php if(isset($section_style['section_margin_bottom']) && $section_style['section_margin_bottom']!=''){echo $section_style['section_margin_bottom'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_margin_left" value="<?php if(isset($section_style['section_margin_left']) && $section_style['section_margin_left']!=''){echo $section_style['section_margin_left'];}?>" /></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>
				<tr>
				  <td style="vertical-align:middle;">Padding</td>
				  <td><table border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td align="center">Top</td>
						<td align="center">Right</td>
						<td align="center">Bottom</td>
						<td align="center">Left</td>
					  </tr>
					  <tr>
						<td><input class="thickness form-control" type="text" name="section_padding_top" value="<?php if(isset($section_style['section_padding_top']) && $section_style['section_padding_top']!=''){echo $section_style['section_padding_top'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_padding_right" value="<?php if(isset($section_style['section_padding_right']) && $section_style['section_padding_right']!=''){echo $section_style['section_padding_right'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_padding_bottom" value="<?php if(isset($section_style['section_padding_bottom']) && $section_style['section_padding_bottom']!=''){echo $section_style['section_padding_bottom'];}?>" /></td>
						<td><input class="thickness form-control" type="text" name="section_padding_left" value="<?php if(isset($section_style['section_padding_left']) && $section_style['section_padding_left']!=''){echo $section_style['section_padding_left'];}?>" /></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>   																											    			
			</table>
	  </div>
	</div>
</form>