<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=APP_NAME?></title>
        <link rel="stylesheet" href="/styles.css">
    </head>
    <body>

        <div id="content">

            <h1><?=APP_NAME?></h1>

            <div id="shortener-box">

                <?php if (!isset($shortenedUrl)) { ?>

                <form action="/" method="post">
                    <label <?php if(isset($error)) { ?>class="error" <?php }?>for="url">URL</label>
                    <input class="text<?php if(isset($error)) { ?> error<?php }?>" id="url" type="text" name="url" value="">
                    <input class="submit" type="submit" name="submit" value="Shorten">
                    <?php if (isset($error)) { ?>
                        <div>
                            <p id="error"><?=$error?><p>
                        </div>
                    <?php } ?>
                </form>

                <?php } else { ?>

                    <p>Your shortened URL is:</p>

                    <p id="shortened-url"><?=$shortenedUrl?></p>

                    <p><a href="/">Shorten another URL</a></p>

                <?php } ?>
            </div>

        </div>
    </body>
</html>
