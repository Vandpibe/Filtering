<?php

namespace Vandpibe\Filter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @package Vandpibe
 */
class FilterChain implements FilterInterface
{
    protected $filters = array();
    protected $resolver;

    /**
     * @param FilterInterface[]
     * @param OptionsResolverInterface $resolver
     */
    public function __construct(array $filters, OptionsResolverInterface $resolver = null)
    {
        $this->filters = $filters;
        $this->resolver = $resolver ?: new OptionsResolver();

        $this->configure($this->resolver);
    }

    /**
     * {@inheritDoc}
     */
    public function filter($value, array $context)
    {
        foreach ($this->filters as $filter) {
            $value = $this->call($filter, $value, $context);
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function configure(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @param FilterInterface $filter
     * @param string $value
     * @param array $context
     * @return string
     */
    protected function call(FilterInterface $filter, $value, array $context)
    {
        $resolver = clone $this->resolver;

        $filter->configure($resolver);

        return $filter->filter($value, $resolver->resolve($context));
    }
}
