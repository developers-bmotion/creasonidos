<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<h2 class="section-title">Facebook Settings</h2>

<!-- General -->
<div class="card card-static">
	<div class="card-header">
		General
	</div>
	<div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <?php Facebook()->render_switcher_input( 'enabled' ); ?>
                <h4 class="switcher-label">Enable Facebook Pixel</h4>
            </div>
        </div>
		<div class="row">
			<div class="col">
				<?php Facebook()->render_switcher_input( 'advanced_matching_enabled' ); ?>
				<h4 class="switcher-label">Enable Advanced Matching</h4>
                <div class="alert alert-primary mt-3">Because of a Facebook error, when Advanced Matching is ON, Custom
                    Audiences based on the pixel
                    will not show the size number ("Size: -1", or "Size Unavailable"). They will still work fine for
                    retargeting or Lookalike Audiences. Details <a href="https://www.pixelyoursite
                    .com/facebook-audience-size-not-available" target="_blank">here</a>.</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<?php Facebook()->render_switcher_input( 'remove_metadata' ); ?>
				<h4 class="switcher-label">Remove Facebook default events</h4>
			</div>
		</div>
	</div>
</div>

<hr>
<div class="row justify-content-center">
	<div class="col-4">
		<button class="btn btn-block btn-sm btn-save">Save Settings</button>
	</div>
</div>