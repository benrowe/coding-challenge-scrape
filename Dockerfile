FROM php:8.3-cli

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -m -u ${USER_ID} -g appuser appuser

# Install pcov extension
RUN pecl install pcov && docker-php-ext-enable pcov

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER appuser
