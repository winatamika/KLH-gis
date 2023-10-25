-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2023 at 05:43 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gis`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category`) VALUES
('Bali'),
('NTB'),
('NTT');

-- --------------------------------------------------------

--
-- Table structure for table `marker`
--

CREATE TABLE `marker` (
  `id` int(99) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `icon` text,
  `tahun` varchar(99) DEFAULT NULL,
  `tipe` varchar(99) DEFAULT NULL,
  `legend` text,
  `legendfield` varchar(255) DEFAULT NULL,
  `id_user` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marker`
--

INSERT INTO `marker` (`id`, `title`, `category`, `file`, `icon`, `tahun`, `tipe`, `legend`, `legendfield`, `id_user`) VALUES
(11, 'Mineral Non Logam NTT', 'NTT', 'layer/nonlogam_ntt_intersect1413790750.geojson', 'images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png;images/marker/MINERAL NONLOGAM1413790750.png', '2014', 'marker', 'Andesit;Barit;Basal;Batu Hias;Batuan Ultrabasa;Batuapung;Batugamping;Batusabak;Bentonit;Dasit;Diorit;Dolomit;Felspar;Fosfat;Gipsum;Granit;Kalsedon;Kaolin;Kuarsit;Lempung;Marmer;Obsidian;Oker;Pasirkuarsa;Perlit;Sirtu;Toseki;Trakhit;Tras;Ultrabasa;Zeolit', 'KOMODITI', 1),
(15, 'Mineral Non Logam Bali', 'Bali', 'layer/nonlogam_bali_intersect1413791824.geojson', 'images/marker/MINERAL NONLOGAM1413791824.png;images/marker/MINERAL NONLOGAM1413791824.png;images/marker/MINERAL NONLOGAM1413791824.png;images/marker/MINERAL NONLOGAM1413791824.png;images/marker/MINERAL NONLOGAM1413791824.png', '2014', 'marker', 'Andesit;Batu Hias;Batuapung;Batugamping;Tras', 'KOMODITI', 1),
(16, 'Mineral Logam NTT', 'NTT', 'layer/LOGAM_NTT_Intersect1413792143.geojson', 'images/marker/MINERAL LOGAM1413792143.png;images/marker/MINERAL LOGAM1413792144.png;images/marker/MINERAL LOGAM1413792144.png;images/marker/MINERAL LOGAM1413792144.png;images/marker/MINERAL LOGAM1413792145.png;images/marker/MINERAL LOGAM1413792145.png;images/marker/MINERAL LOGAM1413792145.png;images/marker/MINERAL LOGAM1413792146.png', '2014', 'marker', 'Besi Primer;Emas Primer;Mangan;Pasir Besi;Perak;Seng;Tembaga;Timbal', 'KOMODITI', 1),
(17, 'Mineral Non Logam NTB', 'NTB', 'layer/nonlogam_ntb_intersect1413792664.geojson', 'images/marker/MINERAL NONLOGAM1413792664.png;images/marker/MINERAL NONLOGAM1413792664.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png;images/marker/MINERAL NONLOGAM1413792665.png', '2014', 'marker', 'Andesit;Batuapung;Batugamping;Belerang;Bentonit;Dasit;Diorit;Kalsedon;Kaolin;Lempung;Marmer;Oker;Pasirkuarsa;Perlit;Pirofilit;Toseki;Tras', 'KOMODITI', 1),
(18, 'Mineral Logam NTB', 'NTB', 'layer/LOGAM_NTB_Intersect1413793096.geojson', 'images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png;images/marker/MINERAL LOGAM1413793096.png', '2014', 'marker', 'Besi Primer;Emas Primer;Mangan;Pasir Besi;Perak;Tembaga;Timbal', 'KOMODITI', 1);

-- --------------------------------------------------------

--
-- Table structure for table `polygon`
--

CREATE TABLE `polygon` (
  `id` int(99) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tahun` varchar(99) DEFAULT NULL,
  `legend` text,
  `color` text,
  `tipe` varchar(99) DEFAULT NULL,
  `legendfield` varchar(255) DEFAULT NULL,
  `id_user` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polygon`
--

INSERT INTO `polygon` (`id`, `title`, `category`, `file`, `tahun`, `legend`, `color`, `tipe`, `legendfield`, `id_user`) VALUES
(19, 'Cekungan Air Tanah Bali', 'Bali', 'layer/cat_eko_bali-revisi1413553672.geojson', '2007', 'BUKAN CAT;CAT AMLAPURA;CAT DENPASAR-TABANAN;CAT GILIMANUK;CAT NEGARA;CAT NUSA PENIDA;CAT NUSADUA;CAT SINGARAJA;CAT TEJAKULA', '#29248e;#318822;#7db83d;#ae2b81;#803188;#c2c729;#329198;#2e9c65;#e42c39', 'polygon', 'NAMA_CAT', 1),
(20, 'Tutupan Lahan Bali', 'Bali', 'layer/lc_eko_bali-revisi1413554061.geojson', '2011', 'Bandar Udara Domestik/Internasional;Danau atau Waduk;Hutan Lahan Basah Primer;Hutan Lahan Basah Sekunder;Hutan Lahan Kering Primer;Hutan Lahan Kering Sekunder;Ladang;Lahan Terbuka;Padang rumput, alang-alang, sabana;Pelabuhan Laut;Perkebunan;Permukiman;Sawah;Semak dan Belukar;Sungai;Tambak;Tanaman Campuran', '#ff0000;#0070ff;#70a800;#98e600;#70a800;#98e600;#ff5500;#cd8966;#ff73df;#ff0000;#aaff00;#ff0000;#ffff00;#ff73df;#0070ff;#73b2ff;#55ff00', 'polygon', 'PL_SNI2010', 1),
(21, 'Cekungan Air Tanah NTB', 'NTB', 'layer/cat_eko_ntb-revisi1413554301.geojson', '2014', 'Bima;Bukan CAT;Dompu;Empang;Mataram - Selong;Pekat;Sanggar - Kilo;Sumbawa Besar;Tanjung - Sambelia;Tawali - Sape', '#3945b0;#3cb1ca;#3d9f1c;#713738;#76ba32;#9e3a9c;#aaaf3a;#9ec851;#bf37e1;#926786', 'polygon', 'CAT', 1),
(22, 'Cekungan Air Tanah NTT', 'NTT', 'layer/eko_cat_ntt-revisi1413555178.geojson', '2013', 'Bukan CAT;CAT Aroki;CAT Balaurik;CAT Bajawa;CAT Balauwak;CAT Besikama;CAT Camplong;CAT Delaki;CAT Ende;CAT Iliwatulolo;CAT Kalabahi;CAT Kupang;CAT Kutabura-Lamaayang;CAT Labuanbajo;CAT Larantuka;CAT Lempe;CAT Lewobunga;CAT Lewoleba;CAT Liberapan;CAT Mananga;CAT Maumere;CAT Maurole;CAT Mina;CAT Ngalu;CAT Oemeu;CAT Pasirputih;CAT Reo-Riung;CAT Ruteng;CAT Soe;CAT Waikabubak;CAT Takourang;CAT Wairiang;CAT Waiwadan;CAT Waiwerang;CAT Wapoe;CAT Werula', '#464ea4;#909090;#c5cb50;#36c782;#a89e5b;#ee934f;#d1dc98;#4869db;#ceca6f;#e7da41;#348cbc;#b4c635;#9bcb38;#bd2dae;#1725d0;#446fd0;#e90a95;#b8ea0b;#77b8bb;#f8880c;#d60c57;#a4a4a4;#e7cbfe;#1bfce0;#ffca66;#73649b;#9bf086;#f757bf;#e9bb67;#2ba86c;#ee3e73;#c7e12d;#ea4aea;#552bd5;#8d2124;#83c541', 'polygon', 'CAT', 1),
(23, 'Tutupan Lahan NTT', 'NTT', 'layer/eko_lc_ntt-revisi1413555935.geojson', '2011', 'Bandar Udara Domestik/Internasional;Danau atau Waduk;Hutan Lahan Basah Primer;Hutan Lahan Basah Sekunder;Hutan Lahan Kering Sekunder;Ladang;Lahan Terbuka;Padang rumput, alang-alang, sabana;Pelabuhan Laut;Perkebunan;Perkebunan Campuran;Permukiman;Rawa;Rumput Rawa;Sawah;Semak dan Belukar;Sungai;Tambak;Hutan Lahan Kering Primer', '#ff0000;#0070ff;#70a800;#98e600;#98e600;#ff5500;#cd8966;#ff73df;#ff0000;#aaff00;#55ff00;#ff0000;#73ffdf;#73ffdf;#ffff00;#ff73df;#0070ff;#73b2ff;#70a800', 'polygon', 'PL_SNI2010', 1),
(24, 'Tutupan Lahan NTB', 'NTB', 'layer/lc_eko_ntb-revisi1413619730.geojson', '2011', 'Bandar Udara Domestik/Internasional;Danau atau Waduk;Hutan Lahan Basah Primer;Hutan Lahan Basah Sekunder;Hutan Lahan Kering Primer;Hutan Lahan Kering Sekunder;Ladang;Lahan Terbuka;Padang rumput, alang-alang, sabana;Perkebunan;Permukiman;Pertambangan;Rumput Rawa;Sawah;Semak dan Belukar;Sungai;Tambak', '#ff0000;#0070ff;#70a800;#98e600;#70a800;#98e600;#ff5500;#cd8966;#ff73df;#aaff00;#ff0000;#cd8966;#73ffdf;#ffff00;#ff73df;#0070ff;#73b2ff', 'polygon', 'PL_SNI2010', 1),
(25, 'Ekoregion Bali', 'Bali', 'layer/BALI_EKOREGION_LENGKAP_Project1413783859.geojson', '2014', 'Dataran Fluvial;Dataran Organik/Koral;Dataran Pantai;Pegunungan Vulkanik;Perbukitan Karst;Perbukitan Vulkanik;Dataran Vulkanik', '#99eeff;#ffff7d;#80ffc1;#e66322;#ffcf40;#e68a5c;#ffbb99', 'polygon', 'MM', 1),
(29, 'Ekoregion NTB', 'NTB', 'layer/NTB_EKOREGION_LENGKAP_Project1413784941.geojson', '2014', 'Dataran Fluvial;Dataran Organik/Koral;Dataran Vulkanik;Pegunungan Struktural;Pegunungan Vulkanik;Perbukitan Denudasional;Perbukitan Karst;Perbukitan Struktural;Perbukitan Vulkanik', '#99eeff;#ffff7d;#ffbb99;#a266cc;#e66322;#ff9500;#ffcf40;#b799cc;#e68a5c', 'polygon', 'MM', 1),
(30, 'Ekoregion NTT', 'NTT', 'layer/NTT_EKOREGION_LENGKAP_Project1413785911.geojson', '2014', 'Dataran Fluvial;Dataran Organik/Koral;Dataran Pantai;Dataran Vulkanik;Pegunungan Denudasional;Pegunungan Struktural;Pegunungan Vulkanik;Perbukitan Denudasional;Perbukitan Karst;Perbukitan Struktural;Perbukitan Vulkanik', '#99eeff;#ffff7d;#80ffc1;#ffbb99;#d97e00;#a266cc;#e66322;#ff9500;#ffcf40;#b799cc;#e68a5c', 'polygon', 'MM', 1),
(37, 'NTB DAS Coba', 'NTB', 'layer/NTB_DAS_EKOREGION1414131565.geojson', '2014', 'Dataran Organik/Koral;Dataran Fluvial;Dataran Vulkanik;Pegunungan Struktural;Perbukitan Denudasional;Pegunungan Vulkanik;Perbukitan Karst;Perbukitan Struktural;Perbukitan Vulkanik', '#32cdc6;#edf231;#eb5421;#e0d838;#132ee8;#56690c;#adf11f;#1aa672;#2fd798', 'polygon', 'MM', 1),
(39, 'mineral logam NTB', 'NTB', '', '2014', '', '#000000', 'polygon', '', 1),
(43, 'NTB Coral Baru ', 'NTB', 'layer/NTB Coral1414134107.geojson', '2014', 'Terumbu karang', '#e6500f', 'polygon', 'Habitat', 1);

-- --------------------------------------------------------

--
-- Table structure for table `polyline`
--

CREATE TABLE `polyline` (
  `id` int(9) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tahun` varchar(99) DEFAULT NULL,
  `legend` text,
  `color` text,
  `tipe` varchar(255) DEFAULT NULL,
  `legendfield` varchar(255) DEFAULT NULL,
  `id_user` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polyline`
--

INSERT INTO `polyline` (`id`, `title`, `category`, `file`, `tahun`, `legend`, `color`, `tipe`, `legendfield`, `id_user`) VALUES
(1, 'Batas Wilayah Bali', 'Bali', 'layer/batas_kabupaten_bali.geojson', '2014', 'Batas Kabupaten', '#ff22c8', 'polyline', '', 1),
(5, 'administrasi prov. bali  coba', 'Bali', 'layer/linebali1414132558.geojson', '2014', 'contoh;contoh;contoh;contoh', '#ff0000;#000080;#004000;#0000a0', 'polyline', 'batas', 1),
(6, 'batas administrasi bali', 'Bali', 'layer/linebali1414132971.geojson', '2011', 'batas administrasi', '#80ffff', 'polyline', 'batas', 1),
(7, 'administrasi bali', 'Bali', 'layer/linebali1414133094.geojson', '2000', 'batas administrasi', '#80ff00', 'polyline', 'batas', 1),
(9, 'peta administrasi bali', 'Bali', 'layer/linebali1414133419.geojson', '1999', '', '#000000', 'polyline', 'latihan1', 1),
(10, 'peta administrasi bali', 'Bali', 'layer/linebali1414133469.geojson', '1999', '', '#ff0080', 'polyline', 'bali1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(9) NOT NULL,
  `hak_akses` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `hak_akses`, `username`, `password`) VALUES
(1, 'super admin', 'gungwah', 'bfdcdda7795a4719944c4cbe8fe7c5bc'),
(4, 'super admin', 'luthfi', 'ca31715fa10b8a13300f95973f7ee125'),
(5, 'super admin', 'ppebalinusra', '67f279c649eab8048a0f4a1d8c3f8a42'),
(6, 'super admin', 'mika', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category`);

--
-- Indexes for table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_marker_user` (`id_user`),
  ADD KEY `FK_marker` (`category`);

--
-- Indexes for table `polygon`
--
ALTER TABLE `polygon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_polygon` (`category`),
  ADD KEY `FK_polygon_user` (`id_user`);

--
-- Indexes for table `polyline`
--
ALTER TABLE `polyline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_polyline_user` (`id_user`),
  ADD KEY `FK_polyline` (`category`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marker`
--
ALTER TABLE `marker`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `polygon`
--
ALTER TABLE `polygon`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `polyline`
--
ALTER TABLE `polyline`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `FK_marker` FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_marker_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `polygon`
--
ALTER TABLE `polygon`
  ADD CONSTRAINT `FK_polygon` FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_polygon_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `polyline`
--
ALTER TABLE `polyline`
  ADD CONSTRAINT `FK_polyline` FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_polyline_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
