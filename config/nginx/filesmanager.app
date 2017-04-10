fastcgi_cache_path /var/cache/nginx levels=1:2 keys_zone=FM_CACHE:10m max_size=100m inactive=1h;
add_header X-Cache $upstream_cache_status;
server {
    listen 80;
    listen 443 ssl http2;
    server_name filesmanager.app;
    root "/home/vagrant/Code/filesmanager.app/public";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/filesmanager.app-error.log error;

    sendfile off;

    client_max_body_size 100m;

    set $no_cache 1;
    if ($request_uri ~* "/files/") {
        set $no_cache 0;
    }

    location ~ \.php$ {
        fastcgi_cache_key $scheme$host$request_uri$request_method;
        fastcgi_cache FM_CACHE;
        fastcgi_cache_valid 200 1h;
        fastcgi_cache_use_stale updating error timeout invalid_header http_500 http_503 http_404;
        fastcgi_ignore_headers Cache-Control Expires Set-Cookie;
        fastcgi_cache_bypass $no_cache;
        fastcgi_no_cache $no_cache;

        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }

    ssl_certificate     /etc/nginx/ssl/filesmanager.app.crt;
    ssl_certificate_key /etc/nginx/ssl/filesmanager.app.key;
}

