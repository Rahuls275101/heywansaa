<?php


$t = "\t";
$n = "\n";
$root = $_SERVER['DOCUMENT_ROOT'];
$date = gmdate("Y-m-d\TH:i:s\Z");
$locationName = $this->uri->segment(3);

if ($locationName) {

  //for subdomain
  $location = $this->db->query("SELECT * FROM wps_meta_tags WHERE is_fixed = 'L' AND page_url = '" . $locationName . "'")->result_array();
  if (is_array($location) && !empty($location)) {
    $cnt = 1;
    foreach ($location as $res) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "$n";
      $xml .= '<urlset
      xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xhtml="https://www.w3.org/1999/xhtml"
      xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
      xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">' . "$n";
      $xml .= '<url>
      <loc>https://' . $_SERVER['HTTP_HOST'] . '/' . $res['page_url'] . '</loc>
      <lastmod>' . $date . '</lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
      </url>
    ' . $n;
      $result = $this->db->query("SELECT * FROM wps_meta_tags WHERE is_fixed NOT IN ('L') AND entity_id > '0' AND page_url != 'home' AND page_url != 'products' AND page_url != 'sitemap' AND page_url != 'new-delhi' AND entity_type != 'products/detail'")->result_array();
      foreach ($result as $row) {
        $xml .= '<url>
        <loc>https://' . $_SERVER['HTTP_HOST'] . '/' . $res['page_url'] . '/' . $row['page_url'] . '</loc>
        <lastmod>' . $date . '</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        </url>
      ' . $n;
      }
      $xml .= '</urlset>';
    }
    echo $xml;
    
  } else {
    redirect(site_url(), 'refresh');
    exit;
  }
} else { //Main Site XML Creation
  $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "$n";
  $xml .= '<urlset
      xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xhtml="https://www.w3.org/1999/xhtml"
      xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
      xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">' . "$n";
  $xml .= '<url>
      <loc>https://' . $_SERVER['HTTP_HOST'] . '/</loc>
      <lastmod>' . $date . '</lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
      </url>
    ' . $n;
  $res = $this->db->query("SELECT * FROM wps_meta_tags WHERE is_fixed  NOT IN ('L') AND page_url != 'home' AND page_url != 'products' AND page_url != 'sitemap' AND page_url != 'new-delhi' AND entity_type != 'products/detail'")->result_array();
  //Main Site XML links
  foreach ($res as $row) {
    $xml .= '<url>
        <loc>https://' . $_SERVER['HTTP_HOST'] . '/' . $row['page_url'] . '</loc>
        <lastmod>' . $date . '</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        </url>
      ' . $n;
  }
  //add additional sitemaps
  $location = $this->db->query("SELECT * FROM wps_meta_tags WHERE is_fixed = 'L' GROUP BY page_url")->result_array();
  $counter = 1;
  foreach ($location as $locres) {
    $xml .= '<url>
      <loc>https://' . $_SERVER['HTTP_HOST'] . '/seo/sitemap/' . $locres['page_url'] . '</loc>
      <lastmod>' . $date . '</lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
      </url>' . $n;
    $counter++;
  }
  $xml .= '</urlset>';
  echo $xml;
}
?>