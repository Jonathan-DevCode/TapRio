<?php

class Sitemap
{

    public function __construct()
    {
        
    }


    public function indexAction()
    {
        $imoveis = (new Orm('imovel'))
            ->get();
        
        if(isset($imoveis[0])) {
            // Gera o XML do sitemap
            $imoveis_xml = '';
            $baseUri = Http::base();
            foreach ($imoveis as $imovel) {
                $imoveis_xml .= '
                <url>
                    <loc>' . $baseUri . '/imovel/ver/' . $imovel->imovel_id . '</loc>
                    <lastmod>' . date('Y-m-d') . 'T' . date('H:i:s-2:00') . '</lastmod>
                    <changefreq>daily</changefreq>
                    <priority>0.95</priority>
                </url>';
            }
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
                        <urlset
                            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
                            <url>
                                <loc>' . $baseUri . '</loc>
                                <lastmod>' . date('Y-m-d') . 'T' . date('H:i:s-2:00') . '</lastmod>
                                <changefreq>daily</changefreq>
                                <priority>1.00</priority>
                            </url>
                            '. $imoveis_xml .'
                        </urlset>
                ';
            header("Content-type: text/xml");
            echo $xml;
        }     
    }
}
