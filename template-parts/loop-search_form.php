<form action="<?php echo home_url(); ?>" method="get" class="search__form">
    <input type="text" name="s" value="<?php the_search_query(); ?>" class="search__form--textbox">
    <button type="submit" class="search btn">Search</button>
</form>