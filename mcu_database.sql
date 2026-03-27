-- ============================================================
--  MCU UNIVERSE DATABASE
--  Đồ án giữa kỳ — CodeIgniter 3 + MySQL
--  Import: phpMyAdmin > Import > chọn file này
-- ============================================================

CREATE DATABASE IF NOT EXISTS `mcu_database`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `mcu_database`;

-- ─────────────────────────────────────────────────────────────
--  BẢNG phases
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `phases` (
    `id`          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `phase_num`   TINYINT         NOT NULL COMMENT '1 – 6',
    `ten_phase`   VARCHAR(120)    NOT NULL,
    `saga`        VARCHAR(80)     NOT NULL COMMENT 'Infinity Saga / Multiverse Saga',
    `years`       VARCHAR(20)     NOT NULL COMMENT 'VD: 2008 – 2012',
    `mo_ta`       TEXT            NOT NULL,
    `film_count`  TINYINT         NOT NULL DEFAULT 0,
    `phase_hue`   SMALLINT        NOT NULL DEFAULT 0 COMMENT 'CSS hue cho accent color',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_phase_num` (`phase_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────
--  BẢNG movies
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `movies` (
    `id`          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `slug`        VARCHAR(100)    NOT NULL UNIQUE,
    `title`       VARCHAR(200)    NOT NULL,
    `year`        SMALLINT        NOT NULL,
    `duration`    VARCHAR(30)     NOT NULL COMMENT 'VD: 126 phút',
    `rating`      DECIMAL(3,1)    NOT NULL DEFAULT 0.0,
    `box_office`  VARCHAR(20)     NOT NULL DEFAULT '—',
    `director`    VARCHAR(150)    NOT NULL DEFAULT '—',
    `cast_list`   TEXT            NOT NULL,
    `description` TEXT            NOT NULL,
    `tagline`     VARCHAR(255)    NOT NULL DEFAULT '',
    `bg_color`    VARCHAR(10)     NOT NULL DEFAULT '#333333',
    `poster_url`  VARCHAR(500)    NOT NULL DEFAULT '',
    `type`        ENUM('movie','series','special') NOT NULL DEFAULT 'movie',
    `view_order`  SMALLINT        NOT NULL DEFAULT 0 COMMENT 'Thứ tự xem theo timeline',
    `phase_id`    INT UNSIGNED    NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_phase` (`phase_id`),
    KEY `idx_type`  (`type`),
    KEY `idx_order` (`view_order`),
    CONSTRAINT `fk_movie_phase`
        FOREIGN KEY (`phase_id`) REFERENCES `phases` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────
--  BẢNG characters
-- ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `characters` (
    `id`              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `slug`            VARCHAR(80)     NOT NULL UNIQUE,
    `name`            VARCHAR(100)    NOT NULL,
    `alter_ego`       VARCHAR(150)    NOT NULL DEFAULT '',
    `status`          ENUM('active','deceased','unknown','special')
                                      NOT NULL DEFAULT 'active',
    `status_label`    VARCHAR(80)     NOT NULL DEFAULT 'Đang hoạt động',
    `bg_color`        VARCHAR(10)     NOT NULL DEFAULT '#333333',
    `avatar_initials` VARCHAR(4)      NOT NULL DEFAULT '',
    `phase_1`         TINYINT(1)      NOT NULL DEFAULT 0,
    `phase_2`         TINYINT(1)      NOT NULL DEFAULT 0,
    `phase_3`         TINYINT(1)      NOT NULL DEFAULT 0,
    `phase_4`         TINYINT(1)      NOT NULL DEFAULT 0,
    `phase_5`         TINYINT(1)      NOT NULL DEFAULT 0,
    `phase_6`         TINYINT(1)      NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
--  SEED DATA
-- ============================================================

-- ─── phases ──────────────────────────────────────────────────
INSERT INTO `phases`
    (`phase_num`, `ten_phase`, `saga`, `years`, `mo_ta`, `film_count`, `phase_hue`)
VALUES
(1, 'The Beginning',      'Infinity Saga',   '2008 – 2012',
 'Khởi đầu vũ trụ với Iron Man, Thor, Hulk và cuộc hội tụ Avengers đầu tiên.', 6, 0),

(2, 'Expansion',          'Infinity Saga',   '2013 – 2015',
 'Mở rộng vũ trụ với Guardians of the Galaxy và những mối đe dọa mới.', 6, 20),

(3, 'The Infinity War',   'Infinity Saga',   '2016 – 2019',
 'Thanos — cuộc chiến Infinity War và Endgame thay đổi vũ trụ mãi mãi.', 11, 340),

(4, 'New World',          'Multiverse Saga', '2021 – 2022',
 'Hậu Endgame — multiverse mở ra, những anh hùng mới trỗi dậy.', 10, 200),

(5, 'The Kang Dynasty',   'Multiverse Saga', '2023 – 2024',
 'Kang the Conqueror và mối đe dọa xuyên thời gian.', 8, 260),

(6, 'Secret Wars',        'Multiverse Saga', '2025 – 2026',
 'Avengers: Secret Wars — cuộc hội tụ vĩ đại nhất lịch sử MCU.', 0, 170);

-- ─── movies ──────────────────────────────────────────────────
INSERT INTO `movies`
    (`slug`, `title`, `year`, `duration`, `rating`, `box_office`,
     `director`, `cast_list`, `description`, `tagline`,
     `bg_color`, `poster_url`, `type`, `view_order`, `phase_id`)
VALUES
-- Phase 1
('iron-man', 'Iron Man', 2008, '126 phút', 8.0, '$585M',
 'Jon Favreau',
 'Robert Downey Jr., Gwyneth Paltrow, Jeff Bridges, Terrence Howard',
 'Tony Stark, một thiên tài chế tạo vũ khí và tỷ phú tự kiêu, bị bắt cóc bởi tổ chức khủng bố và buộc phải chế tạo vũ khí hủy diệt. Thay vào đó, ông xây dựng một bộ giáp chiến đấu để thoát khỏi tù giam — và sau đó hoàn thiện nó thành Iron Man, khởi động vũ trụ MCU.',
 '"Genius. Billionaire. Playboy. Philanthropist."',
 '#C0392B', '', 'movie', 1,
 (SELECT id FROM phases WHERE phase_num = 1)),

('incredible-hulk', 'The Incredible Hulk', 2008, '112 phút', 6.7, '$264M',
 'Louis Leterrier',
 'Edward Norton, Liv Tyler, Tim Roth, William Hurt',
 'Bruce Banner lang thang khắp thế giới để tìm cách chữa khỏi tình trạng biến đổi thành Hulk khi cơn giận nổi lên. Trong khi đó, Tướng Thaddeus Ross truy đuổi anh để dùng khả năng đó cho quân đội.',
 '"This is not who I am."',
 '#27AE60', '', 'movie', 2,
 (SELECT id FROM phases WHERE phase_num = 1)),

('iron-man-2', 'Iron Man 2', 2010, '124 phút', 7.0, '$624M',
 'Jon Favreau',
 'Robert Downey Jr., Mickey Rourke, Gwyneth Paltrow, Don Cheadle, Scarlett Johansson',
 'Tony Stark tiết lộ danh tính là Iron Man với thế giới và phải đối mặt với sức ép từ chính phủ, đồng thời đương đầu với Ivan Vanko/Whiplash. Chất độc palladium trong lồng ngực từ từ giết chết anh.',
 '"I am Iron Man."',
 '#E74C3C', '', 'movie', 3,
 (SELECT id FROM phases WHERE phase_num = 1)),

('thor', 'Thor', 2011, '115 phút', 7.0, '$449M',
 'Kenneth Branagh',
 'Chris Hemsworth, Natalie Portman, Tom Hiddleston, Anthony Hopkins',
 'Thor bị trục xuất khỏi Asgard xuống Trái Đất vì sự kiêu ngạo của mình. Anh phải chứng minh bản thân xứng đáng cầm búa Mjolnir trong khi Loki âm mưu đoạt ngôi.',
 '"Whosoever holds this hammer, if he be worthy, shall possess the power of Thor."',
 '#1A5276', '', 'movie', 4,
 (SELECT id FROM phases WHERE phase_num = 1)),

('captain-america-first-avenger', 'Captain America: The First Avenger', 2011, '124 phút', 7.3, '$371M',
 'Joe Johnston',
 'Chris Evans, Hayley Atwell, Hugo Weaving, Tommy Lee Jones',
 'Steve Rogers — người lính nhỏ bé trở thành Super-Soldier, chiến đấu chống lại HYDRA và Red Skull trong Thế chiến II. Sau khi đánh bại Red Skull, anh hy sinh bằng cách lao máy bay xuống Bắc Băng Dương và thức dậy 70 năm sau.',
 '"Not a perfect soldier, but a good man."',
 '#154360', '', 'movie', 5,
 (SELECT id FROM phases WHERE phase_num = 1)),

('avengers', 'The Avengers', 2012, '143 phút', 8.0, '$1.520B',
 'Joss Whedon',
 'Robert Downey Jr., Chris Evans, Chris Hemsworth, Mark Ruffalo, Scarlett Johansson, Jeremy Renner',
 'Loki và Tesseract — Nick Fury triệu tập Iron Man, Cap, Thor, Hulk, Black Widow và Hawkeye. Đội hình Avengers đầu tiên hội tụ bảo vệ Trái Đất khỏi cuộc xâm lăng của Chitauri.',
 '"There was an idea..."',
 '#1A2980', '', 'movie', 6,
 (SELECT id FROM phases WHERE phase_num = 1)),

-- Phase 2
('iron-man-3', 'Iron Man 3', 2013, '130 phút', 7.1, '$1.215B',
 'Shane Black',
 'Robert Downey Jr., Gwyneth Paltrow, Ben Kingsley, Guy Pearce',
 'Sau sự kiện New York, Tony bị rối loạn tâm lý và phải đối mặt với Mandarin — kẻ thù bí ẩn nhất từ trước đến nay — và mầm bệnh Extremis đang đe dọa cả đất nước.',
 '"We make our own demons."',
 '#922B21', '', 'movie', 7,
 (SELECT id FROM phases WHERE phase_num = 2)),

('guardians-of-the-galaxy', 'Guardians of the Galaxy', 2014, '121 phút', 8.0, '$774M',
 'James Gunn',
 'Chris Pratt, Zoe Saldana, Dave Bautista, Vin Diesel, Bradley Cooper',
 'Peter Quill/Star-Lord cùng băng nhóm hỗn tạp — Groot, Rocket, Gamora, Drax — bảo vệ vũ trụ khỏi Ronan và Power Stone. Giới thiệu vũ trụ ngoài Trái Đất của MCU.',
 '"We are Groot."',
 '#6D4C8E', '', 'movie', 10,
 (SELECT id FROM phases WHERE phase_num = 2)),

('avengers-age-of-ultron', 'Avengers: Age of Ultron', 2015, '141 phút', 7.3, '$1.405B',
 'Joss Whedon',
 'Robert Downey Jr., Chris Evans, Chris Hemsworth, Mark Ruffalo, Elizabeth Olsen, Paul Bettany',
 'Tony Stark tạo ra AI Ultron để bảo vệ hòa bình — nhưng Ultron quyết định xóa sổ loài người. Scarlet Witch và Quicksilver xuất hiện. Vision ra đời từ Mind Stone.',
 '"There are no strings on me."',
 '#2C3E50', '', 'movie', 11,
 (SELECT id FROM phases WHERE phase_num = 2)),

-- Phase 3
('captain-america-civil-war', 'Captain America: Civil War', 2016, '147 phút', 7.8, '$1.153B',
 'Anthony Russo, Joe Russo',
 'Chris Evans, Robert Downey Jr., Tom Holland, Chadwick Boseman, Sebastian Stan',
 'Đạo luật Sokovia chia rẽ các Avengers. Team Iron Man vs Team Cap — Spider-Man lần đầu xuất hiện. Black Panther debut. Zemo thao túng tất cả.',
 '"United we stand, divided we fall."',
 '#2E4057', '', 'movie', 13,
 (SELECT id FROM phases WHERE phase_num = 3)),

('doctor-strange', 'Doctor Strange', 2016, '115 phút', 7.5, '$677M',
 'Scott Derrickson',
 'Benedict Cumberbatch, Tilda Swinton, Rachel McAdams, Chiwetel Ejiofor',
 'Bác sĩ Stephen Strange từ phẫu thuật thần kinh đến phép thuật — Eye of Agamotto (Time Stone) và Sorcerer Supreme. Giới thiệu thế giới thần bí của MCU.',
 '"Forget everything you think you know."',
 '#F39C12', '', 'movie', 14,
 (SELECT id FROM phases WHERE phase_num = 3)),

('black-panther', 'Black Panther', 2018, '134 phút', 7.3, '$1.347B',
 'Ryan Coogler',
 'Chadwick Boseman, Michael B. Jordan, Lupita Nyong''o, Danai Gurira',
 'T''Challa trở về Wakanda làm vua và đối mặt với Killmonger — câu chuyện về di sản, bản sắc và trách nhiệm. Wakanda Forever.',
 '"Wakanda Forever."',
 '#1A237E', '', 'movie', 18,
 (SELECT id FROM phases WHERE phase_num = 3)),

('avengers-infinity-war', 'Avengers: Infinity War', 2018, '149 phút', 8.4, '$2.048B',
 'Anthony Russo, Joe Russo',
 'Robert Downey Jr., Chris Evans, Chris Hemsworth, Josh Brolin, Benedict Cumberbatch',
 'Thanos thu thập 6 Infinity Stones. Toàn bộ MCU hội tụ nhưng Thanos thực hiện Snap — xóa sổ một nửa sinh linh vũ trụ.',
 '"The end is near."',
 '#4A235A', '', 'movie', 19,
 (SELECT id FROM phases WHERE phase_num = 3)),

('avengers-endgame', 'Avengers: Endgame', 2019, '181 phút', 8.4, '$2.798B',
 'Anthony Russo, Joe Russo',
 'Robert Downey Jr., Chris Evans, Chris Hemsworth, Scarlett Johansson, Mark Ruffalo',
 '5 năm sau Snap, các Avengers còn lại thực hiện Time Heist xuyên suốt multiverse để thu hồi các Infinity Stones. Trận chiến cuối cùng. "I am Iron Man."',
 '"Whatever it takes."',
 '#0D0D0D', '', 'movie', 22,
 (SELECT id FROM phases WHERE phase_num = 3)),

-- Phase 4
('wandavision', 'WandaVision', 2021, '9 tập', 7.9, 'Disney+',
 'Matt Shakman',
 'Elizabeth Olsen, Paul Bettany, Kathryn Hahn, Teyonah Parris',
 'Wanda tạo ra Hex — thực tế giả tạo mang phong cách sitcom qua các thập kỷ. Giới thiệu Scarlet Witch toàn năng và Monica Rambeau.',
 '"Who is doing this to you, Wanda?"',
 '#1E8449', '', 'series', 23,
 (SELECT id FROM phases WHERE phase_num = 4)),

('loki', 'Loki (Season 1 & 2)', 2021, '12 tập', 8.6, 'Disney+',
 'Kate Herron, Justin Benson',
 'Tom Hiddleston, Owen Wilson, Sophia Di Martino, Jonathan Majors',
 'TVA — Time Variance Authority. Loki khám phá Sacred Timeline và gặp Kang the Conqueror. Multiverse chính thức mở ra. He Who Remains.',
 '"I''m a Loki. I will always survive."',
 '#2471A3', '', 'series', 25,
 (SELECT id FROM phases WHERE phase_num = 4)),

('spider-man-no-way-home', 'Spider-Man: No Way Home', 2021, '148 phút', 8.2, '$1.901B',
 'Jon Watts',
 'Tom Holland, Zendaya, Benedict Cumberbatch, Willem Dafoe, Alfred Molina',
 'Doctor Strange mở multiverse — các phản diện và Spider-Man từ vũ trụ khác đổ bộ. Ba Peter Parker cùng chiến đấu. Tobey. Andrew. Tom.',
 '"With great power, there must also come great responsibility."',
 '#E74C3C', '', 'movie', 28,
 (SELECT id FROM phases WHERE phase_num = 4)),

-- Phase 5
('ant-man-quantumania', 'Ant-Man and the Wasp: Quantumania', 2023, '125 phút', 6.2, '$476M',
 'Peyton Reed',
 'Paul Rudd, Evangeline Lilly, Jonathan Majors, Michael Douglas',
 'Scott Lang bị kéo vào Quantum Realm và đối mặt với Kang the Conqueror — kẻ chinh phục thời gian đáng sợ nhất MCU.',
 '"How many more of you are there?"',
 '#1F618D', '', 'movie', 30,
 (SELECT id FROM phases WHERE phase_num = 5)),

('guardians-vol-3', 'Guardians of the Galaxy Vol. 3', 2023, '150 phút', 8.0, '$846M',
 'James Gunn',
 'Chris Pratt, Zoe Saldana, Bradley Cooper, Vin Diesel, Dave Bautista, Pom Klementieff',
 'Hành trình của Rocket — bí ẩn về quá khứ bi thảm với High Evolutionary. Lời chia tay đẫm nước mắt nhất của MCU với nhóm Guardians.',
 '"We''re still a family."',
 '#922B21', '', 'movie', 31,
 (SELECT id FROM phases WHERE phase_num = 5)),

('captain-america-brave-new-world', 'Captain America: Brave New World', 2025, '118 phút', 5.9, '$365M',
 'Julius Onah',
 'Anthony Mackie, Harrison Ford, Liv Tyler, Danny Ramirez',
 'Sam Wilson chính thức trở thành Captain America mới. Red Hulk xuất hiện. Câu chuyện quyền lực chính trị phức tạp.',
 '"The only power I have is that I believe we can do better."',
 '#1A5276', '', 'movie', 32,
 (SELECT id FROM phases WHERE phase_num = 5)),

-- Phase 6
('avengers-doomsday', 'Avengers: Doomsday', 2026, 'TBA', 0.0, 'TBA',
 'Anthony Russo, Joe Russo',
 'Robert Downey Jr., Chris Evans, Benedict Cumberbatch (TBC)',
 'Cuộc hội tụ chưa từng có trong lịch sử MCU. Doom, Kang, và toàn bộ các anh hùng của Multiverse Saga. Sắp ra mắt tháng 5/2026.',
 '"Doom is inevitable."',
 '#1a1a1a', '', 'movie', 33,
 (SELECT id FROM phases WHERE phase_num = 6));


-- ─── characters ──────────────────────────────────────────────
INSERT INTO `characters`
    (`slug`, `name`, `alter_ego`, `status`, `status_label`,
     `bg_color`, `avatar_initials`,
     `phase_1`, `phase_2`, `phase_3`, `phase_4`, `phase_5`, `phase_6`)
VALUES
('iron-man',         'Iron Man',        'Tony Stark',                'deceased', 'Đã hi sinh · Endgame',
 '#E23636', 'IM', 1, 1, 1, 0, 0, 0),

('captain-america',  'Captain America', 'Steve Rogers → Sam Wilson', 'active',   'Đang hoạt động',
 '#2E86C1', 'CA', 1, 1, 1, 1, 1, 0),

('thor',             'Thor Odinson',    'God of Thunder',            'active',   'Đang hoạt động',
 '#1A5276', 'TH', 1, 1, 1, 1, 1, 0),

('scarlet-witch',    'Scarlet Witch',   'Wanda Maximoff',            'unknown',  'Không xác định',
 '#922B21', 'SW', 0, 1, 1, 1, 0, 0),

('doctor-strange',   'Doctor Strange',  'Stephen Strange',           'active',   'Đang hoạt động',
 '#F39C12', 'DS', 0, 0, 1, 1, 1, 0),

('spider-man',       'Spider-Man',      'Peter Parker',              'active',   'Đang hoạt động',
 '#E74C3C', 'SP', 0, 0, 1, 1, 1, 1),

('loki',             'Loki',            'God of Mischief',           'special',  'God of Stories',
 '#1E8449', 'LK', 1, 1, 1, 1, 1, 0),

('thanos',           'Thanos',          'The Mad Titan',             'deceased', 'Đã bị tiêu diệt',
 '#6C3483', 'TN', 0, 1, 1, 0, 0, 0);
