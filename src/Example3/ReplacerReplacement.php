<?php
namespace Example3;

use Example3\Entity\Tag;

/**
 * ReplacerReplacement
 *
 * @author Fodor Péter
 * @since 2016.12.02. 22:34
 */
class ReplacerReplacement
{
    /**
     * @var TagProvider
     */
    protected $tagProvider;

    /**
     * @var AutoHelperConfiguration
     */
    protected $config;

    /**
     * ReplacerReplacement constructor.
     *
     * @param TagProvider $provider
     * @param AutoHelperConfiguration $config
     */
    public function __construct(TagProvider $provider = null, AutoHelperConfiguration $config = null)
    {
        $this->config = $config;
        $this->tagProvider = $provider;
    }

    /**
     * @param TagProvider $tagProvider
     */
    public function setTagProvider($tagProvider)
    {
        $this->tagProvider = $tagProvider;
    }

    /**
     * @param AutoHelperConfiguration $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $string
     *
     * @return string|null
     */
    public function autoHelp($string)
    {
        if (!$string) {
            return null;
        }

        $string = stripslashes($string);

        if ($this->config->isEnabled() === false) {
            return $string;
        }

        $tags = $this->tagProvider->getTags();

        if (empty($tags)) {
            return $string;
        }

        $ignored = $this->tokenizeHtmlTags($string);

        $string = str_replace(
            $ignored['tags'],
            $ignored['tokens'],
            $string
        );

        $string = $this->autohelpText($string, $tags);

        $string = str_replace(
            $ignored['tokens'],
            $ignored['tags'],
            $string
        );

        return $string;
    }

    /**
     * @param $string
     *
     * @return array
     */
    public function tokenizeHtmlTags($string)
    {
        $ignored = [
            "tags" => [],
            "tokens" => []
        ];
        $countOfIgnored = 0;
        $ignoredMatches = [];

        preg_match_all(
            '/<[^<>]+>/',
            $string,
            $ignoredMatches
        );

        foreach ($ignoredMatches[0] as $ignoredTag) {
            $ignored["tags"][] = $ignoredTag;
            $ignored["tokens"][] = '#i#' . $countOfIgnored . '#';
            $countOfIgnored++;
        }

        return $ignored;
    }

    /**
     * @param Tag $tag
     *
     * @return string
     */
    public function convertTagToPattern(Tag $tag)
    {
        $delimiter = '/';
        $tagSafe = preg_quote($tag->getTag(), $delimiter);
        $tagBoundary = $this->config->isWholeWordReplace()
            ? '\b'
            : '';

        return $delimiter . $tagBoundary . $tagSafe . $tagBoundary . $delimiter . 'iu';
    }

    /**
     * @param $string
     * @param Tag[] $tags
     *
     * @return string
     */
    public function autohelpText($string, $tags)
    {
        $autohelpWords = [];
        $autohelpTokens = [];
        $autohelpSpans = [];
        $countOfReplacements = 0;

        foreach ($tags as $tag) {
            $tagMatches = [];
            $pattern = $this->convertTagToPattern($tag);

            preg_match_all(
                $pattern,
                $string,
                $tagMatches
            );

            if (!count($tagMatches[0])) {
                continue;
            }

            foreach ($tagMatches[0] as $originalWord) {
                $autohelpWords[] = $pattern;
                $autohelpTokens[] = '#t#' . $countOfReplacements . '#';
                $autohelpSpans[] = "<span class=\"autohelp\" title=\"{$tag->getDescription()}\">$originalWord</span>";
                $countOfReplacements++;
            }
        }

        $string = preg_replace(
            $autohelpWords,
            $autohelpTokens,
            $string
        );

        $string = str_replace(
            $autohelpTokens,
            $autohelpSpans,
            $string
        );

        return $string;
    }
}