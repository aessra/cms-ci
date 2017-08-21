<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_model extends CI_Model
{
	public $OUTPUT_FILE = 'sitemap.xml';
	public $CLI = true;
	public $skip = array();
	public $FREQUENCY = 'daily';
	public $PRIORITY = '0.5';

	public function createSitemap()
	{
		$result = array();

		// Program start
	    $VERSION = "2.1";
	    $AGENT = "Mozilla/5.0 (compatible; Plop PHP XML Sitemap Generator/" . $VERSION . ")";
	    $NL = $this->CLI ? "\n" : "<br>";

	    $pf = fopen ($this->OUTPUT_FILE, "w");
	    if (!$pf)
	    {
	        $result['status'] = 'ERR';
	        $result['message']  = "Cannot create " . $this->OUTPUT_FILE . "!" . $NL;
	    }

	    fwrite($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
	                 "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
	                 "        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
	                 "        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
	                 "        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n" .
	                 "  <url>\n" .
	                 "    <loc>" . base_url() . "/</loc>\n" .
	                 "    <changefreq>" . $this->FREQUENCY . "</changefreq>\n" .
	                 "  </url>\n");

	    $scanned = array();
	    $this->ScanPage();

	    $pf = fopen ($this->OUTPUT_FILE, "a+");
	    if (!$pf)
	    {
	        $this->result['status'] = 'ERR';
	        $this->result['message']  = "Cannot create " . $this->OUTPUT_FILE . "!" . $NL;
	    }
	    
	    fwrite($pf, "</urlset>");
	    fclose ($pf);

	    $result['status'] = 'OK';
	    $result['message'] = '';
	    
	    return $result;
	}

	function ScanPage ()
	{
		$result = array();

		$sql = 'SELECT
					`page_url`, `front_end`
				FROM
					`lumi_pages`
				WHERE
					`front_end` = \'1\'';

		$query = $this->db->query($sql);
		$result = $query->result_array();

	    $NL = $this->CLI ? "\n" : "<br>";

		$pf = fopen ($this->OUTPUT_FILE, "a+");
		
		if (!$pf)
		{
			$result['status'] = 'ERR';
			$result['message']  = "Cannot create " . $this->OUTPUT_FILE . "!" . $NL;
		}else
		{

			foreach ($result as $row) {
				fwrite($pf, "  <url>\n".
	                        "    <loc>". base_url().$row['page_url']."</loc>\n" .
	                        "    <changefreq>" . $this->FREQUENCY . "</changefreq>\n" .
	                        "    <priority>" . $this->PRIORITY . "</priority>\n" .
	                        "  </url>\n");
			}
	    	$this->ScanContent();    
		}
	}

	function ScanContent ()
	{
		$result = array();

		$sql = 'SELECT
					`seo_url`, `status`
				FROM
					`lumi_contents`
				WHERE
					`status` = \'1\'';

		$query = $this->db->query($sql);
		$result = $query->result_array();
		
	    $NL = $this->CLI ? "\n" : "<br>";

		$pf = fopen ($this->OUTPUT_FILE, "a+");
		
		if (!$pf)
		{
			$result['status'] = 'ERR';
			$result['message']  = "Cannot create " . $this->OUTPUT_FILE . "!" . $NL;
		}else
		{

			foreach ($result as $row) {
				fwrite($pf, "  <url>\n".
	                        "    <loc>". base_url().$row['seo_url']."</loc>\n" .
	                        "    <changefreq>" . $this->FREQUENCY . "</changefreq>\n" .
	                        "    <priority>" . $this->PRIORITY . "</priority>\n" .
	                        "  </url>\n");
			}
			$this->ScanChart();
		}
	}

	function ScanChart ()
	{
		$result = array();

		$sql = 'SELECT
					`seo_url`, `status`
				FROM
					`lumi_charts`
				WHERE
					`status` = \'1\'';

		$query = $this->db->query($sql);
		$result = $query->result_array();
		
	    $NL = $this->CLI ? "\n" : "<br>";

		$pf = fopen ($this->OUTPUT_FILE, "a+");
		
		if (!$pf)
		{
			$result['status'] = 'ERR';
			$result['message']  = "Cannot create " . $this->OUTPUT_FILE . "!" . $NL;
		}else
		{

			foreach ($result as $row) {
				fwrite($pf, "  <url>\n".
	                        "    <loc>". base_url().$row['seo_url']."</loc>\n" .
	                        "    <changefreq>" . $this->FREQUENCY . "</changefreq>\n" .
	                        "    <priority>" . $this->PRIORITY . "</priority>\n" .
	                        "  </url>\n");
			}
		}
	}
}