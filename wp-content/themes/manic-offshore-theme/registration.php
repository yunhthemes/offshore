<?php
function registration_form( $username, $password, $email, $title, $first_name, $surname, $mobile_telephone ) {
    echo '
    <script>
    (function($) {
        $(document).ready(function(){
            function changeStep(id){
                if(id==3) {
                    $(".step-"+(parseInt(id) - 1)).hide();
                } 
                else $("#step-"+(parseInt(id) - 1)).hide();
                
                $("#step-"+id).show();
                $(".btn-primary").removeClass("btn-primary").addClass("btn-default").prop( "disabled", false );
                $(".step-"+id+"-circle").removeClass("btn-default").addClass("btn-primary").prop( "disabled", true );
            }

            $(".next-btn").on("click", function(e){
                e.preventDefault();                
                changeStep($(this).data("id"));
            });

        });
        
    }(jQuery));
    </script>
    
    <div class="stepwizard">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <button type="button" data-id="1" class="step-1-circle btn btn-primary btn-circle" disabled="disabled">1</button>                
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="2" class="step-2-1-circle step-2-2-circle btn btn-default btn-circle" disabled="disabled">2</button>                
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="3" class="step-3-circle btn btn-default btn-circle" disabled="disabled">3</button>                
            </div> 
            <div class="stepwizard-step">
                <button type="button" data-id="4" class="step-4-circle btn btn-default btn-circle" disabled="disabled">4</button>                
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="5" class="step-5-circle btn btn-default btn-circle" disabled="disabled">5</button>                
            </div>
        </div>
    </div>

    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

    <p class="ip_address">IP Address detected: <span class="user_ip">220.369.964.24</span></p>

    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

    <div id="step-1">
        <form id="registration-page-form-step-1">
          <div class="field-container">
            <h3>Please select:</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            <a href="#" id="incorporate_company"><button data-id="2-1" class="custom-submit-class next-btn">Incorporate a new company</button></a>
            <a href="#" id="shelf_company"><button data-id="2-2" class="custom-submit-class next-btn">Purchase a shelf company</button></a>            
          </div>             
        </form>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-2-1" class="step-2 reg-step">
        <form id="registration-page-form-2">
          <div class="field-container">
            
            <h3>Offshore Company</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <label for="type_of_company">Type of company:</label>
            <div class="custom-input-class-select-container">            
                <select name="type_of_company" class="custom-input-class">
                    <option value="Please select">Please select</option>
                    <option selected="selected" value="Cyprus limited liability company">Cyprus limited liability company</option>
                </select>
            </div>

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <h3>Offshore name suggestions</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <div class="field-container">
                <label for="name">1st Choice</label>
                <input type="text" name="company_name_1" class="custom-input-class" value="">
            </div>
            <div class="field-container">
                <label for="name">2nd Choice</label>
                <input type="text" name="company_name_2" class="custom-input-class" value="">
            </div>
            <div class="field-container">
                <label for="name">3rd Choice</label>
                <input type="text" name="company_name_3" class="custom-input-class" value="">
            </div>

            <a href="#" id="next"><button data-id="3" class="custom-submit-class next-btn">Next</button></a>
            
          </div>             
        </form>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-2-2" class="step-2 reg-step">
        <form id="registration-page-form-2">
          <div class="field-container">
            
            <h3>Shelf Company</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <label for="type_of_company">Type of company:</label>
            <div class="custom-input-class-select-container">            
                <select name="type_of_company" class="custom-input-class">
                    <option value="Please select">Please select</option>
                    <option selected="selected" value="Cyprus limited liability company">Cyprus limited liability company</option>
                </select>
            </div>

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <p>Click on our shelf offerings below for details:</p>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <div class="field-container">                
                <input type="radio" name="company_name" value="" checked="true">
                <ul>
                    <li><label for="company_name">Company name: Test Company</label></li>
                    <li><label for="incorporation_date">Date of incorporation: 01/01/2001</label></li>
                    <li><label for="price">Price: $1000</label></li>
                </ul>                
            </div>

            <div class="field-container">                
                <input type="radio" name="company_name" value="">
                <ul>
                    <li><label for="company_name">Company name: Test Company 2</label></li>
                    <li><label for="incorporation_date">Date of incorporation: 02/02/2002</label></li>
                    <li><label for="price">Price: $2000</label></li>
                </ul>                
            </div>

            <div class="field-container">                
                <input type="radio" name="company_name" value="">
                <ul>
                    <li><label for="company_name">Company name: Test Company 3</label></li>
                    <li><label for="incorporation_date">Date of incorporation: 03/03/2003</label></li>
                    <li><label for="price">Price: $3000</label></li>
                </ul>                
            </div>

            <a href="#" id="next"><button data-id="3" class="custom-submit-class next-btn">Next</button></a>
           
            
          </div>             
        </form>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-3" class="reg-step">
        <form id="registration-page-form-3">
            
            <div class="personnel">
                <h3>Shareholders</h3>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <p>At least one shareholder is required, to whom  a minimum of one share must be issued. Shareholders may be either natural persons or other corporate entities. Should confidentiality be required, the shares may be held via nominee shareholders. Please tick the box below if you would like Offshore Company Solutions to provide nominee shareholders. Bearer shares are not allowed.</p>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
                
                <div class="field-container">
                    <label for="shareholder">Shareholder 1</label>
                    <input type="text" name="shareholder_1" placeholder="Shareholder name" class="custom-input-class-2">                
                    <input type="text" name="shareamount_1" placeholder="Share amount" class="custom-input-class-2">
                </div>

                <div class="field-container">
                    <label for="shareholder">Shareholder 2</label>
                    <input type="text" name="shareholder_2" placeholder="Shareholder name" class="custom-input-class-2">                
                    <input type="text" name="shareamount_2" placeholder="Share amount" class="custom-input-class-2">
                </div>

                <div class="field-container">
                    <label for="shareholder">Shareholder 3</label>
                    <input type="text" name="shareholder_3" placeholder="Shareholder name" class="custom-input-class-2">                
                    <input type="text" name="shareamount_3" placeholder="Share amount" class="custom-input-class-2">
                </div>

                <div class="field-container">
                    <input type="checkbox" name="nominee_shareholders">
                    <label for="nominee_shareholders" class="checkbox-label">Offshore Company Solutions to provide nominee shareholders</label>
                </div>

                <div class="field-container">
                    <label for="total_share">Total shares to be issued</label>
                    <input type="text" name="total_share" class="custom-input-class-2">
                </div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            </div>

            <div class="personnel">
                <h3>Directors</h3>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <p>At least one director is required, who may be either a natural person or another company. The directors may be resident anywhere in the world. If the company will wish to qualify for benefits under the network of double tax treates which Cyprus has in place with other countries, then it will be necessary for the majority of directors to be resident in Cyprus. It is possible for a single person to be a sole director and shareholder.  Professional directors may be appointed if confidentiality is required.  Please tick the box below if you would like Offshore Company Solutions to provide professional directors.</p>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
                
                <div class="field-container">
                    <label for="director">Director 1</label>
                    <input type="text" name="director_1" placeholder="Director name" class="custom-input-class">                                    
                </div>

                <div class="field-container">
                    <label for="director">Director 2</label>
                    <input type="text" name="director_2" placeholder="Director name" class="custom-input-class">                                    
                </div>

                <div class="field-container">
                    <label for="director">Director 3</label>
                    <input type="text" name="director_3" placeholder="Director name" class="custom-input-class">                                    
                </div>

                <div class="field-container">
                    <input type="checkbox" name="nominee_directors">
                    <label for="nominee_directors" class="checkbox-label">Offshore Company Solutions to provide professional directors</label>
                </div>              

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>  
            </div>

            <div class="personnel">
                <h3>Secretary</h3>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <p>A company secretary must be appointed, who may be a natural person or company, resident in any country but preferably in Cyprus. The same person may act as both company secretary and director or company secretary and shareholder. It is possible for the same person to act as shareholder, director and secretary provided there is at least one other shareholder or director. secretary.Please tick the box below if you would like Offshore Company Solutions to provide a company secretary.</p>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
                
                <div class="field-container">
                    <label for="secretary">Secretary name</label>
                    <input type="text" name="secretary_1" class="custom-input-class">                                    
                </div>                

                <div class="field-container">
                    <input type="checkbox" name="nominee_directors">
                    <label for="nominee_directors" class="checkbox-label">Offshore Company Solutions to provide professional directors</label>
                </div>                
            </div>

            <a href="#" id="next"><button data-id="4" class="custom-submit-class next-btn">Next</button></a>
             
        </form>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-4" class="reg-step">
        <form id="registration-page-form-4">
            
            <div class="personnel">
                <h3>Additional services</h3>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <p>At least one shareholder is required, to whom  a minimum of one share must be issued. Shareholders may be either natural persons or other corporate entities. Should confidentiality be required, the shares may be held via nominee shareholders. Please tick the box below if you would like Offshore Company Solutions to provide nominee shareholders. Bearer shares are not allowed.</p>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
                
                <div class="field-container">
                    <h4 class="pull-left">Bank account</h4>
                    <h4 class="pull-right">Price</h4>
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="country-options-container pull-left">                
                        <label for="bank_account" class="country_options_label">Country options</label>
                        <div class="custom-input-class-select-container half">            
                            <select id="bank_account" class="custom-input-class">
                                <option value="No">No</option>
                                <option selected="" value="Cyprus">Cyprus</option>
                                <option value="Malta">Malta</option>
                                <option value="Switzerland">Switzerland</option>
                            </select>
                        </div>
                    </div>
                    <div class="price pull-right"><p>$1000</p></div>
                    <div class="clear"></div>
                </div>

                <div class="field-container">
                    <h4 class="pull-left">Credit/debit card</h4>
                    <h4 class="pull-right">Price</h4>
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="country-options-container pull-left">                
                        <label for="credit_card" class="country_options_label">Country options</label>
                        <div class="custom-input-class-select-container half">            
                            <select id="credit_card" class="custom-input-class">
                                <option value="No">No</option>
                                <option selected="" value="Cyprus">Cyprus</option>
                                <option value="Malta">Malta</option>
                                <option value="Switzerland">Switzerland</option>
                            </select>
                        </div>
                    </div>
                    <div class="price pull-right"><p>$1000</p></div>
                    <div class="clear"></div>
                </div>

                <div class="field-container">
                    <h4 class="pull-left">Mail forwarding</h4>
                    <h4 class="pull-right">Price</h4>
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="country-options-container pull-left">                
                        <label for="credit_card" class="country_options_label">Country options</label>
                        <div class="custom-input-class-select-container half">            
                            <select id="credit_card" class="custom-input-class">
                                <option value="No">No</option>
                                <option selected="" value="Cyprus">Cyprus</option>
                                <option value="Malta">Malta</option>
                                <option value="Switzerland">Switzerland</option>
                            </select>
                        </div>
                    </div>
                    <div class="price pull-right"><p>$1000</p></div>
                    <div class="clear"></div>
                </div>

                <div class="field-container">
                    <h4 class="pull-left">Local telephone</h4>
                    <h4 class="pull-right">Price</h4>
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="country-options-container pull-left">                
                        <label for="credit_card" class="country_options_label">Country options</label>
                        <div class="custom-input-class-select-container half">            
                            <select id="credit_card" class="custom-input-class">
                                <option value="No">No</option>
                                <option selected="" value="Cyprus">Cyprus</option>
                                <option value="Malta">Malta</option>
                                <option value="Switzerland">Switzerland</option>
                            </select>
                        </div>
                    </div>
                    <div class="price pull-right"><p>$1000</p></div>
                    <div class="clear"></div>
                </div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <div class="field-container">
                    <h4>I would like to receive information on:</h4>                    
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="field-container">
                        <input type="checkbox" name="merchant_account"><label for="merchat_account" class="checkbox-label">Establishing a merchant account</label>
                    </div>
                    <div class="field-container">
                        <input type="checkbox" name="office_presence"><label for="office_presence" class="checkbox-label">Setting up a physical office presence</label>
                    </div>
                    <div class="field-container">
                        <input type="checkbox" name="real_estate"><label for="real_estate" class="checkbox-label">Purchasing real estate</label>
                    </div>
                    <div class="field-container">
                        <input type="checkbox" name="economic_citizenship"><label for="economic_citizenship" class="checkbox-label">Economic citizenship possibilities</label>
                    </div>
                </div>

               
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            </div>            

            <a href="#" id="next"><button data-id="4" class="custom-submit-class next-btn">Next</button></a>
             
        </form>
    </div>
    ';
}

function custom_registration_function() { 
    registration_form(
        $username,
        $password,
        $email,
        $title,
        $first_name,
        $surname,
        $mobile_telephone
    );
}

// Register a new shortcode: [custom_registration]
add_shortcode( 'custom_registration', 'custom_registration_shortcode' );
 
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}
?>