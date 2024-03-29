<?php

declare(strict_types=1);

namespace hulang\thinkPaginatorDriver;

use think\Paginator;

/**
 * AmazeUI 分页驱动
 * @package hulang\thinkPaginatorDriver
 */
class AmazeUI extends Paginator
{
    /**
     * 上一页按钮
     * @param string $text 按钮文字
     * @return mixed|string
     */
    protected function getPreviousButton(string $text = "&laquo;"): string
    {
        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() - 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 下一页按钮
     * @param string $text 按钮文字
     * @return mixed|string
     */
    protected function getNextButton(string $text = '&raquo;'): string
    {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 页码按钮
     * @return mixed|string
     */
    protected function getLinks(): string
    {
        if ($this->simple) {
            return '';
        }

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null,
        ];

        $side   = 3;
        $window = $side * 2;

        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } elseif ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last']  = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        } elseif ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last']  = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first']  = $this->getUrlRange(1, 2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last']   = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        }

        $html = '';

        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }

        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }

        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }

        return $html;
    }

    /**
     * 渲染分页html
     * @return mixed|string
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<ul class="am-pagination">%s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                return sprintf(
                    '<ul class="am-pagination">%s %s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getLinks(),
                    $this->getNextButton()
                );
            }
        }
    }

    /**
     * 生成一个可点击的按钮
     * @param  string $url 按钮链接地址
     * @param  string $text 按钮文字
     * @return mixed|string
     */
    protected function getAvailablePageWrapper(string $url, string $text): string
    {
        return '<li><a href="' . htmlentities($url) . '">' . $text . '</a></li>';
    }

    /**
     * 生成一个禁用的按钮
     * @param  string $text 按钮文字
     * @return mixed|string
     */
    protected function getDisabledTextWrapper(string $text): string
    {
        return '<li class="am-disabled"><a aria-disabled="true">' . $text . '</a></li>';
    }

    /**
     * 生成一个激活的按钮
     * @param  string $text 按钮文字
     * @return mixed|string
     */
    protected function getActivePageWrapper(string $text): string
    {
        return '<li class="am-active" aria-current="page"><a>' . $text . '</a></li>';
    }

    /**
     * 生成省略号按钮
     * @return mixed|string
     */
    protected function getDots(): string
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮
     * @param  array $urls 按钮链接地址
     * @return mixed|string
     */
    protected function getUrlLinks(array $urls): string
    {
        $html = '';

        foreach ($urls as $text => $url) {
            $html .= $this->getPageLinkWrapper($url, $text);
        }

        return $html;
    }

    /**
     * 生成普通页码按钮
     * @param  string $url 按钮链接地址
     * @param  string $text 按钮文字
     * @return mixed|string
     */
    protected function getPageLinkWrapper(string $url, string $text): string
    {
        if ($this->currentPage() == $text) {
            return $this->getActivePageWrapper($text);
        }

        return $this->getAvailablePageWrapper($url, $text);
    }
}
