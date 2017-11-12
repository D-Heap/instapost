# Instapost
A Wordpress Plugin for fetching individual public Instagram posts

## Dependencies

This plugin relies on the brilliant [Advanced Custom Fields](https://www.advancedcustomfields.com) Wordpress plugin 


## Features

- Get Instagram post data on demand from its URL.
- Stores JSON data in an ACF repeater field

## Installation

- Download and copy the `insta-post` directory to `wp-content/plugins`
- Activate the plugin
- Import the ACF JSON Group or copy the file to `acf-json` in your theme - 
For more information see [ACF Local JSON](https://www.advancedcustomfields.com/resources/local-json/)

## Usage

- Once setup, create a new Post
- Find the `Instagram posts` ACF repeater field
- Hit the `Add Instagram post` button
- Paste the post URL you want to get data for - e.g. https://www.instagram.com/p/BMucx5NBRua/
- The plugin will get the data using the [`oembed` API endpoint](https://www.instagram.com/developer/embedding/#oembed)
- It will store the JSON data retrieved with the additional `datetime` value and with mentions and hashtags links

## Example

```
<?php

  foreach( get_field( 'instagram', $post->ID ) as $item ){
    
    $post_data = json_decode( $item['instagram_post'] );
    
    // Get individual values
    printf( 'Title: %s', $post_data->title );
    printf( 'Image URL: %s', $post_data->thumbnail_url );
    printf( 'Author: %s', $post_data->author_name );
    
    // Or if you prefer show the embed code
    printf( 'Embed code: %s', $post_data->html );
  }
```

## TODO

- Create an ACF Field Type
