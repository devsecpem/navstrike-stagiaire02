FROM php:latest

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ADD . /var/www/html/

RUN chmod 777 /var/www/html/

EXPOSE 80
EXPOSE 22

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html/"]
