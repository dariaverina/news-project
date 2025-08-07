# Demo Theme

October CMS demo theme that demonstrates the basic core functionality and utilizes the accompanying demo plugin. It is a great theme to copy when building a site from scratch.

The theme acts as a reference implementation for default component markup when distributing plugins.

Have fun!

## Combining CSS and JavaScript

This theme doesn't combine assets for performance reasons. To combine the stylesheets, replace the following lines in the default layout. When combining with this theme, we recommend enabling the config `enable_asset_deep_hashing` in the file **config/cms.php**.

Uncombined stylesheets:

```twig
<link href="{{ 'assets/css/vendor.css'|theme }}" rel="stylesheet">
<link href="{{ 'assets/css/theme.css'|theme }}" rel="stylesheet">
```

Combined stylesheets:

```twig
<link href="{{ [
    '@framework.extras',
    'assets/css/vendor.css',
    'assets/css/theme.css'
]|theme }}" rel="stylesheet">
```

> **Note**: October CMS also includes a LESS (`.less`) or SCSS (`.scss`) compiler, if you prefer to use these extensions.

Uncombined JavaScript:

```twig
{% framework extras %}
<script src="{{ 'assets/js/controls/alert-dialog.js'|theme }}"></script>
<script src="{{ 'assets/js/controls/password-dialog.js'|theme }}"></script>
<script src="{{ 'assets/js/controls/gallery-slider.js'|theme }}"></script>
<script src="{{ 'assets/js/controls/card-slider.js'|theme }}"></script>
<script src="{{ 'assets/js/controls/quantity-input.js'|theme }}"></script>
<script src="{{ 'assets/js/app.js'|theme }}"></script>
```

Combined JavaScript:

```twig
<script src="{{ [
    '@framework.extras',
    'assets/js/controls/alert-dialog.js',
    'assets/js/controls/password-dialog.js',
    'assets/js/controls/gallery-slider.js',
    'assets/js/controls/card-slider.js',
    'assets/js/controls/quantity-input.js',
    'assets/js/app.js'
]|theme }}"></script>
```

> **Important**: Make sure you keep the `{% styles %}` and `{% scripts %}` placeholder tags as these are used by plugins for injecting assets.
