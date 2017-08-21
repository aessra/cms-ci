<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$string = strtolower($_GET['search']);

$arr = array();
foreach ($search as $row)
{
    array_push($arr, strtolower($row['content_title']));
}

function filter($var)
{
    global $string;
    if (!empty($string))
    {
        return strstr($var, $string);
    }
}

$filterArray = array_filter($arr, "filter");

$result = "";
foreach ($filterArray as $key => $value)
{
    $seo_url = strtolower($value);
    $seo_url = str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
    $seo_url = preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

    $title = str_replace($string, "<strong>".$string."</strong>", $value);
    $row = "<li id='liSearch'><a href='".base_url()."$seo_url' style='color: rgba(255, 255, 255, 1);'>".$title."</a></li>";
    $result .= $row;
}
?>
<style>
    
#liSearch{
    list-style: none;
}
#liSearch a {
    cursor: pointer;
    padding: 4px;
}
#liSearch a:hover {
    color: yellow !important;
    opacity: 1;
    text-decoration: none;
}
#liSearch a strong{
    color: #d0075e;
}
</style>
<?php
if($result == "")
{
    echo "No result";
}else
{
    echo $result;
}