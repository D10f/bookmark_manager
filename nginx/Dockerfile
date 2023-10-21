FROM nginx:1.23 AS base

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}
ENV NGINX_USER=laravel

RUN groupadd -g ${GID} ${NGINX_USER} && \
    useradd -u ${UID} -g ${GID} ${NGINX_USER} && \
    sed -i -E "s/^user\s+(www-data|nginx)/user\t${NGINX_USER}/g" /etc/nginx/nginx.conf

EXPOSE 80
EXPOSE 443
