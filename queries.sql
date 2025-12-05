-- ==========================================================
-- MBG ANALYTICAL QUERIES
-- Purpose: Reporting & Business Intelligence for Logistics
-- Author: Zaghokun
-- ==========================================================

-- 1. DISTRIBUTION PERFORMANCE DASHBOARD
-- Melihat performa distribusi harian per status (Terkirim vs Pending)
SELECT 
    d.tanggal_kirim,
    d.status_pengiriman,
    COUNT(d.distribusi_id) as total_paket,
    CONCAT(FORMAT(COUNT(d.distribusi_id) * 100.0 / SUM(COUNT(d.distribusi_id)) OVER(PARTITION BY d.tanggal_kirim), 2), '%') as persentase
FROM DISTRIBUSI d
GROUP BY d.tanggal_kirim, d.status_pengiriman
ORDER BY d.tanggal_kirim DESC;

-- 2. TOP PARTNER PERFORMANCE (Kapasitas vs Realisasi)
-- Mengukur efektivitas Mitra dalam menyalurkan bantuan
SELECT 
    m.nama_mitra,
    m.wilayah_operasional,
    m.kapasitas_harian,
    COUNT(d.distribusi_id) as realisasi_pengiriman,
    SUM(p.kalori_total) as total_kalori_disalurkan
FROM MITRA m
JOIN DISTRIBUSI d ON m.mitra_id = d.mitra_id
JOIN PAKETBANTUAN p ON d.paket_id = p.paket_id
WHERE d.status_pengiriman = 'Diterima'
GROUP BY m.mitra_id
ORDER BY total_kalori_disalurkan DESC
LIMIT 10;

-- 3. AUDIT TRAIL & ANOMALY DETECTION
-- Mencari distribusi yang sudah dikirim tapi belum ada laporan balikan (Potensi Masalah)
SELECT 
    d.distribusi_id,
    m.nama_mitra,
    p.nama_lengkap as penerima,
    d.tanggal_kirim,
    DATEDIFF(CURRENT_DATE, d.tanggal_kirim) as hari_terlambat
FROM DISTRIBUSI d
LEFT JOIN LAPORANDATA l ON d.distribusi_id = l.distribusi_id
JOIN MITRA m ON d.mitra_id = m.mitra_id
JOIN PENERIMA p ON d.penerima_id = p.penerima_id
WHERE d.status_pengiriman = 'Dikirim' 
AND l.laporan_id IS NULL
AND DATEDIFF(CURRENT_DATE, d.tanggal_kirim) > 3;

-- 4. NUTRITIONAL COVERAGE REPORT (VIEW)
-- Membuat View agar tim frontend bisa mengambil data gizi tanpa query rumit
CREATE OR REPLACE VIEW view_rekap_gizi_wilayah AS
SELECT 
    pn.kecamatan,
    pn.kelurahan,
    COUNT(DISTINCT pn.penerima_id) as total_penerima,
    SUM(pb.kalori_total) as total_kalori_masuk,
    AVG(pb.berat_total) as rata_rata_berat_paket
FROM PENERIMA pn
JOIN DISTRIBUSI d ON pn.penerima_id = d.penerima_id
JOIN PAKETBANTUAN pb ON d.paket_id = pb.paket_id
WHERE d.status_pengiriman = 'Diterima'
GROUP BY pn.kecamatan, pn.kelurahan;
