FROM php:8.3-fpm-alpine

# 1. Install standard system cron dependencies for Alpine Linux
RUN apk add --no-cache dcron

RUN docker-php-ext-install pdo_mysql

# 2. Set the working directory inside the container
WORKDIR /var/www


# 3. Create our custom crontab execution line (Gio's 2-minute interval)
# This routes outputs directly to the Docker terminal logs stream
RUN echo "*/2 * * * * php /var/www/scripts/email.php > /proc/1/fd/1 2>&1" > /etc/crontabs/root

# 4. Run the cron daemon in the foreground (-f) so the Docker container stays active
ENTRYPOINT ["crond", "-f", "-l", "2"]