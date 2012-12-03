<?php

namespace spec\Vandpibe\Filtering\Filter;

use PHPSpec2\ObjectBehavior;

class EmojiFilter extends ObjectBehavior
{
    function it_converts_text_to_images()
    {
        $this->filter(':-1:', array('asset_root' => ''))
            ->shouldReturn('<img class="emoji" title=":-1:" alt=":-1:" src="/-1.png" height="20" width="20" align="absmiddle" />');
    }

    /**
     * @param Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    function it_have_a_default_asset_path($resolver)
    {
        $resolver->setDefaults(array(
            'asset_root' => '/',
        ))->shouldBeCalled();

        $this->configure($resolver);
    }
}
