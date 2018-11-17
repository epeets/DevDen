<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Category;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;


class WPImportController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view ('auth.tools.import.wp');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'api' => 'required'
        ]);

        $api=$request->input('api');
        $posts="/wp-json/wp/v2/posts/";
        $media="/wp-json/wp/v2/media/";
        $category="/wp-json/wp/v2/categories/";
        $per_page=10;
        $pages=2;
        $i=1;


        while($i <= $pages){

            $url=$api.$posts."?per_page=".$per_page."&page=".$i;
            Log::debug($url);

            $unparsed_json = file_get_contents($url);
        
            $json_object = json_decode($unparsed_json);

            if($json_object){

                foreach($json_object as $wp_post){
                    $wp_post_title=$wp_post->title->rendered;
                    $wp_post_date=$wp_post->date;
                    $wp_post_content=$wp_post->content->rendered;
                    $wp_post_category_id=$wp_post->categories[0];
        
                    // Handle File Upload
                    if($wp_post->featured_media){
        
                        $wp_post_featured_id=$wp_post->featured_media;
                        $media_url=json_decode(file_get_contents($api.$media.$wp_post_featured_id));
                        $wp_post_featured_image=$media_url->guid->rendered;
                        $filename=$this->getImageName($wp_post_featured_image);
        
                        // Upload Image
                        $path = $this->downloadFile($wp_post_featured_image,"storage/images/wp/$filename");
        
                    } else {
                        $wp_post_featured_image = 'noimage.jpg';
                    }

                    // Create Category
                    $cat_url=$api.$category.$wp_post_category_id;
                    Log::debug($cat_url);
                    $cat_name= $this->getCategories($cat_url)->name;
                    Log::debug($cat_name);
                    $ifCatExists=DB::table('categories')->where('title', $cat_name)->exists();
                    $catId=DB::table('categories')->select('id')->where('title', $cat_name)->first();
                   
                    if(!$ifCatExists){
                        $new_cat = new Category;
                        $new_cat->title = $this->getCategories($cat_url)->name;
                        $new_cat->save();
                    }

        
                    // Create Post
                    $wp_post = new Post;
                    $wp_post->title =html_entity_decode($wp_post_title);
                    $wp_post->created_at=Carbon::parse($wp_post_date);
                    $wp_post->body =html_entity_decode(htmlentities($wp_post_content));
                    $wp_post->user_id = auth()->user()->id;
                    $wp_post->featured_image = $filename;
                    $wp_post->categories = $catId->id;
                    $wp_post->save();

                }

            }

            $i++;
        }

        return redirect('/auth/tools/import/wp')->with('success', 'Posts Imported');
    }

    protected function getImageName($imageUrl)
    {
        $imageExplode=explode("/",$imageUrl);
        $imageFilenameWithExt=end($imageExplode);
        // Get just filename no ext
        $filename = explode(".",$imageFilenameWithExt);
        // Get just extension
        $extension = end($filename);
        // Filename to store
        $fileNameToStore = $filename[0].'_'.time().'.'.$extension;
        return $fileNameToStore;
    }
    
    protected function downloadFile($url, $path)
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

    protected function getCategories($url)
    {
        $get_category=json_decode(file_get_contents($url));
        
        return $get_category;
    
    }
}