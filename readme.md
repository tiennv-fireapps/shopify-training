## Up docker component

Hãy chắc chắn rằng bạn đã cài đặt docker ở máy tính của bạn

```cd laradock & docker-compose up -d mysql nginx phpmyadmin redis```

## Exec docker workspace

Component ```workspace``` là component chứa code của dự án của chúng ta. Code dự án sẽ tự động mapping ở folder ```example_project``` vào docker component. Để vào docker component quản lý code chúng ta chạy lệnh sau

```docker-compose exec workspace bash```

## Install laravel

Sau khi vào docker component chúng ta chạy lệnh sau để cài đặt project laravel của chúng ta

```composer install```

Copy file .env-example thành .env

## View example project

Chúng ta có thể xem demo project chạy ở link ```http://localhost```