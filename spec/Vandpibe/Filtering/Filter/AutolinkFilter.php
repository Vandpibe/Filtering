<?php

namespace spec\Vandpibe\Filtering\Filter;

use PHPSpec2\ObjectBehavior;

class AutolinkFilter extends ObjectBehavior
{
    function it_dosent_convert_link_text_when_auto_link_is_disabled()
    {
        $text = '<p>"http://www.github.com"</p>';
        $this->filter($text, array('auto_link' => false))->shouldReturn($text);
    }

    function it_converts_to_links()
    {
        $this->filter('<p>"http://www.github.com"</p>', array('auto_link' => true))
            ->shouldReturn('<p>"<a href="http://www.github.com">http://www.github.com</a>"</p>');
    }

    /**
     * @param Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    function it_is_configured_to_always_auto_link($resolver)
    {
        $resolver->setDefaults(array(
            'auto_link' => true,
        ))->shouldBeCalled();

        $this->configure($resolver);
    }
}
