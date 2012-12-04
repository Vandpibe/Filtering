<?php

namespace Vandpibe\Filtering\Filter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @package Vandpibe
 */
interface FilterInterface
{
    /**
     * @param string
     * @param  array  $context
     * @return string
     */
    public function filter($value, array $context);

    /**
     * Easy validation of the options needed in the context. This can also
     * set default options that will be merged with the ones given in the context.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configure(OptionsResolverInterface $resolver);
}
