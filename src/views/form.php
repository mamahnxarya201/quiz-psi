<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melihat Data Contact Person</title>
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <div class="container">
        <h1><?= $titleText ?> Data Contact Person</h1>
        <form id="personForm">
            <fieldset>
                <legend>Biodata</legend>
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" value="<?= htmlspecialchars($person ? $person->name : '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="ttl">Tempat/Tanggal Lahir:</label>
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="text" id="tempat" name="tempat" placeholder="Masukkan Tempat Lahir" value="<?= htmlspecialchars($person ? $person->tempatLahir : '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col">
                            <input class="form-control" type="date" id="ttl" name="ttl" placeholder="dd/mm/yyyy" value="<?= $person ? $person->getTanggalLahir() : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required><?= htmlspecialchars($person ? $person->alamat : '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp/Hp:</label>
                    <input class="form-control" type="text" id="no_telp" name="no_telp" placeholder="Masukkan No Telp/Hp" value="<?= htmlspecialchars($person ? $person->noTelp : '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <label>
                        <input type="radio" name="jenis_kelamin" value="pria" required <?= $person && $person->jenisKelamin == 1 ? 'checked' : '' ?>> Pria
                    </label>
                    <label>
                        <input type="radio" name="jenis_kelamin" value="wanita" <?= $person && $person->jenisKelamin == 0 ? 'checked' : '' ?>> Wanita
                    </label>
                </div>
                <div class="form-group">
                    <label for="foto">Pas Foto:</label>
                    <input class="form-control" type="file" id="foto" name="foto">
                </div>
                <img class="img-fluid" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" />
                <input type="hidden" name="id" value="<?= $person ? $person->id : '' ?>">
            </fieldset>
            <div class="row">
                <div class="col">
                    <button type="button" class="back-button" onclick="navigateToHome()">Back</button>
                </div>
                <div class="col">
                    <button type="button" class="submit-button <?= $action === 'view' ? 'hidden' : '' ?>" onclick="submitForm()">Submit</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        let navigateToHome = () => window.location.href='/';

        function submitForm() {
            const form = document.getElementById('personForm');
            const formData = new FormData(form);
            const fileInput = document.getElementById('foto');
            const file = fileInput.files[0];

            const titleText = "<?= $titleText ?>";
            let endpoint = '/api/person/add';
            if (titleText === 'Merubah') {
                endpoint = '/api/person/update';
            }

            if (file) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    const base64String = reader.result.split(',')[1];
                    formData.append('foto_base64', base64String);

                    fetch(endpoint, {
                        method: 'POST',
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            // window.location.href = '/'
                            console.log("Form submitted successfully!");
                        } else {
                            alert('Failed to submit form');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Failed to submit form');
                    });
                };
                reader.readAsDataURL(file);
            } else {
                fetch(endpoint, {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        // window.location.href = '/'
                        console.log("Form submitted successfully!");
                    } else {
                        alert('Failed to submit form');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to submit form');
                });
            }
        }
    </script>
</body>

</html>