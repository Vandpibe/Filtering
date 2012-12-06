<?php

namespace Vandpibe\Filtering\Filter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vandpibe\Emoji\Emoji;

/**
 * @package Vandpibe
 */
class EmojiFilter implements FilterInterface
{
    protected $emoji;

    /**
     * @param Emoji $emoji
     */
    public function __construct(Emoji $emoji = null)
    {
        $this->emoji = $emoji ?: new Emoji;
    }

    /**
     * {@inheritDoc}
     */
    public function filter($text, array $context)
    {
        // Build a pattern like /:(\+1|ship|light):/
        $pattern     = sprintf('/:(%s):/', implode('|', array_map('preg_quote', $this->emoji->all())));
        $replacement = sprintf('<img class="emoji" title=":\\1:" alt=":\\1:" src="%s\\1.png" height="%d" width="%d" align="absmiddle" />',
            $context['asset_root'] ? $context['asset_root'] . '/' : '',
            $context['size'],
            $context['size']
        );

        return preg_replace($pattern, $replacement, $text);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'asset_root' => '/',
            'size' => 20,
        ));

        $resolver->setNormalizer('asset_root', function (Options $option, $path) {
            return rtrim($path, '/');
        });
    }
}
