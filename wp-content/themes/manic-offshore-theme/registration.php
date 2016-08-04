<?php
if(!is_user_logged_in ()) {
    
    $current_url = $_SERVER['REQUEST_URI'];
    $urlArr = explode('/', $current_url);

    if(in_array('company-formation-order', $urlArr)) {
        wp_redirect( get_permalink( get_page_by_path('sign-up') )); exit;
    }
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

function get_ip_address() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

function registration_form() {
    $ip = get_ip_address();
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();
    $user_name = $current_user->user_login;    
    
    global $wpdb;
    $field_id = $wpdb->get_var( "SELECT parent_id FROM wp_bp_xprofile_fields WHERE name = 'US dollars (US$)'");
    $currency = $wpdb->get_var( "SELECT value FROM wp_bp_xprofile_data WHERE user_id = $user_id AND field_id = $field_id" );

    echo '
    <script>
    (function($) {
        $(document).ready(function(){    

            // window.onpopstate = function (e) { window.history.forward(1); }

            $(window).bind("beforeunload", function(){

                return "";

            });

            ///////////
            //// GET CURRENT USER\'S COUNTRY
            ///////////

            var country;
            var currency;

            $.getJSON("http://ipinfo.io", function(data){
                country = data.country;
            });          

            currency = "'.$currency.'";

            //////////
            //// CUSTOM JS FUNC
            //////////

            Array.prototype.allValuesSame = function() {

                for(var i = 1; i < this.length; i++)
                {
                    if(this[i] !== this[0])
                        return false;
                }

                return true;
            }

            ///////////
            //// VALIDATIONS
            ///////////                 

            $.extend( $.validator.prototype, {
                checkForm: function () {
                    this.prepareForm();
                    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                        if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                                this.check(this.findByName(elements[i].name)[cnt]);
                            }
                        } else {
                            this.check(elements[i]);
                        }
                    }
                    return this.valid();
                }
            });

            function inArray(needle, haystack) {
                var length = haystack.length;
                for(var i = 0; i < length; i++) {
                    if(needle.indexOf(haystack[i]) > -1) return true;
                }
                return false;
            }

            function validateForm($selector, formID) {

                $.validator.addMethod("telephone", function (value, element) 
                {
                    return this.optional(element) || /^(?=.*[0-9])[- +()0-9]+$/.test(value.replace(/\s/g, ""));
                }, "Invalid phone no");

                $.validator.addMethod("companynames", function (value, element) 
                {
                    var check;
                    var val = value.toLowerCase();
                    var name_rules = [];

                    var selected_company_type = $(".type_of_company option:selected").text();

                    if(selected_company_type == "Cyprus limited liability company") {
                        name_rules = [ "ltd", "limited" ];
                    }
                    else if(selected_company_type == "Belize international business company") {
                        name_rules = [ "ltd", "limited", "corporation", "corp", "incorporated", "inc", "société anonyme", "sociedad anónima", "sa", "aktiengesellschaft", "ag" ];
                    }
                    else if(selected_company_type == "BVI business company") {
                        name_rules = [ "ltd", "limited", "corporation", "corp", "incorporated", "inc", "société anonyme", "sociedad anónima", "sa" ];
                    }
                    else if(selected_company_type == "Nevis international business company") {
                        name_rules = [ "ltd", "limited", "corporation", "corp", "co", "incorporated", "inc", "société anonyme", "sociedad anónima", "sa", "gmbh" ];
                    }
                    else if(selected_company_type == "Seychelles international business company") {
                        name_rules = [ "ltd", "limited", "corporation", "corp", "incorporated", "inc", "société anonyme", "sociedad anónima", "sa" ];
                    }
                    else if(selected_company_type == "Ras Al Khaimah offshore company") {
                        name_rules = [ "limited" ];    
                    }
                    else if(selected_company_type == "Hong Kong limited liability company") {
                        name_rules = [ "limited", "plc" ];
                    }
                    else if(selected_company_type == "Irish limited liability company") {
                        name_rules = [ "limited", "ltd", "teoranta", "teo" ];
                    }
                    else if(selected_company_type == "Malta limited liability company") {
                        name_rules = [ "limited", "ltd", "company limited", "co limited", "co ltd" ];
                    }
                    else if(selected_company_type == "Singapore limited liability company") {
                        name_rules = [ "limited", "ltd", "sendirian", "sdn", "private", "pte", "berhad", "bhd" ];
                    }  
                    else {
                        name_rules = [ "ltd", "limited" ];
                    }           

                    var cur_name_val = val.trim();
                        cur_name_val = cur_name_val.split(" ");

                    if($.inArray(cur_name_val[cur_name_val.length-1], name_rules) > -1) check = true;
                    else check = false;

                    // if(inArray(val, name_rules)) check = true;
                    // else check = false;

                    return this.optional(element) || check;
                }, "Company name must be a valid name.");

                $.validator.addMethod("notEqualTo",
                    function(value, element, param) {
                        var notEqual = true;
                        value = $.trim(value);                        
                        for (i = 0; i < param.length; i++) {
                            if (value == $.trim($(param[i]).val())) { notEqual = false; }
                        }
                        return this.optional(element) || notEqual;
                    },
                    "Please enter a diferent value."
                );

                if(formID==1) {                    

                    $selector.validate({
                        focusInvalid: false,
                        invalidHandler: function(form, validator) {

                            if (!validator.numberOfInvalids())
                                return;

                            var $firstErrorEl = $(validator.errorList[0].element);

                            $("html, body").animate({
                                scrollTop: $firstErrorEl.offset().top - 150
                            }, 2000);

                        },
                        rules : {
                            "company_name_1": {
                                required : {
                                    depends : function(elem) {
                                        return $("#new-incorporation").is(":checked");
                                    }
                                },
                                companynames : true,
                                notEqualTo: ["#company_name_2","#company_name_3"]
                            },
                            "company_name_2": {
                                required : {
                                    depends : function(elem) {
                                        return $("#new-incorporation").is(":checked");
                                    }
                                },
                                companynames : true,
                                notEqualTo: ["#company_name_1","#company_name_3"]
                            },
                            "company_name_3": {
                                required : {
                                    depends : function(elem) {
                                        return $("#new-incorporation").is(":checked");
                                    }
                                },
                                companynames : true,
                                notEqualTo: ["#company_name_1","#company_name_2"]
                            }
                        },
                        messages: {
                            "company_name_1" : "Please provide three company names",
                            "company_name_2" : "Please provide three company names",
                            "company_name_3" : "Please provide three company names"
                        },
                        errorPlacement: function(error, element) {                            
                            element.attr("placeholder", error.text());
                        }
                    });
                }else if(formID==2) {

                    var selected_company_type = $(".type_of_company option:selected").text();
                    var shareholderCount = $(".shareholder").find(".field-container").length;
                    var errMessageArr = {};

                    for(var i=1;i<=3;i++) {
                        errMessageArr["shareholder_"+i+"_name"] = "Name required";                        
                        errMessageArr["shareholder_"+i+"_address"] = "Street required";
                        errMessageArr["shareholder_"+i+"_address_2"] = "City required";
                        errMessageArr["shareholder_"+i+"_address_4"] = "Country required";
                        errMessageArr["shareholder_"+i+"_telephone"] = "Telephone number required";
                        errMessageArr["shareamount_"+i+"_amount"] = "Shares required";

                        errMessageArr["director_"+i+"_name"] = "Name required";
                        errMessageArr["director_"+i+"_address"] = "Street required";
                        errMessageArr["director_"+i+"_address_2"] = "City required";
                        errMessageArr["director_"+i+"_address_4"] = "Country required";
                        errMessageArr["director_"+i+"_telephone"] = "Telephone number required";
                    }

                    errMessageArr["secretary_1_name"] = "Name required";
                    errMessageArr["secretary_1_address"] = "Street required";
                    errMessageArr["secretary_1_address_2"] = "City required";
                    errMessageArr["secretary_1_address_4"] = "Country required";
                    errMessageArr["secretary_1_telephone"] = "Telephone number required";
                    errMessageArr["secretary_1_amount"] = "Shares required";

                    var errMessageJson = $.parseJSON(JSON.stringify(errMessageArr));                   
                      
                    $selector.validate({
                        focusInvalid: false,
                        invalidHandler: function(form, validator) {

                            if (!validator.numberOfInvalids())
                                return;

                            var $firstErrorEl = $(validator.errorList[0].element);

                            $("html, body").animate({
                                scrollTop: $firstErrorEl.offset().top - 150
                            }, 2000);

                        },
                        rules : {
                            "shareholder_1_name" : {
                                required: true
                                // ,notEqualTo: ["#shareholder_2_name", "#shareholder_3_name", "#shareholder_4_name", "#shareholder_5_name", "#director_1_name", "#director_2_name", "#director_3_name", "#director_4_name", "#director_5_name", "#secretary_1_name"]
                            },
                            "shareholder_1_address" : "required",
                            "shareholder_1_address_2" : "required",
                            "shareholder_1_address_4" : "required",
                            "shareholder_1_telephone" : {
                                "required" : true,
                                "telephone" : true
                            },
                            "shareamount_1_amount" : {
                                "required" : true,
                                "number": true
                            },                            
                            "director_1_name" : {
                                required: {
                                    depends : function(elem) {
                                        if($("#nominee_director").is(":checked")==false) return true;
                                        else return false;
                                    }
                                }
                                // ,notEqualTo: ["#shareholder_1_name", "#shareholder_2_name", "#shareholder_3_name", "#shareholder_4_name", "#shareholder_5_name", "#director_2_name", "#director_3_name", "#director_4_name", "#director_5_name", "#secretary_1_name"]
                            },
                            "director_1_address" : {
                                required: {
                                    depends : function(elem) {
                                        if($("#nominee_director").is(":checked")==false) return true;
                                        else return false;
                                    }
                                }
                            },
                            "director_1_address_2" : {
                                required: {
                                    depends : function(elem) {
                                        if($("#nominee_director").is(":checked")==false) return true;
                                        else return false;
                                    }
                                }
                            },                            
                            "director_1_address_4" : {
                                required: {
                                    depends : function(elem) {
                                        if($("#nominee_director").is(":checked")==false) return true;
                                        else return false;
                                    }
                                }
                            },
                            "director_1_telephone" : {
                                required: {
                                    depends : function(elem) {
                                        if($("#nominee_director").is(":checked")==false) return true;
                                        else return false;
                                    }
                                }
                            }
                        },
                        errorPlacement: function(error, element) {                            
                            element.attr("placeholder", error.text());
                        },
                        messages: errMessageJson
                    });

                    var secretary_optional_company_types_arr = ["Belize international business company", "BVI business company", "Nevis international business company", "Seychelles international business company"];

                    if($.inArray( selected_company_type, secretary_optional_company_types_arr ) === -1) {

                        $("#secretary_1_name").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($("#nominee_secretary").is(":checked")==false) return true;
                                    else return false;
                                }
                            }                       
                        });
                        $("#secretary_1_address").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($("#nominee_secretary").is(":checked")==false) return true;
                                    else return false;
                                }
                            }                       
                        });
                        $("#secretary_1_address_2").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($("#nominee_secretary").is(":checked")==false) return true;
                                    else return false;
                                }
                            }                       
                        });
                        $("#secretary_1_address_4").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($("#nominee_secretary").is(":checked")==false) return true;
                                    else return false;
                                }
                            }                       
                        });
                        $("#secretary_1_telephone").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($("#nominee_secretary").is(":checked")==false) return true;
                                    else return false;
                                }
                            }
                        });
                    }else {
                        $( "#secretary_1_name" ).rules( "remove", "required" );
                        $( "#secretary_1_address" ).rules( "remove", "required" );
                        $( "#secretary_1_address_2" ).rules( "remove", "required" );
                        $( "#secretary_1_address_4" ).rules( "remove", "required" );
                        $( "#secretary_1_telephone" ).rules( "remove", "required" );
                    }

                }else if(formID==4) {

                    var rulesArr = {};

                    $(".passport_upload").each(function(i, obj){
                        var selector = $(obj).data("fieldname");
                        rulesArr[selector] = "required"
                    });

                    $(".bill_upload").each(function(i, obj){
                        var selector = $(obj).data("fieldname");
                        rulesArr[selector] = "required"
                    });

                    rulesArr["nominee_director_annual_fee"] = "required";
                    rulesArr["nominee_secretary_annual_fee"] = "required";
                    rulesArr["company_name_choices[]"] = {
                        required : true,
                        companynames : true
                    };
                    // rulesArr["tnc"] = "required";

                    var rulesJson = $.parseJSON(JSON.stringify(rulesArr));

                    // console.log(rulesJson);

                    $selector.validate({
                        rules: rulesJson,
                        invalidHandler: function(form, validator) {

                            if (!validator.numberOfInvalids())
                                return;

                            var $firstErrorEl = $(validator.errorList[0].element);

                            $("html, body").animate({
                                scrollTop: $firstErrorEl.offset().top - 150
                            }, 2000);

                        },
                        messages: {
                            "nominee_director_annual_fee": "Please assign at least one director for your company.",
                            "nominee_secretary_annual_fee": "Please assign at least one secretary for your company."
                        },
                        errorPlacement: function(error, element) {
                            if (element.attr("name") == "nominee_director_annual_fee") {

                                element.next(".error").remove();
                                element.after("<p class=\"error pull-left\" style=\"display:inline-block;\">"+error.text()+"</p>");
                                element.parent().find(".go-step-2").show();
                                element.parent().addClass("half-field-container-2")

                            } else if (element.attr("name") == "nominee_secretary_annual_fee") {

                                element.next(".error").remove();
                                element.after("<p class=\"error pull-left\" style=\"display:inline-block;\">"+error.text()+"</p>");
                                element.parent().find(".go-step-2").show();
                                element.parent().addClass("half-field-container-2")

                            } else if (element.attr("name") == "tnc") {
                                error.insertAfter($("label[for=tnc]"));
                            } else {
                                error.insertAfter(element);
                                // element.attr("placeholder", error.text());
                            }
                        }
                    });
                }
            }

            function specialValidationStep2() {
                var $form2 = $("#registration-page-form-2");

                var nomineeShareholder = document.querySelector("#nominee_shareholder");
                var nomineeDirector = document.querySelector("#nominee_director");                
                var nomineeSecretary = document.querySelector("#nominee_secretary");                

                var $shareholderFieldcontainer = $form2.find(".shareholder").find(".pasteclone").find(".field-container");
                var $directorFieldcontainer = $form2.find(".director").find(".pasteclone").find(".field-container");                
                var $secretaryFieldcontainer = $form2.find(".secretary").find(".field-container");

                var selected_company_type = $(".type_of_company option:selected").text();                

                if(nomineeDirector.checked===false && nomineeSecretary.checked===false) {
                    
                    var persons = [],
                        custom_err_msg = "";

                    if(selected_company_type == "Hong Kong limited liability company" || selected_company_type == "Irish limited liability company" || selected_company_type == "Singapore limited liability company") {

                        if($directorFieldcontainer.length == 1) {
                            $directorFieldcontainer.each(function(k, obj){
                                persons.push($(obj).find(".director-name").val());
                            });                  
                        }else {
                            persons.push(""); // no validation required if more than one director appointed
                        }

                        persons.push($secretaryFieldcontainer.find("#secretary_1_name").val());

                        // console.log(persons);
                        // console.log($directorFieldcontainer.length);

                        custom_err_msg = "The same person may not act as sole director and secretary.  You may either appoint one more director or request Offshore Company Solutions to provide a professional director or company secretary.";

                        // check if empty then let other validation do the work
                        var empty_field = false;
                        $.each(persons, function(k, person){
                            if(person==="") empty_field = true;
                        });

                        if(selected_company_type != "Malta limited liability company" && selected_company_type != "Ras Al Khaimah offshore company" && empty_field===false && persons.allValuesSame()===true) {
                            alert(custom_err_msg);

                            return false;
                        }

                    }else {

                        if(nomineeShareholder.checked===false) {
                            $shareholderFieldcontainer.each(function(k, obj){
                                persons.push($(obj).find(".shareholder-name").val());
                            });

                            $directorFieldcontainer.each(function(k, obj){
                                persons.push($(obj).find(".director-name").val());
                            });              

                            persons.push($secretaryFieldcontainer.find("#secretary_1_name").val());

                            custom_err_msg = "The same person may not act as sole shareholder, director and secretary.  You may either appoint one more shareholder or director or request Offshore Company Solutions to provide a nominee shareholder, professional director or company secretary.";

                            // check if empty then let other validation do the work
                            var empty_field = false;
                            $.each(persons, function(k, person){
                                if(person==="") empty_field = true;
                            });

                            if(selected_company_type != "Malta limited liability company" && selected_company_type != "Ras Al Khaimah offshore company" && empty_field===false && persons.allValuesSame()===true) {
                                alert(custom_err_msg);

                                return false;
                            }
                        }                        

                    }
                }

                return true;
            }

            ////////////
            //// CHANGE STEPS
            ////////////

            function moveToTop() {
                window.scrollTo(0, 420);
            }

            function changeNextStep(id, hash){

                var $form1 = $("#registration-page-form-1-1");
                var $form2 = $("#registration-page-form-2");
                validateForm($form1, 1);

                if($form1.valid() && $form2.valid()) {

                    $(".active").removeClass("active");
                    $("#step-"+id).addClass("active");

                    $(".btn-primary").removeClass("btn-primary").addClass("btn-default").prop( "disabled", false );
                    $(".step-"+id+"-circle").removeClass("btn-default").addClass("btn-primary").prop( "disabled", true );

                    $(".active-step").removeClass("active-step");
                    $(".step-"+id+"-circle").parent().addClass("active-step");

                    moveToTop();

                    updateHashInURL(hash);

                }
                
                // if(id=="1-1"|| id=="1-2") {
                //     $("#step-2").find(".back-btn").data("id", id);
                //     $(".step-1-circle").data("id", id);

                //     add the chosen route to hidden field
                //     if(id=="1-1") {
                //         update_input_val(1, "#chosen_route");
                //         on_route_change(1);
                //     }
                //     else {
                //         update_input_val(2, "#chosen_route");
                //         on_route_change(2); 
                //     } 

                // }                
            }

            function changePrevStep(id, hash) {
                
                $(".active").removeClass("active");
                $("#step-"+id).addClass("active");                
                
                $(".btn-primary").removeClass("btn-primary").addClass("btn-default").prop( "disabled", false );
                $(".step-"+id+"-circle").removeClass("btn-default").addClass("btn-primary").prop( "disabled", true );

                $(".active-step").removeClass("active-step");
                $(".step-"+id+"-circle").parent().addClass("active-step");

                moveToTop();

                updateHashInURL(hash);
            }

            ////////////
            //// CLONE FORM
            ////////////

            function cloneForm($el) {
                var html = $el.children(".field-container").clone();
                $el.next(".pasteclone").append(html);
            }

            function amendFields(fieldID, selector, lblName, $fieldContainer, action) {
                // for name validation
                var currentFieldName = "#"+selector+"_"+fieldID+"_name";

                // for name validation
                var allFieldIds = ["#shareholder_1_name","#shareholder_2_name","#shareholder_3_name","#shareholder_4_name","#shareholder_5_name","#director_1_name","#director_2_name","#director_3_name","#director_4_name","#director_5_name","#secretary_1_name"];

                // for name validation
                var otherFieldsIdsExceptCurrent = $.grep(allFieldIds, function(id, index) {
                   return id != currentFieldName
                });

                var selected_company_type = $(".type_of_company option:selected").text();                

                $fieldContainer.find("label.name").html(lblName+" "+fieldID);
                $fieldContainer.find("label.address").html(lblName+" "+fieldID+" address").data("person-id", fieldID);        

                $fieldContainer.find("select."+selector+"-type").attr("name", selector+"_"+fieldID+"_type").attr("id", selector+"_"+fieldID+"_type").attr("data-"+selector+"-id", fieldID);        

                $fieldContainer.find("input."+selector+"-type").attr("name", selector+"_"+fieldID+"_type_switch[]").attr("id", selector+"_"+fieldID+"_type").attr("data-"+selector+"-id", fieldID).next(".switchery").remove();

                $fieldContainer.find("input, select").removeClass("error").attr("disabled", false);

                if(action!=="delete") $fieldContainer.find("."+selector+"-name").val("");
                $fieldContainer.find("."+selector+"-name").attr("name", selector+"_"+fieldID+"_name").attr("id", selector+"_"+fieldID+"_name").attr("data-"+selector+"-id", fieldID).attr("placeholder", "Name");

                if(fieldID==1) {
                    $fieldContainer.find("."+selector+"-name").rules("add", {
                        required: true                       
                    });
                }else {
                    $fieldContainer.find("."+selector+"-name").rules("add", {
                        required: {
                            depends : function(elem) {
                                if($fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                                else return false;
                            }
                        }
                        // ,notEqualTo: otherFieldsIdsExceptCurrent                        
                    });                        
                }                

                if(action!=="delete") $fieldContainer.find("."+selector+"-address").val("");
                $fieldContainer.find("."+selector+"-address").attr("name", selector+"_"+fieldID+"_address").attr("id", selector+"_"+fieldID+"_address").attr("data-"+selector+"-id", fieldID).attr("placeholder", "Street")

                if(fieldID==1) {
                    $fieldContainer.find("."+selector+"-address").rules("add", {
                        required: true
                    });
                }else {
                    $fieldContainer.find("."+selector+"-address").rules("add", {
                        required: {
                            depends : function(elem) {
                                if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                                else return false;
                            }
                        }
                    });
                }                    

                if(action!=="delete") $fieldContainer.find("."+selector+"-address-2").val("");
                $fieldContainer.find("."+selector+"-address-2").attr("name", selector+"_"+fieldID+"_address_2").attr("id", selector+"_"+fieldID+"_address_2").attr("data-"+selector+"-id", fieldID).attr("placeholder", "City");

                if(fieldID==1) {
                    $fieldContainer.find("."+selector+"-address-2").rules("add", {
                        required: true
                    });
                }else {
                    $fieldContainer.find("."+selector+"-address-2").rules("add", {
                        required: {
                            depends : function(elem) {
                                if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                                else return false;
                            }
                        }
                    });
                }

                if(action!=="delete") $fieldContainer.find("."+selector+"-address-3").val("");
                $fieldContainer.find("."+selector+"-address-3").attr("name", selector+"_"+fieldID+"_address_3").attr("id", selector+"_"+fieldID+"_address_3").attr("data-"+selector+"-id", fieldID).attr("placeholder", "State");

                // .rules("add", {
                //         required: {
                //             depends : function(elem) {
                //                 if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                //                 else return false;
                //             }
                //         }
                //     });

                if(action!=="delete") $fieldContainer.find("."+selector+"-address-4").val("");
                $fieldContainer.find("."+selector+"-address-4").attr("name", selector+"_"+fieldID+"_address_4").attr("id", selector+"_"+fieldID+"_address_4").attr("data-"+selector+"-id", fieldID);
                            
                if(fieldID==1) {
                    $fieldContainer.find("."+selector+"-address-4").rules("add", {
                        required: true
                    });
                }else {
                    $fieldContainer.find("."+selector+"-address-4").rules("add", {
                        required: {
                            depends : function(elem) {
                                if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                                else return false;
                            }
                        }
                    });
                }
                if(action!=="delete") $fieldContainer.find("."+selector+"-telephone").val("");
                $fieldContainer.find("."+selector+"-telephone").attr("name", selector+"_"+fieldID+"_telephone").attr("id", selector+"_"+fieldID+"_telephone").attr("data-"+selector+"-id", fieldID).attr("placeholder", "Telephone");

                if(fieldID==1) {
                    $fieldContainer.find("."+selector+"-telephone").rules("add", {
                        required: true,
                        telephone: true
                    });                    
                } else {
                    $fieldContainer.find("."+selector+"-telephone").rules("add", {
                        required: {
                            depends : function(elem) {
                                if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="") return true;
                                else return false;
                            }
                        },
                        telephone: true
                    });
                }
                if(selector=="shareholder") {
                    if(action!=="delete") $fieldContainer.find("."+selector+"-amount").val("");
                    $fieldContainer.find("."+selector+"-amount").attr("name", "shareamount_"+fieldID+"_amount").attr("id", selector+"_"+fieldID+"_amount").attr("data-"+selector+"-id", fieldID).attr("placeholder", "")

                    if(fieldID==1) {
                        $fieldContainer.find("."+selector+"-amount").rules("add", {
                            required: true
                        }); 
                    }else {
                        $fieldContainer.find("."+selector+"-amount").rules("add", {
                            required: {
                                depends : function(elem) {
                                    if($fieldContainer.find("."+selector+"-name").val()!="" || $fieldContainer.find("."+selector+"-address").val()!="" || $fieldContainer.find("."+selector+"-address-2").val()!="" || $fieldContainer.find("."+selector+"-address-3").val()!="" || $fieldContainer.find("."+selector+"-address-4").val()!="" || $fieldContainer.find("."+selector+"-telephone").val()!="") return true;
                                    else return false;
                                }
                            }
                        });
                    }
                }

                initInputTel($fieldContainer.find("."+selector+"-telephone"));
                initPlugin($fieldContainer.find(".person-type-1-switch"));
                initPlugin($fieldContainer.find(".person-type-2-switch"));  

                if(selected_company_type=="Singapore limited liability company"){
                    $(".director").find(".switch-container").hide();
                    $(".secretary").find(".switch-container").hide();
                }else if(selected_company_type=="Irish limited liability company"){
                    $(".director").find(".switch-container").hide();
                }else if(selected_company_type=="Malta limited liability company"){
                    $(".secretary").find(".switch-container").hide();
                }else {
                    $(".director").find(".switch-container").show();
                    $(".secretary").find(".switch-container").show();
                }
            }

            function updateExistingFieldsAfterDelete(selector) {
                var $fieldContainers = $("."+selector).find(".pasteclone").find(".field-container");

                $fieldContainers.each(function(i, obj){
                    var fieldID = i + 1;
                    var lblName = selector.charAt(0).toUpperCase() + selector.slice(1);
                    var $fieldContainer = $(obj);

                    amendFields(fieldID, selector, lblName, $fieldContainer, "delete");

                });
            }

            function updateClonedFields($pasteclone, selector) {
                var fieldID = $("."+selector).find(".pasteclone").find(".field-container").length;
                var $fieldContainer = $pasteclone.find(".field-container").last();
                var lblName = selector.charAt(0).toUpperCase() + selector.slice(1);

                amendFields(fieldID, selector, lblName, $fieldContainer, "add");

            }

            //////////
            /// AJAX REQUEST
            //////////

            function makeRequest(Data, URL, Method) {

                var request = $.ajax({
                    url: URL,
                    type: Method,
                    data: Data,
                    success: function(response) {
                        // if success remove current item
                        // console.log(response);
                    },
                    error: function( error ){
                        // Log any error.
                        console.log("ERROR:", error);
                    }
                });

                return request;
            };

            function makeJsonpRequest(Data, URL, Method) {
                
                var request = $.ajax({
                    url: URL,
                    crossDomain: true,
                    type: Method,
                    data: Data,
                    dataType: "jsonp",
                    jsonpCallback: "jsonpCallback",
                    contentType: "application/json; charset=utf-8;",                    
                    success: function (data) {
                        // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        // console.log(status + "; " + error);
                    }
                });

                return request;

            }

            function failedRequest(response){
                response.fail(function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                });
            }

            ///////////
            /// FILE UPLOAD
            ///////////

            function initFileUpload($selector) {
                $selector.each(function(i, obj) {
                    var $button = $(obj).prev("button");                    
                    var selector = $(obj).attr("data-fieldname");

                    var url = "'.SITEURL.'/b/api/uploadfiles";
                    $(obj).fileupload({
                        url: url,
                        dataType: "json",
                        formData: { "user_name" : "'.$user_name.'" },
                        done: function (e, data) {

                            var shortText = jQuery.trim(data.result.file.org_name).substring(0, 30).trim(this);

                            $("input[name="+selector+"]").val(data.result.file.name);
                            $("#"+selector+"_files").html("");
                            $("<p/>").text(shortText).appendTo("#"+selector+"_files");
                            $("#"+selector+"_files").parent().find("label.error").hide();

                            $button.text($button.data("btn-text"));

                        }
                    }).prop("disabled", !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : "disabled"); 

                });                
  
            }

            ///////////
            /// DOM MANIPULATION
            ///////////

            function createTemplate(selector) {
                var source = $(selector).html(),
                    template = Handlebars.compile(source);

                return template;
            }

            function appendToSelect(data, selector) {
                $.each(data, function(index, each_data){
                    var option = new Option(each_data.name, each_data.id);
                    $(option).data("prices", each_data.price);
                    $(option).data("prices_eu", each_data.price_eu);
                    $("."+selector).append($(option));                    
                });
            }

            function appendToHtml(data, selector) {
                $(selector).html(data);
            }

            function createTemplateAndAppendHtml(template_selector, newdata, append_to_selector) {
                var template = createTemplate(template_selector);
                var data = template(newdata);
                
                appendToHtml(data, append_to_selector);
            }            

            function on_route_change(route) {
                if(route==1) {
                    $("#route-1-summary").show();                       
                    $("#route-2-summary").hide(); 

                    if(currency=="Euro (€)")
                        appendToHtml("€"+prices_eu["jurisdiction"], "#summaryjurisdiction-price");
                    else
                        appendToHtml("US$"+prices["jurisdiction"], "#summaryjurisdiction-price");       

                    if(currency=="Euro (€)") appendToHtml("€0.00", "#summarycompany-price");
                    else appendToHtml("US$0.00", "#summarycompany-price");

                    update_input_val("", "#shelf_company_id"); // summary forms                    

                }else {                    
                    $("#route-2-summary").show();                    
                    $("#route-1-summary").hide();

                    if(currency=="Euro (€)") appendToHtml("€0.00", "#summaryjurisdiction-price");
                    else appendToHtml("US$0.00", "#summaryjurisdiction-price");
                }
            }

            function update_input_val(data, selector) {                
                $(selector).val(data);
            }

            function addAmount(amount, add_amount) {
                if(add_amount=="") add_amount = 0;
                amount += parseFloat(add_amount);
                return amount;
            }         

            function updateHashInURL(hash) {
                window.location.hash = hash;
                return false;
            }

            var director_switches = []; // to use for disabling director switch later on
            function initPlugin(selector) {
                
                if(selector.jquery) {
                    var elems = [];
                    elems.push(selector.get(-1));
                }else {
                    // init plugin
                    var elems = Array.prototype.slice.call(document.querySelectorAll(selector));
                }                

                elems.forEach(function(html) {
                    var init = new Switchery(html, { color: "#008b9b" });
                    var selected_company_type = $(".type_of_company option:selected").text();
                    var nomineeShareholder = document.querySelector("#nominee_shareholder");                    

                    if(selector.jquery) {
                        if($(html).data("selector")=="director" && selected_company_type == "Malta limited liability company") {

                            director_switches.push(init);

                            if(nomineeShareholder.checked===false || $(".shareholder").find(".pasteclone").find(".field-container").length == 1) {
                                init.disable();
                            }

                        }
                    }                 

                    if($(html).hasClass("js-switch")) {
                        html.onchange = function() {

                            if($(html).attr("id")=="nominee_shareholder" && selected_company_type == "Malta limited liability company") {
                                // if shareholder count is greater than one or ocs shareholder is selected
                                if(html.checked) {
                                    $.each(director_switches, function(k, obj){
                                        // console.log(obj.element.disabled);
                                        if($(obj.element).is(":disabled"))
                                            obj.enable();
                                    });
                                }else {

                                    // disable only if there is one shareholder
                                    if($(".shareholder").find(".pasteclone").find(".field-container").length == 1) {
                                        //reset back to individual only if company was chosen
                                        if(director_switches[0].element.checked===false)
                                            $(director_switches[0].element).trigger("click"); 

                                        $.each(director_switches, function(k, obj){ 
                                            obj.disable();
                                        });    
                                    }
                                    
                                }
                            }

                            if(html.checked) {
                                $(html).parent().parent().find(".key-person-info").hide();
                                $(html).parent().parent().find(".key-person-info").find(".field-container").find("input[type=\"text\"].person-input").val("");
                                // $(html).parent().parent().find(".key-person-info").find(".field-container").find("select.person-input").prop("selectedIndex", 0);
                                $(html).parent().parent().find(".add-remove-btn-container-director").hide();
                                $(html).parent().parent().find(".nominee-container").show();
                                
                            }else {
                                $(html).parent().parent().find(".key-person-info").show();
                                $(html).parent().parent().find(".add-remove-btn-container-director").show();
                                $(html).parent().parent().find(".nominee-container").hide();                                
                            } 
                        };
                    }else if($(html).hasClass("person-type-1-switch")) {
                        html.onchange = function() {
                            var switch2_state = $(html).parent().find(".person-type-2-switch").is(":checked");
                            var current_value;
                            if(html.checked==false && switch2_state==false){
                                $(html).parent().find(".person-type-2-switch").trigger("click");
                                current_value = $(html).parent().find(".person-type-2-switch").val();
                            }
                            else if(html.checked==true && switch2_state==true) {
                                $(html).parent().find(".person-type-2-switch").trigger("click");                                
                                current_value = $(html).val(); // if switch 1 is checked, get switch 1 value
                            }
                            $(html).parent().parent().find(".person-type").val(current_value).trigger("change");
                        }
                    }else if($(html).hasClass("person-type-2-switch")) {
                        html.onchange = function() {
                            var switch1_state = $(html).parent().find(".person-type-1-switch").is(":checked");
                            var current_value;
                            if(html.checked==true && switch1_state==true) {
                                $(html).parent().find(".person-type-1-switch").trigger("click");
                                current_value = $(html).val();
                            }
                            else if(html.checked==false && switch1_state==false) {
                                $(html).parent().find(".person-type-1-switch").trigger("click");                                
                                current_value = $(html).parent().find(".person-type-1-switch").val();
                            }
                            $(html).parent().parent().find(".person-type").val(current_value).trigger("change");
                        }
                    }else if($(html).hasClass("service-js-switch")) {
                        html.onchange = function() {
                            var countryId = $(html).data("country-id");
                            var serviceId = $(html).data("service-id");
                            var serviceName = $(html).data("service-name");

                            if(html.checked) {                                
                                $(".service-"+serviceId+"-country-"+countryId).prop("disabled", false);                                
                                if(serviceName=="Bank accounts") {
                                    // console.log("hi")
                                    $(".credit_card_in_country_"+countryId).prop("disabled", false);
                                }                                
                            }else {
                                $(".service-"+serviceId+"-country-"+countryId).prop("disabled", true);
                                if(serviceName=="Bank accounts") {
                                    $(".credit_card_in_country_"+countryId).val("").trigger("change");    
                                    $(".credit_card_in_country_"+countryId).prop("disabled", true);    
                                }                                                                
                            }
                        }
                    }
                });                                            

            }

            function on_nominee_switch_change(selector, switch_input, price, price_eu) {
                if ($(switch_input).prop("checked")) {
                    $(".summary-"+selector+"-price-container").show();

                    if(currency=="Euro (€)") $("#summary-"+selector+"-price").html("<p>€"+price_eu+"</p>");
                    else $("#summary-"+selector+"-price").html("<p>US$"+price+"</p>");

                    $("#nominee_"+selector+"_annual_fee").prop("checked", true);
                } 
                else {
                    $(".summary-"+selector+"-price-container").hide();

                    if(currency=="Euro (€)") $("#summary-"+selector+"-price").hide().html("<p>€0.00</p>");
                    else $("#summary-"+selector+"-price").hide().html("<p>US$0.00</p>");
                    $("#nominee_"+selector+"_annual_fee").prop("checked", false);
                } 
                $("#nominee_"+selector+"_annual_fee").val(price);
            }

            function updateSummaryTotal() {
                var summaryTotal = 0;             
                var cur_symbol = "US$";   
                $("#registration-page-form-4").find(".summary-price").each(function(index, obj){
                    var eachPrice = $(obj).text();                    

                    if(currency=="Euro (€)") cur_symbol = "€";

                    // console.log($(obj));
                    // console.log(eachPrice);

                    var priceArr = eachPrice.split(cur_symbol);

                    // console.log(priceArr);

                    summaryTotal += parseFloat(priceArr[1]);
                });

                $(".total-summary-price").html("<h6>"+cur_symbol+summaryTotal+"</h6>");
            }

            function updateKeyPersonnelSummary() {
                
                var chosen_route = $("#chosen_route").val();

                var directors = $("input.director-name").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var director_type = $("select.director-type").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var input_director_type = $("input.director-type").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var director_address = $("input.director-address").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var director_address_2 = $("input.director-address-2").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var director_address_3 = $("input.director-address-3").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var director_address_4 = $("select.director-address-4").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var director_telephone = $("input.director-telephone").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });

                // console.log(input_director_type);

                var secretaries = $("input.secretary-name").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var secretary_type = $("select.secretary-type").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var secretary_address = $("input.secretary-address").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var secretary_address_2 = $("input.secretary-address-2").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var secretary_address_3 = $("input.secretary-address-3").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var secretary_address_4 = $("select.secretary-address-4").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var secretary_telephone = $("input.secretary-telephone").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });

                var shareholders = $("input.shareholder-name").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var shareholder_type = $("select.shareholder-type").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var shareholder_amounts = $("input.shareholder-amount").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var shareholder_address = $("input.shareholder-address").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var shareholder_address_2 = $("input.shareholder-address-2").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var shareholder_address_3 = $("input.shareholder-address-3").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var shareholder_address_4 = $("select.shareholder-address-4").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });
                var shareholder_telephone = $("input.shareholder-telephone").serializeArray().filter(function(k) { return $.trim(k.value) != "" && $.trim(k.value) != 0; });

                var services = $("input.service-name").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });                
                var services_ids = $("input.service-id").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });     
                var services_countries = [];
                var services_countries_ids = [];
                var services_prices = [];
                var services_credit_card_counts = [];                

                for(index = 0; index < services_ids.length; index++) {
                    services_countries_ids[index] = $("input.service-"+services_ids[index].value+"-country-id").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                    services_countries[index] = $("input.service-"+services_ids[index].value+"-country").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                    services_prices[index] = $("input.service-"+services_ids[index].value+"-price").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                    services_credit_card_counts[index] = $("input.service-"+services_ids[index].value+"-credit-card-count").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                }

                var info_services = $("input.info-service-id").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var info_services_names = $("input.info-service-name").serializeArray().filter(function(k) { return $.trim(k.value) != ""; });

                for(index =0; index < info_services.length; index++) {
                    if(info_services_names[index] && info_services_names[index].name) info_services[index].service_name = info_services_names[index].name;
                    if(info_services_names[index] && info_services_names[index].value) info_services[index].service_value = info_services_names[index].value;
                }

                var selectedData = [];

                // amend shareholders
                for(index = 0; index < shareholders.length; index++) {
                    if(shareholder_type[index] && shareholder_type[index].name) shareholders[index].type_name = shareholder_type[index].name;
                    if(shareholder_type[index] && shareholder_type[index].value) shareholders[index].type_value = shareholder_type[index].value;

                    if(shareholder_amounts[index] && shareholder_amounts[index].name) shareholders[index].amount_name = shareholder_amounts[index].name;
                    if(shareholder_amounts[index] && shareholder_amounts[index].value) shareholders[index].amount_value = shareholder_amounts[index].value;

                    if(shareholder_address[index] && shareholder_address[index].name) shareholders[index].address_name = shareholder_address[index].name;
                    if(shareholder_address[index] && shareholder_address[index].value) shareholders[index].address_value = shareholder_address[index].value;

                    if(shareholder_address_2[index] && shareholder_address_2[index].name) shareholders[index].address_2_name = shareholder_address_2[index].name;
                    if(shareholder_address_2[index] && shareholder_address_2[index].value) shareholders[index].address_2_value = shareholder_address_2[index].value;

                    if(shareholder_address_3[index] && shareholder_address_3[index].name) shareholders[index].address_3_name = shareholder_address_3[index].name;
                    if(shareholder_address_3[index] && shareholder_address_3[index].value) shareholders[index].address_3_value = shareholder_address_3[index].value;

                    if(shareholder_address_4[index] && shareholder_address_4[index].name) shareholders[index].address_4_name = shareholder_address_4[index].name;
                    if(shareholder_address_4[index] && shareholder_address_4[index].value) shareholders[index].address_4_value = shareholder_address_4[index].value;

                    if(shareholder_telephone[index] && shareholder_telephone[index].name) shareholders[index].telephone_name = shareholder_telephone[index].name;
                    if(shareholder_telephone[index] && shareholder_telephone[index].value) shareholders[index].telephone_value = shareholder_telephone[index].value;
                }

                // amend directors
                for(index = 0; index < directors.length; index++) {                    
                    if(director_type[index] && director_type[index].name) directors[index].type_name = director_type[index].name;
                    if(director_type[index] && director_type[index].value) directors[index].type_value = director_type[index].value; else directors[index].type_value = 1;

                    if(director_address[index] && director_address[index].name) directors[index].address_name = director_address[index].name;
                    if(director_address[index] && director_address[index].value) directors[index].address_value = director_address[index].value;

                    if(director_address_2[index] && director_address_2[index].name) directors[index].address_2_name = director_address_2[index].name;
                    if(director_address_2[index] && director_address_2[index].value) directors[index].address_2_value = director_address_2[index].value;

                    if(director_address_3[index] && director_address_3[index].name) directors[index].address_3_name = director_address_3[index].name;
                    if(director_address_3[index] && director_address_3[index].value) directors[index].address_3_value = director_address_3[index].value;

                    if(director_address_4[index] && director_address_4[index].name) directors[index].address_4_name = director_address_4[index].name;
                    if(director_address_4[index] && director_address_4[index].value) directors[index].address_4_value = director_address_4[index].value;

                    if(director_telephone[index] && director_telephone[index].name) directors[index].telephone_name = director_telephone[index].name;
                    if(director_telephone[index] && director_telephone[index].value) directors[index].telephone_value = director_telephone[index].value;
                }

                if(secretaries.length > 0) {
                    if(secretary_type[0] && secretary_type[0].name) secretaries[0].type_name = secretary_type[0].name;
                    if(secretary_type[0] && secretary_type[0].value) secretaries[0].type_value = secretary_type[0].value;

                    if(secretary_address[0] && secretary_address[0].name) secretaries[0].address_name = secretary_address[0].name;
                    if(secretary_address[0] && secretary_address[0].value) secretaries[0].address_value = secretary_address[0].value;

                    if(secretary_address_2[0] && secretary_address_2[0].name) secretaries[0].address_2_name = secretary_address_2[0].name;
                    if(secretary_address_2[0] && secretary_address_2[0].value) secretaries[0].address_2_value = secretary_address_2[0].value;

                    if(secretary_address_3[0] && secretary_address_3[0].name) secretaries[0].address_3_name = secretary_address_3[0].name;
                    if(secretary_address_3[0] && secretary_address_3[0].value) secretaries[0].address_3_value = secretary_address_3[0].value;    

                    if(secretary_address_4[0] && secretary_address_4[0].name) secretaries[0].address_4_name = secretary_address_4[0].name;
                    if(secretary_address_4[0] && secretary_address_4[0].value) secretaries[0].address_4_value = secretary_address_4[0].value;    

                    if(secretary_telephone[0] && secretary_telephone[0].name) secretaries[0].telephone_name = secretary_telephone[0].name;
                    if(secretary_telephone[0] && secretary_telephone[0].value) secretaries[0].telephone_value = secretary_telephone[0].value;    
                }
                

                // console.log(shareholders)            
                // console.log(services_prices);
                // console.log(services_credit_card_counts);
                // console.log(services_countries_ids);
                // console.log(services_countries);
                // console.log(services);

                for(index = 0; index < services.length; index++) {
                    if(services_ids[index] && services_ids[index].name) services[index].service_id_name = services_ids[index].name;
                    if(services_ids[index] && services_ids[index].value) services[index].service_id_value = services_ids[index].value;

                    services[index].countries = services_countries[index];

                    $.each(services[index].countries, function(i, v){
                        if(services_prices[index].length > 0) {
                            if(services_credit_card_counts[index].length > 0) {
                                if(services_credit_card_counts[index][i]) {
                                    v.service_country_id_name = services_countries_ids[index][i].name;
                                    v.service_country_id_value = services_countries_ids[index][i].value;                            
                                    v.service_price_name = services_prices[index][i].name;
                                    var total_credit_card_price = parseFloat(services_prices[index][i].value) * parseFloat(services_credit_card_counts[index][i].value);
                                    v.service_price_value = total_credit_card_price;
                                    v.services_credit_card_counts_name = services_credit_card_counts[index][i].name;
                                    v.services_credit_card_counts_value = services_credit_card_counts[index][i].value;                                      
                                }                                
                            }else {
                                v.service_country_id_name = services_countries_ids[index][i].name;
                                v.service_country_id_value = services_countries_ids[index][i].value;
                                v.service_price_name = services_prices[index][i].name;
                                v.service_price_value = services_prices[index][i].value;
                            }                                                    
                        }                        
                    });                    
                }                

                services.currency = "'.$currency.'";
                // console.log(services);
                // console.log(info_services);
                // console.log(secretaries);
                
                selectedData["shareholders"] = shareholders;
                selectedData["directors"] = directors;
                selectedData["secretaries"] = secretaries;
                selectedData["services"] = services;
                selectedData["infoservices"] = info_services;

                // console.log(services);

                createTemplateAndAppendHtml("#summaryshareholder-template", selectedData, "#summaryshareholder");
                createTemplateAndAppendHtml("#summarydirector-template", selectedData, "#summarydirector");
                createTemplateAndAppendHtml("#summarysecretary-template", selectedData, "#summarysecretary");
                createTemplateAndAppendHtml("#summaryservice-template", selectedData, "#summaryservice");
                createTemplateAndAppendHtml("#summaryinfoservice-template", selectedData, "#summaryinfoservice");

                // temp fix
                $("#summarydirector").removeClass("half-field-container-2");
                $("#summarysecretary").removeClass("half-field-container-2");

                $("#summary_total_share").val($("#total_share").val());

                on_nominee_switch_change("director", $("input#nominee_director"), prices["directors"], prices_eu["directors"]);
                on_nominee_switch_change("shareholder", $("input#nominee_shareholder"), prices["shareholders"], prices_eu["shareholders"]);
                on_nominee_switch_change("secretary", $("input#nominee_secretary"), prices["secretaries"], prices_eu["secretaries"]);                                     

                updateSummaryTotal();

                initFileUpload($(".passport_upload"));
                initFileUpload($(".bill_upload"));

                $(".passport_upload").each(function(i, obj){
                    var selector = $(obj).data("selector");
                    var $this = $(this);                    

                    if($("#"+selector+"_type").val()==2) {
                        $this.prev("button").text("Upload incorporation certificate").data("btn-text", "Incorporation certificate uploaded");
                    }
                });

                $(".bill_upload").each(function(i, obj){
                    var selector = $(obj).data("selector");
                    var $this = $(this);                    

                    if($("#"+selector+"_type").val()==2) {
                        $this.prev("button").text("Upload memo & articles").data("btn-text", "Memo & articles uploaded");
                    }
                });

                
                var $form4 = $("#registration-page-form-4");
                validateForm($form4, 4);

            }

            function updateOnJurisdictionChange(selectedCompanyTypeName, selectedCompanyTypePrice, selectedCompanyTypeId){
                appendToHtml(selectedCompanyTypeName, ".summaryjurisdiction-name");
                appendToHtml(selectedCompanyTypeName, "#jurisdiction-name");
                if(currency=="Euro (€)") appendToHtml("€"+selectedCompanyTypePrice, "#jurisdiction-price");
                else appendToHtml("US$"+selectedCompanyTypePrice, "#jurisdiction-price");
                update_input_val(selectedCompanyTypeId, "#jurisdiction_id"); // summary form
            }

            function isNumeric(n) {
              return !isNaN(parseFloat(n)) && isFinite(n);
            }

            function initInputTel($selector) {
                $selector.intlTelInput({
                    utilsScript: "'.JS.'/plugins/utils.js",
                    nationalMode: false,
                    preferredCountries: [],
                    autoPlaceholder: false
                });

                $selector.intlTelInput("setCountry", country);
            }

            function fillForm2WithSavedData() {
                if($.isEmptyObject(query)===false) {                    
                    var data_query = setToRetrieveSavedData(query);
                    var response = getSavedData(data_query);

                    response.done(function(data, textStatus, jqXHR){                    
                        if(jqXHR.status==200) {
                            savedData = data.saved_data.companies[0];

                            if(data.saved_data.nominee_shareholder==1) $("#step-2").find("#nominee_shareholder").trigger("click");
                            if(data.saved_data.nominee_director==1) $("#step-2").find("#nominee_director").trigger("click");
                            if(data.saved_data.nominee_secretary==1) $("#step-2").find("#nominee_secretary").trigger("click");                            

                            $.each(data.saved_data.companywpuser_shareholders, function(i, shareholder){
                                // console.log(shareholder)
                                var id = parseInt(i+1);
                                if(id>1) $(".add-more-shareholder").trigger("click");

                                $("#step-2").find("select[name=shareholder_"+id+"_type]").val(shareholder.type).trigger("change");
                                $("#step-2").find("input[name=shareholder_"+id+"_name]").val(shareholder.name);
                                $("#step-2").find("input[name=shareholder_"+id+"_address]").val(shareholder.address);
                                $("#step-2").find("input[name=shareholder_"+id+"_address_2]").val(shareholder.address_2);
                                $("#step-2").find("input[name=shareholder_"+id+"_address_3]").val(shareholder.address_3);
                                $("#step-2").find("select[name=shareholder_"+id+"_address_4]").val(shareholder.address_4);
                                $("#step-2").find("input[name=shareholder_"+id+"_telephone]").val(shareholder.telephone);
                                $("#step-2").find("input[name=shareamount_"+id+"_amount]").val(shareholder.share_amount).trigger("keyup");
                                
                            });

                            $.each(data.saved_data.companywpuser_directors, function(i, director){
                                // console.log(director)
                                var id = parseInt(i+1);
                                if(id>1) $(".add-more-director").trigger("click");

                                $("#step-2").find("select[name=director_"+id+"_type]").val(director.type).trigger("change");
                                $("#step-2").find("input[name=director_"+id+"_name]").val(director.name);
                                $("#step-2").find("input[name=director_"+id+"_address]").val(director.address);
                                $("#step-2").find("input[name=director_"+id+"_address_2]").val(director.address_2);
                                $("#step-2").find("input[name=director_"+id+"_address_3]").val(director.address_3);
                                $("#step-2").find("select[name=director_"+id+"_address_4]").val(director.address_4);
                                $("#step-2").find("input[name=director_"+id+"_telephone]").val(director.telephone);
                                
                            });

                            $.each(data.saved_data.companywpuser_secretaries, function(i, secretary){
                                // console.log(secretary)
                                var id = parseInt(i+1);
                                if(id>1) $(".add-more-secretary").trigger("click");

                                $("#step-2").find("select[name=secretary_"+id+"_type]").val(secretary.type).trigger("change");
                                $("#step-2").find("input[name=secretary_"+id+"_name]").val(secretary.name);
                                $("#step-2").find("input[name=secretary_"+id+"_address]").val(secretary.address);
                                $("#step-2").find("input[name=secretary_"+id+"_address_2]").val(secretary.address_2);
                                $("#step-2").find("input[name=secretary_"+id+"_address_3]").val(secretary.address_3);
                                $("#step-2").find("select[name=secretary_"+id+"_address_4]").val(secretary.address_4);
                                $("#step-2").find("input[name=secretary_"+id+"_telephone]").val(secretary.telephone);                                    
                                
                            });

                            // console.log(data_query.referral);

                            if(data_query.referral===false) {
                                $("#step-2").find(".next-btn").trigger("click");    
                            }                        

                            ///////

                            // console.log(data.saved_data.servicescountries)

                            $.each(data.saved_data.servicescountries, function(i, service){
                                var country_id = service.country_id;
                                var service_id = service.service_id;
                                var credit_card_count = service.pivot.credit_card_count;
                                // if(service_id==2) { // bank account service           
                                    // console.log("doing things!");                        
                                    $("#step-3").find(".service-"+service_id+"-country-"+country_id).trigger("click");
                                // }else if(service_id==3) { // credit card service
                                    $("#step-3").find(".service-"+service_id+"-country-"+country_id+"-card-count").val(credit_card_count).trigger("keyup");
                                // }
                            });

                            $.each(data.saved_data.informationservices, function(i, infoservice){
                                $("input[value="+infoservice.id+"].info-service-id").trigger("click");
                            });                            

                            if(data_query.referral===false) {
                                $("#step-3").find(".next-btn").trigger("click");
                            }

                            update_input_val(savedData.id, "#saved_company_id"); // previously saved company id 

                            if(data.saved_data.companywpuser_shareholders.length>0) {                                        
                                // fill summary page uploaded files if any
                                $.each(data.saved_data.companywpuser_shareholders, function(i, shareholder){
                                    var id = parseInt(i+1);
                                    if(shareholder.passport) {
                                        $("#step-4").find("input[name=shareholder_"+id+"_passport]").val(shareholder.passport);    
                                        $("#step-4").find("div#shareholder_"+id+"_passport_files").text(shareholder.passport);
                                    }
                                    if(shareholder.bill) {
                                        $("#step-4").find("input[name=shareholder_"+id+"_bill]").val(shareholder.bill);                                    
                                        $("#step-4").find("div#shareholder_"+id+"_bill_files").text(shareholder.bill);
                                    }
                                });
                            }

                            if(data.saved_data.companywpuser_directors.length>0) {                                
                                // fill summary page uploaded files if any
                                $.each(data.saved_data.companywpuser_directors, function(i, director){
                                    var id = parseInt(i+1);
                                    if(director.passport) {
                                        $("#step-4").find("input[name=director_"+id+"_passport]").val(director.passport);                                    
                                        $("#step-4").find("div#director_"+id+"_passport_files").text(director.passport);    
                                    }
                                    if(director.bill) {
                                        $("#step-4").find("input[name=director_"+id+"_bill]").val(director.bill);
                                        $("#step-4").find("div#director_"+id+"_bill_files").text(director.bill);
                                    }
                                });
                            }

                            if(data.saved_data.companywpuser_secretaries.length>0) {                                
                                // fill summary page uploaded files if any
                                $.each(data.saved_data.companywpuser_secretaries, function(i, secretary){
                                    var id = parseInt(i+1);
                                    if(secretary.passport) {
                                        $("#step-4").find("input[name=secretary_"+id+"_passport]").val(secretary.passport);
                                        $("#step-4").find("div#secretary_"+id+"_passport_files").text(secretary.passport);
                                    }
                                    if(secretary.bill) {
                                        $("#step-4").find("input[name=secretary_"+id+"_bill]").val(secretary.bill);    
                                        $("#step-4").find("div#secretary_"+id+"_bill_files").text(secretary.bill);                                    
                                    }
                                });
                            }
                            
                        }
                    });
                }
            }


            ////////////
            //// EVENTS
            ////////////

            // Bind an event to window.onhashchange that, when the hash changes, gets the
            // hash and adds the class "selected" to any matching nav link.
            $(window).hashchange( function(){
                var hash = location.hash.substring(1);                
                changePrevStep(hash, hash);         
            })

            $(".next-btn").on("click", function(e){
                e.preventDefault();   

                $("#new-incorporation").prop( "checked", true );

                if($(this).data("id")==3) {
                    if(specialValidationStep2()===false) {
                        return false;
                    }
                }

                changeNextStep($(this).data("id"), $(this).data("hash"));

                if($(this).data("id")==2) {

                    initInputTel($(".shareholder-telephone"));
                    initInputTel($(".director-telephone"));
                    initInputTel($(".secretary-telephone"));

                    update_input_val(1, "#chosen_route");
                    on_route_change(1);                    

                    fillForm2WithSavedData();

                }                
                if($(this).data("id")==4) {
                    updateKeyPersonnelSummary();
                }
            });

            $(".back-btn").on("click", function(e){
                e.preventDefault();                
                changePrevStep($(this).data("id"), $(this).data("hash"));
            });

            /////

            $("#step-2").on("click", ".add-more", function(e){
                e.preventDefault();                
                
                var selector = $(this).data("selector");
                var selected_company_type = $(".type_of_company option:selected").text();

                $("."+selector).find(".remove-this").show();

                // if there is two shareholder allow director to be a company 
                if(selector=="shareholder" && selected_company_type=="Malta limited liability company") {
                    // console.log($(".shareholder").find(".pasteclone").find(".field-container").length);
                    if($(".shareholder").find(".pasteclone").find(".field-container").length >= 1) {

                        // enable only if its diabled caz enabling twice have some issue
                        // console.log(director_switches[0].element);
                        if(director_switches[0].element.disabled===true) {
                            $.each(director_switches, function(k, obj){
                                obj.enable();
                            });    
                        }
                        
                    }
                }
                
                if($("."+selector).find(".pasteclone").children(".field-container").length < 5) {
                    cloneForm($(this).parent().parent().find(".cloneable"));
                    updateClonedFields($(this).parent().parent().find(".pasteclone"), $(this).data("selector"));

                }else {
                    alert("Can\'t add more than is 5");
                }                
                
            });

            $("#step-2").on("click", ".remove-this", function(e){
                e.preventDefault();

                var selector = $(this).data("selector");
                var selected_company_type = $(".type_of_company option:selected").text();

                if (confirm("Are you sure you want to remove?")) {                    

                    if($("."+selector).find(".pasteclone").find(".field-container").length > 1) {

                        $(this).parent().parent(".field-container").remove();    
                        updateExistingFieldsAfterDelete(selector);

                        if(selector=="shareholder") {
                            $("."+selector).find(".pasteclone").find(".field-container").find(".person-input").trigger("change");    
                        }
                    
                        if($("."+selector).find(".pasteclone").find(".field-container").length == 1) 
                            $("."+selector).find(".remove-this").hide();

                    }else {
                        alert("Company must have at least one " + selector);
                    }

                    // if there is two shareholder allow director to be a company 
                    if(selector=="shareholder" && selected_company_type=="Malta limited liability company") {
                        // console.log($(".shareholder").find(".pasteclone").find(".field-container").length);

                        // console.log(document.querySelector("#nominee_shareholder").checked);
                        // if shareholder is only 1 and nominee is not selected
                        if($(".shareholder").find(".pasteclone").find(".field-container").length === 1 && document.querySelector("#nominee_shareholder").checked=== false) {

                            //reset back to individual only if company was chosen
                            if(director_switches[0].element.checked===false)
                                $(director_switches[0].element).trigger("click");

                            $.each(director_switches, function(k, obj){
                                obj.disable();
                            });
                        }
                    }
                    
                }

            });

            $("#step-2").on("click", ".remove", function(e){
                e.preventDefault();

                var selector = $(this).data("selector");

                if($(this).parent().parent().find("."+selector+" .field-container").length > 1) {
                    $(this).parent().parent().find(".pasteclone").children(".field-container").last().remove();

                    if($(this).parent().parent().find(".pasteclone").children(".field-container").length < 1) $(this).parent().find(".remove").hide();

                    $("#step-2").find(".person-input").trigger("keyup");
                }
                else {
                    alert("Company must have at least one " + selector);
                }            
                
            });            

            $("#step-4").on("click", ".edit-summary-btn", function(e){
                e.preventDefault();

                $(this).parent().parent().parent().parent().find(".edit-form").show();
                $(this).parent().parent().parent().parent().find(".person-info").hide();
            });

            $("#step-4").on("click", ".save-summary-btn", function(e){
                e.preventDefault();

                var editForm = $(this).parent().parent().parent().find(".edit-form");
                var personInfo = $(this).parent().parent().parent().find(".person-info");                

                editFromValues = editForm.find(".custom-input-class").serializeArray();

                // console.log(editFromValues);

                var valid = true;

                $.each(editFromValues, function(i, v){
                    v.name = v.name.replace("edit_","");

                    if(v.name.indexOf("amount") != -1) {
                        if(isNumeric(v.value)==false || v.value=="" || v.value <= 0) {
                            valid = false;                            
                            $("#summary_"+v.name).addClass("error").attr("placeholder", "Invalid");
                        }else {
                            $("#summary_"+v.name).removeClass("error").attr("placeholder", "");
                            personInfo.find("."+v.name).text(v.value+" shares");    
                            personInfo.find("#"+v.name).val(parseFloat(v.value)); 
                        }
                    }else {
                        if(v.name.indexOf("address_3") == -1 && v.value==""){
                            valid = false;
                            $("#summary_"+v.name).addClass("error").attr("placeholder", "This field is required.");
                        }
                        else {
                            $("#summary_"+v.name).removeClass("error").attr("placeholder", "");
                            personInfo.find("."+v.name).text(v.value);    
                            personInfo.find("#"+v.name).val(v.value);    
                        }
                    }                    
                });

                if(valid) {
                    editForm.hide();
                    personInfo.show();
                }                

            });

            $("#step-4").on("change keyup", ".edit-no-of-card", function(e){
                e.preventDefault();

                var editedVal = $(this).val();
                var editedInputName = $(this).attr("name");

                var totalPrice = $(this).data("price");
                var noOfCard = $(this).data("noofcard");

                if(editedVal=="" || isNaN(editedVal)==true){
                    editedVal = 0;
                }

                var pricePerCard = totalPrice / noOfCard;

                var newtotalPrice = parseFloat(pricePerCard) * parseFloat(editedVal); 

                var currency = "'.$currency.'";

                if(currency=="Euro (€)")
                    $(this).parent().parent().parent().parent().find(".summary-price").text("€"+newtotalPrice);
                else
                    $(this).parent().parent().parent().parent().find(".summary-price").text("US$"+newtotalPrice);

                $(this).parent().parent().parent().find("."+editedInputName).text(editedVal);

                updateSummaryTotal();

            });

            // remove service in summary
            $("#step-4").on("click", ".remove-btn", function(e){
                e.preventDefault();
                $(this).parent().parent().parent().parent().remove();

                var selector = $(this).data("selector");
                
                if($("#"+selector).attr("type")=="checkbox") {
                    $("#"+selector).trigger("click");
                    $("#"+selector+"_annual_fee").prop("checked", false); // for secretary, direcor, shareholder validation

                    updateSummaryTotal();

                    var $form4 = $("#registration-page-form-4"); // to appear error message straight away
                    if(!$form4.valid()) return false;
                }
                else {
                    // console.log(selector)
                    // console.log($("#"+selector).val());
                    $("#"+selector).val("").trigger("change");

                    updateSummaryTotal();
                }                
            });

            $("#step-4").on("click", ".upload-passport-btn", function(e){
                e.preventDefault();
            });

            $("#step-4").on("click", ".upload-bill-btn", function(e){
                e.preventDefault();
            });

            $("#step-4").on("click", ".go-step-2", function(e){
                e.preventDefault();                
                changePrevStep(2, 2);                    
            });

            /////

            $(".step-circle").on("click", function(e){
                e.preventDefault();                         
                changePrevStep($(this).data("id"), $(this).data("hash"));                    
            });

            /////

            var prices = [];
            var prices_eu = [];
            var newdata = [];

            function initTheForms(data, selectedCompanyTypeId, selectedCompanyTypeName, selectedCompanyTypePrice) {

                newdata["rules"] = data.rules;
                createTemplateAndAppendHtml("#company-name-rules-template", newdata, "#company-name-rules");

                data.companies.currency = "'.$currency.'";
                newdata["companies"] = data.companies;
                createTemplateAndAppendHtml("#shelf-companies-template", newdata, "#shelf-companies");

                prices["jurisdiction"] = data.price;
                prices_eu["jurisdiction"] = data.price_eu;
                
                data.shareholders.currency = "'.$currency.'";
                newdata["shareholders"] = data.shareholders;
                createTemplateAndAppendHtml("#shareholder-template", newdata, "#shareholder");
                prices["shareholders"] = data.shareholders[0].price;
                prices_eu["shareholders"] = data.shareholders[0].price_eu;

                var selected_company_type = $(".type_of_company option:selected").text();

                data.directors.selected_company_type = selected_company_type;
                data.directors.currency = "'.$currency.'";
                newdata["directors"] = data.directors;
                createTemplateAndAppendHtml("#director-template", newdata, "#director");
                prices["directors"] = data.directors[0].price;
                prices_eu["directors"] = data.directors[0].price_eu;

                data.secretaries.currency = "'.$currency.'";
                newdata["secretaries"] = data.secretaries;
                createTemplateAndAppendHtml("#secretary-template", newdata, "#secretary");
                prices["secretaries"] = data.secretaries[0].price;
                prices_eu["secretaries"] = data.secretaries[0].price_eu;

                data.services.currency = "'.$currency.'";
                newdata["services"] = data.services;
                createTemplateAndAppendHtml("#service-template", newdata, "#service");             

                // console.log(data.services);

                newdata["informationservices"] = data.informationservices;
                createTemplateAndAppendHtml("#informationservices-template", newdata, "#informationservices");

                director_switches = []; // empty director switch everytime form create

                // init plugin
                initPlugin(".js-switch");
                initPlugin(".info-service-js-switch");
                initPlugin(".service-js-switch");
                initPlugin(".person-type-1-switch");
                initPlugin(".person-type-2-switch");

                // console.log($("#registration-page-form-2"));

                // validate form 2
                var $form2 = $("#registration-page-form-2");
                validateForm($form2, 2);

                $("#shareholder").find(".add-more").trigger("click");
                $("#director").find(".add-more").trigger("click");

                $(".remove-this").hide();

                updateOnJurisdictionChange(selectedCompanyTypeName, selectedCompanyTypePrice, selectedCompanyTypeId);

            }

            $(".step-1").on("change", "select.type_of_company", function(e){                
                
                var selectedCompanyTypeId = $(this).val();
                var selectedCompanyTypeName = $(this).find("option:selected").text();
                if(currency=="Euro (€)") {
                    var selectedCompanyTypePrice = $(this).find("option:selected").data("prices_eu");
                }else {
                    var selectedCompanyTypePrice = $(this).find("option:selected").data("prices");
                }
                var step_id = $(this).data("id");

                if($.isEmptyObject(query)===false) {                    

                    var data = setToRetrieveSavedData(query);                    

                    var response = getSavedData(data);

                    response.done(function(dataResponse, textStatus, jqXHR){                    
                        if(jqXHR.status==200) {                            
                            savedData = dataResponse.saved_data.companies[0];     

                            var getcompanyinclsavedData = {};
                            getcompanyinclsavedData.company_type_id = selectedCompanyTypeId;
                            getcompanyinclsavedData.user_id = data.user_id;
                            
                            var child_response = makeRequest(getcompanyinclsavedData, "'.SITEURL.'/b/admin/jurisdiction/getcompanyinclsaved", "POST");

                            child_response.done(function(getcompanyinclsavedResponse, textStatus, jqXHR){                    
                                if(jqXHR.status==200) {
                                        
                                    initTheForms(getcompanyinclsavedResponse, selectedCompanyTypeId, selectedCompanyTypeName, selectedCompanyTypePrice);
                                    
                                    // if saved company is not for just refernce
                                    if(data.referral===false) {
                                        var found = false;
                                        $(".buy-now").each(function(i, obj){
                                            var company_id = $(obj).data("company-id");
                                            
                                            var selectedCompanyId = savedData.id;
                                            if(company_id == selectedCompanyId) {
                                                $(obj).trigger("click");
                                                found = true;
                                            }                                        
                                        });

                                        if(found === false) {
                                            $(".new-incorporation").trigger("click");
                                            var companyNameArr = savedData.name.split(",");

                                            $(".company-name-choice").each(function(i, obj){
                                                $(obj).val(companyNameArr[i].trim()).trigger("keyup");
                                            });

                                            $("#step-1").find(".next-btn").trigger("click");
                                        }
                                    }

                                }
                            });

                        }
                    });

                }else {
                    // with cross domain
                    // var response = makeJsonpRequest("", "http://103.25.203.23/b/admin/jurisdiction/"+selectedCompanyTypeId, "GET");
                    var response = makeJsonpRequest("", "'.SITEURL.'/b/admin/jurisdiction/"+selectedCompanyTypeId, "GET");

                    // without cross domain
                    // var response = makeRequest("", "'.SITEURL.'/b/admin/jurisdiction/"+selectedCompanyTypeId, "GET");                

                    response.done(function(data, textStatus, jqXHR){                    
                        if(jqXHR.status==200) {
                            
                            initTheForms(data, selectedCompanyTypeId, selectedCompanyTypeName, selectedCompanyTypePrice);

                        }
                    });
                }                        

                failedRequest(response);                
            });

            $("#step-3").on("change keyup", ".credit-card-count", function(e){
                if($(this).val()!==""){
                    $(this).parent().parent().find("input[type=hidden]").prop("disabled", false);
                }else {
                    $(this).parent().parent().find("input[type=hidden]").prop("disabled", true);
                }                
            });

            $("#step-1").on("click", ".new-incorporation", function(e){
                e.preventDefault();

                $("#new-incorporation").prop( "checked", true ); // check checkbox for validation purpose

                $("#new-incorporation-container").slideDown().show();   

                $(".cancel-btn-1").hide();

                update_input_val(1, "#chosen_route");
                on_route_change(1);
            });

            $("#step-1").on("click", ".buy-now", function(e){
                e.preventDefault(); 

                initInputTel($(".shareholder-telephone"));
                initInputTel($(".director-telephone"));
                initInputTel($(".secretary-telephone"));

                $("#new-incorporation").prop( "checked", false ); // uncheck checkbox for validation purpose               

                update_input_val(2, "#chosen_route");
                on_route_change(2); 

                changeNextStep(2, $(this).data("hash")); 

                update_input_val($(this).data("company-id"), "#shelf_company_id"); // summary forms
                appendToHtml($(this).data("company-name"), "#summarycompany-name");

                if(currency=="Euro (€)") {
                    appendToHtml("€"+$(this).data("company-price-eu"), "#summarycompany-price"); 
                }else {
                    appendToHtml("US$"+$(this).data("company-price"), "#summarycompany-price");     
                }

                fillForm2WithSavedData();                              
            });

            /////

            $("#step-3").on("change", "#service_country", function(e){
                e.preventDefault();
                var servicePrice = $(this).find(":selected").data("price");
                $(this).parent().parent().next("#service-price").html("US$"+servicePrice);
                $(this).parent().parent().parent().find("input.service-price").val(servicePrice);
            });

            //////

            $(".company-name-choice").on("change keyup", function(e){
                var id = $(this).data("choice-id");
                var data = $(this).val();
                update_input_val(data, "#company_name_choice_"+id);
            });

            $(".company-name-choice").on("keypress", function(e){
                // e.preventDefault();
                if(e.keyCode === 13){
                    $(this).parent().parent().find(".next-btn").trigger("click");
                    return false;
                }
            });

            ///////

            $("#step-2").on("change keyup", ".person-input", function(e){
                var selector = $(this).data("selector");
                var field = $(this).data(selector+"-field");
                var id = $(this).data(selector+"-id");
                var data = $(this).val();
                var totalShareAmount = 0;
                
                if(selector=="shareholder" && field=="amount"){                                    
                    $(".shareholder-amount").each(function(i, obj){
                        totalShareAmount = addAmount(totalShareAmount, $(obj).val().replace(/,/g, ""));
                    });       

                    update_input_val(Number(totalShareAmount), "#total_share");
                }
                
                // update_input_val(data, "#summary_"+selector+"_"+id+"_"+field); 
            });

            $("#step-2").on("change", ".person-type", function(e){
                
                e.preventDefault();
                if($(this).val()==2) {
                    $(this).parent().parent().find(".person-name").attr("placeholder", "Company name");
                    var selector = $(this).data("selector");
                    selector = selector.charAt(0).toUpperCase() + selector.slice(1);
                    var person_id = $(this).parent().parent().find(".person-address").data("person-id");
                    $(this).parent().parent().find(".person-address").text(selector+" "+person_id+" registered office address");                        

                    $(this).parent().parent().find(".person-name").rules("add", {
                        messages: {
                            required: "Company name required"
                        }
                    });

                }else {
                    $(this).parent().parent().find(".person-name").attr("placeholder", "Name");
                    var selector = $(this).data("selector");
                    selector = selector.charAt(0).toUpperCase() + selector.slice(1);
                    var person_id = $(this).parent().parent().find(".person-address").data("person-id");
                    $(this).parent().parent().find(".person-address").text(selector+" "+person_id+" address");    

                    $(this).parent().parent().find(".person-name").rules("add", {
                        messages: {
                            required: "Name required"
                        }
                    });
                }                

            });

            ///////

            $(".payment-gateway-btn").on("click", function(e){

                e.preventDefault();
                // console.log($("#registration-page-form-4").serializeArray().filter(function(k) { return $.trim(k.value) != ""; }));

                $("#action").val("checkout");

                var $form4 = $("#registration-page-form-4");

                if($form4.valid()) {
                    var data = $form4.serializeArray().filter(function(k) { return $.trim(k.value) != ""; });                    

                    var response = makeRequest(data, "'.SITEURL.'/b/admin/company", "POST");

                    // $(this).prop("disabled", true);

                    response.done(function(data, textStatus, jqXHR){                    
                        if(jqXHR.status==200) {
                            alert("Successfully submitted!");   

                            var wpuser_ids = [];

                            $.each(data.response, function(i, each_data){
                                wpuser_ids.push(each_data.wpuser_id);
                            });

                            $(window).unbind("beforeunload");

                            if(wpuser_ids.length>0) {

                                //// send in mail func

                                // var newdata = {};                
                                // newdata.receipient_ids = wpuser_ids;

                                // var response = makeRequest(newdata, "'.SITEURL.'/wp-admin/admin-ajax.php?action=bp_send_message", "POST");

                                // response.done(function(data, textStatus, jqXHR){
                                //     if(jqXHR.status==200) {      
                                //         console.log(data);

                                //         setTimeout(function(){ 
                                //             // window.location.href = "'.SITEURL.'/client-dashboard";
                                //         }, 500);
                                //     }
                                // }); 
                                window.canExit = true;
                                window.location.href = "'.SITEURL.'/client-dashboard";

                            }else {
                                setTimeout(function(){ 
                                    window.canExit = true;
                                    window.location.href = "'.SITEURL.'/client-dashboard";
                                }, 500);
                            }                                                    
                        }
                    });

                    failedRequest(response);
                }

            });

            function getFormData($form) {
                var formData = $form.serializeJSON({parseBooleans: true});
                return formData;
            }

            $(".save-now").on("click", function(e){
                e.preventDefault();

                $("#action").val("save");

                // local storage save
                // for(var i=1; i<=4; i++) {
                //     var $form;
                //     if(i==1)
                //         $form = $("#registration-page-form-1-1");
                //     else 
                //         $form = $("#registration-page-form-"+i);

                //     var FormData = getFormData($form);
                //     var storage = $.localStorage;
                //     var saved;

                //     saved = storage.set("form_"+i+"_data", FormData);
                // }

                // if(saved) {
                //     alert("Your data has been saved.");
                // }

                var $form4 = $("#registration-page-form-4");

                var data = $form4.serializeArray().filter(function(k) { return $.trim(k.value) != ""; });
                var response = makeRequest(data, "'.SITEURL.'/b/admin/company", "POST");

                $(this).text("Saved");//.prop("disabled", true)

                response.done(function(data, textStatus, jqXHR){                    
                    if(jqXHR.status==200) {

                        // console.log(data);

                        alert("Your order has been saved. You may return to your order to finalise it at any time by logging into your account. Please note that if you have selected a shelf company, it will only be available when you return to your order if it has not been bought by another client in the meantime.");

                        $(window).unbind("beforeunload");

                        setTimeout(function(){ 
                            window.canExit = true;
                            window.location.href = "'.SITEURL.'/client-dashboard";
                        }, 1000);
                        
                    }
                });

                failedRequest(response);

            });

            $(".cancel-btn").on("click", function(e){
                e.preventDefault();

                var href = $(this).parent().attr("href");
                window.canExit = true;
                window.location.href = href;

            });

            ///////////
            /// INIT
            ///////////

            function getQueryParams(qs) {
                qs = qs.split("+").join(" ");

                var params = {},
                    tokens,
                    re = /[?&]?([^=]+)=([^&]*)/g;

                while (tokens = re.exec(qs)) {
                    params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
                }

                return params;
            }

            function handleBarExt() {
                // add operator support for handlebar
                Handlebars.registerHelper("ifCond", function (v1, operator, v2, options) {

                    switch (operator) {
                        case "==":
                            return (v1 == v2) ? options.fn(this) : options.inverse(this);
                        case "===":
                            return (v1 === v2) ? options.fn(this) : options.inverse(this);
                        case "<":
                            return (v1 < v2) ? options.fn(this) : options.inverse(this);
                        case "<=":
                            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
                        case ">":
                            return (v1 > v2) ? options.fn(this) : options.inverse(this);
                        case ">=":
                            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
                        case "&&":
                            return (v1 && v2) ? options.fn(this) : options.inverse(this);
                        case "||":
                            return (v1 || v2) ? options.fn(this) : options.inverse(this);
                        default:
                            return options.inverse(this);
                    }
                });

                Handlebars.registerHelper("counter", function (index){
                    return index + 1;
                });
            }

            function getAllCompanyTypes(savedData, referral) {

                if (typeof(savedData)==="undefined") savedData = null;

                // with cross domain
                var response = makeJsonpRequest("", "'.SITEURL.'/b/admin/jurisdiction", "GET");

                // without cross domain
                // var response = makeRequest("", "'.SITEURL.'/b/admin/jurisdiction", "GET");

                response.done(function(data, textStatus, jqXHR){                    
                    if(jqXHR.status==200) {

                        appendToSelect(data, "type_of_company");

                        if(savedData!==null && referral==false)
                            $("#step-1").find(".type_of_company").val(savedData.company_type_id).trigger("change");

                    }
                });

                failedRequest(response);
            }

            function getSavedData(data) {
                // ajax here
                return response = makeRequest(data, "'.SITEURL.'/b/api/retrievesavedcompany", "POST");                
            }

            function setToRetrieveSavedData() {
                var user_id = "'.$user_id.'";
                var data = {};

                data.referral = false;
                if(query.savedcompany) data.company_id = query.savedcompany;
                else {
                    data.company_id = query.refertocompany;  
                    data.referral = true;
                } 

                data.user_id = user_id;

                return data;
            }

            var query;
            function init() {
                
                query = getQueryParams(document.location.search);   
                var savedData;          

                handleBarExt();
                updateHashInURL("1");

                if($.isEmptyObject(query)===false) {

                    var data = setToRetrieveSavedData(query);
                    var response = getSavedData(data);

                    response.done(function(r_data, textStatus, jqXHR){                    
                        if(jqXHR.status==200) {                           
                            savedData = r_data.saved_data.companies[0];                      
                            getAllCompanyTypes(savedData, data.referral);
                        }
                    });

                    failedRequest(response);
                      
                } else {

                    getAllCompanyTypes();

                }                
                
            }

            init();

        });
        
    }(jQuery));
    </script>
    <script id="shelf-companies-template" type="text/x-handlebars-template">
        {{#if companies.length}}
            <p>The following shelf companies are immediately available.  You may purchase one of these or order a new incorporation below.</p>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>        
            <div class="field-container">  
                <div class="header">
                    <div class="each-header">
                        <h6>Company name</h6>
                    </div>
                    <div class="each-header">
                        <h6>Incorporated</h6>
                    </div>
                    <div class="each-header">
                        <h6>Price</h6>
                    </div>
                    <div class="each-header"></div>
                </div>  

                {{#companies}}                                       
                    <div class="content">
                        <div class="each-content">
                            <p>{{ name }}</p>
                        </div>
                        <div class="each-content">
                            <p>{{ incorporation_date }}</p>    
                        </div>
                        <div class="each-content">  
                            {{#ifCond ../companies.currency "==" "Euro (€)" }}                      
                                <p>€{{ price_eu }}</p>                            
                            {{else}}
                                <p>US${{ price }}</p>                            
                            {{/ifCond}}
                        </div>
                        <div class="each-content">
                            <button data-company-name="{{name}}" data-company-id="{{id}}" data-company-price="{{price}}" data-company-price-eu="{{price_eu}}" class="custom-submit-class buy-now" data-hash="2">Buy now</button>
                        </div>                        
                    </div>                               
                {{/companies}}
            </div>    
        {{else}}   
            <p>Unfortunately no shelf companies are presently available.  You may order a new incorporation below.</p>
            <div class="vc_empty_space hide-from-mobile" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
        {{/if}}

        <div class="vc_empty_space hide-from-mobile" style="height: 29px"><span class="vc_empty_space_inner"></span></div>                         
        
        <h6>New incorporation</h6>
        <div class="pull-left">
            <p>I would like Offshore Company Solutions to arrange a new incorporation for me.</p>
            <p><span id="jurisdiction-name"></span> new incorporation charge: <span id="jurisdiction-price"></span></p>
        </div>
        <div class="pull-right">
            <button data-id="0" data-hash="#" class="custom-submit-class new-incorporation">Incorporate now</button>                    
        </div>
        <div class="clear"></div>
        <!-- <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>             -->
        
    </script>
    <script id="company-name-rules-template" type="text/x-handlebars-template">
        <p class="white-space-pre">{{rules}}</p>          
    </script>
    <script id="shareholder-template" type="text/x-handlebars-template">
        {{#if shareholders.length}}
            <h3>Shareholders</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
                     
            {{#shareholders}}
                <p>{{name_rules}}</p>
            {{/shareholders}}

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
            
            <div class="shareholder">
                <div class="cloneable">
                    <div class="field-container">
                        <div class="custom-input-container-left pull-left">                            
                            <label for="shareholder_0_type" class="name">Shareholder 0</label>
                            <a href="#" data-selector="shareholder" class="remove-this">Remove this shareholder <i class="fa fa-times" aria-hidden="true"></i></a>
                            <div class="vc_empty_space" style="height: 10px;clear:both;"><span class="vc_empty_space_inner"></span></div>
                            <div class="custom-input-class-select-container hide-select">            
                                <select disabled="disabled" name="shareholder_0_type" id="shareholder_0_type" data-selector="shareholder" data-shareholder-field="type" data-shareholder-id="0" class="shareholder-type person-input custom-input-class person-type">
                                    <option value="1">This shareholder is an individual</option>
                                    <option value="2">This shareholder is a company</option>
                                </select>
                            </div>
                            <div class="switch-container">
                                <p class="inline-lbl">This shareholder is</p>                            
                                                    
                                <input type="checkbox" name="shareholder_0_type_switch[]" value="1" data-selector="shareholder" data-shareholder-field="type" data-shareholder-id="0" class="shareholder-type person-input custom-input-class person-type-switch person-type-1-switch" checked="checked">
                                <label for="shareholder_0_type_switch[]" class="inline-lbl">an individual</label>                            
                                <input type="checkbox" name="shareholder_0_type_switch[]" value="2" data-selector="shareholder" data-shareholder-field="type" data-shareholder-id="0" class="shareholder-type person-input custom-input-class person-type-switch person-type-2-switch">
                                <label for="shareholder_0_type_switch[]" class="inline-lbl">a company</label>
                            </div>

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                        
                            <input disabled="disabled" type="text" name="shareholder_0_name" id="shareholder_0_name" placeholder="Name" data-selector="shareholder" data-shareholder-field="name" data-shareholder-id="0" class="shareholder-name person-input custom-input-class person-name">                
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <label for="shareholder_0_address" class="address person-address" data-person-id="1">Shareholder 0 address</label>
                            <input disabled="disabled" type="text" name="shareholder_0_address" id="shareholder_0_address" placeholder="Street" data-selector="shareholder" data-shareholder-field="address" data-shareholder-id="0" class="shareholder-address person-input custom-input-class">  

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>       

                            <input disabled="disabled" type="text" name="shareholder_0_address_2" id="shareholder_0_address_2" placeholder="City" data-selector="shareholder" data-shareholder-field="address_2" data-shareholder-id="0" class="shareholder-address-2 person-input custom-input-class">    

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>         

                            <input disabled="disabled" type="text" name="shareholder_0_address_3" id="shareholder_0_address_3" placeholder="State" data-selector="shareholder" data-shareholder-field="address_3" data-shareholder-id="0" class="shareholder-address-3 person-input custom-input-class">

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>           

                            <div class="custom-input-class-select-container">            
                                <select disabled="disabled" name="shareholder_0_address_4" id="shareholder_0_address_4" data-selector="shareholder" data-shareholder-field="address_4" data-shareholder-id="1" class="shareholder-address-4 person-input custom-input-class">
                                <option value="">Country</option><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option>
                                </select>     
                            </div>

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>    

                            <input disabled="disabled" type="text" name="shareholder_0_telephone" id="shareholder_1_telephone" data-selector="shareholder" data-shareholder-field="telephone" data-shareholder-id="0" placeholder="Telephone" class="shareholder-telephone person-input custom-input-class">          
                        </div>
                        <div class="custom-input-container-right pull-right">
                            <label for="shareamount_0_amount">Number of shares</label>
                            <input disabled="disabled" type="text" name="shareamount_0_amount" placeholder="" data-selector="shareholder" data-shareholder-field="amount" data-shareholder-id="0" class="shareholder-amount person-input custom-input-class" value="">
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="pasteclone"></div>
            </div>

            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                       
            <div class="add-remove-btn-container">                
                <a href="#" data-selector="shareholder" class="add-more add-more-shareholder">Add shareholder <i class="fa fa-plus"></i></a>
                <!-- <a href="#" data-selector="shareholder" class="remove remove-shareholder">Remove <i class="fa fa-minus"></i></a> -->
            </div>
            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            

            <div class="field-container">
                <div class="custom-input-container-left pull-left total-share-container">
                    <label for="total_share" class="align-label">Total shares to be issued</label>
                </div>
                <div class="custom-input-container-right pull-right">
                    <input type="text" name="total_share" id="total_share" class="custom-input-class" value="0">
                </div>
                <div class="clear"></div>                   
            </div>          

            <p>Should confidentiality be required, Offshore Company Solutions can arrange for the shares to be held by nominees on behalf of the above shareholders instead of registering the shares directly in the names of the shareholders.  An annual nominee shareholder fee of will apply for this service.</p>  
            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            

            <div class="pull-left">
                <p>Offshore Company Solutions to provide nominee shareholders?</p>
                <p>Annual nominee shareholder fee: 
                {{#shareholders}}                    
                    {{#ifCond ../shareholders.currency "==" "Euro (€)" }}                      
                        <span class="nominee-shareholder-price">€{{price_eu}}</span>
                    {{else}}
                        <span class="nominee-shareholder-price">US${{price}}</span>               
                    {{/ifCond}}
                {{/shareholders}}
                </p>
            </div>
            <div class="pull-right yesno-btn"><input type="checkbox" name="nominee_shareholder" id="nominee_shareholder" class="js-switch"></div>
            <div class="clear"></div>

            <div class="field-container">
                <div class="vc_empty_space" style="height: 20px"><span class="vc_empty_space_inner"></span></div>
                
                <!-- <div class="nominee-container hidden">
                    <div class="pull-left">
                        <label for="nominee_shareholder" class="checkbox-label align-label">Annual nominee shareholder fee:</label>
                    </div>
                    <div class="pull-right">
                        {{#shareholders}}
                                <p class="nominee-shareholder-price">US${{price}}</p>
                        {{/shareholders}}
                    </div>
                    <div class="clear"></div>
                </div> -->
            </div>            

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
        {{/if}}
    </script>
    <script id="director-template" type="text/x-handlebars-template">
        {{#if directors.length}}
            <h3>Directors</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            {{#directors}}
                <p>{{name_rules}}</p>
            {{/directors}}

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            

            <p>Professional directors may be provided by Offshore Company Solutions if confidentiality is required.  An annual professional director fee will be charged for this service.</p>
            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
            
            <div class="pull-left">
                <p>Offshore Company Solutions to provide professional directors?</p>            
                <p>Annual professional director fee: 
                {{#directors}}                    
                    {{#ifCond ../directors.currency "==" "Euro (€)" }}    
                        <span class="nominee-director-price">€{{price_eu}}</span>                  
                    {{else}}
                        <span class="nominee-director-price">US${{price}}</span>
                    {{/ifCond}}
                {{/directors}}
                </p>
            </div>
            <div class="pull-right yesno-btn"><input type="checkbox" name="nominee_director" id="nominee_director" class="js-switch"></div>
            <div class="clear"></div>

            <div class="field-container">
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                            
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                                        

                <!-- <div class="nominee-container hidden">
                    <div class="pull-left">
                        <label for="nominee_director" class="checkbox-label">Annual professional director fee:</label>
                    </div>
                    <div class="pull-right">
                        {{#directors}}
                            <p class="nominee-director-price">US${{price}}</p>
                        {{/directors}}
                    </div>
                    <div class="clear"></div>
               
                    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>                      
                </div>             -->
            </div>  
                    
            <div class="director key-person-info">
                <div class="cloneable">
                    <div class="field-container">
                        <div class="custom-field-container">
                            <label for="director" class="name">Director 0</label>
                            <a href="#" data-selector="director" class="remove-this">Remove this director <i class="fa fa-times" aria-hidden="true"></i></a>
                            <div class="vc_empty_space" style="height: 10px;clear:both;"><span class="vc_empty_space_inner"></span></div>
                            <div class="custom-input-class-select-container hide-select">            
                                <select disabled="disabled" name="director_0_type" id="director_0_type" data-selector="director" data-director-field="type" data-director-id="0" class="director-type person-input custom-input-class person-type">
                                    <option value="1">This director is an individual</option>
                                    <option value="2">This director is a company</option>
                                </select>
                            </div>
                            <div class="switch-container">
                                <p class="inline-lbl">This director is</p>                            
                                                    
                                <input type="checkbox" name="director_0_type_switch[]" value="1" data-selector="director" data-director-field="type" data-director-id="0" class="director-type person-input custom-input-class person-type-switch person-type-1-switch" checked="checked">
                                <label for="director_0_type_switch[]" class="inline-lbl">an individual</label>                            
                                <input type="checkbox" name="director_0_type_switch[]" value="2" data-selector="director" data-director-field="type" data-director-id="0" class="director-type person-input custom-input-class person-type-switch person-type-2-switch">
                                <label for="director_0_type_switch[]" class="inline-lbl">a company</label>
                            </div>
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>

                            <input type="text" disabled="disabled" name="director_0_name" id="director_0_name" placeholder="Name" data-selector="director" data-director-field="name" data-director-id="0" class="director-name person-input custom-input-class person-name">   

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>    

                            <label for="director_0_address" class="address person-address" data-person-id="0">Director 1 address</label>

                            <input type="text" disabled="disabled" name="director_0_address" id="director_0_address" placeholder="Street" data-selector="director" data-director-field="address" data-director-id="0" class="director-address person-input custom-input-class"> 

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>   

                            <input type="text" disabled="disabled" name="director_0_address_2" id="director_0_address_2" placeholder="City" data-selector="director" data-director-field="address_2" data-director-id="0" class="director-address-2 person-input custom-input-class">       

                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            

                            <input type="text" disabled="disabled" name="director_0_address_3" id="director_0_address_3" placeholder="State" data-selector="director" data-director-field="address_3" data-director-id="0" class="director-address-3 person-input custom-input-class">
                            
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>           

                            <div class="custom-input-class-select-container">
                                {{#ifCond directors.selected_company_type "==" "Irish limited liability company" }}
                                    <select disabled="disabled" name="director_0_address_4" id="director_0_address_4" placeholder="Country" data-selector="director" data-director-field="address_4" data-director-id="0" class="director-address-4 person-input custom-input-class">
                                        <option value="">Country</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                    </select>
                                {{else}}
                                    <select disabled="disabled" name="director_0_address_4" id="director_0_address_4" placeholder="Country" data-selector="director" data-director-field="address_4" data-director-id="0" class="director-address-4 person-input custom-input-class">
                                        <option value="">Country</option><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option>
                                    </select>                                    
                                {{/ifCond}}    
                            </div>                
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <input disabled="disabled" type="text" name="director_0_telephone" id="director_0_telephone" placeholder="Telephone" data-selector="director" data-director-field="telephone" data-director-id="0" class="director-telephone person-input custom-input-class">
                        </div>                                
                    </div>
                </div>
                <div class="pasteclone"></div>
            </div>

            <div class="add-remove-btn-container add-remove-btn-container-director">                
                <a href="#" data-selector="director" class="add-more add-more-director">Add director <i class="fa fa-plus"></i></a>            
                <!-- <a href="#" data-selector="director" class="remove remove-director">Remove <i class="fa fa-minus"></i></a> -->
            </div>
            

        {{/if}}
    </script>

    <script id="secretary-template" type="text/x-handlebars-template">
        {{#if secretaries.length}}            
            <h3>Secretary</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

            {{#secretaries}}
                <p>{{name_rules}}</p>
            {{/secretaries}}

            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            

            <p>A professional secretary may be provided by Offshore Company Solutions, with the necessary experience to handle the responsibilities carried by this position.  An annual company secretary fee will apply for this service.</p>

            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
            <div class="pull-left">
                <p>Offshore Company Solutions to provide a company secretary?</p>
                <p>Annual company secretary fee: 
                    {{#secretaries}}
                        {{#ifCond ../secretaries.currency "==" "Euro (€)" }}    
                            <span class="nominee-secretary-price">€{{price_eu}}</span>                  
                        {{else}}
                            <span class="nominee-secretary-price">US${{price}}</span>
                        {{/ifCond}}
                    {{/secretaries}}
                </p>
            </div>
            <div class="pull-right yesno-btn"><input type="checkbox" name="nominee_secretary" id="nominee_secretary" class="js-switch"></div>
            <div class="clear"></div>

            <div class="field-container">
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                            
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>  

                <!-- <div class="nominee-container hidden">
                    <div class="pull-left">
                        <label for="nominee_secretary" class="checkbox-label">Annual company secretary fee:</label>
                    </div>
                    <div class="pull-right">
                        {{#secretaries}}
                            <p class="nominee-secretary-price">US${{price}}</p>
                        {{/secretaries}}
                    </div>
                    <div class="clear"></div>
               

                    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>                                    

                </div>                          -->
            </div>                
            <div class="secretary key-person-info">
                <div class="field-container">
                    <label for="secretary" class="name">Secretary</label>
                    <div class="custom-input-class-select-container hide-select">            
                        <select name="secretary_1_type" id="secretary_1_type" data-selector="secretary" data-secretary-field="type" data-secretary-id="1" class="secretary-type person-input custom-input-class person-type">
                            <option value="1">This secretary is an individual</option>
                            <option value="2">This secretary is a company</option>
                        </select>
                    </div>
                    <div class="switch-container">
                        <p class="inline-lbl">This secretary is</p>                            
                                            
                        <input type="checkbox" name="secretary_3_type_switch[]" value="1" data-selector="secretary" data-secretary-field="type" data-secretary-id="1" class="secretary-type person-input custom-input-class person-type-switch person-type-1-switch" checked="checked">
                        <label for="secretary_3_type_switch[]" class="inline-lbl">an individual</label>                            
                        <input type="checkbox" name="secretary_3_type_switch[]" value="2" data-selector="secretary" data-secretary-field="type" data-secretary-id="1" class="secretary-type person-input custom-input-class person-type-switch person-type-2-switch">
                        <label for="secretary_3_type_switch[]" class="inline-lbl">a company</label>
                    </div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    <input type="text" name="secretary_1_name" id="secretary_1_name" placeholder="Name" data-selector="secretary" data-secretary-field="name" data-secretary-id="1" class="secretary-name person-input custom-input-class person-name">     
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                    <label for="secretary_1_address" class="address person-address" data-person-id="1">Secretary address</label>
                    <input type="text" name="secretary_1_address" id="secretary_1_address" placeholder="Street" data-selector="secretary" data-secretary-field="address" data-secretary-id="1" class="secretary-address person-input custom-input-class">                
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                    <input type="text" name="secretary_1_address_2" id="secretary_1_address_2" placeholder="City" data-selector="secretary" data-secretary-field="address_2" data-secretary-id="1" class="secretary-address-2 person-input custom-input-class">                
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                    <input type="text" name="secretary_1_address_3" id="secretary_1_address_3" placeholder="State" data-selector="secretary" data-secretary-field="address_3" data-secretary-id="1" class="secretary-address-3 person-input custom-input-class">                               
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                    <div class="custom-input-class-select-container">            
                        <select name="secretary_1_address_4" id="secretary_1_address_4" placeholder="Country" data-selector="secretary" data-secretary-field="address_4" data-secretary-id="1" class="secretary-address-4 person-input custom-input-class"><option value="">Country</option><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select>     
                    </div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                    <input type="text" name="secretary_1_telephone" id="secretary_1_telephone" placeholder="Telephone" data-selector="secretary" data-secretary-field="telephone" data-secretary-id="1" class="secretary-telephone person-input custom-input-class">                               
                </div>
            </div>   
        {{/if}}
    </script>

    <script id="service-template" type="text/x-handlebars-template">
        {{#if services.length}}
            <p>Now that we know how to structure your company, would you like to add any of the following services?</p>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            {{#services}}
                <div class="field-container">
                    {{#ifCond name "==" "Registered office annual fee (compulsory)"}}

                    {{else}}
                    <h4 class="pull-left">{{name}}</h4>
                    <h4 class="pull-right"></h4>
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    {{/ifCond}}
                    {{#ifCond name "==" "Bank accounts"}}
                        <p>A bank account may be opened in the following jurisdictions for your company (multiple jurisdictions may be selected):</p>                    
                    {{/ifCond}}
                    {{#ifCond name "==" "Credit/debit cards"}}
                        <p>Credit or debit cards are available in the following jurisdictions for your company.  Note that a bank account must be opened at the same bank before credit or debit cards may be issued:</p>                    
                    {{/ifCond}}

                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="country-options-container pull-left">                                                                
                        <input type="hidden" name="service_{{counter @index}}_id" class="service-id" value="{{id}}">
                        <input type="hidden" name="service_{{counter @index}}_name" class="service-name" value="{{name}}">
                        <!-- <select id="service_country" name="service_{{counter @index}}_country" class="service-country custom-input-class">
                            <option value="" data-price="0.00" selected="selected">Please Select</option>
                            {{#countries}}
                            <option value="{{pivot.id}}" data-price="{{pivot.price}}">{{name}}</option>
                            {{/countries}}
                        </select> -->
                        {{#ifCond name "==" "Registered office annual fee (compulsory)"}}
                            {{#countries}}                           
                                <input type="hidden" name="service_{{../id}}_country_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-country" value="{{name}}">
                                {{#ifCond ../../services.currency "==" "Euro (€)" }} 
                                    <input type="hidden" name="service_{{../id}}_price_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-price" value="{{pivot.price_eu}}">
                                {{else}}
                                    <input type="hidden" name="service_{{../id}}_price_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-price" value="{{pivot.price}}">
                                {{/ifCond}}
                                <input type="hidden" name="service_{{../id}}_country_{{counter @index}}_id" id="service_{{../id}}_country_{{counter @index}}_id" data-service-name="{{../name}}" data-service-id="{{../id}}" data-country-id="{{id}}" value="{{pivot.id}}" class="service-{{../id}}-country-id">
                            {{/countries}}
                        {{else}}
                            <div class="header">
                                <div class="col-1-header">
                                    {{#ifCond name "==" "Credit/debit cards"}}
                                    <h6 for="service_country">Bank location</h6>
                                    {{else}}
                                    <h6 for="service_country">Location</h6>
                                    {{/ifCond}}
                                </div>
                                <div class="col-2-header">
                                    {{#ifCond name "==" "Credit/debit cards"}}
                                    <h6 for="service_country">Charge per card</h6>
                                    {{else}}
                                    <h6 for="service_country">Price</h6>
                                    {{/ifCond}}
                                </div>
                                <div class="col-3-header">
                                    {{#ifCond name "==" "Credit/debit cards"}}
                                    <h6 for="service_country">No. of cards to issue</h6>
                                    {{else}}
                                    <h6 for="service_country">Open account</h6>
                                    {{/ifCond}}
                                </div>
                            </div>
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                            {{#countries}}
                                <div class="each-country">
                                    <div class="col-1">
                                        <div id="service-country" class="service-country"><p>{{name}}</p></div>
                                        <input type="hidden" name="service_{{../id}}_country_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-country" value="{{name}}" disabled="disabled">
                                    </div>
                                    <div class="col-2">
                                        {{#ifCond ../../services.currency "==" "Euro (€)" }}    
                                            <div id="service-price" class="service-price price"><p>€{{pivot.price_eu}}</p></div>
                                            <input type="hidden" name="service_{{../id}}_price_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-price" value="{{pivot.price_eu}}" disabled="disabled">
                                        {{else}}
                                            <div id="service-price" class="service-price price"><p>US$ {{pivot.price}}</p></div>
                                            <input type="hidden" name="service_{{../id}}_price_{{counter @index}}" class="service-{{../id}}-country-{{id}} service-{{../id}}-price" value="{{pivot.price}}" disabled="disabled">
                                        {{/ifCond}}
                                    </div>               
                                    {{#ifCond ../name "==" "Credit/debit cards"}}           
                                    <div class="col-3">
                                        <input type="text" name="service_{{../id}}_country_{{counter @index}}_no_of_card" id="service_{{../id}}_country_{{counter @index}}_no_of_card" class="credit_card_in_country_{{id}} service-{{../id}}-credit-card-count credit-card-count custom-input-class-2 service-{{../id}}-country-{{id}}-card-count service-{{../id}}-country-{{id}}" disabled="disabled">
                                        <input type="hidden" name="service_{{../id}}_country_{{counter @index}}_id" value="{{pivot.id}}" class="service-{{../id}}-country-id  service-{{../id}}-country-{{id}}"  disabled="disabled">                
                                    </div>        
                                    {{else}}
                                    <div class="col-3">
                                        <input type="checkbox" name="service_{{../id}}_country_{{counter @index}}_id" id="service_{{../id}}_country_{{counter @index}}_id" data-service-name="{{../name}}" data-service-id="{{../id}}" data-country-id="{{id}}" value="{{pivot.id}}" class="service-js-switch service-{{../id}}-country-id service-{{../id}}-country-{{id}}">
                                    </div>
                                    {{/ifCond}}
                                    
                                </div>
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            {{/countries}}
                        {{/ifCond}}
                    </div>
                    <div class="clear"></div>
                </div>    
            {{/services}}
        {{/if}}
    </script>  

    <script id="informationservices-template" type="text/x-handlebars-template">
        {{#if informationservices.length}}
            <h3>Other services</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
            
            <div class="field-container">
                <p>Please let us know whether you would like to receive information on any of the following:</p>                    
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                {{#informationservices}}
                    <div class="field-container">
                        <div class="pull-left">
                            <label for="info_services[]" class="checkbox-label">{{name}}</label>
                            <input type="hidden" name="info_services_name[]" class="info-service-name" value="{{name}}">
                        </div>
                        <div class="pull-right">
                            <input type="checkbox" name="info_services_id[]" value="{{id}}" class="info-service-id info-service-js-switch">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                {{/informationservices}}
            </div>            
        {{/if}}
    </script>    

    <script id="summaryshareholder-template" type="text/x-handlebars-template">
        {{#shareholders}}
            {{#if value}}
                {{#if @first}}
                    <h4>Shareholders</h4>                    
                    <input type="hidden" name="shareholder_count" value="{{../shareholders.length}}">
                {{/if}}
                <div class="field-container half-field-container-2">
                    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
                    
                    <div class="input-container col-1 pull-left">
                        <div class="person-info">                
                            <p class="shareholder_{{counter @index}}_name">{{value}}</label>
                            <p class="shareholder_{{counter @index}}_address">{{address_value}}</p>
                            <p class="shareholder_{{counter @index}}_address_2">{{address_2_value}}</p>
                            <p class="shareholder_{{counter @index}}_address_3">{{address_3_value}}</p>
                            <p class="shareholder_{{counter @index}}_address_4">{{address_4_value}}</p>
                            <p class="shareholder_{{counter @index}}_telephone">{{telephone_value}}</p>                            
                            <input type="hidden" name="shareholder_{{counter @index}}_name" id="shareholder_{{counter @index}}_name" value="{{value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_type" id="shareholder_{{counter @index}}_type" value="{{type_value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_address" id="shareholder_{{counter @index}}_address" value="{{address_value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_address_2" id="shareholder_{{counter @index}}_address_2" value="{{address_2_value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_address_3" id="shareholder_{{counter @index}}_address_3" value="{{address_3_value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_address_4" id="shareholder_{{counter @index}}_address_4" value="{{address_4_value}}">
                            <input type="hidden" name="shareholder_{{counter @index}}_telephone" id="shareholder_{{counter @index}}_telephone" value="{{telephone_value}}">
                        </div>
                        <div class="edit-form">
                            <input type="text" placeholder="Name" name="edit_shareholder_{{counter @index}}_name" id="summary_{{name}}" value="{{value}}" class="name-edit-input required custom-input-class one-row">
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <input type="text" placeholder="Street" name="edit_shareholder_{{counter @index}}_address" id="summary_{{address_name}}" value="{{address_value}}" class="address-edit-input required custom-input-class one-row">
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <input type="text" placeholder="City" name="edit_shareholder_{{counter @index}}_address_2" id="summary_{{address_2_name}}" value="{{address_2_value}}" class="address-2-edit-input custom-input-class required one-row">
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <input type="text" placeholder="State" name="edit_shareholder_{{counter @index}}_address_3" id="summary_{{address_3_name}}" value="{{address_3_value}}" class="address-3-edit-input custom-input-class one-row">
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <div class="custom-input-class-select-container">            
                                <select name="edit_shareholder_{{counter @index}}_address_4" id="summary_{{address_4_name}}" value="{{address_4_value}}" class="address-4-edit-input custom-input-class required one-row"><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select>     
                            </div>    
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <input type="text" placeholder="Telephone" name="edit_shareholder_{{counter @index}}_telephone" id="summary_{{telephone_name}}" value="{{telephone_value}}" class="telephone-edit-input custom-input-class required one-row">                        
                            <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                            <button class="save-summary-btn custom-submit-class custom-submit-class-2">Save</button>                     
                        </div>                      
                    </div>
                    <div class="input-container text-container col-2 pull-left">                
                        <div class="person-info">
                            <p class="shareholder_{{counter @index}}_amount">{{amount_value}} shares</p>                
                            <input type="hidden" name="shareholder_{{counter @index}}_amount" id="shareholder_{{counter @index}}_amount" value="{{amount_value}}" class="custom-input-class small-input-2 one-row shareholder-amount-input">        
                        </div>
                        <div class="edit-form">
                            <input type="text" name="edit_shareholder_{{counter @index}}_amount" id="summary_shareholder_{{counter @index}}_amount" value="{{amount_value}}" class="custom-input-class required small-input-2 one-row shareholder-amount-input">                            
                        </div>
                    </div>
                    <div class="col-3 pull-right upload-col-container">       
                        <div class="edit-btn-container">    
                            <span class="btn btn-success fileinput-button">                                                             
                                <button class="edit-summary-btn custom-submit-class custom-submit-class-2">Edit</button>
                            </span>
                        </div>
                        <div class="upload-btn-container">
                            <input type="text" name="shareholder_{{counter @index}}_passport" />
                            <span class="btn btn-success fileinput-button">                            
                                <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
                                <!-- The file input field used as target for the file upload widget -->
                                <input class="passport_upload" type="file" name="files" data-fieldname="shareholder_{{counter @index}}_passport" data-selector="shareholder_{{counter @index}}" />
                            </span>
                            <!-- The container for the uploaded files -->
                            <div id="shareholder_{{counter @index}}_passport_files" class="files"></div>
                        </div>
                        
                        <div class="upload-btn-container">
                            <input type="text" name="shareholder_{{counter @index}}_bill" />
                            <span class="btn btn-success fileinput-button">                            
                                <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
                                <!-- The file input field used as target for the file upload widget -->                            
                                <input class="bill_upload" type="file" name="files" data-fieldname="shareholder_{{counter @index}}_bill" data-selector="shareholder_{{counter @index}}" />
                            </span>                
                            <!-- The container for the uploaded files -->
                            <div id="shareholder_{{counter @index}}_bill_files" class="files"></div>        
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>                
                {{#if @last}} 
                    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
                    <input type="checkbox" name="nominee_shareholder_annual_fee" id="nominee_shareholder_annual_fee" checked="checked" value="">
                    <div class="summary-shareholder-price-container">                                                
                        <div class="half-field-container-2">
                            <div class="nominee-lbl-container pull-left col-1"><p>Nominee shareholders annual fee</p></div>
                            <div class="pull-left col-2"></div>
                            <div class="pull-right col-3 remove-col-container">
                                <div class="nominee-cta-container">
                                    <button data-selector="nominee_shareholder" class="remove-btn custom-submit-class custom-submit-class-2">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div id="summary-shareholder-price" class="col-3 price summary-price pull-right"><p>$0</p></div>
                        <div class="clear"></div>
                    </div>
                    
                    <input type="hidden" name="total_share" id="summary_total_share" disabled="true" class="custom-input-class small-input-2">
                {{/if}}                                              
            {{/if}}
        {{/shareholders}}
    </script> 

    <script id="summarydirector-template" type="text/x-handlebars-template">                
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
        <h4>Directors</h4>        
        {{#if directors.length}}                        
            {{#directors}}
                {{#if value}}     
                    {{#if @first}}<input type="hidden" name="director_count" value="{{../directors.length}}">{{/if}}
                    <div class="field-container half-field-container-2">
                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>   

                        <div class="input-container col-1 pull-left">                
                            <div class="person-info">
                                <p class="director_{{counter @index}}_name">{{value}}</label>
                                <p class="director_{{counter @index}}_address">{{address_value}}</p>
                                <p class="director_{{counter @index}}_address_2">{{address_2_value}}</p>
                                <p class="director_{{counter @index}}_address_3">{{address_3_value}}</p>
                                <p class="director_{{counter @index}}_address_4">{{address_4_value}}</p>
                                <p class="director_{{counter @index}}_telephone">{{telephone_value}}</p>
                                <input type="hidden" name="director_{{counter @index}}_name" id="director_{{counter @index}}_name" value="{{value}}">
                                <input type="hidden" name="director_{{counter @index}}_type" id="director_{{counter @index}}_type" value="{{type_value}}">
                                <input type="hidden" name="director_{{counter @index}}_address" id="director_{{counter @index}}_address" value="{{address_value}}">
                                <input type="hidden" name="director_{{counter @index}}_address_2" id="director_{{counter @index}}_address_2" value="{{address_2_value}}">
                                <input type="hidden" name="director_{{counter @index}}_address_3" id="director_{{counter @index}}_address_3" value="{{address_3_value}}">
                                <input type="hidden" name="director_{{counter @index}}_address_4" id="director_{{counter @index}}_address_4" value="{{address_4_value}}">
                                <input type="hidden" name="director_{{counter @index}}_telephone" id="director_{{counter @index}}_telephone" value="{{telephone_value}}">
                            </div>
                            <div class="edit-form">
                                <input type="text" placeholder="Name" name="edit_director_{{counter @index}}_name" id="summary_{{name}}" value="{{value}}" class="name-edit-input required custom-input-class one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="Street" name="edit_director_{{counter @index}}_address" id="summary_{{address_name}}" value="{{address_value}}" class="address-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="City" name="edit_director_{{counter @index}}_address_2" id="summary_{{address_2_name}}" value="{{address_2_value}}" class="address-2-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="State" name="edit_director_{{counter @index}}_address_3" id="summary_{{address_3_name}}" value="{{address_3_value}}" class="address-3-edit-input custom-input-class one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <div class="custom-input-class-select-container">            
                                    <select name="edit_director_{{counter @index}}_address_4" id="summary_{{address_4_name}}" value="{{address_4_value}}" class="address-4-edit-input custom-input-class required one-row"><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select>     
                                </div>
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="Telephone" name="edit_director_{{counter @index}}_telephone" id="summary_{{telephone_name}}" value="{{telephone_value}}" class="telephone-edit-input custom-input-class required one-row">

                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <button class="save-summary-btn custom-submit-class custom-submit-class-2">Save</button>                     
                            </div>
                        </div>
                        <div class="col-2 text-container pull-left">
                            
                        </div>
                        <div class="col-3 pull-right upload-col-container">
                            <div class="edit-btn-container">    
                                <span class="btn btn-success fileinput-button">                                                             
                                    <button class="edit-summary-btn custom-submit-class custom-submit-class-2">Edit</button>    
                                </span>
                            </div>
                            <div class="upload-btn-container">
                                <input type="text" name="director_{{counter @index}}_passport" />
                                <span class="btn btn-success fileinput-button">                            
                                    <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input class="passport_upload" type="file" name="files" data-fieldname="director_{{counter @index}}_passport" data-selector="director_{{counter @index}}" />
                                </span>
                                <!-- The container for the uploaded files -->
                                <div id="director_{{counter @index}}_passport_files" class="files"></div>
                            </div>
                            
                            <div class="upload-btn-container">
                                <input type="text" name="director_{{counter @index}}_bill" />
                                <span class="btn btn-success fileinput-button">                            
                                    <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
                                    <!-- The file input field used as target for the file upload widget -->                            
                                    <input class="bill_upload" type="file" name="files" data-fieldname="director_{{counter @index}}_bill" data-selector="director_{{counter @index}}" />
                                </span>                
                                <!-- The container for the uploaded files -->
                                <div id="director_{{counter @index}}_bill_files" class="files"></div>        
                            </div>                            
                        </div>      
                        <div class="clear"></div>                    
                    </div>
                {{/if}}            
            {{/directors}}
        {{else}}
            <div class="vc_empty_space" style="height: 15px"><span class="vc_empty_space_inner"></span></div>            
            <input type="checkbox" name="nominee_director_annual_fee" id="nominee_director_annual_fee" value="" checked="checked">
            <div class="summary-director-price-container">                
                <p>Offshore Company Solutions to provide professional directors</p>
                <div class="vc_empty_space" style="height: 20px"><span class="vc_empty_space_inner"></span></div>        
                <div class="half-field-container-2">
                    <div class="nominee-lbl-container col-1 pull-left"><p>Professional directors annual fee</p></div>
                    <div class="col-2 pull-left"></div>
                    <div class="col-3 remove-col-container pull-right"><div class="nominee-cta-container"><button data-selector="nominee_director" class="remove-btn custom-submit-class custom-submit-class-2">Remove</button></div></div>
                    <div class="clear"></div>
                </div>
                <div id="summary-director-price" class="col-3 price summary-price pull-right"><p>$0</p></div>
            </div>   
            <a href="#" class="go-step-2 pull-right"><button class="custom-submit-class custom-submit-class-2">Assign Director</button></a>         
            <div class="clear"></div>
        {{/if}}            
    </script>        

    <script id="summarysecretary-template" type="text/x-handlebars-template">                
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
        <h4>Secretary</h4>
        {{#if secretaries.length}}                        
            {{#secretaries}}
                {{#if value}}
                    {{#if @first}}<input type="hidden" name="secretary_count" value="{{../secretaries.length}}">{{/if}}
                    <div class="field-container half-field-container-2">
                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            

                        <div class="input-container col-1 pull-left">    
                            <div class="person-info">            
                                <p class="secretary_{{counter @index}}_name">{{value}}</label>
                                <p class="secretary_{{counter @index}}_address">{{address_value}}</p>
                                <p class="secretary_{{counter @index}}_address_2">{{address_2_value}}</p>
                                <p class="secretary_{{counter @index}}_address_3">{{address_3_value}}</p>
                                <p class="secretary_{{counter @index}}_address_4">{{address_4_value}}</p>
                                <p class="secretary_{{counter @index}}_telephone">{{telephone_value}}</p>
                                <input type="hidden" name="secretary_{{counter @index}}_name" id="secretary_{{counter @index}}_name" value="{{value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_type" id="secretary_{{counter @index}}_type" value="{{type_value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_address" id="secretary_{{counter @index}}_address" value="{{address_value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_address_2" id="secretary_{{counter @index}}_address_2" value="{{address_2_value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_address_3" id="secretary_{{counter @index}}_address_3" value="{{address_3_value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_address_4" id="secretary_{{counter @index}}_address_4" value="{{address_4_value}}">
                                <input type="hidden" name="secretary_{{counter @index}}_telephone" id="secretary_{{counter @index}}_telephone" value="{{telephone_value}}">
                            </div>
                            <div class="edit-form">
                                <input type="text" name="edit_secretary_{{counter @index}}_name" id="summary_{{name}}" placeholder="Name" value="{{value}}" class="name-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="Street" name="edit_secretary_{{counter @index}}_address" id="summary_{{address_name}}" value="{{address_value}}" class="address-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="City" name="edit_secretary_{{counter @index}}_address_2" id="summary_{{address_2_name}}" value="{{address_2_value}}" class="address-2-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="State" name="edit_secretary_{{counter @index}}_address_3" id="summary_{{address_3_name}}" value="{{address_3_value}}" class="address-3-edit-input custom-input-class one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <div class="custom-input-class-select-container">            
                                    <select name="edit_secretary_{{counter @index}}_address_4" id="summary_{{address_4_name}}" value="{{address_4_value}}" class="address-4-edit-input custom-input-class required one-row"><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option></select>     
                                </div>
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>            
                                <input type="text" placeholder="Telephone" name="edit_secretary_{{counter @index}}_telephone" id="summary_{{telephone_name}}" value="{{telephone_value}}" class="address-3-edit-input custom-input-class required one-row">
                                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>                                        
                                <button class="save-summary-btn custom-submit-class custom-submit-class-2">Save</button>                     
                            </div>
                        </div>      
                        <div class="col-2 text-container pull-left">
                            
                        </div>   
                        <div class="col-3 pull-right upload-col-container">                                                            
                            <div class="edit-btn-container">    
                                <span class="btn btn-success fileinput-button">                                                             
                                    <button class="edit-summary-btn custom-submit-class custom-submit-class-2">Edit</button>    
                                </span>
                            </div>
                            <div class="upload-btn-container">
                                <input type="text" name="secretary_{{counter @index}}_passport" />
                                <span class="btn btn-success fileinput-button">                            
                                    <button class="upload-btn upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input class="passport_upload" type="file" name="files" data-fieldname="secretary_{{counter @index}}_passport" data-selector="secretary_{{counter @index}}" />
                                </span>
                                <!-- The container for the uploaded files -->
                                <div id="secretary_{{counter @index}}_passport_files" class="files"></div>
                            </div>
                            
                            <div class="upload-btn-container">
                                <input type="text" name="secretary_{{counter @index}}_bill" />
                                <span class="btn btn-success fileinput-button">                            
                                    <button class="upload-btn upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
                                    <!-- The file input field used as target for the file upload widget -->                            
                                    <input class="bill_upload" type="file" name="files" data-fieldname="secretary_{{counter @index}}_bill" data-selector="secretary_{{counter @index}}" />
                                </span>                
                                <!-- The container for the uploaded files -->
                                <div id="secretary_{{counter @index}}_bill_files" class="files"></div>        
                            </div>
                        </div>  
                        <div class="clear"></div>                           
                    </div>
                {{/if}}
            {{/secretaries}}
        {{else}}    
            <div class="vc_empty_space" style="height: 15px"><span class="vc_empty_space_inner"></span></div>                    
            <input type="checkbox" name="nominee_secretary_annual_fee" id="nominee_secretary_annual_fee" value="" checked="checked">
            <div class="summary-secretary-price-container">                
                <p>Offshore Company Solutions to provide a company secretary</p>
                <div class="vc_empty_space" style="height: 20px"><span class="vc_empty_space_inner"></span></div>                        
                <div class="half-field-container-2">
                    <div class="nominee-lbl-container pull-left col-1"><p>Company secretary annual fee</p></div>
                    <div class="pull-left col-2"></div>
                    <div class="pull-right col-3 remove-col-container"><div class="nominee-cta-container"><button data-selector="nominee_secretary" class="remove-btn custom-submit-class custom-submit-class-2">Remove</button></div></div>                
                    <div class="clear"></div>
                </div>
                <div id="summary-secretary-price" class="col-3 price summary-price pull-right"><p>US$0</p></div>
                <div class="clear"></div>
            </div>                          
            <a href="#" class="go-step-2 pull-right"><button class="custom-submit-class custom-submit-class-2">Assign Secretary</button></a>            
            <div class="clear"></div>
        {{/if}}     
    </script>

    <script id="summaryservice-template" type="text/x-handlebars-template">
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
        <h4>Other services</h4>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

        {{#services}}            
            {{#if @first}}
                <input type="hidden" name="service_count" value="{{../services.length}}">
                {{#ifCond ../../services.currency "==" "Euro (€)" }}
                    <input type="hidden" name="currency" value="EURO">
                {{else}}
                    <input type="hidden" name="currency" value="USD">
                {{/ifCond}}
            {{/if}}                   
            {{#countries}}
                {{#if @first}}<input type="hidden" name="service_{{counter @../index}}_country_count" value="{{../countries.length}}">{{/if}}                   
                <input type="hidden" name="service_{{counter @../index}}_country_{{counter @index}}_id" value="{{service_country_id_value}}">

                <div class="field-container">
                    <div class="half-field-container-2">
                        <div class="pull-left col-1">
                            {{#ifCond ../value "==" "Registered office annual fee (compulsory)"}}              
                                <p>{{../value}}</p>
                            {{else}}
                                {{#ifCond ../value "==" "Bank accounts"}}              
                                <p>Bank account in {{value}}</p>
                                {{else}}
                                <p>{{../value}} in {{value}} {{#if services_credit_card_counts_value}} <!-- - <span class="service_{{counter @../index}}_country_{{counter @index}}_no_of_card">{{services_credit_card_counts_value}}</span> cards --> {{/if}}</p>
                                {{/ifCond}}                            
                            {{/ifCond}}
                        </div>
                        <div class="col-2 pull-left"></div>
                        <div class="pull-right col-3 service-cta-col">
                            
                            {{#if services_credit_card_counts_value}}
                            <div class="service-cta-container service-cta-with-input">
                                <input type="text" name="service_{{counter @../index}}_country_{{counter @index}}_no_of_card" value="{{services_credit_card_counts_value}}" class="edit-no-of-card custom-input-class small-input-2" data-price="{{service_price_value}}" data-noofcard="{{services_credit_card_counts_value}}">                            
                                <button data-selector="{{services_credit_card_counts_name}}" class="remove-btn custom-submit-class custom-submit-class-2">Remove</button>
                            {{else}}
                            <div class="service-cta-container">
                                {{#ifCond ../value "==" "Registered office annual fee (compulsory)"}}
                                {{else}}
                                    <button data-selector="service_{{counter @../index}}_country_{{counter @index}}_id" class="remove-btn custom-submit-class custom-submit-class-2">Remove</button>
                                {{/ifCond}}
                            {{/if}}                        
                            </div>                        
                        </div>
                        <div class="clear"></div>
                    </div>
                    {{#ifCond ../../services.currency "==" "Euro (€)" }}
                        <div class="price summary-price pull-right col-3">€{{service_price_value}}</div>
                    {{else}}
                        <div class="price summary-price pull-right col-3">US${{service_price_value}}</div>
                    {{/ifCond}}
                    <div class="clear"></div>
                    <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>        
                </div>                
            {{/countries}}
        {{/services}}        
    </script>

    <script id="summaryinfoservice-template" type="text/x-handlebars-template">        
        {{#infoservices}}                        
            <input type="hidden" name="{{name}}" value="{{value}}">            
        {{/infoservices}}        
    </script>

    <!-- <p class="ip_address">IP Address detected: <span class="user_ip">'.$ip.'</span></p> -->    
    
    <div class="stepwizard">
        <div class="stepwizard-row">
            <div class="stepwizard-step active-step">
                <button type="button" data-id="1" data-hash="1" class="step-1-circle step-1-1-circle step-1-2-circle step-circle btn btn-circle btn-primary" disabled>
                </button>
                <p>Incorporate from <br> scratch or choose <br> a shelf company</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="2" data-hash="2" class="step-2-circle step-circle btn btn-default btn-circle" disabled="disabled">                    
                </button>
                <p>Tell us how to structure it</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" data-id="3" data-hash="3" class="step-3-circle step-circle btn btn-default btn-circle" disabled="disabled">                    
                </button>
                <p>Select any <br> optional services</p>
            </div> 
            <div class="stepwizard-step">
                <button type="button" data-id="4" data-hash="4" class="step-4-circle step-circle btn btn-default btn-circle" disabled="disabled">                    
                </button>
                <p>Review and <br> submit your order</p>
            </div>            
        </div>
    </div>
            
    <div class="vc_empty_space" style="height: 29px;"><span class="vc_empty_space_inner"></span></div>
    <div class="vc_empty_space" style="height: 29px;"><span class="vc_empty_space_inner"></span></div>
    <div class="vc_empty_space" style="height: 29px;"><span class="vc_empty_space_inner"></span></div>    
    <div class="vc_empty_space hidden-xs" style="height: 29px;"><span class="vc_empty_space_inner"></span></div>        

    <div id="step-1" class="step-1 reg-step active">
        <form id="registration-page-form-1-1">
          <div class="field-container">

            <input type="hidden" name="chosen_route" id="chosen_route" value="">
            
            <h3>Please select the type of company you would like to purchase:</h3>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
            <!-- <label for="type_of_company">Type of company:</label> -->
            <div class="custom-input-class-select-container">            
                <select name="type_of_company" class="type_of_company custom-input-class" data-id="1-1">
                    <option value="Please select">Please select</option>                    
                </select>
            </div>

            <div class="vc_empty_space hide-from-mobile" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

            <div id="shelf-companies">
            <!-- JS CONTENT GOES HERE -->
            </div>            

            <div class="vc_empty_space hide-from-mobile" style="height: 29px"><span class="vc_empty_space_inner"></span></div>                                

            <input type="checkbox" name="new-incorporation" id="new-incorporation" value="true" />

            <a href="'.get_permalink( get_page_by_path('client-dashboard') ).'"><button class="custom-submit-class cancel-btn-1">Cancel</button></a>

            <div id="new-incorporation-container" style="display: none;">                

                <!-- <p>Please provide three suggestions for your company’s name in order of preference.  The company will be registered under the first name available.</p> -->
                <p>Please provide three suggestions for your company’s name in order of preference, noting the naming rules listed below. The company will be registered under the first name available.</p>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
                
                <div id="company-name-rules">
                    <!-- JS CONTENT GOES HERE -->
                </div>                

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            
                <div class="field-container">
                    <label for="name">1st choice</label>
                    <input type="text" name="company_name_1" id="company_name_1" data-choice-id="1" class="company-name-choice custom-input-class" value="">
                </div>
                <div class="field-container">
                    <label for="name">2nd choice</label>
                    <input type="text" name="company_name_2" id="company_name_2" data-choice-id="2" class="company-name-choice custom-input-class" value="">
                </div>
                <div class="field-container">
                    <label for="name">3rd choice</label>
                    <input type="text" name="company_name_3" id="company_name_3" data-choice-id="3" class="company-name-choice custom-input-class" value="">
                </div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

                <!-- <a href="#" id="next"><button data-id="0" data-hash="#" class="custom-submit-class back-btn">Back</button></a> -->
                <a href="'.get_permalink( get_page_by_path('client-dashboard') ).'"><button class="custom-submit-class cancel-btn-2">Cancel</button></a>
                <a href="#" id="next"><button data-id="2" data-hash="2" class="custom-submit-class next-btn">Next</button></a>                

            </div>            
            
          </div>             
        </form>

        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-2" class="reg-step">
        <form id="registration-page-form-2">
            <!-- <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div> -->

            <!-- <p>The same person cannot act as sole shareholder, director and secretary. One more person must be appointed to any of these positions or a nominee shareholder, professional director or company secretary provided by Offshore Company Solutions.</p> -->
            
            <div id="shareholder" class="personnel">
                <!-- JS CONTENT GOES HERE -->                
            </div>

            <div id="director" class="personnel">
                <!-- JS CONTENT GOES HERE -->                                
            </div>

            <div id="secretary" class="personnel">
                <!-- JS CONTENT GOES HERE -->       
            </div>
                
            <a href="'.get_permalink( get_page_by_path('client-dashboard') ).'"><button class="custom-submit-class cancel-btn">Cancel</button></a>
            <a href="#" id="next"><button data-id="1" data-hash="1" class="custom-submit-class back-btn">Back</button></a>
            <a href="#" id="next"><button data-id="3" data-hash="3" class="custom-submit-class next-btn">Next</button></a>            
             
        </form>        

        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
    </div>

    <div id="step-3" class="reg-step">
        <form id="registration-page-form-3">
            
            <div class="personnel">
                <div id="service">
                    <!-- JS CONTENT GOES HERE -->
                </div>
                
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
                
                <div id="informationservices">
                    <!-- JS CONTENT GOES HERE -->
                </div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            </div>            
            
            <a href="'.get_permalink( get_page_by_path('client-dashboard') ).'"><button class="custom-submit-class cancel-btn">Cancel</button></a>
            <a href="#" id="next"><button data-id="2" data-hash="2" class="custom-submit-class back-btn">Back</button></a>
            <a href="#" id="next"><button data-id="4" data-hash="4" class="custom-submit-class next-btn">Next</button></a>            
             
        </form>
    </div>

    <div id="step-4" class="reg-step">
        <p>Below is a summary of your order.  Please review and make any corrections here.</p>
        <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
        <p>In order to comply with our due diligence requirements, we are required to receive scanned copies of passports and recent utility bills (not older than 3 months) in respect of all persons listed here.  These may be uploaded using the buttons next to each person’s name.  You may replace a file which has already been uploaded by clicking on the same button again and selecting the new file. You will not be able to finalise your order until all passports and utility bills have been uploaded.</p>

        <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
        <form name="registration-page-form-4" id="registration-page-form-4">
            <div class="field-container">
                <h3 class="pull-left"></h3>
                <h4 class="pull-right">Charge</h4>
                <div class="clear"></div>
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
            </div>

            <input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">
            <input type="hidden" name="jurisdiction_id" id="jurisdiction_id">
            <input type="hidden" name="saved_company_id" id="saved_company_id">

            <div id="route-1-summary" class="route-specific-summary">
                <div class="input-container pull-left">                
                    <p>New company formation - <span class="summaryjurisdiction-name"></span></p>
                </div>
                <div id="summaryjurisdiction-price" class="price summary-price pull-right"><p>$0</p></div>
                <div class="clear"></div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>            
            
                <div id="company-names-summary">
                    <h4>Proposed company names</h4>
                    <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>

                    <div class="field-container half-field-container">
                        <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                        
                        <!-- <div class="input-container pull-left">                
                            <label for="company_type">One:</label>                            
                        </div>                 -->
                        <div class="pull-left">
                            <input type="text" name="company_name_choices[]" id="company_name_choice_1" class="custom-input-class">
                        </div>
                        <div class="clear"></div>
                    </div>            

                    <div class="field-container half-field-container">
                        <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                        
                        <!-- <div class="input-container pull-left">                
                            <label for="company_type">Two:</label>                            
                        </div> -->
                        <div class="pull-left">
                            <input type="text" name="company_name_choices[]" id="company_name_choice_2" class="custom-input-class">
                        </div>                
                        <div class="clear"></div>
                    </div>            

                    <div class="field-container half-field-container">
                        <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                        
                        <!-- <div class="input-container pull-left">                
                            <label for="company_type">Three:</label>                            
                        </div> -->
                        <div class="pull-left">
                            <input type="text" name="company_name_choices[]" id="company_name_choice_3" class="custom-input-class">
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            </div>
            <div id="route-2-summary" class="route-specific-summary">
                <div class="input-container pull-left">                
                    <p>Purchase of shelf company - <span class="summaryjurisdiction-name"></span>: <span id="summarycompany-name"></span></p>                    
                    <input type="hidden" name="shelf_company_id" id="shelf_company_id" value="">
                </div>
                <div id="summarycompany-price" class="price summary-price pull-right"><p>$0</p></div>
                <div class="clear"></div>

                <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
            </div>            

            <div id="summaryshareholder">
                <!-- JS CONTENT GOES HERE -->
            </div>

            <div id="summarydirector">
                <!-- JS CONTENT GOES HERE -->
            </div>            

            <div id="summarysecretary">
                <!-- JS CONTENT GOES HERE -->
            </div>

            <div id="summaryservice">
                <!-- JS CONTENT GOES HERE -->
            </div>                          

            <div id="summaryinfoservice">
                <!-- JS CONTENT GOES HERE -->
            </div>                          
                        
            <div class="field-container">
                <div class="pull-left">                
                    <h6>Total amount to pay</h6>
                </div>
                <div class="total-summary-price price pull-right"><h6>$TBC</h6></div>     
                <div class="clear"></div> 
            </div>
            <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>        
            <!-- <div class="field-container">
                <input type="checkbox" name="tnc" value="yes"> <label for="tnc">I have read and agree with the Terms and conditions</label>
            </div> -->
            <input type="hidden" name="action" id="action" value="">

            <!-- <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>         -->
            <a href="'.get_permalink( get_page_by_path('client-dashboard') ).'"><button class="custom-submit-class cancel-btn">Cancel</button></a>
            <a href="#" id="next"><button data-id="3" data-hash="3" class="custom-submit-class back-btn">Back</button></a>
            <a href="#"><button class="custom-submit-class payment-gateway-btn">Submit order</button></a>
            <a href="#"><button class="custom-submit-class save-now">Save incomplete order</button></a>            
            
        </form>        
    </div>';
}

function custom_registration_function() { 
    registration_form();
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