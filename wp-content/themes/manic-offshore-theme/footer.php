
<!-- 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.3/jquery.sticky.min.js"></script>
<script type="text/javascript">
  $zopim(function() {

    setTimeout(function(){
      console.log('testing: ');
      console.log(jQuery(".zopim"));
      console.log(jQuery(".zopim").sticky);
      jQuery(".zopim").sticky({bottomSpacing:75});
    }, 1000);
  });
</script>
 -->
<?php
deploy_mikado_get_footer();

if (is_user_logged_in ()): ?>
<script>
  document.getElementsByClassName("tnc_link")[0].style.display = "block";
</script>
<?php else: ?>
<script>
  document.getElementsByClassName("tnc_link")[0].style.display = "block";
</script>
<?php endif; ?>