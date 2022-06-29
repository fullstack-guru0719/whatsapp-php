<?php 
$report_list = get_ci_value("reports_list");
if( count($report_list) == 1){
	foreach ($report_list as $row){
		$id = strtolower( str_replace(" ", "_", $row['name']) );
		if(!segment(3) == $id){
			redirect( get_module_url("index/".$id) );
		}
	}
}
?>

<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-list search-list">
		<?php if( count($report_list) != 1){?>
		<div class="widget-item widget-item-3 search-list <?php _e( segment(3) == ""?"active":"" ) ?>" data-pid="">
			 <a href="<?php _e( get_module_url("index") )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url("index") )?>" data-call-after="Layout.tooltip();">
                <div class="icon border"><i class="fas fa-chart-bar" style="color: #fa7070"></i></div>
                <div class="content content-2">
                    <div class="title fw-4"><?php _e( "All" )?></div>
                    <div class="desc"><?php _e( "Report" )?></div>
                </div>
            </a>
			
			<div class="widget-option">
				<label class="i-radio i-radio--tick i-radio--brand m-t-6">
					<input type="radio" name="account[]" class="check-item" <?php _e( segment(3) == ""?"checked":"" ) ?> value="" >
					<span></span>
				</label>
			</div>
		</div>
		<?php }?>

		<?php 
		

		if(!empty($report_list)){?>

			<?php foreach ($report_list as $row): 
				$icon = $row['icon'];
				$name = $row['name'];
				$color = $row['color'];
				$id = strtolower( str_replace(" ", "_", $row['name']) );
			?>
				
				<div class="widget-item widget-item-3 search-list <?php _e( segment(3) == $id?"active":"" ) ?>" data-pid="<?php _e( get_data($row, 'pid') )?>">
					 <a href="<?php _e( get_module_url("index/".$id) )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url("index/".$id) )?>" data-call-after="Layout.tooltip();">
		                <div class="icon border"><i class="<?php _e( $icon )?>" style="color: <?php _e( $color )?>"></i></div>
		                <div class="content content-2">
		                    <div class="title fw-4"><?php _e( $name )?></div>
		                    <div class="desc"><?php _e( "Report" )?></div>
		                </div>
		            </a>
					
					<div class="widget-option">
						<label class="i-radio i-radio--tick i-radio--brand m-t-6">
							<input type="radio" name="account[]" class="check-item" <?php _e( segment(3) == $id?"checked":"" ) ?> value="<?php _e( $id )?>" >
							<span></span>
						</label>
					</div>
				</div>

			<?php endforeach ?>

		<?php }else{?>

			<div class="empty small"></div>

		<?php }?>

	</div>

</div>