# Magento2 Smtp
Extension enables you to easily use your own custom SMTP server for sending mail.

### Configuration

from Magento 2.0.*

<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/config.png" style="width:100%"/>

from Magento 2.1.*

from Magento 2.2.*

<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/config.2.1.3.png" style="width:100%"/>

### Log Message

from Magento 2.1.*

from Magento 2.2.*

listing page
<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/grid.png" style="width:100%"/>

view page
<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/view.png" style="width:100%"/>

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
	php bin/magento setup:di:compile
	php bin/magento setup:static-content:deploy  (optional)

