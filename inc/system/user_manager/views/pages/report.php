<?php 
$stats_by_status = $result->stats_by_status;
$stats_by_date = $result->stats_by_date;
$stats_by_login_type = $result->stats_by_login_type;
$recently_registered_users = $result->recently_registered_users;
$chart = $result->chart;
?>
<div class="subheadline wrap-m m-b-30">
	
	<div class="sh-main wrap-c">
		<div class="sh-title text-info fs-18 fw-5"><i class="far fa-chart-bar"></i> <?php _e('User report')?></div>
	</div>
	
</div>

<div class="m-t-10">
	
	<div class="row no-gutters widget-main m-b-30">
	    <div class="col">
  			<div class="widget-card p-20">
  				<div class="widget-details wrap-m">
  					<div class="widget-info wrap-c">
  						<div class="widget-title"><?php _e("Active user")?></div>
  						<div class="widget-desc"><?php _e("Number of active users")?></div>
  					</div>
					<div class="widget-stats wrap-c text-success"><?php _e( $stats_by_status->active )?></div>
  				</div>
  				<div class="widget-progress progress m-b-5">
			  		<div class="progress-bar bg-success" role="progressbar" style="width: <?php _e( $stats_by_status->percent_active )?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="widget-action wrap-m">
					<div class="widget-change wrap-c"><?php _e("Percent")?></div>
					<div class="widget-number wrap-c"><?php _e( round( $stats_by_status->percent_active ) )?><?php _e("%")?></div>
				</div>
  			</div>
	    </div>
	    <div class="col">
  			<div class="widget-card p-20">
  				<div class="widget-details wrap-m">
  					<div class="widget-info wrap-c">
  						<div class="widget-title"><?php _e("Inactive user")?></div>
  						<div class="widget-desc"><?php _e("Number of  inactive users")?></div>
  					</div>
					<div class="widget-stats wrap-c text-warning"><?php _e( $stats_by_status->inactive )?></div>
  				</div>
  				<div class="widget-progress progress m-b-5">
			  		<div class="progress-bar bg-warning" role="progressbar" style="width: <?php _e( $stats_by_status->percent_inactive )?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="widget-action wrap-m">
					<div class="widget-change wrap-c"><?php _e("Percent")?></div>
					<div class="widget-number wrap-c"><?php _e( round( $stats_by_status->percent_inactive ) )?><?php _e("%")?></div>
				</div>
  			</div>
	    </div>
	    <div class="col">
  			<div class="widget-card p-20">
  				<div class="widget-details wrap-m">
  					<div class="widget-info wrap-c">
  						<div class="widget-title"><?php _e("Banned user")?></div>
  						<div class="widget-desc"><?php _e("Number of banned users")?></div>
  					</div>
					<div class="widget-stats wrap-c text-danger"><?php _e( $stats_by_status->banned )?></div>
  				</div>
  				<div class="widget-progress progress m-b-5">
			  		<div class="progress-bar bg-danger" role="progressbar" style="width: <?php _e( $stats_by_status->percent_banned )?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<div class="widget-action wrap-m">
					<div class="widget-change wrap-c"><?php _e("Percent")?></div>
					<div class="widget-number wrap-c"><?php _e( round( $stats_by_status->percent_banned ) )?><?php _e("%")?></div>
				</div>
  			</div>
	    </div>
	</div>

	<div class="row">
		
		<div class="col-md-4 m-b-25">
			<div class="card widget-chart-activity">
				<div class="card-body p-0">
					<div class="chart-bg bg-info">
						<div class="card-top wrap-m">
							<h6 class="card-title wrap-c p-20"><i class="fas fa-caret-right p-r-5"></i> <?php _e('Register history')?></h6>
						</div>
					</div>
					
					<div class="card-box p-l-20 p-r-20">
						<div class="row">
							<div class="col-6">
								<div class="box-item">
									<span class="icon text-solid-info"><i class="fas fa-user-plus"></i></span>
									<span class="title"><?php _e("Today")?></span>
									<span class="number"><?php _e( sprintf( __("%s users") , $stats_by_date->today) )?></span>
								</div>
							</div>
							<div class="col-6">
								<div class="box-item">
									<span class="icon text-solid-success"><i class="fas fa-user-plus"></i></span>
									<span class="title"><?php _e("This week")?></span>
									<span class="number"><?php _e( sprintf( __("%s users") , $stats_by_date->week) )?></span>
								</div>
							</div>
							<div class="col-6">
								<div class="box-item">
									<span class="icon text-solid-warning"><i class="fas fa-user-plus"></i></span>
									<span class="title"><?php _e("This month")?></span>
									<span class="number"><?php _e( sprintf( __("%s users") , $stats_by_date->month) )?></span>
								</div>
							</div>
							<div class="col-6">
								<div class="box-item">
									<span class="icon text-solid-danger"><i class="fas fa-user-plus"></i></span>
									<span class="title"><?php _e("This year")?></span>
									<span class="number"><?php _e( sprintf( __("%s users") , $stats_by_date->year) )?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 m-b-25">
			<div class="card widget-user-box">
				<div class="card-header wrap-m">
					<div class="card-title wrap-c m-b-0 text-info"><i class="fas fa-caret-right p-r-5"></i> <?php _e('Recently registered users')?></div>
				</div>
				<div class="card-body nicescroll no-update">

					<div class="widget-list">
						<?php
						if($recently_registered_users){
						 	foreach ($recently_registered_users as $row) {?>
							<div class="widget-item widget-item-3">
								 <a href="#">
					                <div class="icon"><img src="<?php _e( get_avatar($row->fullname) )?>"></div>
					                <div class="content content-2">
					                    <div class="title"><?php _e( $row->fullname )?></div>
					                    <div class="desc"><?php _e( ucfirst($row->login_type) )?></div>
					                </div>
					            </a>
									
								<div class="widget-option">
									<?php if($row->status == 1){?>
										<span class="badge badge-warning"><?php _e("Inactive")?></span>
									<?php }else if($row->status == 0){?>
										<span class="badge badge-danger"><?php _e("Banned")?></span>
									<?php }else{?>
										<span class="badge badge-success"><?php _e("Active")?></span>
									<?php }?>
								</div>
							</div>
						<?php }}?>
					</div>

				</div>
			</div>
		</div>
		<div class="col-md-4 m-b-25">
			<div class="card widget-user-box">
				<div class="card-header wrap-m">
					<div class="card-title wrap-c m-b-0 text-info"><i class="fas fa-caret-right p-r-5"></i> <?php _e('Login type')?></div>
				</div>
				<div class="card-body h-438">
					
					<div class="w-250 m-auto">
		            	<canvas id="chart-area" height="438"></canvas>
					</div>

				</div>
			</div>
		</div>

	</div>

	<div class="card rounded">
		<div class="card-header wrap-m">
			<div class="card-title wrap-c text-info"><i class="fas fa-caret-right p-r-5"></i> <?php _e("Last 30 days")?></div>
		</div>
        <div class="card-body h-350">
        	<canvas id="line-stacked-area" height="350"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		setTimeout(function(){
			Core.lineChart(
				"line-stacked-area",
				<?php _e($chart->date)?>, 
				[
					<?php _e($chart->value)?>
				],
				[
					"<?php _e('New register')?>"
				]
			);

			Core.pieChart(
				"chart-area",
				["<?php _e('Direct')?>", "<?php _e('Facebook')?>", "<?php _e('Google')?>", "<?php _e('Twitter')?>"], 
				[
					<?php _e( $stats_by_login_type->direct )?>,
					<?php _e( $stats_by_login_type->facebook )?>,
					<?php _e( $stats_by_login_type->google )?>,
					<?php _e( $stats_by_login_type->twitter )?>
				]
			);
		}, 300);
	});
</script>