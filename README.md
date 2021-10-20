# Airport Operations

**Symfony 5 project**

### Environment
- nginx 1.17
- php-fpm 7.3
- postgresql 11.5
- xdebug 2.7.1

### Requirements
Docker compose, Git and as the main IDE is PhpStorm (preferably the latest version with Shell Configuration supports).

### Installation
First, create a folder for your project and clone the repository:

```bash
git clone https://github.com/f-stojanovic/airport-operations.git
```

Open project root folder and run next configurations:
1. Open terminal and run: `docker-compose -f docker-compose.yaml up`
2. Enter the PHP container: `docker exec -it airport-operations_php_1 /bin/bash`
3. In the container run `composer install` (after execute, it will take a little time to index the installed vendors)
4. In the same container run: `php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20211020164914` to fill up the database
5. Now, lets load some fixtures with `php bin/console doctrine:fixtures:load`

Go to `http://localhost` page in your browser. If the installation is successful, you will see:
- Login form. 
- In the upper right corner click Register -
After registration you will be redirected again to Login page.
- You can login now and you will be redirected to Dashboard. :) 

> Welcome to Airport Operations Dashboard!

Here you can perform all operations defined in the task. All requests can be done in the `List of Aircraft` view.

### Cron job

For cron job operations I have used [this library](https://github.com/Cron/Symfony-Bundle).

You can start it by doing next:

1. Enter the PHP container: `docker exec -it airport-operations_php_1 /bin/bash`
2. Then run: `bin/console cron:create`
3. For the params of the first command enter: `landed:check`, `if:landed:check`, `*/1 * * * *`), hit enter
4. For the params of the second command enter: `approach:check`, `on:approach:check`, `*/3 * * * *`), hit enter
5. For the params of the third command enter: `weather`, `weather:check`, `*/1 * * * *`), hit enter
6. Cron jobs are created now! Run them by entering: `bin/console cron:start --blocking`

```bash
Now go and play! :)
```

