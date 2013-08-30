## EdgeDesign Texy Bundle

This is a simple bundle wrapping up Texy! text processor (http://texy.info/en) into a Symfony bundle.


## Setup

`composer require edgedesign/texy-bundle` should do the trick.

Don't forget to register `Edge\TexyBundle\EdgeTexyBundle` in your AppKernel.

## Configuration

Feel free to override `Resources/config/config.yml` directives.
You can change classes which will be instantiated, if you are not satisfied with our implementation, 
just implement correct interfaces please.

In section `edge_texy_bundle.filters` you can set-up your filters.
First-level key determines name of filter. 

Then, there are 3 types of settings. 
- 'allowed' is used for setting enabled modules via calls like `$texy->allowed[$moduleName] = true/false`
- 'module' is for passing settings to module, it will be translated in call similar to this: `$texy->$moduleName.'Module'->$parameter = $settings`
- 'variables' is the most powerful settings, it enables you to do almost everything. It is translated into following call: `$texy->$variableName = $variableValue`

In values, you can use asterisk sign (*), which will be translated to constant Texy::ALL and dash sign (-), which translates to Texy::NONE.

If this settings is not enough, you can extend Texy, set it up in constructor and set name of your instance as `class` attribute.

```yaml
edge_texy_bundle.filters:
        filter_from_my_class:
            class: MyClassExtendingTexy    			
```

In this case, settings allowed, module and variables will be passed to this extended class too.

## Usage

There are two ways how to use this bundle.

### Service
You can get TexyProcessor service named `edge_texy_bundle.class.processor` and call method `$processor->process($filterId, $text)`.

This will process your `$text` via filter set in config with id `$filterId`.

### Twig macro
Second way is to use registered Twig macro '`texy_process`'.

```twig
{{ variableThatINeedToPassThroughTexy|texy_process(filterId)}}
```

This way, given variable is passed through filter named `filterId`. If no filter name given, macro tries to use filter called "default".

### Settings examples
Settings example for sanitizing html output (put this into your config.yml):
```yaml
edge_texy:
  attribute_settings:
      html5_attributes: &html5_attributes
          - itemid
          - itemprop
          - itemref
          - itemscope
          - itemtype
      html_identifiers: &html_identifiers
          - class
          - id
      global_attributes: &global_attributes
          << : [*html5_attributes, *html_identifiers]
  filters:
      sanitize:
          outputMode: 4   # Set outputMode to HTML5 - https://github.com/jiripudil/texy/blob/master/Texy/Texy.php#L122
          variables:
              allowedTags:
                  a: [itemid, itemprop, itemref, itemscope, itemtype, class, id, href, title]
                  acronym: [title]
                  b: *global_attributes
                  br: *global_attributes
                  cite: *global_attributes
                  code: *global_attributes
                  div: *global_attributes
                  em: *global_attributes
                  img: [itemid, itemprop, itemref, itemscope, itemtype, class, id, src, alt]
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
## Tests

Run tests with PHPUnit from root directory.

No reasonable tests are done though. My bad..