<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーリスト</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td><?php echo h($user['id']); ?></td>
                <td><?php echo h($user['name']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>