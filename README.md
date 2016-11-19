# Magento2 Smtp
Extension enables you to easily use your own custom SMTP server for sending mail.

## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-smtp
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy

