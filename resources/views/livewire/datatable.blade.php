

<div class="container">
    <div class="row mb-4 inline">
        {{-- <div class="col ">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-select" >
                <option>2</option>
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div> --}}

        <div class="col offset-8">
            {{__('translation.search')}}:
            <input wire:model.debounce.300ms="search" class="form-control" type="text" placeholder="Search Blogs...">
        </div>

    </div>
    <button wire:click="createBlog" type="button" class="btn btn-primary mb-2"> {{__('translation.create_blog')}} </button>


    <table class="table">
        <thead>
            <tr>
                <th wire:click="sortBy('title')" style="cursor: pointer;">

                    {{__('translation.blog_title')}}

                    @include('partials._sort-icon',['field'=>'title'])


                </th>
                <th wire:click="sortBy('content')"  style="cursor: pointer;">

                    {{__('translation.content')}}
                    @include('partials._sort-icon',['field'=>'content'])
                </th>
                <th wire:click="sortBy('date')" style="cursor: pointer;">

                    {{__('translation.date')}}

                    @include('partials._sort-icon',['field'=>'date'])
                </th>
                <th wire:click="sortBy('writer_name')" style="cursor: pointer;">

                    {{__('translation.writer_name')}}

                    @include('partials._sort-icon',['field'=>'writer_name'])

                </th>
                <th wire:click="sortBy('status')"  style="cursor: pointer;">

                    {{__('translation.status')}}

                    @include('partials._sort-icon',['field'=>'status'])
                </th>
                <th wire:click="sortBy('topic')" style="cursor: pointer;">

                    {{__('translation.topic')}}

                    @include('partials._sort-icon',['field'=>'topic'])
                </th>
                <th wire:click="sortBy('created_at')" style="cursor: pointer;">

                    {{__('translation.created_at')}}

                    @include('partials._sort-icon',['field'=>'created_at'])


                </th>
                <th wire:click="sortBy('updated_at')"  style="cursor: pointer;">

                    {{__('translation.updated_at')}}

                    @include('partials._sort-icon',['field'=>'updated_at'])

                </th>


                <th wire:click="sortBy('title_ar')"  style="cursor: pointer;">

                    {{__('translation.title_ar')}}

                    @include('partials._sort-icon',['field'=>'title_ar'])

                </th>
                <th wire:click="sortBy('content_ar')"  style="cursor: pointer;">

                    {{__('translation.content_ar')}}

                    @include('partials._sort-icon',['field'=>'content_ar'])

                </th>
                <th wire:click="sortBy('topic_ar')"  style="cursor: pointer;">

                    {{__('translation.topic_ar')}}

                    @include('partials._sort-icon',['field'=>'topic_ar'])

                </th>
                <th wire:click="sortBy('writer_ar')"  style="cursor: pointer;">

                    {{__('translation.writer_ar')}}

                    @include('partials._sort-icon',['field'=>'writer_ar'])

                </th>
                <th wire:click="sortBy('base_image')"  style="cursor: pointer;">

                    {{__('translation.base_image')}}

                    @include('partials._sort-icon',['field'=>'base_image'])

                </th>

                <th> {{__('translation.action')}}</th>
            </tr>
        </thead>

        <tbody>


            @foreach ($blogs as $index => $item)

            <tr>
                <td>{{$item->title}}</td>
                <td>{{Str::limit($item->content, 25) }}...</td>
                <td>{{$item->date}}</td>
                <td>{{$item->writer_name}}</td>
                <td>{{$item->status}}</td>
                <td>{{$item->topic}}</td>
                <td>{{$item->created_at}}</td>
                <td>{{$item->updated_at}}</td>

                <td>{{$item->title_ar}}</td>
                <td>{{ Str::limit($item->content_ar, 25) }}...</td>
                <td>{{$item->topic_ar}}</td>
                <td>{{$item->writer_ar}}</td>
                <td>
                    <a href="{{$item->base_image}}" data-lightbox="baseImage">
                        <img    src="{{$item->thumbnailPath}}" alt="base_image not found" width = "55" height = "55">

                    </a>

                </td>
                <td>

                    <div class="btn-group" role="group">
                        <button  type="button" class="btn btn-sm btn-primary me-3" wire:click="editBlog({{$item}})"> <i class="fas fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-sm btn-danger" wire:click="confirmDelete({{$item['id']}},{{$index}})"><i class="far fa-trash-alt"></i> Delete</button>

                    </div>
                </td>

            </tr>

            @endforeach





        </tbody>
    </table>

    <div>

       <p>
            Showing {{$blogs->firstItem()}} to {{$blogs->lastItem()}} out of {{$blogs->total()}} blogs
        </p>
        <div class="flex flex-row mt-2">
            {{ $blogs->links('pagination::bootstrap-4') }}
        </div>
    </div>


    {{-- Delete confirm --}}
    @if(!empty($deleteModal))





    <div  id="deleteDialog"  class="modals" >

        <!-- Modal content --> <span class="close">&times;</span>

        <div class="modal-content " style="width: 500px">
            <div class="position-relative">
                <div class="position-absolute top-0 end-0">

                </div>
              </div>
              <div class="container">

              </div>

          <div class="row">
            <div class="col-7">
                <span>  Are you sure want to delete? {{$deletingBlogId  }}</span>
            </div>

            <div class="col-2">
                <button class="btn btn-success " wire:click="deleteBlog()">  Delete</button>

            </div>
            <div class="col-2">
                <button  class="btn btn-danger" wire:click="closeModal"  id="cancelDialog">Cancel</button>

            </div>
          </div>

        </div>

      </div>
    @endif

    @if($editModal || $createModal)
    {{-- {{$editModal?'is_active':'' --}}
    <div  class="modals " id="myModal" >
    <div class="modal-background"></div>
    <div class="modal-content p-3" style="overflow-y:auto;">


        <form wire:submit.prevent="saveBlog"  enctype="multipart/form-data">
            @csrf

            <div class="mb-3" >
                <label for="title" class="form-label">{{__('translation.blog_title')}}</label>
                <input wire:model.lazy="editingBlog.title" name="title" class="form-control" id="title" aria-describedby="title">
                @error('editingBlog.title')
                <p class="help is-danger">{{$message}}</p>

                @enderror

              </div>
            <div class="mb-3" >
              <label for="content" class="form-label">{{__('translation.content')}}</label>
              <textarea wire:model.lazy="editingBlog.content" name="content" id="content" cols="40" rows="5"></textarea>
              @error('editingBlog.content')
              <p class="help is-danger">{{$message}}</p>
              @enderror

            </div>
            <div class="mb-3" >
                <label for="date" class="form-label">{{__('translation.date')}} </label>
                <input type="date" wire:model.lazy="editingBlog.date"   name="date" class="form-control" id="date" aria-describedby="date">


                @error('editingBlog.date')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <label for="writer_name" class="form-label">{{__('translation.writer_name')}} </label>
                <input wire:model.lazy="editingBlog.writer_name"  name="writer_name" class="form-control" id="writer_name" aria-describedby="writer_name">
                @error('editingBlog.writer_name')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <label for="status" class="form-label">{{__('translation.status')}} </label>
                @if ($editingBlog['status'] == 1)
                <button type="button" class="btn btn-success" disabled>{{__('translation.action')}}</button>
                <button type="button" class="btn btn-danger" wire:click="changeActive({{$editingBlog['status']}})" > Deactive </button>
                @elseif ($editingBlog['status'] == 0)
                <button type="button" class="btn btn-success"  wire:click="changeActive({{$editingBlog['status']}})">Active</button>
                <button  type="button" class="btn btn-danger" disabled>Deactive </button>

                @else

                <button type="button" class="btn btn-success" wire:click="setStatus(1)">Active </button>

                <button type="button" class="btn btn-danger" wire:click="setStatus(0)">Deactive </button>
                @endif

                {{-- <div class="button-group round toggle">
                    <input  type="radio" id="active" name="r-group" >
                    <label  class="button" for="active">active</label>
                    <input  type="radio" id="deactive" name="r-group">
                    <label  class="button" for="deactive">deactive</label>
                </div> --}}




                @error('editingBlog.status')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <label for="topic" class="form-label">{{__('translation.topic')}} </label>
                <input wire:model.lazy="editingBlog.topic"  name="topic" class="form-control" id="topic" aria-describedby="topic">
                @error('editingBlog.topic')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <label for="videoURL" class="form-label">{{__('translation.video')}} </label>
                <input wire:model.lazy="editingBlog.videoURL"  name="videoURL" class="form-control" id="videoURL" aria-describedby="videoURL">
                @error('editingBlog.videoURL')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <label for="fileURL" class="form-label">{{__('translation.file')}}  </label>
                <input wire:model.lazy="editingBlog.fileURL" type="file" accept="application/pdf" name="fileURL" class="form-control" id="fileURL" aria-describedby="fileURL">
                @error('editingBlog.fileURL')
                <p class="help is-danger">{{$message}}</p>
                @enderror

            </div>
            <div class="mb-3" >
                <div class="row">
                    <label for="base_image" class="form-label">{{__('translation.base_image')}} </label>
                </div>

                @if($editingBlog['base_image'])

                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}
                {{-- WTF --}}

                {{-- <a href="{{$item->base_image}}" data-lightbox="baseImage_{{$item->id}}">
                    <img    src="{{$item->base_image}}" alt="base_image not found" width = "150" height = "150">

                </a> --}}

                <a href="{{$editingBlog['base_image']}}" data-lightbox="baseImage_{{$editingBlog['id']}}">
                    <img    src="{{$editingBlog['base_image']}}" alt="base_image not found" width = "150" height = "150">

                </a>
                <div class="d-flex justify-content-end">
                    <button  wire:click.prevent="removeBaseImage()" type="button"  class="btn btn-danger">Remove Base Image</button>

                </div>
                @else
                <input  wire:model="base_image" type="file" id="base_image" name="base_image" accept="image/*" class="form-control">

                @endif

                @error('base_image')
                <p class="help is-danger">{{$message}}</p>
                @enderror




            </div>

            <div class="mb-3" >
                <label for="image" class="form-label"> {{__('translation.images')}}</label>

                @if ($editModal)

                <ul>
                    @foreach ($editingBlog['images_array'] as $index => $imagePath )

                    <li wire:key="{{ $loop->index }}">
                            <div class="row mb-3">
                                   <div class="col-8">
                                       {{-- @if(isset($imagePath->galleryImage)) --}}
                                       <a href="{{ $imagePath }}" data-lightbox="images">
                                         <img src="{{ $imagePath}}" alt="base_image not found" width = "150" height = "150">

                                       </a>
                                       {{-- @endif --}}

                                       </div>



                            </div>


                    </li>
                        @endforeach

     </ul>

                @endif



                <ol>

                @foreach ($images as $image )
                {{--  images here --}}

                    <li wire:key="{{ $loop->index }}">
                        <div class="row mb-3">
                            <div class="col-8">
                                <input  wire:model.lazy="images.{{ $loop->index }}" type="file" id="images.{{ $loop->index }}"  name="images.{{ $loop->index }}" accept="image/*" class="form-control">

                            </div>
                            {{-- <div class="col-4">
                                <button  wire:click.prevent="removeImage({{ $loop->index }})" type="button"  class="btn btn-danger">Remove </button>
                            </div> --}}

                        </div>

                    </li>


                @endforeach

                @error('images.*')
                <p class="help is-danger">{{$message}}</p>
                @enderror

                @if($errors->any())
                <h4>{{$errors->first()}}</h4>
                @endif
            </ol>


            </div>
            <hr>
            <div class="arabic_content">
                <div class="mb-3" >
                    <label for="topic_ar" class="form-label">{{__('translation.topic_ar')}}</label>
                    <input wire:model.lazy="editingBlog.topic_ar" name="topic_ar" class="form-control" id="topic_ar" aria-describedby="topic_ar">
                    @error('editingBlog.topic_ar')
                    <p class="help is-danger">{{$message}}</p>

                    @enderror

                  </div>
                <div class="mb-3" >
                    <label for="title" class="form-label">{{__('translation.title_ar')}}</label>
                    <input wire:model.lazy="editingBlog.title_ar" name="title_ar" class="form-control" id="title_ar" aria-describedby="title_ar">
                    @error('editingBlog.title_ar')
                    <p class="help is-danger">{{$message}}</p>

                    @enderror

                  </div>
                  <div class="mb-3" >
                    <label for="title" class="form-label">{{__('translation.writer_ar')}}</label>
                    <input wire:model.lazy="editingBlog.writer_ar" name="writer_ar" class="form-control" id="writer_ar" aria-describedby="writer_ar">
                    @error('editingBlog.writer_ar')
                    <p class="help is-danger">{{$message}}</p>

                    @enderror

                  </div>

                <div class="mb-3" >
                  <label for="content_ar" class="form-label">{{__('translation.content_ar')}}</label>
                  <textarea wire:model.lazy="editingBlog.content_ar" name="content_ar" id="content_ar" cols="40" rows="5"></textarea>
                  @error('editingBlog.content_ar')
                  <p class="help is-danger">{{$message}}</p>
                  @enderror

                </div>

            </div>

            <div class="row">
                <div class="col-6">
                <button  wire:click.prevent="addImageElement()" type="button"  class="btn btn-success">ADD image</button>
                </div>
                <div class=" col-6">
                    <button  wire:click.prevent="removeImage()" type="button"  class="btn btn-danger">Remove from Last</button>
                </div>
            </div>
            <div class="row mt-5">
            <button  type="submit"  class="btn btn-primary">{{__('translation.save')}}</button>

            <button type="button"   class="btn btn-danger"   id="cancelDialog">{{__('translation.cancel')}}</button>
            </div>

          </form>





        </div>

    </div>


    </div>




    @endif



    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'positionFromTop':	50,
            'imageFadeDuration':600
            });
        document.addEventListener('click', function (event) {

            var modal = document.getElementById("myModal");
            var deleteDialog = document.getElementById("deleteDialog");
            var cancelDialog = document.getElementById("cancelDialog");


            // Get the value of the "count" property
            if (event.target == modal || event.target ==  deleteDialog || event.target == cancelDialog) {
                @this.closeModal();
    }



        });







    </script>


</div>






