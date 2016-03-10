<?php
function four_steps_form() {
    echo '
    <div class="stepwizard hide-step-indicators">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <button type="button" data-id="1" class="step-1-1-circle step-1-2-circle btn btn-primary btn-circle" disabled="disabled">1</button>                
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="2" class="step-2-circle btn btn-default btn-circle" disabled="disabled">2</button>                
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="3" class="step-3-circle btn btn-default btn-circle" disabled="disabled">3</button>                
            </div> 
            <div class="stepwizard-step">
                <button type="button" data-id="4" class="step-4-circle btn btn-default btn-circle" disabled="disabled">4</button>                
            </div>            
        </div>
    </div>

    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

    <p class="ip_address">IP Address detected: <span class="user_ip">220.369.964.24</span></p>

    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    
    <!-- INDEX -->
    <div id="step-0">
        <form id="registration-page-form-step">
          <div class="field-container">
            <h3>Please select:</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            <a href="#" id="incorporate_company"><button data-id="1-1" class="custom-submit-class next-btn">Incorporate a new company</button></a>
            <a href="#" id="shelf_company"><button data-id="1-2" class="custom-submit-class next-btn">Purchase a shelf company</button></a>            
          </div>             
        </form>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>
    <!-- END INDEX -->';
}

function four_steps_function() { 
    four_steps_form();
}

// Register a new shortcode: [four_steps]
add_shortcode( 'four_steps', 'four_steps_shortcode' );
 
// The callback function that will replace [book]
function four_steps_shortcode() {
    ob_start();
    four_steps_function();
    return ob_get_clean();
}
?>