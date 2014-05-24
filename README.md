Image bundle
============
[![Latest Stable Version](https://poser.pugx.org/nkt/image-bundle/v/stable.svg)](https://packagist.org/packages/nkt/image-bundle) [![Total Downloads](https://poser.pugx.org/nkt/image-bundle/downloads.svg)](https://packagist.org/packages/nkt/image-bundle) [![Latest Unstable Version](https://poser.pugx.org/nkt/image-bundle/v/unstable.svg)](https://packagist.org/packages/nkt/image-bundle) [![License](https://poser.pugx.org/nkt/image-bundle/license.svg)](https://packagist.org/packages/nkt/image-bundle)

Usage
-----

Add `"nkt/image-bundle": "1.0.x-dev"` into composer.json.

Add `Nkt\ImageBundle\NktImageBundle` into your kernel bundles.

Add configuration into `app/config/config.yml`:

```yml
nkt_image:
    upload_dir: %kernel.root_dir%/uploads # Value by default
    types:
        logo:
            extension:  jpg
            min_width:  100
            max_width:  1000
            min_height: 100
            max_height: 1000
        slider:
            min_width: 500
```

Import routing in your `app/config/routing.yml`:

```yml
nkt_image:
    resource: "@NktImageBundle/Resources/config/routing.yml"
    prefix: /
```

Then clear your application cache, and update database schema.
```bash
app/console cache:clear
app/console doctrine:schema:update --force
```

License
-------

MIT
