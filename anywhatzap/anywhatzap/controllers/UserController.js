// controllers/userController.js
export const getUsers = (req, res) => {
    // Contoh data pengguna
    const users = [
        { id: 1, name: 'John Doe' },
        { id: 2, name: 'Jane Doe' }
    ];
    res.json(users);
};

export const createUser = (req, res) => {
    const newUser = req.body; // Ambil data pengguna dari body permintaan
    // Logika untuk menyimpan pengguna baru bisa ditambahkan di sini
    res.status(201).json(newUser); // Mengembalikan pengguna yang baru dibuat
};