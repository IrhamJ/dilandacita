-- Create Database
CREATE DATABASE DilandaCita2;
USE DilandaCita2;

-- Create Table



-- Membuat tabel m_role
CREATE TABLE m_role (
    id_role BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Membuat tabel m_kategori_user
CREATE TABLE m_kategori_user (
    id_kategori_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id BIGINT UNSIGNED NOT NULL,
    nama_kategori_user VARCHAR(50) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Foreign Key Constraint
    CONSTRAINT FK_m_kategori_user_role
        FOREIGN KEY (role_id) REFERENCES m_role(id_role)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE m_user (
    id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nik VARCHAR(20),
    no_kk VARCHAR(20),
    telepon VARCHAR(20),
    name VARCHAR(100),
    siak_user VARCHAR(255),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    pic VARCHAR(255),
    api_token VARCHAR(255),
    remember_token VARCHAR(100),
    verification_code VARCHAR(255),
    is_email_verified TINYINT,
    no_kec INT,
    no_kel INT,
    role_id BIGINT UNSIGNED NOT NULL,
    kategori_user_id BIGINT UNSIGNED,
    layanan_id VARCHAR(50),
    is_helpdesk INT,
    is_semeru INT,
    is_ketua_rw INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign Key Constraints
    CONSTRAINT FK_m_user_role
        FOREIGN KEY (role_id) REFERENCES m_role(id_role)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT FK_m_user_kategori
        FOREIGN KEY (kategori_user_id) REFERENCES m_kategori_user(id_kategori_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
-- Membuat tabel m_layanan
CREATE TABLE m_layanan (
    id_layanan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(100),
    path VARCHAR(100),
    url VARCHAR(100),
    keterangan TEXT,
    is_active INT,
    limit INT,
    is_active_limit_fo INT,
    limit_fo INT,
    redirect VARCHAR(255),
    status_redirect SMALLINT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Membuat tabel t_pengajuan
CREATE TABLE t_pengajuan (
    id_pengajuan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    layanan_id BIGINT UNSIGNED,
    nik VARCHAR(255),
    nomor_kk VARCHAR(255),
    tgl_pengajuan DATE,
    status_pengajuan VARCHAR(255),
    created_by BIGINT UNSIGNED,
    keterangan TEXT,
    nama_lgkp VARCHAR(191),
    id_petugas BIGINT UNSIGNED,
    pin VARCHAR(8),
    telepon VARCHAR(20),
    email VARCHAR(200),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    verified_by BIGINT UNSIGNED,
    verified_timestamp DATETIME,
    process_by BIGINT UNSIGNED,
    process_timestamp DATETIME,
    done_by BIGINT UNSIGNED,
    done_timestamp DATETIME,
    repaired_by BIGINT UNSIGNED,
    repaired_timestamp DATETIME,
    rejected_by BIGINT UNSIGNED,
    rejected_timestamp DATETIME,
    grab_by BIGINT UNSIGNED,
    grab_timestamp DATETIME,
    cetak_biodata_by BIGINT UNSIGNED,
    cetak_biodata_timestamp DATETIME,
    menunggu_by BIGINT UNSIGNED,
    menunggu_timestamp DATETIME,
    status_klaim VARCHAR(25),
    claim_timestamp DATETIME,
    claim_done_timestamp DATETIME,
    claim_notes VARCHAR(500),
    claim_done_by BIGINT UNSIGNED,
    claim_reject_timestamp DATETIME,
    claim_reject_by BIGINT UNSIGNED,
    claim_reject_notes VARCHAR(500),
    alasan_pengajuan VARCHAR(255),
    dokumen TEXT,
    layanan_id_parent BIGINT UNSIGNED,
    pengajuan_id_parent BIGINT UNSIGNED,
    nik_pemohon_lain VARCHAR(255),
    nama_pemohon_lain VARCHAR(255),
    dokumen_pemohon_lain TEXT,
    is_surat_kuasa INT,

    -- Foreign Key Constraints
    CONSTRAINT FK_t_pengajuan_layanan_id
        FOREIGN KEY (layanan_id) 
        REFERENCES m_layanan(id_layanan)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_created_by
        FOREIGN KEY (created_by) 
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_id_petugas
        FOREIGN KEY (id_petugas)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_verified_by
        FOREIGN KEY (verified_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_process_by
        FOREIGN KEY (process_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_done_by
        FOREIGN KEY (done_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_repaired_by
        FOREIGN KEY (repaired_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_rejected_by
        FOREIGN KEY (rejected_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_grab_by
        FOREIGN KEY (grab_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_cetak_biodata_by
        FOREIGN KEY (cetak_biodata_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_menunggu_by
        FOREIGN KEY (menunggu_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_claim_done_by
        FOREIGN KEY (claim_done_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT FK_t_pengajuan_claim_reject_by
        FOREIGN KEY (claim_reject_by)
        REFERENCES m_user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Membuat tabel t_syarat_ajuan_layanan
CREATE TABLE t_syarat_ajuan_layanan (
    id_syarat_ajuan_layan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id BIGINT UNSIGNED,
    nik VARCHAR(20),
    img_1 VARCHAR(255),
    img_thumb_1 VARCHAR(255),
    img_2 VARCHAR(255),
    img_thumb_2 VARCHAR(255),
    img_3 VARCHAR(255),
    img_thumb_3 VARCHAR(255),
    img_4 VARCHAR(255),
    img_thumb_4 VARCHAR(255),
    img_5 VARCHAR(255),
    img_thumb_5 VARCHAR(255),
    img_6 VARCHAR(255),
    img_thumb_6 VARCHAR(255),
    img_7 VARCHAR(255),
    img_thumb_7 VARCHAR(255),
    img_8 VARCHAR(255),
    img_thumb_8 VARCHAR(255),
    img_9 VARCHAR(255),
    img_thumb_9 VARCHAR(255),
    img_10 VARCHAR(255),
    img_thumb_10 VARCHAR(255),
    img_11 VARCHAR(255),
    img_thumb_11 VARCHAR(255),
    img_12 VARCHAR(255),
    img_thumb_12 VARCHAR(255),
    img_13 VARCHAR(255),
    img_thumb_13 VARCHAR(255),
    img_14 VARCHAR(255),
    img_thumb_14 VARCHAR(255),
    img_15 VARCHAR(255),
    img_thumb_15 VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Foreign Key Constraint
    CONSTRAINT FK_t_syarat_ajuan_layanan_pengajuan
        FOREIGN KEY (pengajuan_id)
        REFERENCES t_pengajuan(id_pengajuan)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Membuat tabel Pengajuan_Cetak_KTP
CREATE TABLE Pengajuan_Cetak_KTP (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    provinsi INT,
    kabkota INT,
    kecamatan INT,
    kelurahan INT,
    pengajuan_id BIGINT UNSIGNED,
    nik_pengajuan VARCHAR(16),
    nama_lengkap_pengajuan VARCHAR(255),
    alasan_pengajuan VARCHAR(255),
    keterangan TEXT,

    -- Foreign Key Constraint
    CONSTRAINT FK_Pengajuan_Cetak_KTP_pengajuan
        FOREIGN KEY (pengajuan_id)
        REFERENCES t_pengajuan(id_pengajuan)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Membuat tabel Pengajuan_Akta_Kelahiran
CREATE TABLE Pengajuan_Akta_Kelahiran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id BIGINT UNSIGNED,
    provinsi INT,
    kabkota INT,
    kecamatan INT,
    kelurahan INT,
    nik_saksi_1 VARCHAR(16),
    nama_lgkp_saksi_1 VARCHAR(191),
    no_kk_saksi_1 VARCHAR(16),
    kwrngrn_saksi_1 VARCHAR(5),
    nik_saksi_2 VARCHAR(16),
    nama_lgkp_saksi_2 VARCHAR(191),
    no_kk_saksi_2 VARCHAR(16),
    kwrngrn_saksi_2 VARCHAR(5),
    nik_ayah VARCHAR(16),
    nama_lgkp_ayah VARCHAR(191),
    tmpt_lhr_ayah VARCHAR(191),
    tgl_lhr_ayah DATE,
    kwrngrn_ayah INT,
    nik_ibu VARCHAR(16),
    nama_lgkp_ibu VARCHAR(191),
    tmpt_lhr_ibu VARCHAR(191),
    tgl_lhr_ibu DATE,
    kwrngrn_ibu INT,
    nik_anak VARCHAR(16),
    nama_lgkp_anak VARCHAR(191),
    tempat_dilahirkan_anak VARCHAR(191),
    tempat_kelahirkan_anak VARCHAR(191),
    tgl_kelahiran_anak DATE,
    jenis_kelamin_anak INT,
    hari INT,
    waktu_kelahiran TIME,
    jenis_kelahiran INT,
    kelahiran_ke INT,
    penolong_klhrn INT,
    berat_anak VARCHAR(10),
    panjang_anak VARCHAR(10),
    keterangan TEXT,

    -- Foreign Key Constraint
    CONSTRAINT FK_Pengajuan_Akta_Kelahiran_pengajuan
        FOREIGN KEY (pengajuan_id)
        REFERENCES t_pengajuan(id_pengajuan)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

