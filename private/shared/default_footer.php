<footer>
    <!--&copy; --> <?php //echo date('Y'); ?>
</footer>
<script src="<?php echo url_for("/script.js") ?>"></script>
</body>

</html>

<?php db_disconnect($db); ?>