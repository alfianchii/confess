FROM nginx:1.24.0

# Environment arguments
ARG UID
ARG GID
ARG USER

ENV UID=${UID}
ENV GID=${GID}
ENV USER=${USER}

# Dialout group in Alpine Linux conflicts with MacOS staff group's gid, which is 20
RUN delgroup dialout

# Creating user and group
RUN addgroup --gid ${GID} --system ${USER}
RUN adduser --ingroup ${USER} --system --disabled-password --shell /bin/sh -u ${UID} ${USER}

# Modify Nginx configuration to use the new user's privileges
RUN sed -i "s/user nginx/user '${USER}'/g" /etc/nginx/nginx.conf

# Copies nginx configurations to override the default
ADD ./nginx/*.conf /etc/nginx/conf.d/

# Certbot
# RUN apt-get update && apt-get install -y certbot
# RUN echo "ssl_session_cache shared:le_nginx_SSL:1m;\
# ssl_session_timeout 1440m;\
# ssl_session_tickets off;\
# ssl_protocols TLSv1.2 TLSv1.3;\
# ssl_prefer_server_ciphers off;\
# ssl_ciphers 'TLS_AES_128_GCM_SHA256:TLS_AES_256_GCM_SHA384:TLS_CHACHA20_POLY1305_SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384';\
# ssl_ecdh_curve secp384r1;\
# ssl_stapling on;\
# ssl_stapling_verify on;\
# resolver 8.8.8.8 8.8.4.4;" > /etc/letsencrypt/options-ssl-nginx.conf

# Make html directory
RUN mkdir -p /var/www/html