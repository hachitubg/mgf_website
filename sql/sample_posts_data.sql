-- Sample data for posts and categories
-- Chạy file này sau khi đã chạy schema.sql

USE mgf_website;

-- Thêm danh mục tin tức (nếu chưa có)
INSERT INTO categories (name, slug, type, description, sort_order, is_active) VALUES
('Thông cáo báo chí', 'thong-cao-bao-chi', 'post', 'Các thông cáo báo chí chính thức', 1, 1),
('Tin tức & Sự kiện', 'tin-tuc-su-kien', 'post', 'Tin tức và sự kiện của công ty', 2, 1),
('Thư viện', 'thu-vien', 'post', 'Hình ảnh và video', 3, 1),
('Hoạt động', 'hoat-dong', 'post', 'Các hoạt động của công ty', 4, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Lấy ID của các danh mục (giả sử ID tự động)
-- Bạn có thể kiểm tra ID thực tế bằng: SELECT * FROM categories WHERE type='post';

-- Thêm bài viết mẫu
INSERT INTO posts (category_id, title, slug, excerpt, content, featured_image, is_active, created_at) VALUES
(
    (SELECT id FROM categories WHERE slug='tin-tuc-su-kien' AND type='post' LIMIT 1),
    'KÊ PHI – TRỨNG GÀ CHUẨN NHÂN ĐẠO HFAC TẠI VIỆT NAM',
    'ke-phi-trung-ga-chuan-nhan-dao-hfac-tai-viet-nam',
    'Kê Phi - Thương hiệu trứng gà đạt chuẩn nhân đạo HFAC đầu tiên tại Việt Nam',
    '<h2>Giới thiệu về Kê Phi</h2>
    <p>Kê Phi là thương hiệu trứng gà được nuôi theo tiêu chuẩn nhân đạo cao nhất...</p>
    <h3>Tiêu chuẩn HFAC</h3>
    <p>HFAC (Humane Farm Animal Care) là tổ chức phi lợi nhuận hàng đầu thế giới trong việc cải thiện cuộc sống của động vật trang trại...</p>',
    'chickens_20-_20red_20laying_20hens_20eating_20from_20feeder_zlikovec_iStock_Thinkstock-639109398.jpg',
    1,
    '2025-05-13 10:00:00'
),
(
    (SELECT id FROM categories WHERE slug='tin-tuc-su-kien' AND type='post' LIMIT 1),
    'BA HUÂN ĐẠT GIẢI THƯỞNG TOP 10 THƯƠNG HIỆU XUẤT SẮC CHÂU Á – THÁI BÌNH 2024',
    'ba-huan-dat-giai-thuong-top-10-thuong-hieu-xuat-sac-chau-a-thai-binh-2024',
    'Ba Huân vinh dự nhận giải thưởng Top 10 Thương hiệu xuất sắc Châu Á - Thái Bình Dương 2024',
    '<h2>Giải thưởng uy tín</h2>
    <p>Giải thưởng Top 10 Thương hiệu xuất sắc Châu Á - Thái Bình Dương là một trong những giải thưởng uy tín nhất trong khu vực...</p>
    <h3>Thành tựu của Ba Huân</h3>
    <p>Với hơn 30 năm hoạt động trong ngành chăn nuôi và chế biến thực phẩm, Ba Huân đã không ngừng nỗ lực...</p>',
    'Hinh-Co-Ba-nhan-giai-thuong-top-10-thuong-hieu-xuat-sac-1.jpg',
    1,
    '2024-11-04 09:00:00'
),
(
    (SELECT id FROM categories WHERE slug='hoat-dong' AND type='post' LIMIT 1),
    'BA HUÂN HỢP TÁC CÙNG SANOVO SẢN XUẤT TRỨNG LỎNG THANH TRÙNG CHẤT LƯỢNG CAO',
    'ba-huan-hop-tac-cung-sanovo-san-xuat-trung-long-chat-luong-cao',
    'Hợp tác chiến lược với Sanovo - công ty hàng đầu thế giới về công nghệ sản xuất trứng lỏng',
    '<h2>Về Sanovo</h2>
    <p>Sanovo là tập đoàn hàng đầu thế giới chuyên về công nghệ chế biến trứng, với hơn 100 năm kinh nghiệm...</p>
    <h3>Sản phẩm trứng lỏng thanh trùng</h3>
    <p>Trứng lỏng thanh trùng là sản phẩm cao cấp, đảm bảo vệ sinh an toàn thực phẩm tuyệt đối...</p>',
    '1-2.png',
    1,
    '2024-10-16 14:30:00'
),
(
    (SELECT id FROM categories WHERE slug='tin-tuc-su-kien' AND type='post' LIMIT 1),
    'MANG BA HUÂN ĐẾN GẦN HƠN VỚI KHÁCH HÀNG – BẰNG GIAN HÀNG TRÊN SHOPEE FOOD',
    'mang-ba-huan-den-gan-hon-voi-khach-hang-shopee-food',
    'Ba Huân chính thức có mặt trên nền tảng Shopee Food, mang đến sự tiện lợi cho khách hàng',
    '<h2>Mua sắm tiện lợi trên Shopee Food</h2>
    <p>Khách hàng giờ đây có thể dễ dàng đặt mua các sản phẩm của Ba Huân thông qua ứng dụng Shopee Food...</p>
    <h3>Ưu đãi đặc biệt</h3>
    <p>Nhân dịp ra mắt, Ba Huân áp dụng nhiều chương trình khuyến mãi hấp dẫn cho khách hàng...</p>',
    'Screenshot-2024-03-06-080218.png',
    1,
    '2024-03-13 11:00:00'
),
(
    (SELECT id FROM categories WHERE slug='hoat-dong' AND type='post' LIMIT 1),
    'TRẢI NGHIỆM MUA THỰC PHẨM BA HUÂN NHANH CHÓNG TIỆN LỢI CÙNG GRAB MART',
    'trai-nghiem-mua-thuc-pham-ba-huan-cung-grab-mart',
    'Hợp tác với Grab Mart mang đến trải nghiệm mua sắm nhanh chóng, tiện lợi',
    '<h2>Liên kết với Grab Mart</h2>
    <p>Ba Huân đã chính thức hợp tác với Grab Mart để đưa sản phẩm đến tay người tiêu dùng nhanh chóng nhất...</p>
    <h3>Giao hàng nhanh 30 phút</h3>
    <p>Với mạng lưới rộng khắp của Grab, khách hàng có thể nhận hàng chỉ trong vòng 30 phút...</p>',
    'demo-bh-x-grab-24012024-01-scaled.jpg',
    1,
    '2024-01-23 08:45:00'
),
(
    (SELECT id FROM categories WHERE slug='tin-tuc-su-kien' AND type='post' LIMIT 1),
    'BA HUÂN ĐƯỢC VINH DANH THƯƠNG HIỆU MẠNH QUỐC GIA',
    'ba-huan-duoc-vinh-danh-thuong-hieu-manh-quoc-gia',
    'Vinh dự được công nhận là Thương hiệu Mạnh Quốc Gia năm 2024',
    '<h2>Giải thưởng Thương hiệu Mạnh</h2>
    <p>Đây là giải thưởng dành cho các doanh nghiệp có đóng góp xuất sắc cho nền kinh tế Việt Nam...</p>
    <h3>Cam kết chất lượng</h3>
    <p>Ba Huân cam kết tiếp tục duy trì và nâng cao chất lượng sản phẩm, phục vụ người tiêu dùng...</p>',
    '01.jpg',
    1,
    '2024-01-19 15:20:00'
),
(
    (SELECT id FROM categories WHERE slug='thong-cao-bao-chi' AND type='post' LIMIT 1),
    'THÔNG CÁO BÁO CHÍ: RA MẮT SẢN PHẨM MỚI TRỨNG GÀ OMEGA-3',
    'thong-cao-bao-chi-ra-mat-san-pham-moi-trung-ga-omega-3',
    'Ba Huân chính thức ra mắt dòng sản phẩm trứng gà giàu Omega-3',
    '<h2>Sản phẩm mới</h2>
    <p>Trứng gà Omega-3 của Ba Huân được sản xuất từ đàn gà được nuôi bằng thức ăn giàu Omega-3...</p>',
    NULL,
    1,
    '2024-02-15 10:00:00'
),
(
    (SELECT id FROM categories WHERE slug='thu-vien' AND type='post' LIMIT 1),
    'THƯ VIỆN HÌNH ẢNH: CHUYẾN THAM QUAN TRANG TRẠI',
    'thu-vien-hinh-anh-chuyen-tham-quan-trang-trai',
    'Hình ảnh chuyến tham quan trang trại chăn nuôi của Ba Huân',
    '<p>Những hình ảnh đẹp từ chuyến tham quan trang trại chăn nuôi gà của Ba Huân...</p>',
    NULL,
    1,
    '2024-03-20 16:00:00'
);

-- Kiểm tra kết quả
SELECT p.*, c.name as category_name 
FROM posts p 
LEFT JOIN categories c ON p.category_id = c.id 
ORDER BY p.created_at DESC;
