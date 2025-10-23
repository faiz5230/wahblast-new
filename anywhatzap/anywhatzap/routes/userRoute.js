// routes/userRoutes.js
import express from 'express';
import { getUsers, createUser } from '../controllers/UserController.js';

const router = express.Router();

router.get('/users', getUsers); // Mengambil daftar pengguna
router.post('/users', createUser); // Menambahkan pengguna baru

export default router;