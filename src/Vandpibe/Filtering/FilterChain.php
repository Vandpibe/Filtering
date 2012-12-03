<?php

namespace Vandpibe\Filtering;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vandpibe\Filtering\Exception\UnexpectedTypeException;
use Vandpibe\Filtering\Filter\FilterInterface;

/**
 * @package Vandpibe
 */
class FilterChain implements FilterInterface
{
    protected $filters = array();
    protected $options;

    /**
     * @param FilterInterface[]|string[]
     * @param OptionsResolverInterface $options
     */
    public function __construct(array $filters, OptionsResolverInterface $options = null)
    {
        $this->filters = $filters;
        $this->options = $options ?: new OptionsResolver();

        $this->configure($this->options);
    }

    /**
     * {@inheritDoc}
     */
    public function filter($value, array $context)
    {
        $filters = array_map(array($this, 'resolve'), $this->filters);

        foreach ($filters as $filter) {
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
        // Because each filter's context and default values are independent it is cloned
        // to ensure it is clean for each call.
        $options = clone $this->options;

        $filter->configure($options);

        return $filter->filter($value, $options->resolve($context));
    }

    /**
     * @throws UnexpectedTypeException
     * @return FilterInterface
     */
    protected function resolve($filter)
    {
        if (false == $filter instanceof FilterInterface) {
            throw new UnexpectedTypeException($filer, 'Vandpibe\Filter\FilterInterface');
        }

        return $filter;
    }
}
