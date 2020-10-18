# PHP Upload Image

[upload-image](https://github.com/oksglm/upload-image) is a REST API for uploading image with Basic Authentication.

## Usage

Before running this project you need to create your own encrypted password through `config/encrypt.php` file.

```bash
php /path/config/encrypt.php pass1
```

To use this password, you have to add your username and password to `config/config.ini` file.

```ini
...

[credentials]
secret_key = yoursecretkey123456
your_username = "your_encrypted_epassword"

...
```

You can call the API directly from the command line, as in the following example:

```bash
curl --location --request POST 'http://localhost/test/upload.php' \
--header 'Authorization: Basic eW91cl91c2VybmFtZTp5b3VyX3Bhc3N3b3Jk' \
--form 'file=@/path/to/your/image.png'
```

## License

PHP Upload Image is licensed under [MIT License](LICENSE).
