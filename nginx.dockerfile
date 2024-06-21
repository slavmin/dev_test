FROM nginx:stable-alpine

ADD ./nginx/nginx.conf /etc/nginx/
ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html

RUN addgroup -g 1000 developer && adduser -G developer -g developer -s /bin/sh -D developer

RUN chown developer:developer /var/www/html