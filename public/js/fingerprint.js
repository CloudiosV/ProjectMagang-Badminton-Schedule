document.getElementById('btn-enroll').addEventListener('click', async function() {
    const userID = document.getElementById('user_id').value;
    const statusMessage = document.getElementById('status-message-element');

    if (!userID) {
        alert("Pilih karyawan dulu!");
        return;
    }
    statusMessage.innerText = "Alat menyala. Silakan tempelkan jari yang sama 3 kali...";
    statusMessage.style.color = "orange";
    
    try {
        const golangServiceResponse = await fetch('http://localhost:8080/enroll', {
            method: 'POST'
        });

        const golangEnrollResult = await golangServiceResponse.json();

        if (golangEnrollResult.error) {
            statusMessage.innerText = "Gagal scan: " + golangEnrollResult.error;
            statusMessage.style.color = "red";
            return;
        }

        statusMessage.innerText = "Scan sukses! Sedang menyimpan ke database...";
        statusMessage.style.color = "blue";

        const FPStringV10 = golangEnrollResult.template9;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/fingerprint/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                user_id: userID,
                fingerprint_string: FPStringV10
            })
        });

        const Fingerprint_data = await response.json();

        if (Fingerprint_data.status === 'success') {
            statusMessage.innerText = "Berhasil! Data tersimpan di server.";
            statusMessage.style.color = "green";
        } else {
            statusMessage.innerText = "Gagal simpan ke server Laravel.";
            statusMessage.style.color = "red";
        }

    } catch (networkOrSystemError) {
        console.error(networkOrSystemError);
        statusMessage.innerText = "Pastikan aplikasi server fingerprint (Golang) sudah berjalan di PC ini!";
        statusMessage.style.color = "red";
    }
});

document.getElementById('btn-verify').addEventListener('click', async function() {
    const selectedEmployeeId = document.getElementById('user_id').value;
    const statusMessage = document.getElementById('status-message-element');

    if (!selectedEmployeeId) {
        alert("Pilih karyawan dulu untuk diverifikasi!");
        return;
    }

    try {
        statusMessage.innerText = "Mengambil data sidik jari dari server...";
        statusMessage.style.color = "orange";

        const dbResponse = await fetch(`/fingerprint/data/${selectedEmployeeId}`, {headers: {'Accept': 'application/json'}});
        const FPData = await dbResponse.json();
        
        if (FPData.error) {
            statusMessage.innerText = FPData.error;
            statusMessage.style.color = "red";
            return;
        }
        const registeredFPString = FPData.fingerprint_string;

        statusMessage.innerText = "Alat menyala. Silakan tempelkan jari 3 kali...";
        const captureResponse = await fetch('http://localhost:8080/enroll', { method: 'POST' });
        const captureFPData = await captureResponse.json();

        if (captureFPData.error) {
            statusMessage.innerText = "Gagal scan: " + captureFPData.error;
            statusMessage.style.color = "red";
            return;
        }

        const liveFPString = captureFPData.template9; 

        if (!liveFPString) {
            statusMessage.innerText = "Error: Alat gagal menerjemahkan sidik jari (Data kosong).";
            statusMessage.style.color = "red";
            console.error("Isi balasan capture dari Golang:", captureFPData);
            return;
        } 

        statusMessage.innerText = "Mencocokkan...";
        const verifyResponse = await fetch('http://localhost:8080/verify', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                registered_template: registeredFPString, 
                verification_template: liveFPString,
                do_learning: false
            })
        });
        const verifyData = await verifyResponse.json();

        if (verifyData.Match === true || verifyData.match === true) {
            statusMessage.innerText = "Verifikasi Berhasil! Jari COCOK.";
            statusMessage.style.color = "green";
        } else {
            statusMessage.innerText = "Gagal! Jari TIDAK COCOK dengan karyawan tersebut.";
            statusMessage.style.color = "red";
        }

    } catch (error) {
        console.error(error);
        statusMessage.innerText = "Terjadi kesalahan sistem atau koneksi Golang.";
        statusMessage.style.color = "red";
    }
});

document.getElementById('btn-identify').addEventListener('click', async function() {
    const statusMessage = document.getElementById('status-message-element');

    try {
        statusMessage.innerText = "Menyiapkan mesin absen...";
        statusMessage.style.color = "orange";

        const dbResponse = await fetch(`/fingerprint/data-all`, {headers: {'Accept': 'application/json'}});
        const FPData = await dbResponse.json();
        
        if (!FPData.fingerprint_list || FPData.fingerprint_list.length === 0) {
            statusMessage.innerText = "Database kosong! Belum ada karyawan yang mendaftar.";
            statusMessage.style.color = "red";
            return;
        }

        const allFingerprints = FPData.fingerprint_list;

        statusMessage.innerText = "Alat menyala. Silakan tempelkan jari untuk Absen...";
        const captureResponse = await fetch('http://localhost:8080/enroll', { method: 'POST' });
        const captureFPData = await captureResponse.json();

        if (captureFPData.error) {
            statusMessage.innerText = "Gagal scan: " + captureFPData.error;
            statusMessage.style.color = "red";
            return;
        }
        
        const liveFPString = captureFPData.template9;

        if (!liveFPString) {
            statusMessage.innerText = "Error: Alat gagal menerjemahkan sidik jari (Data kosong).";
            statusMessage.style.color = "red";
            return;
        }

        const formattedDataForGolang = allFingerprints.map(fp => ({
            id: fp.id,
            template9: fp.fingerprint_string,
        }));

        statusMessage.innerText = "Mencari kecocokan di database...";
        const identifyResponse = await fetch('http://localhost:8080/identify', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                templates: formattedDataForGolang, 
                verification_template: liveFPString
            })
        });
        const identifyData = await identifyResponse.json();

        const matchedUserId = identifyData.MatchedID || identifyData.matchedID || identifyData.matched_id;

        if (matchedUserId && matchedUserId > 0) {
            const matchedEmployee = allFingerprints.find(emp => emp.id == matchedUserId);
            
            const employeeName = matchedEmployee ? matchedEmployee.employee_name : `Karyawan Tidak Diketahui`;

            statusMessage.innerText = `Absen Berhasil! Selamat datang, ${employeeName} (ID: ${matchedUserId}).`;
            statusMessage.style.color = "green";
        } else {
            statusMessage.innerText = "Sidik jari tidak terdaftar di sistem!";
            statusMessage.style.color = "red";
        }

    } catch (error) {
        console.error(error);
        statusMessage.innerText = "Terjadi kesalahan sistem atau koneksi Golang.";
        statusMessage.style.color = "red";
    }
});