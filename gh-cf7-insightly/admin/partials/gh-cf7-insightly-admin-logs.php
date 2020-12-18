<div class="wrap">
	<h2>Logs</h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<form method="post">
						<?php
						$this->gh_cf7_insightly_logs_obj->prepare_items();
						$this->gh_cf7_insightly_logs_obj->display(); 
						?>
					</form>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>