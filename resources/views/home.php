<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME?></title>
        <link rel="stylesheet" href="/styles.css">
    </head>
    <body>
        <h1><?=APP_NAME?></h1>

        <?php if (!isset($shortenedUrl)) { ?>

        <p>Enter a URL to shorten it:</p>
        <form action="/" method="post">
            <label for="url">URL</label>
            <input id="url" type="text" name="url" value="">
            <input type="submit" name="submit" value="Shorten">
            <?php if (isset($error)) { ?>
            <span id="error"><?=$error?><span>
            <?php } ?>
        </form>

        <?php } else { ?>

            <p>Your shortened URL is: <?=$shortenedUrl?></p>

        <?php } ?>
    </body>
</html>
