<h3>Create ads</h3>
			<form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>" style="width: 60%;">
						 <input type="hidden" name="action" value="wpse10500" />

						<h4>Advertiser</h4>
						<select class="selectpicker form-control" name="advertiser_id">
				 		 	<option>Select Advertiser</option>
							<?php if($advertisers):?>
								<?php foreach($advertisers as $advertiser):?>
										<option value="<?php echo $advertiser->id;?>"><?php echo $advertiser->name;?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>

						<h4> Advertisement Title</h4> 
						<input type="text" class="form-control" name="name"/>

						<!--<h4>Duration in seconds</h4>
						<input type="number" min="0" max="60" class="form-control" >-->
						<h4>Pricing</h4>
						<select class="selectpicker form-control" name="pricing_id">
				 		 	<option>Select Ad Package</option>
					  		<?php if($pricing):?>
							<?php foreach($pricing as $price):?>
						     <option value="<?php echo $price->id;?>"><?php echo $price->name;?> - P<?php echo $price->price;?> (<?php echo $price->views;?> views)</option>
					     	<?php endforeach;?>
						<?php endif;?>
						</select>


						<h4>Video Ads</h4>
							<div class="input-group">
						      <input type="text" class="form-control media-input" name="ad_file" placeholder="">
						      <span class="input-group-btn">
						        <button class="btn btn-default media-button" type="button">Media</button>
						      </span>
						    </div><!-- /input-group -->
						</select>
						<br />

						<p><button type="submit" name="new-ad" class="btn btn-primary form-control" > Add</button></p>

						
					
				</form>

<script type="text/javascript">
	  jQuery('.media-button').on('click', function() {
	  		// check for media manager instance
            if(wp.media.frames.gk_frame) {
                wp.media.frames.gk_frame.open();
                return;
            }
            // configuration of the media manager new instance
            wp.media.frames.gk_frame = wp.media({
                title: 'Select video ad',
                multiple: false,
                library: {
                    type: 'video'
                },
                button: {
                    text: 'Use selected video ad'
                }
            });
 			 var gk_media_set_image = function() {
                var selection = wp.media.frames.gk_frame.state().get('selection');
 
                // no selection
                if (!selection) {
                    return;
                }
 
                // iterate through selected elements
                selection.each(function(attachment) {
                    var url = attachment.attributes.url;
                    jQuery('.media-input').val(url);
                });
            };
 
            // closing event for media manger
            wp.media.frames.gk_frame.on('close', gk_media_set_image);
            // image selection event
            wp.media.frames.gk_frame.on('select', gk_media_set_image);
            // showing media manager
            wp.media.frames.gk_frame.open();
	  });
</script>