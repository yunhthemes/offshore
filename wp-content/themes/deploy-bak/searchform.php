<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <input placeholder="<?php esc_attr_e('Search and hit enter', 'deploy'); ?>" type="text" value="<?php echo esc_attr(get_search_query()); ?>" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="&#xe090;" />
    </div>
</form>