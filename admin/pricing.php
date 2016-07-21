<h3>Pricing </h3>
		<div class="container-fluid">

			<div class="row">

				<div class="col-md-6">
					 <table class="table">
				    	<thead>
				      <tr>
				        <th>Package Name</th>
				        <th>Views</th>
				         <th>Price</th>
				      </tr>
				    </thead>
				    <tbody>
				  <?php if($pricing):?>
						<?php foreach($pricing as $data):?>
					      <tr class="info">
					        <td><?php echo $data->name;?></td>
					        <td><?php echo $data->views;?></td>
					        <td><?php echo $data->price;?></td>
					      </tr>	
				     	<?php endforeach;?>
					<?php endif;?>
				    </tbody>
				  </table>
				</div>

				<div class="col-md-6">
						<h4>New Package</h4>
					<form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
							<input type="hidden" name="action" value="wpse10500" />
							<div class="input-group">
  									<span class="input-group-addon" id="basic-addon1">Package Name</span>
  									<input type="text" name="name" class="form-control" placeholder="Package Name" aria-describedby="basic-addon1">
							</div>
							<br />
							<div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Views</span>
  									<input type="text"  name="views"  class="form-control" placeholder="Views" aria-describedby="basic-addon1">
							</div>
							<br />
							<div class="input-group">
  								<span class="input-group-addon" id="basic-addon1">Price</span>
  									<input type="text" name="price"  class="form-control" placeholder="Price" aria-describedby="basic-addon1">
							</div>
							<br />
							<p><button type="submit" name="add-pricing" class="btn btn-primary form-control" > Add</button></p>

					</form>
				</div>

			</div>

		</div>