SMART BASKET - PRODUCT VIDEO FIX

Root cause fixed:
1. Seller add/edit forms had a video input, but SellerController never validated or saved the video.
2. products table had no video column.
3. Product model did not allow video mass assignment.
4. Customer product detail page did not render the saved product video.

Files included:
- app/Http/Controllers/SellerController.php
- app/Models/Product.php
- database/migrations/2026_09_08_000000_add_video_to_products_table.php
- resources/views/products/show.blade.php

After copying these files into the project, run from the Laravel project folder:

php artisan migrate
php artisan storage:link
php artisan optimize:clear
php artisan route:clear
php artisan view:clear

Then restart the server:
php artisan serve

Important:
- Product video limit is 20 MB.
- Supported extensions: MP4, WEBM, MOV.
- Videos are stored in storage/app/public/product-videos.
- Customer product detail page shows the video with controls when a video exists.
- If your PHP configuration rejects files above 20 MB, increase upload_max_filesize and post_max_size in php.ini, then restart PHP/Apache.
