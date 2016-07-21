<h3>Add New Advertiser</h3>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-5">
					<form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
						 <input type="hidden" name="action" value="wpse10500" />
						<p><label>Company Name :</label>
						<input type="text" name="comp_name" class="form-control"/>
					</p>
						<p><label>Email :</label><input name="comp_email" type="text" class="form-control"/></p>
						<p><label>Contact Number :</label><input name="comp_number" type="text" class="form-control"/></p>
						<p><button type="submit" name="add-advertiser" class="btn btn-primary form-control" > Save</button></p>
					</form>
				</div>
				<div class="col-md-7">
					<table class="table">
						<tr>
							<th>Advertisers</th>
						</tr>
						<?php if($advertisers):?>
						<?php foreach($advertisers as $advertiser):?>
							<tr>
								<td>
										<?php echo $advertiser->name;?><br />
										<small><?php echo $advertiser->contact_number;?><br />
										<?php echo $advertiser->email;?></small>
								</td>
								
							</tr>
						<?php endforeach;?>
					<?php endif;?>
					</table>
				</div>
		</div>
	