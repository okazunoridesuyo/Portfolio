<form action="<?php echo home_url(); ?>" method="get" class="search__section_container">
    <input type="text" name="s" value="<?php the_search_query(); ?>" class="search__section_container--textbox">
    <button type="submit" class="search btn">Search</button>
</form>