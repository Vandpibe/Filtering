<?php

namespace Vandpibe\Filtering\Filter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @package Vandpibe
 */
class AutolinkFilter implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function filter($value, array $context)
    {
        if (false == $context['auto_link']) {
            return $value;
        }

        $searches = array(
            '/(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/',
            '/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\\+.~#?&\/\/=]+)/',
            '/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/',
        );

        $replaces = array(
            '<a href="\\1">\\1</a>',
            '\\1<a href="http://\\2">\\2</a>',
            '<a href="mailto:\\1">\\1</a>',
        );

        return preg_replace($searches, $replaces, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'auto_link' => true,
        ));
    }
}
