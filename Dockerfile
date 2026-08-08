FROM php:8.2-apache
COPY . /var/www/html/
FROM php:8.2-apache

# نصب پکیج‌های مورد نیاز سیستم
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# فعال‌سازی ماژول رایت ReWrite در آپاچی برای مدیریت درخواست‌ها
RUN a2enmod rewrite

# تعیین دایرکتوری کاری
WORKDIR /var/www/html

# کپی کردن فایل‌های پروژه به داخل کانتینر
COPY . /var/www/html/

# تعیین دسترسی‌های صحیح
RUN chown -R www-data:www-data /var/www/html
