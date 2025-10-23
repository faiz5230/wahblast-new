import fs from 'fs';
import pkg from 'javascript-obfuscator'; // Mengimpor dengan cara default
const { obfuscate } = pkg; // Mengambil named export obfuscate dari pkg

// Array untuk menyimpan file yang akan diobfuski
const filesToObfuscate = [
    { input: './fi.js', output: './fi.js' } 
];

// Fungsi untuk mengobfuski file
const obfuscateFile = (file) => {
    const code = fs.readFileSync(file.input, 'utf-8'); // Baca kode dari file
    const obfuscatedCode = obfuscate(code, {
        compact: true,
        controlFlowFlattening: true,
    }).getObfuscatedCode(); // Obfuscate kode

    fs.writeFileSync(file.output, obfuscatedCode); // Simpan hasil obfuscation
    console.log(`File ${file.input} telah berhasil diobfuski dan disimpan di ${file.output}`);
};

// Proses obfuscation untuk setiap file
filesToObfuscate.forEach(obfuscateFile);
