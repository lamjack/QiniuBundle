# QiniuBundle
===================
A symfony2 bundle to help you use Qiniu cloud storage.
Provides a simple Symfony 2 Bundle to Wrap the QINIU PHP SDK - https://github.com/hfcorriez/php-qiniu

## Installing via Composer

```json
{
    "require": {
        "wiz/qiniu-bundle": "1.0.x-dev"
    }
}
```

## Using and Setting Up

### Kernel.php
```php
public function registerBundles() {
    $bundles = array(
        new \Wiz\QiniuBundle\WizQiniuBundle()
    );
}
```

To provide custom setup for access, secret keys. Add a config options in your config.yml, like:

```yaml
wiz_qiniu:
    access_key: xxx
    secret_key: xxx
```

and you can get the SDK client in container

```php
$this->get('wiz_qiniu.client');
```