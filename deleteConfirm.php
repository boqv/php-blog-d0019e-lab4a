<!-- Delete confirmation page, when deleting an entry -->

<p>Are you sure you want to delete this entry? </p>

<div class="col-1">
    <?php echo '<a href="index.php?page=user&amp;user=' . $_SESSION["user"]["name"] . '&amp;date=' . $_GET["date"] . '&amp;delete=yes">Yes</a>' ?>
</div>
<div class="col-1">
    <?php echo '<a href="index.php?page=user&amp;user=' . $_SESSION["user"]["name"] . '&amp;date=' . $_GET["date"] . '">No</a>' ?>
</div>
