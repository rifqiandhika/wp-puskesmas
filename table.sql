CREATE TABLE `cek_gizi` (
  `id` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL,
  `nama` text NOT NULL,
  `usia` text NOT NULL,
  `tinggi` float NOT NULL,
  `berat` float NOT NULL,
  `ket_tinggi` text NOT NULL,
  `ket_berat` text NOT NULL,
  `update_at` auto_incrementstamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bulan` text NOT NULL,
  `tahun` year NOT NULL,
   PRIMARY KEY  (id)
);