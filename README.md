# URL Shortener

Turn long URLs into shorter, more sharable ones.

---

The current environment variables are set up to work with the domain http://urlshortener.dev for local development. The entry point for the app is `public/index.php`. There is an included .htaccess (copied from Laravel) which should enable mod_rewrite, or you can use the nginx equivalent.

The app and database settings are all stored in `.env.php`.

The current environment is set to `development` so all php errors will be shown. Change the `environment` (in `.env.php`) to `production` to disable these.

## Database set up script

```sql
CREATE TABLE `urls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `path` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `shortened` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
```
## Testing

PHPUnit, Selenium and the Firefox webdriver are used for testing. These will all need to be installed and configured to run the tests. Note: running the tests will also clear the development database.
