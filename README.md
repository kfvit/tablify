# Tablify
Tablify makes creating data-tables in multiple formats easier.

## Installation

Install via composer

    composer require dialect-katirneholm/tablify

Publish config

    php artisan vendor:publish --provider="Dialect\Tablify\TablifyServiceProvider"

## Usage

´´php

  
  #basic usage
  tablify($collection)->text('Header', 'mapping')->toHtml();
  
  //tablify automatically gets properties from data
  tablify($articles)
  ->text('Category', 'category.name')
  ->text('Name', 'name')
  ->currency('Price', 'price');
  
  //TODO: More
  
``
