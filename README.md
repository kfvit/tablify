# Tablify
Tablify makes creating data-tables in multiple formats easier.

## Installation

Install via composer

    composer require dialect-katrineholm/tablify

Publish config

    php artisan vendor:publish --provider="Dialect\Tablify\TablifyServiceProvider"

## Usage
``` php
      #basic usage
      tablify($collection)->text('Header', 'mapping')->toHtml();

      //tablify automatically gets properties from data
      tablify($articles)
      ->text('Category', 'category.name')
      ->text('Name', 'name')
      ->currency('Price', 'price');
      
      //Or it can take a closure
      ->text('popular', function($item){
        return $item->sells > 5 ? 'Yes' : 'No';
      });

      #groups
      //if an item in the data contains a array itself you can loop over it using group
      
      tablify($categories)
      ->text('Category', 'name')
      ->group('articles', function($tablify){
        //In here you can access the tablfiy builder for every article.
      });
      
      #Settings
      //TODO
      
      
      
      
```
