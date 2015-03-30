## EdgeDesign Texy Bundle

This is a simple bundle wrapping up Texy! text processor (http://texy.info/en) into a Symfony bundle.


## Setup

1. `composer require edgedesign/texy-bundle`
2. Add `new Edge\TexyBundle\EdgeTexyBundle()` to your AppKernel.

## Configuration

Feel free to override `Resources/config/config.yml` directives.
You can change classes which will be instantiated, if you are not satisfied with our implementation, 
just implement correct interfaces please.

### Custom attributes

In section `edge_texy_bundle.custom_attributes` you can define custom html attributes which will
be added to every html element. Useful for allowing html5 attributes (`download`, `data-something`, ...).

### Filters

In section `edge_texy_bundle.filters` you can set-up your filters.
First-level key determines name of filter. 

Then, there are 3 types of settings.

- 'allowed' is used for setting enabled modules via calls like `$texy->allowed[$moduleName] = true/false`
- 'module' is for passing settings to module, it will be translated in call similar to this: `$texy->$moduleName.'Module'->$parameter = $settings`
- 'variables' is the most powerful settings, it enables you to do almost everything. It is translated into following call: `$texy->$variableName = $variableValue`

In values, you can use asterisk sign (*), which will be translated to constant Texy::ALL and dash sign (-), which translates to Texy::NONE.

If this settings is not enough, you can extend Texy, set it up in constructor and set name of your instance as `class` attribute.

```
edge_texy_bundle.filters:
  filter_from_my_class:
    # Name of class which will be used to instantiate Texy instance.
    class: MyClassExtendingTexy   
    # equivalent to $texy->allowed['block/code'] = FALSE;
    allowed:
        "block/code": false
    # equivalent to $texy->allowedTags = array('a' => array('href', 'target'), 'em' => Texy::NONE, 'img' => Texy::ALL)
    variables:
        allowedTags:
            a:
               - href
               - target
            em: '-'
            img: '*'
    # equivalent to $texy->{name}Module->variable = value
    modules:
      link:
          forceNoFollow: true; 			
```

In this case, settings allowed, module and variables will be passed to this extended class too.

## Usage

There are two ways how to use this bundle.

### Service

You can get TexyProcessor service named `edge_texy.processor` and call method

```
$processor->multiLineText($text, $filterId);
$processor->singleLineText($text, $filterId);
```

This will process your `$text` via filter set in config with id `$filterId`.

### Twig

Second way is to use registered Twig macros '`texy_process`' and '`texy_process_line`'.

```twig
{{ variableThatINeedToPassThroughTexy|texy_process(filterId)}}
```

Alternative Twig syntax useful when you don't have the content stored in variable, but in template itself:

```twig
{% filter texy_process %}
- Lorem
- Ipsum

Foo **Bar** Baz.
{% endfilter %}
```
(Thank you, [OndraM](https://github.com/OndraM), for [pointing that out](https://github.com/EdgedesignCZ/TexyBundle/issues/1#issuecomment-53973044).)


This way, given variable is passed through filter named `filterId`. If no filter name given, macro tries to use filter called "default".

Difference between macros is that when using texy_process_line, Texy will not wrap given code in block tags like <p>.

### Example config.yml

Settings example for sanitizing html output (put this into your config.yml):

```yaml
edge_texy:
  custom_attributes: &custom_attributes
      500: download
  attribute_settings:
      html5_attributes: &html5_attributes
          100: itemid
          101: itemprop
          102: itemref
          103: itemscope
          104: itemtype
      html_identifiers: &html_identifiers
          200: class
          201: id
      global_attributes: &global_attributes
          << : [*html5_attributes, *html_identifiers]
          << : *custom_attributes
  filters:
      sanitize:
          allowed:
            link/url: false
          modules:
            link:
              shorten: false
          outputMode: 4   # Set outputMode to HTML5 - https://github.com/jiripudil/texy/blob/master/Texy/Texy.php#L122
          variables:
              allowedTags:
                  a:
                      << : *global_attributes
                      0: href
                      1: title
                  acronym: [title]
                  b: *global_attributes
                  br: *global_attributes
                  cite: *global_attributes
                  code: *global_attributes
                  div: *global_attributes
                  em: *global_attributes
                  img:
                      << : *global_attributes
                      0: src
                      1: alt
                  strong: *global_attributes
                  sub: *global_attributes
                  sup: *global_attributes
                  q: *global_attributes
                  small: *global_attributes

      strip:
          allowed:
              paragraph: false
          variables:
              allowedTags: '-'
```

Now, you can use filter `sanitize` to sanitize your HTML output from user
and filter `strip` to make user no HTML from user will appear in your code.
