<?php

namespace Statamic\SeoPro\Reporting\Rules;

use Statamic\SeoPro\Reporting\Rule;

class UniqueTitleTag extends Rule
{
    use Concerns\FailsWhenPagesDontPass;

    /**
     * Number of pages with this page's title.
     */
    protected $count;

    public function siteDescription()
    {
        return __('seo-pro::messages.rules.unique_title_site');
    }

    public function pageDescription()
    {
        return __('seo-pro::messages.rules.unique_title_page');
    }

    public function siteFailingComment()
    {
        return __('seo-pro::messages.rules.unique_title_site_failing', ['count' => $this->failures]);
    }

    public function pageFailingComment()
    {
        return __('seo-pro::messages.rules.unique_title_page_failing', [
            'count' => $this->count,
            'title' => $this->title(),
        ]);
    }

    public function pagePassingComment()
    {
        return $this->title();
    }

    public function processPage()
    {
        $this->count = $this->page->report()->pages()->filter(function ($page) {
            return $page->get('title') === $this->title();
        })->count();
    }

    public function savePage()
    {
        return $this->count;
    }

    public function loadPage($data)
    {
        $this->count = $data;
    }

    public function pageStatus()
    {
        return $this->count === 1 ? 'pass' : 'fail';
    }

    protected function title()
    {
        return $this->page->get('title');
    }

    public function maxPoints()
    {
        return $this->points() * $this->report->pages()->count();
    }

    public function demerits()
    {
        return $this->points() * $this->failures;
    }

    protected function points()
    {
        return 2;
    }
}
