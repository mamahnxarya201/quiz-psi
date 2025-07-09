CREATE TABLE IF NOT EXISTS person (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    no_telp TEXT NOT NULL,
    alamat TEXT NOT NULL,
    jenis_kelamin INTEGER NOT NULL, -- 0 = false, 1 = true
    tanggal_lahir TEXT NOT NULL,    -- Store as ISO8601 string (YYYY-MM-DD)
    tempat_lahir TEXT NOT NULL,
    photo BLOB
);
