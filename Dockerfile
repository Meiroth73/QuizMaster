FROM php:8.3
LABEL maintainer="x"
ADD . /var/www/html

#WORKDIR /app
#ADD . .

EXPOSE 80