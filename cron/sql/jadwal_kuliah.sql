-- Tabel jadwal kuliah untuk reminder pagi agen_harian.php
-- Jalankan: mysql -u<user> -p <db> < cron/sql/jadwal_kuliah.sql

CREATE TABLE IF NOT EXISTS jadwal_kuliah (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  kodemk      VARCHAR(20)  NOT NULL,
  namamk      VARCHAR(150) NOT NULL,
  prodi       VARCHAR(100) NOT NULL,
  kelas       VARCHAR(10)  NOT NULL,
  hari        ENUM('SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU') NOT NULL,
  kapasitas   INT NOT NULL DEFAULT 0,
  terisi      INT NOT NULL DEFAULT 0,
  ruang       VARCHAR(120) NOT NULL,
  jam_mulai   TIME NOT NULL,
  jam_selesai TIME NOT NULL,
  KEY idx_hari (hari)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE jadwal_kuliah;

INSERT INTO jadwal_kuliah
  (kodemk, namamk, prodi, kelas, hari, kapasitas, terisi, ruang, jam_mulai, jam_selesai) VALUES
  ('TKE221121','Pemrograman','Teknik Elektro','A','SELASA',50,45,'GEDUNG TEKNIK C 101','09:45:00','12:25:00'),
  ('TKE221121','Pemrograman','Teknik Elektro','B','SELASA',50,41,'GEDUNG TEKNIK C 101','07:00:00','09:40:00'),
  ('TKE221121','Pemrograman','Teknik Elektro','C','SELASA',50,43,'GEDUNG TEKNIK E 201','09:45:00','12:25:00'),
  ('TKE221121','Pemrograman','Teknik Elektro','D','SELASA',50,43,'GEDUNG TEKNIK E 201','07:00:00','09:40:00'),
  ('TKE221225','Praktikum Pemrograman','Teknik Elektro','J','KAMIS',16,10,'Lab. Komputer Dasar 1','13:00:00','15:40:00'),
  ('TKE221225','Praktikum Pemrograman','Teknik Elektro','K','JUMAT',16,11,'Lab. Komputer Dasar 1','07:00:00','09:40:00'),
  ('TKE221225','Praktikum Pemrograman','Teknik Elektro','L','JUMAT',16,10,'Lab. Komputer Dasar 1','13:00:00','15:40:00'),
  ('TKE224021','Capstone Design','Teknik Elektro','A','JUMAT',40,17,'GEDUNG TEKNIK E 101','07:00:00','10:35:00'),
  ('TKE224918','Machine Learning','Teknik Elektro','A','KAMIS',50,7,'GEDUNG TEKNIK C 101','07:00:00','09:40:00'),
  ('TKE224938','Pemrograman Internet','Teknik Elektro','A','SELASA',40,1,'GEDUNG TEKNIK F113','13:00:00','15:40:00'),
  ('MTE25112','Kecerdasan Buatan','Teknik Elektro (S2)','A','SELASA',10,6,'GEDUNG TEKNIK F113','16:00:00','18:40:00'),
  ('MTE25121','Metodologi Penelitian','Teknik Elektro (S2)','A','SENIN',10,8,'GEDUNG TEKNIK C 101','16:00:00','18:40:00'),
  ('MTE25426','Data Mining dan Machine Learning','Teknik Elektro (S2)','A','JUMAT',10,7,'GEDUNG TEKNIK C 105','16:00:00','18:40:00');
