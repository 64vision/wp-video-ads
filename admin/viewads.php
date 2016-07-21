<h3>Advertisements</h3>
	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					 <table class="table">
				    	<thead>
				      <tr>
				        <th>Advertisement Name</th>
				        <th>Packages</th>
				        <th>Date Created</th>

				        <th>Views</th>
				        <th>Status</th>
				      </tr>
				    </thead>
				    <tbody>
				     <?php if($ads):?>
						<?php foreach($ads as $ad):?>
							 <tr>
							        <td><?php echo $ad->name;?></td>
							        <td><?php echo $ad->pricing_id;?></td>
							        <td><?php echo $ad->created;?></td>
							        <td><?php echo $ad->views;?></td>
							        <td><?php echo $ad->status;?></td>
							      </tr>	
						<?php endforeach;?>
					<?php endif;?>
				     
				      


				    </tbody>
				  </table>
				</div>
			</div>

	</div>