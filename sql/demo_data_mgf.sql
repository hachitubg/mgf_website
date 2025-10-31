-- =====================================================
-- MGF DEMO DATA - CÔNG TY CỔ PHẦN NÔNG NGHIỆP CÔNG NGHỆ CAO MGF
-- Dữ liệu demo cho sản phẩm thức ăn chăn nuôi và tin tức
-- =====================================================

-- Set character set to UTF-8
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET character_set_connection=utf8mb4;

-- =====================================================
-- XÓA DỮ LIỆU CŨ (nếu có)
-- =====================================================
-- Xóa theo thứ tự để tránh lỗi foreign key
DELETE FROM `product_images` WHERE 1=1;
DELETE FROM `products` WHERE 1=1;
DELETE FROM `posts` WHERE 1=1;
DELETE FROM `banners` WHERE 1=1;
DELETE FROM `categories` WHERE 1=1;

-- Reset auto increment
ALTER TABLE `categories` AUTO_INCREMENT = 1;
ALTER TABLE `products` AUTO_INCREMENT = 1;
ALTER TABLE `posts` AUTO_INCREMENT = 1;
ALTER TABLE `banners` AUTO_INCREMENT = 1;
ALTER TABLE `product_images` AUTO_INCREMENT = 1;

-- =====================================================
-- 1. DANH MỤC SẢN PHẨM (Product Categories)
-- =====================================================
INSERT INTO `categories` (`name`, `slug`, `type`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('Thức ăn chăn nuôi Heo', 'thuc-an-chan-nuoi-heo', 'product', 'Dòng sản phẩm thức ăn chăn nuôi heo chất lượng cao với công thức dinh dưỡng tối ưu', 1, 1, NOW(), NOW()),
('Thức ăn chăn nuôi Gà', 'thuc-an-chan-nuoi-ga', 'product', 'Sản phẩm thức ăn chăn nuôi gà đạt chuẩn chất lượng quốc tế', 1, 2, NOW(), NOW()),
('Thức ăn chăn nuôi Vịt', 'thuc-an-chan-nuoi-vit', 'product', 'Thức ăn chăn nuôi vịt với công thức đặc biệt phù hợp điều kiện Việt Nam', 1, 3, NOW(), NOW()),
('Thức ăn chăn nuôi Cá', 'thuc-an-chan-nuoi-ca', 'product', 'Thức ăn cho cá da trơn, cá có vảy và ếch', 1, 4, NOW(), NOW()),
('Thức ăn chăn nuôi Bò', 'thuc-an-chan-nuoi-bo', 'product', 'Thức ăn chăn nuôi bò sữa và bò thịt chất lượng cao', 1, 5, NOW(), NOW()),
('Thức ăn chăn nuôi Chim bồ câu', 'thuc-an-chan-nuoi-chim-bo-cau', 'product', 'Thức ăn chuyên dụng cho chim bồ câu', 1, 6, NOW(), NOW());

-- =====================================================
-- 2. SẢN PHẨM DEMO (Products)
-- =====================================================

-- Sản phẩm HEO
INSERT INTO `products` (`title`, `slug`, `category_id`, `description`, `price`, `promo_price`, `display_order`, `created_at`, `updated_at`) VALUES
('MGF M11S - Thức ăn heo con giai đoạn 1', 'mgf-m11s-thuc-an-heo-con-giai-doan-1', 1, '<h3>Đặc điểm sản phẩm MGF M11S</h3><p>Thức ăn heo con MGF M11S được nghiên cứu và phát triển đặc biệt cho giai đoạn từ 7-20kg - giai đoạn quan trọng nhất trong quá trình phát triển của heo con.</p><h4>Thành phần dinh dưỡng:</h4><ul><li>Protein: 18-20%</li><li>Năng lượng trao đổi: 3200-3400 kcal/kg</li><li>Lysine: 1.2-1.4%</li><li>Canxi, Phospho cân bằng</li><li>Vitamin và khoáng chất vi lượng đầy đủ</li></ul><h4>Lợi ích:</h4><ul><li>Tăng trọng nhanh, đồng đều</li><li>Tăng cường miễn dịch</li><li>Giảm tỷ lệ tiêu chảy</li><li>Chi phí thức ăn tối ưu</li></ul>', 18500.00, 17500.00, 1, NOW(), NOW()),

('MGF M12S - Thức ăn heo con giai đoạn 2', 'mgf-m12s-thuc-an-heo-con-giai-doan-2', 1, '<h3>MGF M12S - Giai đoạn phát triển quan trọng</h3><p>Sản phẩm được thiết kế cho heo giai đoạn 20-40kg với công thức dinh dưỡng cân bằng, giúp heo phát triển khung xương và cơ bắp tối ưu.</p><h4>Ưu điểm:</h4><ul><li>Hỗ trợ tăng trưởng vượt trội</li><li>Tăng cường sức khỏe đường ruột</li><li>Cải thiện hệ miễn dịch</li><li>FCR tối ưu</li></ul>', 17500.00, NULL, 2, NOW(), NOW()),

('MGF M15S - Thức ăn heo thịt giai đoạn 1', 'mgf-m15s-thuc-an-heo-thit-giai-doan-1', 1, '<h3>MGF M15S - Thức ăn heo thịt chất lượng</h3><p>Công thức đặc biệt cho giai đoạn heo thịt 40-70kg, giúp tăng trọng nhanh với chi phí thấp.</p><h4>Đối tượng:</h4><ul><li>Heo thịt từ 40-70kg</li><li>Tối ưu chi phí chăn nuôi</li><li>Tăng trọng ổn định</li></ul>', 16500.00, NULL, 3, NOW(), NOW()),

('MGF M16S - Thức ăn heo thịt giai đoạn 2', 'mgf-m16s-thuc-an-heo-thit-giai-doan-2', 1, '<h3>MGF M16S - Giai đoạn hoàn thiện</h3><p>Sản phẩm cho heo giai đoạn 70-90kg, giúp tăng tỷ lệ nạc, giảm mỡ, cải thiện chất lượng thịt.</p><h4>Ưu điểm:</h4><ul><li>Tối ưu hóa tỷ lệ nạc</li><li>Giảm lượng mỡ</li><li>Chất lượng thịt cao</li></ul>', 15800.00, 14900.00, 4, NOW(), NOW()),

('MGF M17S - Thức ăn heo thịt giai đoạn 3', 'mgf-m17s-thuc-an-heo-thit-giai-doan-3', 1, '<h3>MGF M17S - Hoàn thiện trước xuất chuồng</h3><p>Công thức cuối cùng trước khi xuất chuồng, đảm bảo chất lượng thịt tốt nhất.</p><h4>Đặc điểm:</h4><ul><li>Heo từ 90kg đến xuất chuồng</li><li>Hoàn thiện chất lượng thịt</li><li>Tối ưu lợi nhuận</li></ul>', 15200.00, NULL, 5, NOW(), NOW()),

-- Sản phẩm GÀ
('MGF G10S - Thức ăn gà thịt giai đoạn 1', 'mgf-g10s-thuc-an-ga-thit-giai-doan-1', 2, '<h3>MGF G10S - Khởi đầu vững chắc</h3><p>Thức ăn gà thịt giai đoạn đầu với công thức đặc biệt, giúp gà con khỏe mạnh ngay từ những ngày đầu.</p><h4>Thành phần:</h4><ul><li>Protein cao: 22-24%</li><li>Năng lượng: 3000-3100 kcal/kg</li><li>Vitamin, khoáng chất đầy đủ</li><li>Men vi sinh hỗ trợ tiêu hóa</li></ul><h4>Đối tượng:</h4><ul><li>Gà thịt 1-10 ngày tuổi</li><li>Giúp gà khởi đầu tốt</li></ul>', 19800.00, 18500.00, 6, NOW(), NOW()),

('MGF G20S - Thức ăn gà thịt giai đoạn 2', 'mgf-g20s-thuc-an-ga-thit-giai-doan-2', 2, '<h3>MGF G20S - Giai đoạn tăng trưởng</h3><p>Sản phẩm cho gà giai đoạn phát triển nhanh, tối ưu hóa tăng trọng.</p><h4>Ưu điểm:</h4><ul><li>Gà 11-25 ngày tuổi</li><li>Tăng trưởng vượt trội</li><li>FCR tối ưu</li></ul>', 18200.00, NULL, 7, NOW(), NOW()),

('MGF G30S - Thức ăn gà thịt giai đoạn 3', 'mgf-g30s-thuc-an-ga-thit-giai-doan-3', 2, '<h3>MGF G30S - Hoàn thiện chất lượng</h3><p>Công thức cuối cùng giúp gà đạt trọng lượng xuất chuồng với chất lượng thịt tốt nhất.</p><h4>Đặc điểm:</h4><ul><li>Gà từ 26 ngày đến xuất chuồng</li><li>Chất lượng thịt cao</li><li>Trọng lượng đồng đều</li></ul>', 17500.00, NULL, 8, NOW(), NOW()),

-- Sản phẩm VỊT
('MGF D01 Super - Thức ăn vịt thịt giai đoạn 1', 'mgf-d01-super-thuc-an-vit-thit-giai-doan-1', 3, '<h3>MGF D01 Super - Vịt khỏe từ đầu</h3><p>Thức ăn vịt con với công thức Super đặc biệt, giúp vịt phát triển nhanh và khỏe mạnh.</p><h4>Ưu điểm nổi bật:</h4><ul><li>Protein cao 20-22%</li><li>Tăng trọng nhanh</li><li>Giảm tỷ lệ chết</li><li>Tối ưu chi phí</li></ul><h4>Đối tượng:</h4><ul><li>Vịt thịt 1-14 ngày tuổi</li></ul>', 17800.00, 16500.00, 9, NOW(), NOW()),

('MGF D02 Super - Thức ăn vịt thịt giai đoạn 2', 'mgf-d02-super-thuc-an-vit-thit-giai-doan-2', 3, '<h3>MGF D02 Super - Phát triển tối đa</h3><p>Sản phẩm cho vịt giai đoạn phát triển và hoàn thiện, đảm bảo chất lượng thịt.</p><h4>Ưu điểm:</h4><ul><li>Vịt từ 15 ngày đến xuất chuồng</li><li>Tăng trọng mạnh</li><li>Chất lượng thịt tốt</li></ul>', 16200.00, NULL, 10, NOW(), NOW()),

-- Sản phẩm CÁ
('MGF Fish Pro - Thức ăn cá da trơn', 'mgf-fish-pro-thuc-an-ca-da-tron', 4, '<h3>MGF Fish Pro - Dòng cá da trơn</h3><p>Thức ăn chuyên dụng cho cá da trơn với công thức đặc biệt, giúp cá phát triển nhanh, khỏe mạnh.</p><h4>Đối tượng:</h4><ul><li>Cá da trơn (cá tra, cá basa)</li><li>Phát triển nhanh</li><li>Chất lượng thịt tốt</li></ul>', 14500.00, NULL, 11, NOW(), NOW()),

('MGF Fish Scale - Thức ăn cá có vảy', 'mgf-fish-scale-thuc-an-ca-co-vay', 4, '<h3>MGF Fish Scale - Dòng cá có vảy</h3><p>Sản phẩm chuyên dụng cho các loại cá có vảy và ếch nuôi thương phẩm.</p><h4>Đối tượng:</h4><ul><li>Cá có vảy</li><li>Ếch nuôi thương phẩm</li><li>Tăng trọng ổn định</li></ul>', 15200.00, 14200.00, 12, NOW(), NOW()),

-- Sản phẩm BÒ
('MGF Dairy Cow - Thức ăn bò sữa', 'mgf-dairy-cow-thuc-an-bo-sua', 5, '<h3>MGF Dairy Cow - Tăng năng suất sữa</h3><p>Công thức đặc biệt cho bò sữa, giúp tăng năng suất và chất lượng sữa.</p><h4>Lợi ích:</h4><ul><li>Tăng năng suất sữa 10-15%</li><li>Cải thiện chất lượng sữa</li><li>Tăng cường sức khỏe bò</li><li>Hỗ trợ sinh sản</li></ul>', 12500.00, NULL, 13, NOW(), NOW()),

('MGF Beef Cattle - Thức ăn bò thịt', 'mgf-beef-cattle-thuc-an-bo-thit', 5, '<h3>MGF Beef Cattle - Bò thịt chất lượng</h3><p>Sản phẩm cho bò thịt, giúp tăng trọng nhanh với chi phí hợp lý.</p><h4>Ưu điểm:</h4><ul><li>Tăng trọng tối ưu</li><li>Chi phí hợp lý</li><li>Chất lượng thịt cao</li></ul>', 11800.00, 10900.00, 14, NOW(), NOW()),

-- Sản phẩm CHIM BỒ CÂU
('MGF Pigeon Pro - Thức ăn chim bồ câu', 'mgf-pigeon-pro-thuc-an-chim-bo-cau', 6, '<h3>MGF Pigeon Pro - Chuyên nghiệp</h3><p>Thức ăn chuyên dụng cho chim bồ câu với công thức đặc biệt, đảm bảo chất lượng thịt cao.</p><h4>Đặc điểm:</h4><ul><li>Chim bồ câu thịt</li><li>Công thức đặc biệt</li><li>Chất lượng thịt cao</li></ul>', 22500.00, 20500.00, 15, NOW(), NOW());

-- =====================================================
-- 3. DANH MỤC TIN TỨC (Post Categories)
-- =====================================================
INSERT INTO `categories` (`name`, `slug`, `type`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('Tin tức công ty', 'tin-tuc-cong-ty', 'post', 'Tin tức và hoạt động của MGF', 1, 1, NOW(), NOW()),
('Sự kiện', 'su-kien', 'post', 'Các sự kiện, hội thảo, triển lãm', 1, 2, NOW(), NOW()),
('Nghiên cứu & Phát triển', 'nghien-cuu-phat-trien', 'post', 'Nghiên cứu khoa học và phát triển sản phẩm', 1, 3, NOW(), NOW()),
('Kiến thức chăn nuôi', 'kien-thuc-chan-nuoi', 'post', 'Kiến thức và kinh nghiệm chăn nuôi', 1, 4, NOW(), NOW()),
('Thành tựu nổi bật', 'thanh-tuu-noi-bat', 'post', 'Các thành tựu và giải thưởng của MGF', 1, 5, NOW(), NOW());

-- =====================================================
-- 4. BÀI VIẾT DEMO (Posts)
-- =====================================================
INSERT INTO `posts` (`title`, `slug`, `category_id`, `excerpt`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
('MGF khởi công nhà máy thức ăn chăn nuôi công suất 200,000 tấn/năm tại Hải Dương', 'mgf-khoi-cong-nha-may-thuc-an-chan-nuoi-hai-duong', 7, 'Ngày 15/10/2025, MGF chính thức khởi công xây dựng nhà máy thức ăn chăn nuôi hiện đại tại Khu Công nghiệp Hải Dương với tổng mức đầu tư hơn 500 tỷ đồng.', '<h2>Dự án nhà máy thức ăn chăn nuôi công nghệ cao</h2><p>Với tổng diện tích hơn 10 hecta, nhà máy được trang bị dây chuyên sản xuất hiện đại từ châu Âu, đạt công suất 200,000 tấn thức ăn chăn nuôi mỗi năm.</p><h3>Điểm nổi bật của dự án:</h3><ul><li>Công nghệ sản xuất tiên tiến từ châu Âu</li><li>Hệ thống kiểm soát chất lượng tự động</li><li>Đáp ứng các tiêu chuẩn quốc tế: ISO 9001, HACCP, GMP</li><li>Thân thiện với môi trường</li></ul><p>Dự kiến nhà máy sẽ đi vào hoạt động vào quý 2/2026, tạo việc làm cho hơn 200 lao động địa phương.</p>', 1, NOW(), NOW()),

('MGF ký kết hợp tác chiến lược với tập đoàn chăn nuôi hàng đầu Việt Nam', 'mgf-ky-ket-hop-tac-chien-luoc', 7, 'MGF và Tập đoàn Chăn nuôi XYZ vừa ký kết thỏa thuận hợp tác chiến lược, mở ra cơ hội phát triển bền vững trong ngành chăn nuôi.', '<h2>Hợp tác chiến lược mở ra kỷ nguyên mới</h2><p>Buổi lễ ký kết được tổ chức trọng thể với sự tham gia của đại diện lãnh đạo cấp cao hai bên.</p><h3>Nội dung hợp tác:</h3><ul><li>Cung cấp thức ăn chăn nuôi chất lượng cao</li><li>Hỗ trợ kỹ thuật chăn nuôi</li><li>Nghiên cứu phát triển sản phẩm mới</li><li>Xây dựng chuỗi giá trị bền vững</li></ul><p>Thỏa thuận hợp tác này được kỳ vọng sẽ mang lại lợi ích cho cả hai bên và góp phần phát triển ngành chăn nuôi Việt Nam.</p>', 1, NOW(), NOW()),

('Hội thảo "Giải pháp dinh dưỡng tối ưu cho chăn nuôi heo" thành công rực rở', 'hoi-thao-giai-phap-dinh-duong-chan-nuoi-heo', 8, 'Hơn 300 chủ trang trại đã tham dự hội thảo do MGF tổ chức, chia sẻ kiến thức và kinh nghiệm về dinh dưỡng trong chăn nuôi heo.', '<h2>Hội thảo thu hút đông đảo người chăn nuôi</h2><p>Ngày 20/10/2025, MGF đã tổ chức thành công Hội thảo "Giải pháp dinh dưỡng tối ưu cho chăn nuôi heo" tại Hà Nội.</p><h3>Nội dung hội thảo:</h3><ul><li>Xu hướng dinh dưỡng hiện đại trong chăn nuôi heo</li><li>Giải pháp tối ưu chi phí thức ăn</li><li>Quản lý dịch bệnh trong chăn nuôi</li><li>Chia sẻ mô hình chăn nuôi thành công</li></ul><p>Các chuyên gia hàng đầu trong ngành đã chia sẻ những kiến thức quý báu, giúp người chăn nuôi nâng cao hiệu quả sản xuất.</p>', 1, NOW(), NOW()),

('MGF công bố công thức thức ăn mới cho gà thịt tăng trọng vượt trội', 'mgf-cong-bo-cong-thuc-thuc-an-moi-ga-thit', 9, 'Sau 2 năm nghiên cứu, MGF chính thức ra mắt công thức thức ăn gà thịt thế hệ mới với hiệu quả tăng trọng vượt trội 15%.', '<h2>Đột phá trong dinh dưỡng gà thịt</h2><p>Công thức mới của MGF được nghiên cứu và phát triển bởi đội ngũ chuyên gia giàu kinh nghiệm, kết hợp với công nghệ hiện đại.</p><h3>Ưu điểm vượt trội:</h3><ul><li>Tăng trọng nhanh hơn 15% so với công thức truyền thống</li><li>FCR cải thiện 10%</li><li>Tỷ lệ chết giảm 20%</li><li>Chất lượng thịt tốt hơn</li></ul><h3>Thử nghiệm thực tế:</h3><p>Công thức đã được thử nghiệm tại hơn 50 trang trại trên toàn quốc với kết quả đáng khích lệ. Người chăn nuôi ghi nhận sự khác biệt rõ rệt về tốc độ tăng trọng và sức khỏe đàn gà.</p>', 1, NOW(), NOW()),

('Bí quyết chăn nuôi heo đạt hiệu quả cao trong mùa dịch', 'bi-quyet-chan-nuoi-heo-hieu-qua-cao', 10, 'MGF chia sẻ những bí quyết giúp người chăn nuôi duy trì hiệu quả sản xuất trong bối cảnh dịch bệnh diễn biến phức tạp.', '<h2>Quản lý chăn nuôi heo hiệu quả</h2><p>Trong bối cảnh dịch bệnh trên đàn heo diễn biến phức tạp, việc áp dụng các biện pháp quản lý đúng đắn là vô cùng quan trọng.</p><h3>5 nguyên tắc vàng:</h3><ol><li><strong>Vệ sinh môi trường:</strong> Thường xuyên vệ sinh, khử trùng chuồng trại</li><li><strong>Kiểm soát nguồn giống:</strong> Chỉ mua giống từ nguồn uy tín</li><li><strong>Dinh dưỡng đầy đủ:</strong> Sử dụng thức ăn chất lượng cao</li><li><strong>Theo dõi sức khỏe:</strong> Giám sát hàng ngày, phát hiện sớm bệnh</li><li><strong>Tiêm phòng đầy đủ:</strong> Tuân thủ lịch tiêm phòng khoa học</li></ol><h3>Lời khuyên từ chuyên gia:</h3><p>"Đầu tư vào thức ăn chất lượng cao và quản lý tốt sẽ giúp giảm thiểu rủi ro và tăng hiệu quả chăn nuôi" - Ông Nguyễn Văn A, Chuyên gia MGF.</p>', 1, NOW(), NOW()),

('MGF đạt chứng nhận ISO 9001:2015 và HACCP', 'mgf-dat-chung-nhan-iso-9001-haccp', 11, 'MGF vinh dự nhận chứng nhận ISO 9001:2015 và HACCP, khẳng định cam kết về chất lượng sản phẩm và an toàn thực phẩm.', '<h2>Thành tựu về chất lượng</h2><p>Đây là minh chứng cho nỗ lực không ngừng của MGF trong việc nâng cao chất lượng sản phẩm và dịch vụ.</p><h3>Ý nghĩa của chứng nhận:</h3><ul><li>Đảm bảo quy trình sản xuất đạt tiêu chuẩn quốc tế</li><li>Cam kết về an toàn thực phẩm</li><li>Tăng cường niềm tin của khách hàng</li><li>Mở rộng thị trường xuất khẩu</li></ul><p>MGF sẽ tiếp tục nỗ lực để duy trì và phát triển hệ thống quản lý chất lượng, mang đến những sản phẩm tốt nhất cho khách hàng.</p>', 1, NOW(), NOW()),

('Kỹ thuật chăn nuôi vịt thịt theo tiêu chuẩn VietGAP', 'ky-thuat-chan-nuoi-vit-thit-vietgap', 10, 'Hướng dẫn chi tiết quy trình chăn nuôi vịt thịt theo tiêu chuẩn VietGAP, đảm bảo an toàn và hiệu quả.', '<h2>Quy trình chăn nuôi vịt chuẩn VietGAP</h2><p>VietGAP là tiêu chuẩn thực hành nông nghiệp tốt, giúp nâng cao chất lượng sản phẩm và bảo vệ môi trường.</p><h3>Các bước chính:</h3><ol><li>Chuẩn bị chuồng trại đạt tiêu chuẩn</li><li>Chọn giống vịt chất lượng</li><li>Sử dụng thức ăn đạt chuẩn (MGF D01 Super, D02 Super)</li><li>Quản lý môi trường và vệ sinh</li><li>Ghi chép nhật ký chăn nuôi đầy đủ</li></ol><p>MGF cung cấp giải pháp dinh dưỡng toàn diện cho chăn nuôi vịt theo tiêu chuẩn VietGAP.</p>', 1, NOW(), NOW()),

('MGF tham gia triển lãm Nông nghiệp Quốc tế VietnamAg 2025', 'mgf-tham-gia-trien-lam-vietnamag-2025', 8, 'MGF góp mặt tại triển lãm Nông nghiệp Quốc tế VietnamAg 2025, giới thiệu các sản phẩm và công nghệ tiên tiến.', '<h2>MGF tại VietnamAg 2025</h2><p>Với gian hàng rộng 200m², MGF đã thu hút sự quan tâm của hàng nghìn khách tham quan.</p><h3>Điểm nhấn tại triển lãm:</h3><ul><li>Trưng bày toàn bộ dòng sản phẩm thức ăn chăn nuôi</li><li>Tư vấn kỹ thuật miễn phí</li><li>Chương trình ưu đãi đặc biệt</li><li>Hội thảo chuyên đề về dinh dưỡng chăn nuôi</li></ul><p>Triển lãm là cơ hội để MGF gặp gỡ, trao đổi với khách hàng và đối tác, đồng thời giới thiệu những sản phẩm mới nhất.</p>', 1, NOW(), NOW());

-- =====================================================
-- 5. BANNERS
-- =====================================================
INSERT INTO `banners` (`title`, `location_code`, `image_path`, `link_url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('Banner Trang chủ - Feed Farm Food', 'trang_chu', 'https://via.placeholder.com/1920x600/0C7A07/FFFFFF?text=MGF+Feed+Farm+Food', 'trang-chu.php', 1, 1, NOW(), NOW()),
('Banner Sản phẩm chất lượng cao', 'trang_chu', 'https://via.placeholder.com/1920x600/06B841/FFFFFF?text=San+pham+chat+luong+cao', 'danh-sach-san-pham.php', 1, 2, NOW(), NOW()),
('Banner Danh sách sản phẩm', 'danh_sach_san_pham', 'https://via.placeholder.com/1920x400/0C7A07/FFFFFF?text=Danh+sach+san+pham+MGF', 'danh-sach-san-pham.php', 1, 1, NOW(), NOW()),
('Banner Tin tức & Sự kiện', 'danh_sach_tin_tuc', 'https://via.placeholder.com/1920x400/095505/FFFFFF?text=Tin+tuc+va+Su+kien', 'danh-sach-tin-tuc.php', 1, 1, NOW(), NOW());

-- =====================================================
-- END OF DEMO DATA
-- =====================================================

-- Thống kê
SELECT 'DEMO DATA INSERTED SUCCESSFULLY!' as status;
SELECT COUNT(*) as total_categories FROM categories;
SELECT COUNT(*) as total_products FROM products;
SELECT COUNT(*) as total_posts FROM posts;
SELECT COUNT(*) as total_banners FROM banners;
