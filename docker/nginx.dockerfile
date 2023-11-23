FROM nginx:1.24.0-alpine

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
RUN addgroup -g ${GID} --system ${USER}
RUN adduser -G ${USER} --system -D -s /bin/sh -u ${UID} ${USER}

# Modify Nginx configuration to use the new user's privileges
RUN sed -i "s/user nginx/user '${USER}'/g" /etc/nginx/nginx.conf

# Copies nginx configurations to override the default
ADD ./nginx/*.conf /etc/nginx/conf.d/

# Make html directory
RUN mkdir -p /var/www/html