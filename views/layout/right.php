<section>
    <form>
        <input type="hidden" name="option" value="show_products">
        <input 
        type="range" name="range" min="1000" max="1000000" step="10000" oninput="document.getElementById('max').innerHTML = this.value;">
        <span id="max"><?=isset($_GET['range']) ? $_GET['range'] : ""?></span><br>
        <input type="submit" value="Search">
    </form>
</section>