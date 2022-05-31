ARG COMPOSER_TAG="2.3.5"
ARG PHP_TAG="8.1-cli-alpine"
FROM composer:${COMPOSER_TAG} as builder

WORKDIR /usr/src/suspicious-reading-detector

COPY src ./src
COPY tests ./tests
COPY composer.* ./
COPY phpunit.xml ./
COPY .env ./

RUN composer install

FROM php:${PHP_TAG}

COPY --from=builder /usr/src/suspicious-reading-detector /usr/src/suspicious-reading-detector

WORKDIR /usr/src/suspicious-reading-detector

# CMD [ "php", "--version" ]