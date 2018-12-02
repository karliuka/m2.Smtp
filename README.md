# Magento2 Smtp

[![Total Downloads](https://poser.pugx.org/faonni/module-smtp/downloads)](https://packagist.org/packages/faonni/module-smtp)
[![Latest Stable Version](https://poser.pugx.org/faonni/module-smtp/v/stable)](https://packagist.org/packages/faonni/module-smtp)

Extension enables you to easily use your own custom SMTP server for sending mail.

## Compatibility

Magento CE(EE) 2.0.x, 2.1.x, 2.2.x, 2.3.x

## Install

#### Install via Composer (recommend)

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-smtp
    ```
   Wait while dependencies are updated.
   
#### Manual Installation
   
1. Create a folder {Magento root}/app/code/Faonni/Smtp

2. Download the corresponding [latest version](https://github.com/karliuka/m2.Smtp/releases)

3. Copy the unzip content to the folder ({Magento root}/app/code/Faonni/Smtp)

### Completion of installation

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
	php bin/magento setup:static-content:deploy  (optional)

### Configuration

In the Magento Admin Panel go to *Stores > Configuration > Advanced > System > Mail Sending Settings*.

<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/config.2.1.3.png" style="width:100%"/>

### Log Message

Extension loging copies of the all original emails that sent from your store.
You can view content of any email whenever you like to find out how the customer sees it.
The email log can be cleared automatically after a specified time period.

In the Magento Admin Panel go to *Reports > Sending Emails*.

Email message grid

<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/grid.png" style="width:100%"/>

Email view

<img alt="Magento2 Smtp" src="https://karliuka.github.io/m2/smtp/view.png" style="width:100%"/>

## Uninstall
This works only with modules defined as Composer packages.

#### Remove database data

1. Go to Magento2 root folder

2. Enter following commands to remove database data:

    ```bash
    php bin/magento module:uninstall -r Faonni_Smtp
  
#### Remove Extension
    
1. Go to Magento2 root folder

2. Enter following commands to remove:

    ```bash
    composer remove faonni/module-smtp
    ```

### Completion of uninstall

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
	php bin/magento setup:static-content:deploy  (optional)

