<?php
/**
 *------------------------------------------------------
 * 分页样式
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016-09-29 13:09:16
 * @version   V1.0
 *
 */

namespace App\Widget\Pagination;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\HtmlString;
use Illuminate\Pagination\UrlWindowPresenterTrait;

class Pages implements PresenterContract
{

    use UrlWindowPresenterTrait;

    protected $paginationWrapper    = '<ul class="pagination">%s %s %s</ul>';
    protected $disabledPageWrapper  = '<li class="disabled"><span>%s</span></li>';
    protected $activePageWrapper    = '<li class="active"><span>%s</span></li>';
    protected $previousButtonText   = '<span>&laquo;</span>';
    protected $nextButtonText       = '<span>&raquo;</span>';
    protected $availablePageWrapper = '<li><a href="%s" rel="next">%s</a></li>';
    protected $dotsText             = '...';

    protected $paginator;
    protected $window;
    protected $pageRule;
    protected $appendArr;

    public function init( PaginatorContract $paginator, UrlWindow $window = null )
    {
        $this->paginator = $paginator;
        $this->window    = is_null( $window ) ? UrlWindow::make( $paginator ) : $window->get();
        return $this;
    }

    public function simpleCreate( PaginatorContract $paginator )
    {
        $this->paginator = $paginator;
        return $this;
    }

    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    public function appends(array $request = [])
    {
        $this->appendArr = $request;
        return $this;
    }

    public function setPage( $pageRule )
    {
        $this->pageRule = rtrim($pageRule, '/');
        return $this;
    }

    public function render()
    {
        if ( $this->hasPages() ) {
            return sprintf(
                $this->getPaginationWrapperHTML(),
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }
        return '';
    }

    protected function getAvailablePageWrapper( $url, $page )
    {
        return sprintf( $this->getAvailablePageWrapperHTML(), $url, $page );
    }

    protected function getDisabledTextWrapper( $text )
    {
        return sprintf( $this->getDisabledPageWrapperHTML(), $text );
    }

    protected function getActivePageWrapper( $text )
    {
        return sprintf( $this->getActivePageWrapperHTML(), $text );
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper( $this->getDotsText() );
    }

    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }

    protected function getPageLinkWrapper( $url, $page )
    {
        if($this->pageRule){
            $url = $this->formatUrl($url, $this->pageRule);
        }
        if ( $page == $this->paginator->currentPage() ) {
            return $this->getActivePageWrapper( $page );
        }
        return $this->getAvailablePageWrapper( $url, $page );
    }

    protected function getPreviousButton()
    {
        if ( $this->paginator->currentPage() <= 1 ) {
            return $this->getDisabledTextWrapper( $this->getPreviousButtonText() );
        }
        $url = $this->paginator->url(
            $this->paginator->currentPage() - 1
        );

        return $this->getPageLinkWrapper( $url, $this->getPreviousButtonText() );
    }

    protected function getNextButton()
    {
        if ( !$this->paginator->hasMorePages() ) {
            return $this->getDisabledTextWrapper( $this->getNextButtonText() );
        }
        $url = $this->paginator->url( $this->paginator->currentPage() + 1 );
        return $this->getPageLinkWrapper( $url, $this->getNextButtonText() );
    }

    protected function getAvailablePageWrapperHTML()
    {
        return $this->availablePageWrapper;
    }

    protected function getActivePageWrapperHTML()
    {
        return $this->activePageWrapper;
    }

    protected function getDisabledPageWrapperHTML()
    {
        return $this->disabledPageWrapper;
    }

    protected function getPreviousButtonText()
    {
        return $this->previousButtonText;
    }

    protected function getNextButtonText()
    {
        return $this->nextButtonText;
    }

    protected function getDotsText()
    {
        return $this->dotsText;
    }

    protected function getPaginationWrapperHTML()
    {
        return $this->paginationWrapper;
    }

    /**
     * @param $url
     * @param string $pageRule
     * @return string
     */
    protected function formatUrl($url, $pageRule)
    {
        $pagePreg = '|' . str_replace(['/', '-', '{page}'], ['\/', '\-', '([0-9]+)'], $pageRule) . '|is';
        $urlArr = parse_url($url);

        $newUrl = isset($urlArr['scheme']) ? ($urlArr['scheme'] . "://") : '';
        $newUrl .= isset($urlArr['host']) ? $urlArr['host'] : '';
        $newUrl .= isset($urlArr['path']) ? $urlArr['path'] : '';

        $arrQuery = $this->convertUrlQuery($urlArr['query']);

        if($this->appendArr){
            $arrQuery = array_merge($this->appendArr, $arrQuery);
        }

        if(isset($arrQuery['page'])) {
            $pageRule = str_replace('{page}', $arrQuery['page'], $pageRule);
            unset($arrQuery['page']);
        }

        if(isset($urlArr['path'])){
            $newUrl = preg_replace($pagePreg, '', $newUrl) . $pageRule . (empty($arrQuery) ? '' : ('?' . http_build_query($arrQuery)));
        }else{
            $newUrl = rtrim($newUrl, '/') . $pageRule . (empty($arrQuery) ? '' : ('?' . http_build_query($arrQuery)));
        }
        return $newUrl;
    }

    /**
     * Render the actual link slider.
     *
     * @return string
     */
    protected function getLinks()
    {
        $html = '';

        if (is_array($this->window['first'])) {
            $html .= $this->getUrlLinks($this->window['first']);
        }

        if (is_array($this->window['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($this->window['slider']);
        }

        if (is_array($this->window['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($this->window['last']);
        }

        return $html;
    }

    /**
     * Get the links for the URLs in the given array.
     *
     * @param  array  $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';
        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    /**
     * Returns the url query as associative array
     *
     * @param    string    query
     * @return    array    params
     */
    protected function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

}