@extends('components.layout')
@section('content')
    <style>
        .checked {
            color: orange;
        }

    </style>

    <div class="container mt-4">
        <h3 class="mb-4 border-bottom pb-1">{{ __('translation.blog_list') }}</h3>
        <div class="row blog-list">
            @if (count($blogs) > 0)
                @if (Session::get('locale') == 'ar')
                    @foreach ($blogs as $data)
                        <div class="col-sm-3 mb-5 ">
                            <div class="blog-box" style="display: inline-block">
                                <a href="/blogs/{{ $data->id }}">
                                    <img src="{{ $data->base_image }}" class="card-img-top" alt="{{ $data->title_ar }}"
                                        style=" height: 280px; width: 230px;" />


                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"> {{ $data->title_ar }}</h5>
                                            <p class="card-text">{{ str_limit($data->content_ar, 20) }}</p>
                                            <small>{{ $data->writer_ar }}, <span> {{ $data->date }}</span></small>
                                        </div>
                                        <div class="stars">

                                            @for ($k = 1, $j = $data->stars; $k <= 5; $k++, $j--)
                                                @if ($j > 0) <span class="fa fa-star
                                                checked"></span>
                                            @else
                                                <span class="fa fa-star "></span> @endif
                                            @endfor

                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                @else
                    @foreach ($blogs as $data)
                        <div class="col-sm-3 mb-5 ">
                            <div class="blog-box" style="display: inline-block">
                                <a href="/blogs/{{ $data->id }}">
                                    <img src="{{ $data->base_image }}" class="card-img-top" alt="{{ $data->title }}"
                                        style=" height: 280px; width: 230px;" />


                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"> {{ $data->title }}</h5>
                                            <p class="card-text">{{ str_limit($data->content, 20) }}</p>
                                            <small>{{ $data->writer_name }}, <span> {{ $data->date }}</span></small>
                                        </div>
                                        <div class="stars">
                                            @for ($k = 1, $j = $data->stars; $k <= 5; $k++, $j--)
                                                @if ($j > 0) <span class="fa fa-star
                                                checked"></span>
                                            @else
                                                <span class="fa fa-star "></span> @endif
                                            @endfor

                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                @endif


            @endif
        </div>
        @if (count($blogs) > 0)
            <p class="text-center mt-4 mb-5"><button class="load-more btn btn-dark"
                    data-totalResult="{{ App\Models\Blog::count() }}">Load More</button></p>
        @endif
    </div>

    {{-- Ajax Script Start --}}
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    <script type="text/javascript">
        var main_site = "{{ url('/') }}";
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".load-more").on('click', function() {
                var _totalCurrentResult = $(".blog-box").length;
                // Ajax Reuqest
                $.ajax({
                    url: main_site + '/blogs/load-more-data',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        skip: _totalCurrentResult
                    },
                    beforeSend: function() {
                        $(".load-more").html('Loading...');
                    },
                    success: function(response) {
                        var _html = '';



                        $.each(response, function(index, value) {
                            console.log(value.content.substring(0, 20));

                            _html += '<div class="col-sm-3 mb-5 ">';
                            _html +=
                                '<div class="blog-box" style="display: inline-block">'
                            _html += `<a href="/blogs/${value.id}">`;
                            _html +=
                                `<img src="${value.base_image}" class="card-img-top" alt="${value.title}" style=" height: 280px; width: 230px;"/>`;
                            _html += '<div class="card">';
                            _html += '<div class="card-body">'
                            _html += `<h5 class = "card-title" >${value.title}  </h5>`;
                            _html +=
                                `<p class = "card-text" >${value.content.substring(0,20)}... </p>`;
                            _html +=
                                `<small > ${value.writer_name} , <span >${value.date} </span></small >`;
                            _html += '</div>';
                            _html += '</div>';
                            _html += '</a>';
                            _html += '</div>';

                            _html += '</div>';
                        });
                        $(".blog-list").append(_html);
                        // Change Load More When No Further result
                        var _totalCurrentResult = $(".blog-box").length;
                        var _totalResult = parseInt($(".load-more").attr('data-totalResult'));

                        if (_totalCurrentResult == _totalResult) {
                            $(".load-more").remove();
                        } else {
                            $(".load-more").html('Load More');
                        }
                    }
                });
            });
        });
    </script>
    {{-- Ajax Script End --}}
@endsection
