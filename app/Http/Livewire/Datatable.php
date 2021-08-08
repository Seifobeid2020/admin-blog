<?php

namespace App\Http\Livewire;

use App\Models\Blog;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as Image;
use Livewire\TemporaryUploadedFile;

class Datatable extends Component
{
    use WithPagination,WithFileUploads;

    protected  $blogs;

    public $images =array();
    public $base_image;
    public $base_image_changed=false;
    public $sortBy='date';
    public $sortDirection = 'asc';
    public $perPage= 10;
    public $search ='';


    public $createModal =false;
    public $editModal =false;


    public $deleteModal =false;

    public $editingBlog;
    public $deletingBlog;

    public $deletingBlogId;
    public $deletingBlogIndex;



    public function render()
    {
        // $items =Blog::query()->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);
        $this->fetchBlogs();

        return view('livewire.datatable',[
            'blogs'=>$this->blogs
        ]);
    }

    public function sortBy($field){
        if($this->sortDirection =='asc'){
            $this->sortDirection ='desc';
        }
        else{
            $this->sortDirection ='asc';
        }
        return $this->sortBy =$field;
    }
    public function updatingSearch(){
        $this->resetPage();
    }

    //CRUD
    public function editBlog( $blog){



        $this->editingBlog =$blog;
        $this->base_image=$this->editingBlog['base_image'];
        $images= explode (",", $this->editingBlog['images']);


        $this->editingBlog['images_array'] = $images;


        $this->editModal=!$this->editModal;
        unset( $this->images);

        $this->images =array();
    }

    public function createBlog(){
        $this->editModal=false;
        $this->createModal=true;
        $this->base_image=null;
        $this->editingBlog= array(
            'title'        =>  '',
            'content'         =>  '',
            'date'             =>  '',
            'writer_name'          =>  '',
            'status'              => '',
            'topic'              =>  '',
            'base_image'              =>  '',

            'topic_ar'              =>  '',
            'content_ar'         =>  '',
            'title_ar'        =>  '',
            'writer_ar'        =>  '',


        );
        unset( $this->images);

        $this->images =[''];
    }

    public function saveBlog(){

        if(sizeof($this->images)>1 && $this->images[sizeof($this->images)-1]->getFilename() =='livewire-tmp' )
        {

            return  Redirect::back()->withErrors(['msg', 'The Message']);

        }
        $validated = $this->validate([
            'editingBlog.title'=>'required',
            'editingBlog.content'=>'required',
            'editingBlog.date'=>'required',
            'editingBlog.writer_name'=>'required',
            'editingBlog.status'=>'required',
            'editingBlog.topic'=>'required',

            'editingBlog.topic_ar'=>'required',
            'editingBlog.content_ar'=>'required',
            'editingBlog.title_ar'=>'required',
            'editingBlog.writer_ar'=>'required',



        ]);
        // 'base_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // "images"    => "required|array|min:1",
        // 'images.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // 'base_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        if(!empty($this->editingBlog['id'])){

            $blog =Blog::find($this->editingBlog['id']);


            if($this->base_image_changed){

                $this->deleteImageFromStorage($blog->base_image);

                $validated["editingBlog"]['base_image']= $this->saveImageInStorage($this->base_image);
            }
            // TODO
            // $imagesPath='';
            // foreach($this->images as $image){
            //         if($imagesPath==''){
            //         $imagesPath= $this->saveImageInStorage( $image);
            //     }
            //     else{

            //         $imagesPath= $imagesPath.",".$this->saveImageInStorage( $image);
            //     }



            // }


            $blog->update($validated['editingBlog']);
            $this->base_image_changed =false;
        }else{

            $arrayData = array(
                'title'        =>  $this->editingBlog["title"],
                'content'         =>  $this->editingBlog["content"],
                'date'             =>  $this->editingBlog["date"],
                'writer_name'          =>  $this->editingBlog["writer_name"],
                'status'              =>  $this->editingBlog["status"],
                'topic'              =>  $this->editingBlog["topic"],
                'videoURL'              =>  $this->editingBlog["videoURL"],

                'topic_ar'              =>  $this->editingBlog["topic_ar"],
                'content_ar'         =>  $this->editingBlog["content_ar"],
                'title_ar'        =>  $this->editingBlog["title_ar"],
                'writer_ar'        =>  $this->editingBlog["writer_ar"],

                'user_id'              =>  Auth::id()
            );



            $imagesPath='';
            foreach($this->images as $image){
                    if($imagesPath==''){
                    $imagesPath= $this->saveImageInStorage( $image);
                }
                else{

                    $imagesPath= $imagesPath.",".$this->saveImageInStorage( $image);
                }



            }
            $name =  time().'_'.$this->editingBlog['fileURL']->getClientOriginalName();
            $path = $this->editingBlog['fileURL']->storeAs('files',$name);

            $arrayData['base_image']=$this->saveImageInStorage($this->base_image);
            $arrayData['images']= $imagesPath;
            $arrayData['fileURL']= $path ;






            $newBlog= new Blog($arrayData);
            $newBlog->save();

        }
        $this->fetchBlogs();
        $this->closeModal();
    }
    public function closeModal(){
        $this->editModal=$this->deleteModal=$this->createModal=false;
        $this->deletingBlog=null;


        $this->editingBlog= array(
            'title'        =>  '.',
            'content'         =>  '.',
            'date'             =>  '.',
            'writer_name'          =>  '.',
            'status'              => '.',
            'topic'              =>  '.',

            'topic_ar'              =>  '.',
            'content_ar'         =>  '.',
            'title_ar'        =>  '.',
            'writer_ar'        =>  '.',


        );;
        $validated = $this->validate([
            'editingBlog.title'=>'required',
            'editingBlog.content'=>'required',
            'editingBlog.date'=>'required',
            'editingBlog.writer_name'=>'required',
            'editingBlog.status'=>'required',
            'editingBlog.topic'=>'required',
            'editingBlog.topic_ar'=>'required',
            'editingBlog.content_ar'=>'required',
            'editingBlog.title_ar'=>'required',
            'editingBlog.writer_ar'=>'required',

        ]);

    }
    public function fetchBlogs(){
        if (Auth::user()->role== 'admin') {
            $blogs  =Blog::search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);//->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage) //find(Auth::id());
        }
        else{
            $blogs  =Blog::where('user_id',Auth::id())->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage);//->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage) //find(Auth::id());

        }
        $this->blogs = $blogs ;

    }
    public function confirmDelete($blogId,$arrayIndex){
        $this->deleteModal =true;
        $this->deletingBlogId=$blogId;
        $this->deletingBlogIndex=$arrayIndex;


    }
    public  function deleteBlog()
    {
        if(!empty($this->deletingBlogId)){
            $blogToBeDeleted= Blog::where('user_id',Auth::id())->find($this->deletingBlogId);//->where('user_id',Auth::id())
            Blog::destroy($this->deletingBlogId);
            $this->deleteImageFromStorage($blogToBeDeleted->base_image);


        }
        $this->deletingBlogId=null;
        $this->fetchBlogs();
        $this->closeModal();

    }
    public function addImageElement(){


        if(sizeof($this->images)>0){

            if($this->images[sizeof($this->images)-1]!=null  ){
                if($this->images[sizeof($this->images)-1]->getFilename() !='livewire-tmp' ){
                    array_push( $this->images,new TemporaryUploadedFile('','local'));
                }

            }

        }
        else{
            array_push( $this->images,new TemporaryUploadedFile('','local'));
        }



    }
    public function removeImage(){
        if(sizeof($this->images)>0){
        unset($this->images[sizeof($this->images)-1]);
        $this->images =  array_values( $this->images);
        }

    }
    public function removeBaseImage(){
        $this->editingBlog['base_image']='';
        $this->base_image=null;
        $this->base_image_changed=true;

    }

    private  function saveImageInStorage($image){


        $imageName = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs("images", $imageName);
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);


        //resize base image and add new image with _thumbnail in base path

        $thumbnail_image =  Image::make($image)->fit(55, 55);

        $thumbnail_image->save(public_path('/images//'. substr_replace($imageName, '_thumbnail', strpos($imageName,'.'),0)) );

        return $path;

    }
    private function deleteImageFromStorage($path){
        unlink($path);
        unlink(substr_replace($path, '_thumbnail', strpos($path,'.'),0));
    }
    public function changeActive($status){

        if ( $status ==1) {
            $this->editingBlog['status']=0;
        }
        else
        {
            $this->editingBlog['status']=1;

        }

    }
    public function  setStatus($status){
        if ( $status ==1) {
            $this->editingBlog['status']=1;
        }
        else
        {
            $this->editingBlog['status']=0;

        }
    }
}
