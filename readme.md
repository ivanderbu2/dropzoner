## Dropzoner - Laravel package for Dropzone 

This is work in progress and it is bare Laravel installation right now.

Idea is to have simplest package for Dropzone. You pull it via composer, set service provider and include it in your views with **@include('dropzoner')**. 
It will take full width of parent container, and will throw events on image upload/delete etc.
 
After installation you need to publish Dropzoners config and assets:

```shell
php artisan vendor:publish
```

When you publish these files, you will be able to modify Dropzoner configuration. There you'll find validator array and validator-messages array.

You also need to add upload path into .env file using key **DROPZONER_UPLOAD_PATH**. This directory should be write-able by web server.


If you have some ideas for features, just open issues here on GitHub or send me an email.
