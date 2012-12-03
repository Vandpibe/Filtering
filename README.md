Vandpibe Filtering
==================

On the GitHub blog they announce a RubyGem called [html-pipeline](https://github.com/blog/1311-html-pipeline-chainable-content-filters).

Which is a more or less simple way to have a collection of filters applied on a string or dom document.

The goal is to port this behaviour in PHP. It is not completely possible because Ruby have class identifiers which they call
`new` on when appleing the filters (a form of lazy loading).

Limitations
-----------

* Currently a `FilterInterface` only takes a string value and must return a string aswell.
* `ChainFilter` must get all filters in the constructor as instantiated objects. This could be fixed by adding a
wrapper that knows how to get a Filter by its name.
* The is only a single Filter.

Usage
-----

Usage is simple.

``` php
<?php

use Vandpibe\Filter\FilterChain;
use Vandpibe\Filter\AutolinkFilter;

$chain = new FilterChain(array(
    new AutolinkFilter,
));

$text = $chain->filter('<p>"http://github.com"</p>', array());

// <p>"<a href="http://github.com">http://github.com</a>"</p>
print $text;
```

### LazyLoading Filters

A `FilterChain` supports a `resolve` method that will take the filter input and try and match it to a real `FilterInterface` implementation.

There is currently only a implementation for Symfony's DependencyInjection component.

``` php
<?php

$chain = new LazyFilterChain(array(
    'some.service.id',
    'some.other.service.id',
));

$chain->setContainer($container);

$text = $chain->filter('mytext', array('context' => true));
```

Dependencies
------------

It requires the `OptionsResolver` component from Symfony to have flexible merging of contexts and validation of required options.

For testing [PHPSpec2](http://phpspec.net) is used.

[![Build Status](https://secure.travis-ci.org/Vandpibe/Filter.png?branch=master)](https://next.travis-ci.org/Vandpibe/Filter)
