<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <nav>
        <a href="{{ route('nodes.create') }}"><button>Add mode</button></a>

        <ul>
            <?php foreach ($nodes as $node) { ?>
                <li>
                    <a href="{{ route('nodes.stream', $node['NodeId']) }}">{{ $node['NodeName'] }}</a>
                    <a href="{{ route('nodes.delete', $node['NodeId']) }}"><button>delete</button></a>
                    <a href="{{ route('nodes.update', $node['NodeId']) }}"><button>modify</button></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</body>
</html>