# GENIUS API - PHP SDK

<p align="center">
	Welcome to Software development kit for Genius api
<p>

![Genius](https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Genius_website_logo.svg/1200px-Genius_website_logo.svg.png)

## Installation
using composer
```bash
composer require yzpeedro/genius-php-sdk
```
## Basic Usage
```php
require __DIR__ . "/vendor/autoload.php";

// get GeniusSDK class
use Yzpeedro\GeniusPhpSdk\Genius;

// initiate Genius
$genius = new Genius('YOUR_ACCESS_TOKEN');

// get artist by id
$artist = $genius->artist('artist_id');

// get song by id
$song = $genius->song('song_id');

// get annotation by id
$annotation = $genius->annotations('annotation_id');

// get referents by id
$referent = $genius->referents('web_page_id');

// get webPage
$webPages = $genius->webPage('raw_annotatable_url', 'canonical_url', 'og_url');

// get result from search in Genius database
$search = $genius->search('query');
```
## Documentation
> You can see more about in [Documentation](https://github.com/yzPeedro/genius-php-sdk/wiki)

##

### Disclaimer
> If you are a tech lead or copyright owner of the Genius api and would like this repository removed, please contact me at: pedrocruzpessoa16@gmail.com