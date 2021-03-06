@extends('statamic::layout')
@section('title', 'Meta tags')

@section('content')
  <div class="card p-0 content">
    <div class="py-3 px-4 border-b">
      <h1>Meta tags</h1>
      <p>Manage and customize all meta tags.</p>
    </div>
    <div class="flex flex-wrap p-2">
      <div class="w-full lg:w-1/2 p-2 hover:bg-grey-20 flex items-start rounded-md group">
        <a href="{{ cp_route('metatags.settings') }}" class="mr-2 text-grey-80">
          <svg width="33" height="33" xmlns="http://www.w3.org/2000/svg"><g fill="#000" fill-rule="nonzero"><path d="M16.5 11.394a5.106 5.106 0 100 10.212 5.106 5.106 0 000-10.212zm0 2.042a3.064 3.064 0 110 6.128 3.064 3.064 0 010-6.128z"/><path d="M16.5.5a3.745 3.745 0 00-3.745 3.745v.231l-.004.103c-.034.375-.24.714-.556.918l-.049.028-.05.008-.103.027-.1.038a1.226 1.226 0 01-1.351-.245l-.074-.074a3.744 3.744 0 00-5.298 0 3.744 3.744 0 000 5.298l.082.082c.342.35.44.885.237 1.344-.198.532-.643.85-1.146.862h-.098a3.745 3.745 0 100 7.489h.231c.485.002.925.293 1.118.742a1.23 1.23 0 01-.241 1.362l-.074.074a3.744 3.744 0 000 5.298 3.744 3.744 0 005.298 0l.082-.082c.35-.342.885-.44 1.344-.237.532.198.85.643.862 1.146v.098a3.745 3.745 0 107.489 0v-.231c.002-.485.293-.925.742-1.118a1.23 1.23 0 011.362.241l.074.074a3.744 3.744 0 005.298 0 3.744 3.744 0 000-5.298l-.082-.082a1.222 1.222 0 01-.237-1.344 1.23 1.23 0 011.126-.752h.118a3.745 3.745 0 000-7.49h-.231l-.103-.004a1.224 1.224 0 01-.918-.556l-.028-.049-.008-.05-.027-.103-.038-.1a1.226 1.226 0 01.245-1.351l.074-.074a3.744 3.744 0 000-5.298 3.744 3.744 0 00-5.298 0l-.082.082c-.35.342-.885.44-1.344.237a1.23 1.23 0 01-.752-1.126v-.118A3.745 3.745 0 0016.5.5zm0 2.043c.94 0 1.702.762 1.702 1.702v.122a3.27 3.27 0 001.98 2.995 3.264 3.264 0 003.596-.658l.09-.09a1.702 1.702 0 112.409 2.41l-.082.082-.11.117a3.272 3.272 0 00-.666 3.198l.032.09-.005-.096c0 .138.028.275.083.402a3.268 3.268 0 002.99 1.98h.236a1.702 1.702 0 010 3.405h-.122a3.27 3.27 0 00-2.995 1.98 3.264 3.264 0 00.658 3.596l.09.09a1.702 1.702 0 11-2.41 2.409l-.082-.082a3.272 3.272 0 00-3.612-.662 3.264 3.264 0 00-1.97 2.987v.235a1.702 1.702 0 11-3.405 0v-.122a3.276 3.276 0 00-2.14-3.015c-1.162-.515-2.59-.256-3.545.678l-.09.09a1.702 1.702 0 11-2.409-2.41l.082-.082a3.272 3.272 0 00.662-3.612 3.264 3.264 0 00-2.987-1.97h-.235a1.702 1.702 0 110-3.405h.122a3.276 3.276 0 003.015-2.14c.515-1.162.256-2.59-.678-3.545l-.09-.09a1.702 1.702 0 112.41-2.409l.082.082.117.11a3.272 3.272 0 003.198.666l.09-.032.11-.016c.067-.014.133-.035.196-.062a3.268 3.268 0 001.98-2.99v-.236c0-.94.763-1.702 1.703-1.702z"/></g></svg>
        </a>
        <div class="flex-1">
          <h3 class="mb-1"><a href="{{ cp_route('metatags.settings') }}" class="text-blue">Settings</a></h3>
          <p>Enable the meta tags you really need.</p>
        </div>
      </div>
      <div class="w-full lg:w-1/2 p-2 hover:bg-grey-20 flex items-start rounded-md group">
        <a href="{{ cp_route('metatags.defaults') }}" class="mr-2 text-grey-80">
          <svg width="25" height="32" xmlns="http://www.w3.org/2000/svg"><path d="M0 30.118h1.882V32H0v-1.882zM15.059 32h1.882v-1.882H15.06V32zm3.765 0h1.882v-1.882h-1.882V32zm-15.06 0h1.883v-1.882H3.765V32zm3.765 0h1.883v-1.882H7.529V32zm3.765 0h1.882v-1.882h-1.882V32zm11.294 0h1.883v-1.882h-1.883V32zm0-26.353h1.883V3.765h-1.883v1.882zm0 3.765h1.883V7.529h-1.883v1.883zm0 15.059h1.883v-1.883h-1.883v1.883zm0-11.295h1.883v-1.882h-1.883v1.882zm0 3.765h1.883V15.06h-1.883v1.882zm0 11.294h1.883v-1.882h-1.883v1.882zm0-7.53h1.883v-1.881h-1.883v1.882zm0-20.705v1.882h1.883V0h-1.883zm-3.764 1.882h1.882V0h-1.882v1.882zm-11.295 0h1.883V0H7.529v1.882zm3.765 0h1.882V0h-1.882v1.882zm3.765 0h1.882V0H15.06v1.882zm-11.294 0h1.882V0H3.765v1.882zM0 1.882h1.882V0H0v1.882zm0 22.589h1.882v-1.883H0v1.883zm0 3.764h1.882v-1.882H0v1.882zm0-7.53h1.882v-1.881H0v1.882zM0 5.648h1.882V3.765H0v1.882zm0 3.765h1.882V7.529H0v1.883zm0 3.764h1.882v-1.882H0v1.882zm0 3.765h1.882V15.06H0v1.882z" fill="#000" fill-rule="nonzero"/></svg>
        </a>
        <div class="flex-1">
          <h3 class="mb-1"><a href="{{ cp_route('metatags.defaults') }}" class="text-blue">Default values</a></h3>
          <p>Set the default values for the meta tags you have activated.</p>
        </div>
      </div>
    </div>
  </div>
@endsection
