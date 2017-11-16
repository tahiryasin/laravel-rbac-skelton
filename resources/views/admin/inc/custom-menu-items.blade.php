@foreach($items as $item)
  <li @lm-attrs($item) @if($item->hasChildren()) class="dropdown" @endif data-test="test" @lm-endattrs> 
      <a href="{!! $item->url() !!}">{!! $item->title !!} @if($item->hasChildren())<span class="fa arrow"></span>@endif</a>
      @if($item->hasChildren())
        <ul class="nav nav-second-level collapse">
              @include('admin/inc/custom-menu-items', array('items' => $item->children()))
        </ul> 
      @endif
  </li>
@endforeach