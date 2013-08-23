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
- 'variables' is the most powerful settings, it practically enables you to do everything. It is translated into following call: `$texy->$variableName = $variableValue`

In values, you can use asterisk sign (*), which will be translated to constant Texy::ALL and dash sign (-), which translates to Texy::NONE.

If this settings is not enough, you can extend Texy, set it up in constructor and set name of your instance as `class` attribute.

```yaml
edge_texy_bundle.filters:
        filter_from_my_class:
            class: MyClassExtendingTexy    			
```

In this case, settings allowed, module and variables will be passed to this extended class too.

## Tests

Run tests with PHPUnit from directory "Tests"

No reasonable tests are done though. My bad..