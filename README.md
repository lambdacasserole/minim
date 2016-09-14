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
composer require lambdacasserole/minim
```

Or alternatively, if you're using the PHAR (make sure the `php.exe` executable is in your PATH):

```
php composer.phar require lambdacasserole/minim
```

## Limitations
I'm not a security researcher, don't rely on Minim to be secure out of the box and always perform your own penetration testing.
