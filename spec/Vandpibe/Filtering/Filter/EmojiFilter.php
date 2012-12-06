<?php

namespace spec\Vandpibe\Filtering\Filter;

use PHPSpec2\ObjectBehavior;

class EmojiFilter extends ObjectBehavior
{
    function it_converts_text_to_images()
    {
        $this->filter(':-1:', array('asset_root' => '', 'size' => 20))
            ->shouldReturn('<img class="emoji" title=":-1:" alt=":-1:" src="-1.png" height="20" width="20" align="absmiddle" />');
    }

    function it_uses_the_context_when_replacing_with_img_tags()
    {
        $this->filter(':ship:', array('asset_root' => 'http://github.com', 'size' => 10))
            ->shouldReturn('<img class="emoji" title=":ship:" alt=":ship:" src="http://github.com/ship.png" height="10" width="10" align="absmiddle" />');
    }

    /**
     * @param Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    function it_have_a_default_asset_path($resolver)
    {
        $resolver->setDefaults(array(
            'asset_root' => '/',
            'size' => 20,
        ))->shouldBeCalled();

        $this->configure($resolver);
    }
}
