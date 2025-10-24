import { 
    DisconnectReason, 
    makeWASocket, 
    useMultiFileAuthState,
    downloadContentFromMessage,
    fetchLatestBaileysVersion
} from '@whiskeysockets/baileys';
import fs from 'fs';
import qrcode from 'qrcode-terminal';
import axios from 'axios';
import FormData from 'form-data';
import path from 'path';
import { fileURLToPath } from 'url';
import pino from 'pino';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const folderPath = path.join(__dirname, 'delivered-image');

// Buat folder jika belum ada
if (!fs.existsSync(folderPath)) {
    fs.mkdirSync(folderPath, { recursive: true });
}

let sock;

// Logger dengan level yang lebih rendah untuk mengurangi noise
const logger = pino({ level: 'silent' });

/**
 * Koneksi ke WhatsApp (versi sederhana)
 */
export const connectToWhatsApp = async () => {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
    
    // Fetch versi terbaru Baileys untuk compatibility
    const { version } = await fetchLatestBaileysVersion();
    
    // Browser configs yang lebih realistic
    const browsers = [
        ['Chrome (Windows)', 'Chrome', '120.0.0.0'],
        ['Chrome (MacOS)', 'Chrome', '120.0.0.0'],
        ['Edge (Windows)', 'Edge', '120.0.0.0'],
    ];
    
    const randomBrowser = browsers[Math.floor(Math.random() * browsers.length)];
    
    sock = makeWASocket({
        version,
        auth: state,
        logger,
        browser: randomBrowser,
        markOnlineOnConnect: false,
        syncFullHistory: false,
        printQRInTerminal: false,
        // Tambahan options untuk stability
        getMessage: async () => ({ conversation: '' }),
        defaultQueryTimeoutMs: 60000,
    });

    // Handle QR Code secara manual
    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;
        
        // Tampilkan QR code di terminal
        if (qr) {
            console.log('\n📱 Scan QR Code berikut dengan WhatsApp Anda:');
            qrcode.generate(qr, { small: true });
        }
        
        if (connection === 'close') {
            const statusCode = lastDisconnect?.error?.output?.statusCode;
            const shouldReconnect = statusCode !== DisconnectReason.loggedOut;
            
            console.log('❌ Koneksi ditutup.');
            console.log('Status Code:', statusCode);
            console.log('Should Reconnect:', shouldReconnect);
            
            if (statusCode === 405) {
                console.log('⚠️  Error 405 - Tunggu 30 detik sebelum reconnect...');
                setTimeout(() => {
                    console.log('🔄 Mencoba koneksi ulang...');
                    connectToWhatsApp();
                }, 30000); // 30 detik delay untuk error 405
            } else if (shouldReconnect) {
                setTimeout(() => {
                    console.log('🔄 Mencoba koneksi ulang...');
                    connectToWhatsApp();
                }, 5000);
            } else {
                console.log('⚠️ Anda telah logout. Silakan login kembali.');
            }
        } else if (connection === 'open') {
            console.log('✅ Koneksi WhatsApp berhasil!');
        }
    });

    sock.ev.on('creds.update', saveCreds);

    // Handle pesan masuk
    sock.ev.on('messages.upsert', async (m) => {
        if (m.messages[0].key.fromMe) return;
        
        console.log('\n📨 Pesan baru diterima:');
        console.log(JSON.stringify(m, undefined, 2));
        
        const message = m.messages[0];
        console.log('Dari:', message.key.remoteJid);
    });
    
    return sock;
};

/**
 * Koneksi ke WhatsApp dengan folder auth custom (multi-instance)
 */
export const connectToWhatsappv2 = async (instanceId) => {
    const authFolder = `auth_info_baileys/${instanceId}`;
    const { state, saveCreds } = await useMultiFileAuthState(authFolder);
    
    // Fetch versi terbaru
    const { version } = await fetchLatestBaileysVersion();
    
    // Gunakan browser config yang stabil (tidak random)
    const stableBrowser = ['Chrome (Linux)', 'Chrome', '120.0.0.0'];
    console.log(`🌐 Using stable browser: ${stableBrowser[0]}`);

    sock = makeWASocket({
        version,
        auth: state,
        logger,
        browser: stableBrowser, // Fixed browser, tidak random
        markOnlineOnConnect: false,
        syncFullHistory: false,
        printQRInTerminal: false,
        // Tambahan untuk stabilitas
        getMessage: async () => ({ conversation: '' }),
        defaultQueryTimeoutMs: 60000,
        keepAliveIntervalMs: 30000, // Keep alive setiap 30 detik
        connectTimeoutMs: 60000,
        // Options tambahan untuk stability
        emitOwnEvents: false,
        fireInitQueries: false,
    });

    return new Promise((resolve, reject) => {
        let retryCount = 0;
        const maxRetries = 5; // Increase max retries
        
        // Handle credentials update
        sock.ev.on('creds.update', () => {
            saveCreds();
            console.log('💾 Credentials updated');
        });

        // Handle connection
        sock.ev.on('connection.update', async (update) => {
            const { connection, lastDisconnect, qr } = update;

            // Tampilkan QR code
            if (qr) {
                console.log(`\n📱 [Instance: ${instanceId}] Scan QR Code:`);
                qrcode.generate(qr, { small: true });
                console.log('✅ QR Code generated successfully');
            }

            if (connection === 'close') {
                const statusCode = lastDisconnect?.error?.output?.statusCode;
                const shouldReconnect = statusCode !== DisconnectReason.loggedOut;
                
                console.log('connection closed due to', lastDisconnect?.error);
                console.log('Status Code:', statusCode);
                console.log('Reconnecting:', shouldReconnect);
                
                if (statusCode === 405) {
                    retryCount++;
                    if (retryCount < maxRetries) {
                        const waitTime = 60000 * retryCount; // Longer delay for 405
                        console.log(`⚠️  Error 405 - Retry ${retryCount}/${maxRetries}`);
                        console.log(`⏳ Tunggu ${waitTime/1000} detik...`);
                        setTimeout(() => connectToWhatsappv2(instanceId), waitTime);
                    } else {
                        console.log('❌ Max retries reached. Stopping.');
                        reject(new Error('Error 405: Max retries reached'));
                    }
                } else if (statusCode === 515) {
                    // Error 515 - Stream Error, tunggu lebih lama
                    retryCount++;
                    if (retryCount < maxRetries) {
                        const waitTime = 30000; // 30 detik untuk 515
                        console.log(`⚠️  Error 515 - Stream Error (${retryCount}/${maxRetries})`);
                        console.log(`⏳ Tunggu ${waitTime/1000} detik untuk stabilitas...`);
                        setTimeout(() => connectToWhatsappv2(instanceId), waitTime);
                    } else {
                        console.log('❌ Terlalu banyak stream error. Restart manual diperlukan.');
                        reject(new Error('Error 515: Stream tidak stabil'));
                    }
                } else if (shouldReconnect) {
                    setTimeout(() => connectToWhatsappv2(instanceId), 15000); // 15 detik delay
                } else {
                    console.log('❌ Koneksi ditutup. Tidak bisa terhubung.');
                    reject(new Error('Koneksi ditutup'));
                }
            } else if (connection === 'open') {
                console.log('✅ Koneksi berhasil dan stabil');
                retryCount = 0; // Reset retry count on success
                resolve(sock);
            } else if (connection === 'connecting') {
                console.log('🔄 Sedang menghubungkan...');
            }
        });
    });
};

/**
 * Disconnect dari WhatsApp
 */
export const disconnectWhatsApp = async () => {
    if (!sock) {
        console.log('⚠️ Tidak ada koneksi yang aktif.');
        return { success: false, message: 'Tidak ada koneksi yang aktif.' };
    }

    try {
        await sock.logout();
        sock = null;
        console.log('✅ Koneksi berhasil diputus.');
        return { success: true, message: 'Koneksi berhasil diputus.' };
    } catch (error) {
        console.error('Error saat memutuskan koneksi:', error);
        return { success: false, message: 'Error saat memutuskan koneksi' };
    }
};

/**
 * Hapus folder auth
 */
export const deleteAuthFolder = async (instanceId) => {
    const authFolder = `auth_info_baileys/${instanceId}`;
    
    try {
        if (fs.existsSync(authFolder)) {
            fs.rmdirSync(authFolder, { recursive: true });
            console.log(`✅ Folder ${authFolder} telah dihapus.`);
            return { success: true, message: `Folder ${authFolder} berhasil dihapus` };
        }
        return { success: false, message: 'Folder tidak ditemukan' };
    } catch (error) {
        console.error('Error saat menghapus folder:', error);
        return { success: false, message: 'Error saat menghapus folder' };
    }
};

/**
 * Kirim pesan teks
 */
export const sendMessage = async (jid, text) => {
    if (!sock) {
        throw new Error('WhatsApp socket is not initialized');
    }

    if (!jid.endsWith('@s.whatsapp.net') && !jid.endsWith('@g.us')) {
        throw new Error('Invalid JID format');
    }

    try {
        await sock.sendMessage(jid, { text });
        return { success: true, message: 'Pesan berhasil dikirim' };
    } catch (error) {
        console.error('Error saat mengirim pesan:', error);
        throw error;
    }
};

/**
 * Kirim pesan dengan gambar
 */
export const sendMessageWithImage = async (jid, imageBuffer, caption = '') => {
    if (!sock) {
        throw new Error('WhatsApp socket is not initialized');
    }

    if (!jid.endsWith('@s.whatsapp.net')) {
        throw new Error('Invalid JID format. Must end with @s.whatsapp.net');
    }

    await sock.sendMessage(jid, {
        image: imageBuffer,
        caption: caption
    });

    return { success: true, message: 'Pesan berhasil dikirim' };
};

/**
 * Kirim pesan dengan dokumen
 */
export const sendMessageWithDocument = async (jid, documentBuffer, fileName = 'document.pdf', caption = '') => {
    if (!sock) {
        throw new Error('WhatsApp socket is not initialized');
    }

    if (!jid.endsWith('@s.whatsapp.net')) {
        throw new Error('Invalid JID format. Must end with @s.whatsapp.net');
    }

    await sock.sendMessage(jid, {
        document: documentBuffer,
        mimetype: 'application/pdf',
        caption: caption,
        fileName: fileName
    });

    return { success: true, message: 'Pesan berhasil dikirim' };
};

/**
 * Ambil daftar grup
 */
export const getListGroup = async (instanceId) => {
    if (!sock) {
        await connectToWhatsappv2(instanceId);
    }

    if (!sock) {
        throw new Error('WhatsApp socket is not initialized');
    }

    try {
        const groups = await sock.groupFetchAllParticipating();
        const groupList = Object.values(groups).map(group => ({
            id: group.id,
            subject: group.subject
        }));
        return groupList;
    } catch (error) {
        console.error('Error saat mengambil grup:', error);
        throw new Error('Gagal mengambil grup');
    }
};

/**
 * Kirim pesan ke grup
 */
export const sendMessageToGroup = async (groupJid, messageData, instanceId) => {
    if (!sock) {
        await connectToWhatsappv2(instanceId);
    }

    if (!sock) {
        throw new Error('WhatsApp socket is not initialized');
    }

    if (!groupJid.endsWith('@g.us')) {
        throw new Error('Invalid JID format. Must end with @g.us');
    }

    try {
        if (messageData.document) {
            await sock.sendMessage(groupJid, {
                document: messageData.document,
                caption: messageData.caption,
                fileName: messageData.fileName
            });
        } else if (messageData.video) {
            await sock.sendMessage(groupJid, {
                video: messageData.video,
                caption: messageData.caption,
                fileName: messageData.fileName
            });
        } else if (messageData.image) {
            await sock.sendMessage(groupJid, {
                image: messageData.image,
                caption: messageData.caption,
                fileName: messageData.fileName
            });
        } else {
            await sock.sendMessage(groupJid, { text: messageData.text });
        }

        return { success: true, message: 'Pesan berhasil dikirim ke grup' };
    } catch (error) {
        console.error('Gagal mengirim pesan ke grup', error);
        throw new Error('Gagal mengirim pesan ke grup');
    }
};

/**
 * Cek nomor WhatsApp
 */
export const checkNumber = async (instanceId, numbers) => {
    try {
        if (!sock) {
            await connectToWhatsappv2(instanceId);
        }

        const result = await sock.onWhatsApp(numbers);
        
        result.forEach(contact => {
            if (contact.exists) {
                console.log(`✅ Nomor ${contact.jid} ada di WhatsApp.`);
            } else {
                console.log(`❌ Nomor ${contact.jid} tidak terdaftar di WhatsApp.`);
            }
        });

        return result;
    } catch (error) {
        console.error('Error saat memeriksa nomor WhatsApp:', error);
        throw error;
    }
};

/**
 * Download media dari pesan
 */
const downloadMediaMessage = async (message, type) => {
    const stream = await downloadContentFromMessage(message, type);
    let buffer = Buffer.from([]);
    
    for await (const chunk of stream) {
        buffer = Buffer.concat([buffer, chunk]);
    }
    
    return buffer;
};

/**
 * Handler untuk menerima pesan dan kirim ke webhook
 */
export const getMessage = async (instanceId) => {
    try {
        if (!sock) {
            await connectToWhatsappv2(instanceId);
        }

        if (!sock.ev || typeof sock.ev.on !== 'function') {
            throw new Error('sock.ev tidak terinisialisasi dengan benar.');
        }

        sock.ev.on('messages.upsert', async (messageUpdate) => {
            console.log('📨 Pesan diterima:', JSON.stringify(messageUpdate, null, 2));

            const message = messageUpdate.messages[0];
            
            // Skip pesan dari diri sendiri
            if (message.key.fromMe) return;

            const remoteJid = message.key.remoteJid;
            const pushName = message.pushName || 'Nama tidak tersedia';
            const verifiedBizName = message.verifiedBizName || 'Tidak ada nama bisnis';

            let messageText = '';
            let messageType = '';
            let mediaBuffer = null;
            let filePath = null;

            // Deteksi tipe pesan
            if (message.message.conversation) {
                messageText = message.message.conversation;
                messageType = 'text';
            } else if (message.message.extendedTextMessage) {
                messageText = message.message.extendedTextMessage.text;
                messageType = 'extendedText';
            } else if (message.message.imageMessage) {
                messageText = message.message.imageMessage.caption || '';
                messageType = 'image';
                mediaBuffer = await downloadMediaMessage(message.message.imageMessage, 'image');
            } else if (message.message.videoMessage) {
                messageText = message.message.videoMessage.caption || '';
                messageType = 'video';
                mediaBuffer = await downloadMediaMessage(message.message.videoMessage, 'video');
            } else if (message.message.documentMessage) {
                messageText = message.message.documentMessage.fileName || '';
                messageType = 'document';
                mediaBuffer = await downloadMediaMessage(message.message.documentMessage, 'document');
            }

            console.log(`📩 Pesan dari ${pushName || verifiedBizName}: ${remoteJid}: ${messageText} (Tipe: ${messageType})`);

            // Kirim ke webhook
            if (message.key.fromMe === false) {
                try {
                    const formData = new FormData();
                    formData.append('from', remoteJid);
                    formData.append('text', messageText);
                    formData.append('messageType', messageType);
                    formData.append('waKey', instanceId);
                    formData.append('status', 90);
                    formData.append('type', 'text');
                    formData.append('from_name', pushName || verifiedBizName);

                    // Simpan media jika ada
                    if (mediaBuffer) {
                        const fileExtension = messageType === 'image' ? 'jpg' : 
                                            messageType === 'video' ? 'mp4' : 'pdf';
                        const fileName = `${messageType}-${Date.now()}.${fileExtension}`;
                        filePath = path.join(folderPath, fileName);
                        
                        fs.writeFileSync(filePath, mediaBuffer);
                        formData.append('url_file', fs.createReadStream(filePath));
                    }

                    // Kirim ke webhook
                    const webhookUrl = process.env.WEBHOOK_URL + '/webhookGetMessage';
                    const response = await axios.post(webhookUrl, formData, {
                        headers: {
                            ...formData.getHeaders()
                        }
                    });

                    console.log('✅ Pesan berhasil dikirim ke webhook:', response.data);

                } catch (error) {
                    console.error('❌ Gagal mengirim pesan ke webhook:', error);
                } finally {
                    // Hapus file setelah dikirim
                    if (filePath) {
                        try {
                            fs.unlinkSync(filePath);
                            console.log(`🗑️ File ${filePath} telah dihapus.`);
                        } catch (err) {
                            console.error(`Error saat menghapus file ${filePath}:`, err);
                        }
                    }
                }
            }

            return messageText;
        });

    } catch (error) {
        console.error('❌ Error saat menghubungkan ke WhatsApp:', error);
        throw error;
    }
};

// Export alias untuk backward compatibility
export const disconnectFromWhatsapp = disconnectWhatsApp;

export default {
    connectToWhatsApp,
    connectToWhatsappv2,
    disconnectWhatsApp,
    disconnectFromWhatsapp,
    deleteAuthFolder,
    sendMessage,
    sendMessageWithImage,
    sendMessageWithDocument,
    getListGroup,
    sendMessageToGroup,
    checkNumber,
    getMessage
};
