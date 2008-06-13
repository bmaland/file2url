# file2url

## Overview

The purpose of this application is to facilitate _quick_ uploading of files from
console and/or your Emacs buffer (more methods may be added - or contributed ;).
A small shellscript sends the selected file to the PHP backend via curl, and
echoes out the URL of the file to the terminal. Very useful for quick sharing of
files, with no hassle. Probably most useful for binary files and/or images.

Requires PHP5 and Apache with mod_rewrite. The shellscript (client) requires curl.

Built with Zend Framework 1.5.1.

## Configuration

Basic virtual host entry for Apache:

    <VirtualHost *>
        DocumentRoot "/var/www/apps/file2url/public"
        ServerName file2url
        <Directory /var/www/apps/file2url/publi>
            AllowOverride All
            Order allow, deny
            Allow from all
        </Directory>
    </VirtualHost>

Remember to create a file-folder that Apache can write to:

    mkdir public/files
    chmod -R 777 public/files

You also need to insert at least one user into the db to be able to upload files:

    INSERT INTO users (api_key, email) VALUES ('your-key', 'your@email');

Then update file2url.sh with the corresponding values.

## Usage

Place file2url.sh in your path, then upload files like this:

    file2url.sh <file.ext>

The script will echo out the URL to the uploaded file, i.e http://localhost/fetch/Avfa5
