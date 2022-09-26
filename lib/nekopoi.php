<?php
require_once "dom.php";
class Nekopoi
{
    protected $baseURL = 'https://nekopoi.care';
    protected $cld = "";
    protected $opts = array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    );
    public function __construct()
    {
        $this->context =  stream_context_create($this->opts);
    }
    public function latest($page = 1)
    {

        $output = array();
        $page = isset($page) ? intval($page) : 1;
        $res = file_get_html("{$this->baseURL}/page/{$page}/", 0, $this->context);
        $img = $res->find('div.eropost');
        $i = 0;
        foreach ($img as $image) {
            $getImage = $image->find('img', $i)->src;
            preg_match('/300([^.])+/', $getImage, $resimg);

            $images = str_replace("-" . $resimg[0], "", $getImage);
            $imageInfo = $image->find('h2', $i);
            $title =  $this->getBetween($imageInfo->find('a', $i), '">', '<');
            $link = str_replace($this->baseURL, "", $imageInfo->find('a', $i)->href);
            array_push($output, array(
                'title' => $title, 'link' => $link, 'image' => $images
            ));
        }
        $maxPage = ($res->find('nav.pagination', 0)->find('a.next', 0) != null) ? $res->find('nav.pagination', 0)->find('a.next', 0)->prev_sibling()->innertext() : '';
        return array('code' => 200, 'max_page' => $maxPage,  'result' => $output);
    }

    public function Category($page = 1, $category)
    {
        $output = array();
        $page = isset($page) ? $page : 1;
        $res = file_get_html("{$this->baseURL}/category/{$category}/page/{$page}", 0, $this->context);
        $i = 0;
        foreach ($res->find('div.top') as $ingfo) {
            $title =  $ingfo->find('a', $i)->innertext;
            $link =  str_replace($this->baseURL, "", $ingfo->find('a', $i)->href);
            $img = $this->cld . $ingfo->find('img', $i)->src;
            array_push($output, array('title' => $title, 'link' => $link, 'image' => $img));
        }
        $maxPage = ($res->find('nav.pagination', 0)->find('a.next', 0) != null) ? $res->find('nav.pagination', 0)->find('a.next', 0)->prev_sibling()->innertext() : '';
        return array('code' => 200, 'max_page' => $maxPage, 'result' => $output);
    }


    public function getH($url = '')
    {
        $output = array();
        $res = file_get_html("{$this->baseURL}/{$url}", 0, $this->context);
        $img =  $res->find('div.articles > div.contentpost > div.thm > img', 0)->src;
        preg_match_all('/300\s*([^.])+/', $img, $oimg);
        $img = preg_replace("/-" . $oimg[0][0] . "/", "", $img);
        $title = $res->find('div.articles > div.headpost > div.eropost > div.eroinfo > h1', 0)->innertext;
        $sinopsis = $res->find('div.articles > div.contentpost > div.konten > p ', 1)->innertext;
        $genres = $res->find('div.articles > div.contentpost > div.konten > p');
        foreach ($genres as $genre) {
            if (str_contains($genre->find('b', 0), "Genre")) {
                $genrer = $this->getBetween($genre, '</b>', '<');
            } elseif (str_contains($genre->find('strong', 0), "Genre")) {
                $genrer = $this->getBetween($genre, '</strong>', '<');
            }
        }
        $dl = $res->find('div.boxdownload > div.liner ');
        $i = 0;
        // 
        foreach ($dl as $dll) {
            $dlll =  $dll->find('div.listlink > p > a');
            $p = $dll->find('div.name', $i)->innertext;
            $s = array();
            foreach ($dlll as $ddl) {
                $link = $ddl->href;
                $name = $ddl->innertext;
                array_push($s, array($name, $link));
            }
            array_push($output, array($p, $s));
        }
        // Streams
        $streams = [];
        $stream = $res->find('div.openstream');
        foreach ($stream as $s) {
            $link = $s->find('iframe', 0)->src;
            array_push($streams, $link);
        }
        //  Related
        $related = [];
        $relate = $res->find('ul.related', 0)->find('li');
        foreach ($relate as $r) {
            // title
            $rel['title'] = $r->find('div.border > div.limiter > a', 0)->title;
            // Image
            $srcImage = $r->find('div.border', 0)->find('img', 0)->src;
            preg_match_all("/150\s*([^.])+/", $srcImage, $relimg);
            $rel['image'] = preg_replace("/-" . $relimg[0][0] . "/", "", $srcImage);
            // Link
            $rel['link'] = str_replace($this->baseURL . "/hentai", "", $r->find('div.border', 0)->find('a', 0)->href);

            array_push($related, $rel);
        }


        return array(
            'code' => 200,
            "result" => array(
                'title' => $title,
                'image' => $this->cld . $img,
                'sinopsis' => $sinopsis,
                'genre' => trim($genrer),
                'download' => $output,
                'streams' => $streams
            ),
            "relates" => $related
        );
    }

    public function getSeries($url = '')
    {
        if ($url == '') return array("code" => 404);
        $html = file_get_html("{$this->baseURL}/hentai/{$url}", 0, $this->context)->find('div#content', 0);
        // 
        $data['title'] = $html->find('div.imgdesc > span.desc > b', 0)->innertext;
        $img = $html->find('div.imgdesc > img', 0)->src;
        preg_match_all('/-2\s*([^.])+/', $img, $oimg);
        $data['image'] = $this->cld . preg_replace("/" . $oimg[0][0] . "/", "", $img);
        $data['sinopsis'] = $html->find('div.imgdesc > span.desc > p', 0)->innertext;
        $datas = $html->find('div.listinfo > ul > li');
        foreach ($datas as $dataa) {
            if (preg_match("/Genres/i", $dataa->find('b', 0)->innertext)) {
                $data['genre'] = [];
                $genres = $dataa->find('b', 0)->parent()->find('a');
                foreach ($genres as $g) {
                    array_push($data['genre'], $g->innertext);
                }
            }
            if (preg_match("/Episode/i", $dataa->find('b', 0)->innertext)) {
                preg_match_all('/:\s*([^ ])+/', $dataa->find('b', 0)->parent()->innertext, $eps);
                $data['total_episode'] = $eps[1][0];
            }
            if (preg_match("/Produser/i", $dataa->find('b', 0)->innertext)) {
                preg_match_all('/ \s*([^:])+/', $dataa->find('b', 0)->parent()->innertext, $prod);
                $data['produser'] = $prod[0][0];
            }
        }
        $data['episode_list'] = [];
        $episodeList = $html->find('div.episodelist > ul > li');
        foreach ($episodeList as $eps) {
            $e['episode'] = $eps->find('a', 0)->innertext;
            $e['link'] = str_replace($this->baseURL, '', $eps->find('a', 0)->href);
            $e['released'] = $eps->find('span', 1)->innertext;
            array_push($data['episode_list'], $e);
        }



        return array("code" => 200, "result" => $data);
    }

    public function search($page = 1, $query)
    {
        $output = array();
        $page = isset($page) ? $page : 1;
        if (!$query || $page > 30) {
            http_response_code(400);
            return array('code' => 400, 'msg' => 'bad request');
        }
        $res = file_get_html("{$this->baseURL}/page/{$page}/?s={$query}&post_type=anime", 0, $this->context);
        $i = 0;
        foreach ($res->find('div.top') as $ingfo) {
            $title =  $ingfo->find('a', $i)->innertext;
            $link = str_replace($this->baseURL, "", $ingfo->find('a', $i)->href);
            $img = $this->cld . $ingfo->find('img', $i)->src;
            array_push($output, array('title' => $title, 'link' => $link, 'image' => $img));
        }
        return array('code' => 200, 'result' => $output);
    }

    private function getBetween($content, $start, $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
}

// $p = new Nekopoi;
// header('Content-type: application/json');
// echo json_encode($p->latest());
