<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Media URL: https://eshcole.com/wp-json/wp/v2/media/{id}
// Posts URL: https://eshcole.com/wp-json/wp/v2/posts
// Categories: https://eshcole.com/wp-json/wp/v2/categories
$url="https://eshcole.com/wp-json/wp/v2/posts/?per_page=5&page=1";

$unparsed_json = file_get_contents($url);

$json_object = json_decode($unparsed_json);

// https://eshcole.com/wp-json/wp/v2/media/
// var_dump($json_object->guid->rendered);
// Will dump a beauty json :3
foreach($json_object as $post){
    $post_title=$post->title->rendered;
    $post_date=$post->date;
    $post_content=$post->content->rendered;
    $post_featured_id=$post->featured_media;
    $media_url=json_decode(file_get_contents("https://eshcole.com/wp-json/wp/v2/media/".$post_featured_id));
  
    $post_featured_image=$media_url->guid->rendered;
    $filename=getImageName($post_featured_image);
    //downloadFile($post_featured_image,"images/$filename");
    var_dump(html_entity_decode($post_title));
    var_dump($post_date);
    var_dump(html_entity_decode($post_content));
    var_dump($post_featured_id."</br>");
    var_dump($post_featured_image."</br>");
    var_dump(getImageName($post_featured_image)."</br>");
    var_dump(getCategories($post->categories[0])->name);
    echo "<br/> Next post <br/>";
}

function getImageName($imageUrl)
{
    $imageExplode=explode("/",$imageUrl);
    $imageFilename=end($imageExplode);
    // Get just filename no ext
    $filename = explode(".",$imageFilename);
    // Get just extension
    $extension = end($filename);

    // Filename to store
    $fileNameToStore = $filename[0].'_'.time().'.'.$extension;
    return $fileNameToStore;
}

function downloadFile($url, $path)
{
    $newfname = $path;
    $file = fopen ($url, 'rb');
    if ($file) {
        $newf = fopen ($newfname, 'wb');
        if ($newf) {
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
}

function getCategories($id)
{
    $cat_url=json_decode(file_get_contents("https://eshcole.com/wp-json/wp/v2/categories/".$id));
    
    return $cat_url;

}