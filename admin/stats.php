<div class="container-fluid">
	<h3>Ads Statistics</h3>
		<div class="row">
			<div class="col-md-9">
			
				<div>
				<canvas id="myChart" width="200" height="100"></canvas>
				</div>
			</div>
			<div class="col-md-3">
				
				<div class="row">
					<div class="col-md-12" id="labels-stat-tiledash" style="background-color:#19A2DE; margin-top:7%;">
						<h2 >Total CPM</h2>
						<h2><?php echo count($total_log);?></h2>
					</div>
					<div class="col-md-12" id="labels-stat-tiledash" style="background-color:#8CBE29;">
						<h2>Advertisers</h2>
						<h2><?php echo count($advertisers);?></h2>
					</div>
					<div class="col-md-12" id="labels-stat-tiledash" style="background-color:#FF76BC;">
					<h2>Todays CPM</h2>
					<h2><?php echo count($today_log);?></h2>
					</div>
					<div class="col-md-12">
						
					</div>
				</div>
			</div>
		
		</div>
	</div>

	<style type="text/css">
		#labels-stat-tiledash{
			color:white;
			margin:5%;
			width:90%; 
			text-align: center;
		}
		#timeframe-stat{
		text-align: right;
	}
	</style>

				<?php 
					$labels='';
					$gdata='';
					foreach( $get_last_days as $_data) {
						if($labels)	{
							 $labels .= ',"'.$_data->m.'/'.$_data->d.'"';
							} else {
								 $labels .= '"'.$_data->m.'/'.$_data->d.'"';
							}
							if($gdata)	{
								 $gdata .= ','.$_data->views;
							} else {
								  $gdata .= $_data->views;
							}
					}
					
				?>

		<script language="javascript">
			var ctx = document.getElementById("myChart");
			var myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: [<?php echo $labels;?>],
			        datasets: [{
			            label: 'Views',
			            data: [<?php echo $gdata;?>],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			    }
			});
		</script>