FROM nginx:alpine

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
RUN rm /etc/nginx/conf.d/default.conf
COPY ./nginx/conf.d/ /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]
