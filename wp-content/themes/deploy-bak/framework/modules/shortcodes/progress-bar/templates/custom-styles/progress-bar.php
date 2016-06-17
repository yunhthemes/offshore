
/* ==========================================================================
   Progress bar shortcode start styles
   ========================================================================== */
.q_progress_bar {
    position: relative;
    margin: 0 0 10px;
    width: 100%;
    overflow: hidden;
    text-align: left;
    padding-right: 24px;
}

.q_progress_bar .progress_content_outer{
    background-color: #f6f6f5;
    position: relative;
    overflow: hidden;
    height: 16px;
}

.q_progress_bar .progress_content{
    max-width: 100%;
    overflow: hidden;
    background-color: #279eff;
    height: 16px;
    border: 1px solid transparent;
    box-sizing: border-box;
}

.q_progress_bar .progress_title_holder {
    position: relative;
    margin: 5px 0;
}

.q_progress_bar .progress_title {
    display: inline-block;
    z-index: 100;
}

.q_progress_bar .floating.floating_outside .progress_number{
	background-color: #279eff;
}

.q_progress_bar .progress_number {
    font-size: 12px;
    font-weight: 400;
    color: #fff;
    display: inline-block;
    text-align: center;
    float: right;
    height: 21px; 
    line-height: 21px;
    padding-left: 8px;
    padding-right: 8px;
}

.q_progress_bar .floating .progress_number{
	position:absolute;
    -moz-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    bottom: 0;
}

.q_progress_bar .floating.floating_inside .progress_number{
    -moz-transform: translateX(-100%);
    -o-transform: translateX(-100%);
    transform: translateX(-100%);
    -ms-transform: translateX(-100%);
    -webkit-transform: translateX(-100%);
}

.q_progress_bar .progress_number_wrapper  {
    text-align: right;
    position: absolute;
    left: 0;
    z-index: 10;
    opacity: 0;
    filter: alpha(opacity=0);
    color: #fff;
    bottom: 0;
}

.q_progress_bar .progress_number_wrapper.floating{
	width: 100%;
	height: 100%;
}

.q_progress_bar .progress_number.with_mark .percent:after{
    content: '%';
    margin-left: 0.1em;
    font-size: 1em;
}
.q_progress_bar .progress_number_wrapper.static{
    width: 100% !important;
    margin-left: 0;
}
.q_progress_bar .progress_number_wrapper.static .progress_number{ 
    color: #279eff;
    font-size: 14px;
}

.q_progress_bar .progress_number_wrapper.floating_inside .progress_number{
	height: 16px;
	line-height: 16px;
}

.q_progress_bar .progress_number_wrapper.floating_inside .progress_number .percent{
	display: inline-block;
}

.q_progress_bar .progress_number_wrapper.floating .down_arrow{
    width: 0;
    height: 0;
    border-left: 3px solid transparent;
    border-right: 3px solid transparent;
    border-top: 3px solid #279eff;
    display: block;
    position: absolute;
    left: 50%;
    top: 100%;
    -moz-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
}
/* ==========================================================================
   Progress bar shortcode end styles
   ========================================================================== */