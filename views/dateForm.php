<html>
    <head>
        <link rel="stylesheet" href="/public/css/style.css">
        <script src="/public/js/jquery-3.2.1.min.js"></script>
        <script src="/public/js/form.js"></script>
    </head>
    <body>
        <form action="/" method="post">
            <textarea class="date-input" name="date" placeholder="YYYY/mm/dd+days"><?=$date?></textarea>
            <span class="date-buttons">
                <input class="date-post" type="submit" name="date-post-button" value="Post">
                <button class="date-ajax" type="button">Ajax</button>
            </span>
        </form>
        <div class="date-result">
            <?=$dateResult ?>
        </div>
        <div class="date-errors">
            <?php foreach ($errors as $error) { ?>
                <div><?=$error?></div>
            <?php } ?>
        </div>
    </body>
</html>