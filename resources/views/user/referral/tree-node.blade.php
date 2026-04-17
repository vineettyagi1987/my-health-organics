<ul>
@foreach($nodes as $node)
    <li>
        <span>{{ $node['user']->name }}</span>

        @if(!empty($node['children']))
            @include('user.referral.tree-node', ['nodes' => $node['children']])
        @endif

    </li>
@endforeach
</ul>
