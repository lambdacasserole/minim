# Minim
Minimal single-user auth in PHP.

Every so often, you build a website that needs:
  * to run without a database
  * to have an administrator backend
  * to be accessible by one user only

Minim is designed for this purpose; to be a secure, single-user authentication system that doesn't do anything silly like leak the users password (or store it in plain text) or operate over insecure (non-HTTPS) connections unless you want it to.

## Installation
Install Minim via Composer like this:

```bash
composer require semibreve/minim
```

Or alternatively, if you're using the PHAR (make sure the `php.exe` executable is in your PATH):

```
php composer.phar require semibreve/minim
```

## Configuration
Minim will require you to create a configuration file that looks something like this:

```yaml
# Don't commit this file to source control, it contains your secret settings.

admin_email: me@example.com # The e-mail address of the user, used as a username.
admin_password_hash: $2y$10$x8.kXrWv4lXFpObosuwQ0uoiQAUeFAlEL.oi0tN5pnM.72hoK9e8K # The user's password hash.
secret_key: 7WCPTI3of3cp # The secret key the application uses for symmetric encryption
token_length: 32 # The length, in bytes, of any generated authentication tokens.
token_ttl: 1200 # The time to live for authentication tokens, in seconds.
cookie_name: minim_auth # The name of the authentication cookie.
session_file_name: /var/www/minim/token.dat # The name of the session file on-disk.
cookie_ssl_only: false # Whether or not cookies are enables for HTTPS only. If enabled, non-HTTPS requests will fail.
cookie_http_only: true # Whether to restrict cookies to HTTP only and disallow access by client-side script.
```

The above file specifies some default credentials:

```
Email: me@example.com
Password: demo
```

These *must* be changed before you go into production, so you need to do the following:

* Copy the demo configuration file above into your project. Make sure it is ignored by any version control systems.
* Open it up in your favorite text editor.
* Change the `admin_email` field to your email address
* Change the `admin_password_hash` field to the bcrypt hash of a password of your choice. Generate the hash using the bundled `minim-genhash` utility by invoking `php vendor/bin/minim-genhash <password>` from the project root.
* Change the `secret_key` field to a randomly-generated string at least 12 characters long.
* Change the `salt` field to a randomly-generated string at least 12 characters long.
* The default value of 32 for the `token_length` field should be okay for most applications.
* The default value for the `token_ttl` field of 1200 seconds (20 minutes) should be okay for most applications.
* Change the `session_file_name` field to the absolute path of a writable file on your server that Minim can read and write, but that your server _will not serve_.
* Change `cookie_ssl_only` field to `true` if you're operating over HTTPS. If you're not, take a long hard look at your application and ask yourself why you're considering asking for user credentials over an insecure connection when amazing, free tools like [Let's Encrypt](https://letsencrypt.org/) exist.
* Leave `cookie_http_only` as `true` to make the authentication cookie readable only over HTTP and not by client-side script.

To see an example usage of Minim, [check out the demo repository](https://github.com/semibreve/minim-demo).

## Usage
Load your Minim configuration file like this:

```php
$auth = new Authenticator(new Configuration('my-config-file.yml'));
```

From here you can log the user in:

```php
$auth->authenticate('email', 'password'); // Authenticate user, true on success false on failure.
```

Or redirect away from a page based on whether they're logged in or not:

```php
// Check if user is authenticated.
if (!$auth->isAuthenticated()) {
    header('Location: /forbidden.php'); // Not logged in, go to jail.
    die();
}
```

## Limitations
Don't rely on Minim to be secure out of the box and always perform your own penetration testing.
