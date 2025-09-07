<div>
<h1>Editing {{ $node->NodeName }}</h1>

<form action="{{ route('nodes.modifying', $node->NodeId) }}" method="POST">
    @csrf
    @method('PATCH')

    <label for="NodeName">NodeName:</label>
    <input type="text" name="NodeName" value="{{ old('NodeName', $node->NodeName) }}" required>

    <br>

    <label for="NodeAddress">NodeAddress:</label>
    <input type="text" name="NodeAddress" value="{{ old('NodeAddress', $node->NodeAddress) }}" required>

    <br>

    <button type="submit">Update</button>
    <a href="{{ route('nodes.index') }}">Cancel</a>
</form>
</div>
