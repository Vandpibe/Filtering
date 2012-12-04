<?php

namespace Vandpibe\Filtering;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Vandpibe\Filtering\Exception\UnexpectedTypeException;

/**
 * @package Vandpibe
 */
class LazyFilterChain extends FilterChain implements ContainerAwareInterface
{
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param  mixed           $filter
     * @return FilterInterface
     */
    protected function resolve($filter)
    {
        if (null == $this->container) {
            throw new UnexpectedTypeException($filter, 'Vandpibe\Filtering\Filter\FilterInterface');
        }

        try {
            return $this->container->get($filter);
        } catch (ServiceNotFoundException $e) {
            throw new UnexpectedTypeException($filter, 'Vandpibe\Filtering\Filter\FilterInterface');
        }
    }
}
