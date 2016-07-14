@foreach($items as $item)
  <li@lm-attrs($item) @lm-endattrs>
      @if(!$item->url())
        {!! $item->title !!}
      @else
      <a href="{!! $item->url() !!}">{!! $item->title !!}</a>
      @endif
      @if($item->hasChildren())
        <ul class="treeview-menu">
            @include('custom-menu-items', array('items' => $item->children()))
        </ul>
      @endif
  </li>
@endforeach