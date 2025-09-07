<div>
    <h1>Are you sure you want to delete this item?</h1>
    <p><strong>{{ $node['NodeName'] }}</strong></p>

    <form action="{{ route('nodes.deletion', $node['NodeId']) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Yes, Delete</button>
        <a href="{{ route('nodes.index') }}">Cancel</a>
    </form>
</div>
