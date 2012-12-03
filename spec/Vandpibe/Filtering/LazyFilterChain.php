<?php

namespace spec\Vandpibe\Filtering;

use PHPSpec2\ObjectBehavior;
use Vandpibe\Filtering\Exception\UnexpectedTypeException;

class LazyFilterChain extends ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    function let($container)
    {
        $this->beConstructedWith(array(
            'filter1',
            'filter2',
        ));

        $this->setContainer($container);
    }

    /**
     * @param Vandpibe\Filtering\Filter\FilterInterface $filter1
     * @param Vandpibe\Filtering\Filter\FilterInterface $filter2
     */
    function it_calls_the_container_when_resolving_filters($filter1, $filter2, $container)
    {
        $filter1->filter('', array())->shouldBeCalled();
        $filter2->filter('', array())->shouldBeCalled();

        $container->get('filter1')->willReturn($filter1)->shouldBeCalled();
        $container->get('filter2')->willReturn($filter2)->shouldBeCalled();

        $this->filter('', array());
    }

    function it_converts_missing_services_exception_to_type_exception($container)
    {
        $container->get('filter1')
            ->willThrow('Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException')
            ->shouldBeCalled();

        $this->shouldThrow('Vandpibe\Filtering\Exception\UnexpectedTypeException')
            ->duringFilter('', array());
    }

    function it_throws_exception_when_container_is_not_set()
    {
        $this->setContainer(null);

        $this->shouldThrow('Vandpibe\Filtering\Exception\UnexpectedTypeException')
            ->duringFilter('', array());
    }
}
