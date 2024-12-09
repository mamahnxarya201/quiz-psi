<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Person</title>
    <link rel="stylesheet" href="/views/css/home.css">
</head>
<body>
    <div class="container">
        <h1>Contact Person</h1>
        <button class="add-button" onclick="navigateToAddForm()">ADD</button>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>View</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personCollection as $index => $person): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($person->name, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($person->noTelp, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><button class="view-button" onclick="navigateToViewForm(<?= $person->id ?>)">View</button></td>
                        <td><button class="update-button" onclick="navigateToEditForm(<?= $person->id ?>)">Update</button></td>
                        <td><button class="delete-button">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script> 
        let navigateToAddForm = () => window.location.href='/form/add';
        let navigateToEditForm = (id) => window.location.href='/form/edit?id=' + id;
        let navigateToViewForm = (id) => window.location.href='/form/view?id=' + id;
    </script>
</body>

</html>