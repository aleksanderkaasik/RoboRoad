<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <nav>
        <ul>
            <?php foreach ($Nodes as $Node) { ?>
                <li><a href="{{ route('nodes.preview', $Node['NodeID'])}}">{{ $Node['NodeName'] }}</a></li>
            <?php } ?>
        </ul>
    </nav>
</body>
</html>   