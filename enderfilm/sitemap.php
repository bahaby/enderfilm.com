<?php require_once 'core/init.php'; 
$url=$_SERVER["HTTP_HOST"];
$film=new Film();
$veriler=$film->getirFilm('where (durum = 1 or durum = 2) order by id DESC');
$say=count($veriler);
$tsayfa = ceil($say / 20);
header('Content-type: text/xml'); 
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns:xhtml="http://www.w3.org/1999/xhtml"
      xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';
echo '
<url>
  <loc>http://'.$url.'/</loc>
  <changefreq>always</changefreq>
  <priority>1.0000</priority>
</url>
';
for ($i=2; $i <= $tsayfa ; $i++) { 
  echo '
  <url>
    <loc>http://'.$url.'/'.$i.'</loc>
    <changefreq>always</changefreq>
    <priority>0.7000</priority>
  </url>
  ';
}
foreach ($veriler as $veri) {
	echo '
	<url>
	  <loc>http://'.$url.'/izle/'.$veri["seo_adi"].'.html</loc>
	  <changefreq>always</changefreq>
  	<priority>0.7000</priority>
	</url>
	';
}
echo '
<url>
  <loc>http://'.$url.'/istek.php</loc>
  <changefreq>always</changefreq>
  <priority>0.5000</priority>
</url>
<url>
  <loc>http://'.$url.'/oneri.php</loc>
  <changefreq>always</changefreq>
  <priority>0.5000</priority>
</url>
<url>
  <loc>http://'.$url.'/iletisim.php</loc>
  <changefreq>always</changefreq>
  <priority>0.5000</priority>
</url>
<url>
  <loc>http://'.$url.'/sitemap.xml</loc>
  <changefreq>always</changefreq>
  <priority>0.5000</priority>
</url>
';
echo '</urlset>';
?>