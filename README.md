[![Chunky Logo](https://user-images.githubusercontent.com/5302050/208255118-7fefc15d-c714-4723-94ce-69fca3e703ae.png)](https://github.com/dgtl-one/kirby-chunky)

# Chunky – Large and resumable file uploads for Kirby CMS

![Packagist Version](https://img.shields.io/packagist/v/dgtl-one/kirby-chunky?style=flat-square) ![Kirby Version](https://img.shields.io/badge/Kirby-3.6%2B-black.svg?style=flat-square) ![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/dgtl-one/kirby-chunky/php?style=flat-square) ![Packagist License](https://img.shields.io/packagist/l/dgtl-one/kirby-chunky?style=flat-square)

Chunky is a plugin for Kirby CMS that allows users to easily upload and manage very large files. With support for uploading files ranging from a few MB to multiple TB, Chunky provides a fast and secure way to transfer files of any size without the need to modify server settings or work around file upload limits imposed by hosting providers, proxies (like Cloudflare), firewalls, or CDNs.

One of the key features of Chunky is its support for resumable uploads, which allows users to resume an upload from anywhere inside the panel at a later time. This is particularly useful for transferring large files over slow or unreliable internet connections.

Chunky also extends all files sections automatically and fits seamlessly into the Kirby UI, making it easy for panel users to work with large files without any additional setup or configuration.

Under the hood, Chunky uses the tus protocol v1 and the official [tus-js-library](https://github.com/tus/tus-js-client), ensuring compatibility with a wide range of web servers and hosting providers including NGINX, Apache, and Caddy. Chunky is compatible with PHP 7.2.5 and higher, and provides the option to configure your own chunk size inside your site's config.

## Features:

■ Upload very large files from inside the Kirby Panel, ranging from a few MB to multiple TB in size.<br>
■ Resumable uploads can be initiated at any point from within the Kirby Panel.<br>
■ The file upload limits set by PHP.ini, proxy (like Cloudflare), firewall, or hosting provider can be bypassed.<br>
■ Fast and secure uploads of any size are possible without modifying server settings.<br>
■ The maximum available chunk size on the server is calculated automatically.<br>
■ A custom chunk size can be configured within the site's config.<br>
■ All file sections are automatically extended without the need to modify blueprints.<br>
■ Deep integration of custom file-related hooks and compatibility with other file-related plugins.<br>
■ Compatible with any web server and hosting provider, including NGINX, Apache, and Caddy.<br>
■ Works seamlessly for Panel users and fits perfectly with the known Kirby Upload UI.<br>

## Browser support:

The Chunky plugin is built on top of the tus-js-client, which has been tested and is known to be compatible with a variety of web browsers. While it is likely that Chunky will also work in other browsers, this has not yet been confirmed. However, since the tus client only relies on Web Storage, XMLHttpRequest2, the File API, and the Blob API, it is expected that users who can access the Kirby Panel should also be able to use Chunky without issue.

■ Microsoft Edge 12+<br>
■ Mozilla Firefox 14+<br>
■ Google Chrome 20+<br>
■ Safari 6+<br>
■ Opera 12.1+<br>
■ iOS 6.0+<br>
■ Android 5.0+

## How to use Chunky

Installing Chunky is a breeze. Simply add it to your Kirby CMS plugin folder using your preferred method, and you're all set. Chunky automatically enhances all upload functions in the Kirby Panel, without the need for any additional configurations in the blueprints. And if you decide you no longer want to use Chunky, just remove it from your plugin folder and everything will return to normal.

## Installation

### Download

Download and copy this repository to `/site/plugins/chunky`.

### Git submodule

```
git submodule add https://github.com/dgtl-one/kirby-chunky.git site/plugins/chunky
```

### Composer

```
composer require dgtl-one/kirby-chunky
```

## Config Options

You can also define your own chunk size inside your config.php, however, this will be overridden if the value exceeds the limits defined in the PHP.ini or the limit of a proxy such as Cloudflare (100 MB). If possible, Chunky will automatically set the chunk size to 5 MB.

```
return [
    'dgtlone.kirby-chunky.chunk_size' => '5M', // shortcuts 'K', 'M', 'G' are supported
];
```

The ideal chunk size for resumable tus uploads will depend on a variety of factors, including the size of the file being uploaded, the bandwidth and latency of the network connection, and the capabilities of the server receiving the upload.

In general, it is a good idea to start with a chunk size of around 5 MB and then adjust based on the performance of the upload. Larger chunk sizes may be faster, but may also be more prone to errors if the connection is unstable. Smaller chunk sizes may be slower, but may be more reliable and allow for easier recovery if an error occurs.

Overall, the best chunk size will depend on the specific needs of the average file size of your site and the characteristics of the network environment in which it is being used.

***

## What is TUS?

The TUS protocol (short for "The Upload Server Protocol") is a reliable and popular method for uploading large files over the internet. It works by allowing the client to send multiple small chunks of data to the server, rather than sending the entire file in one go. This makes it possible to resume an interrupted upload from where it left off, as well as to perform other features such as file concatenation, modification, and deletion. TUS is an open protocol, meaning that it is freely available for anyone. It is widely used in a variety of applications, including file sharing platforms and online backup services.

Get more information at [tus.io](https://tus.io).

## License

*Chunky is released under the [MIT License](https://tldrlegal.com/license/mit-license).*
