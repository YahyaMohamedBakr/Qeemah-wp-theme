<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="search" class="search-input" placeholder="ابحث عن دورة..." value="<?php echo get_search_query(); ?>" name="s" aria-label="بحث">
    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
    <button type="button" class="search-close" id="searchClose" onclick="document.getElementById('searchOverlay').classList.remove('active')"><i class="fas fa-times"></i></button>
</form>
