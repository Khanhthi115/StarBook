<section>
    <form autocomplete>
        <input type="hidden" name="option" value="show_products">
        <input autocomplete="on" type="search" name="keyword" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ""?>">
        <input type="submit" value="Search">
    </form>
</section>