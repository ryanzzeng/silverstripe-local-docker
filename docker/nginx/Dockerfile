FROM nginx:alpine
ARG FPM_HOST=app

# Add custom configuration
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s/fastcgi_pass_network_address/${FPM_HOST}/g" /etc/nginx/conf.d/default.conf
WORKDIR /app
ADD . /app

EXPOSE 8080
