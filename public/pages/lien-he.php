<?php 
include __DIR__ . '/header.php';
?>

<style>
  .home #main {
    margin-top: 130px !important;
  }
  
  .contact-page {
    padding: 60px 0;
  }
  
  .contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  
  .contact-page h1 {
    font-size: 36px;
    font-weight: 700;
    color: #0C7A07;
    margin-bottom: 40px;
    text-align: center;
  }
  
  .contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
  }
  
  .contact-info {
    background: #f9f9f9;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .contact-info h2 {
    font-size: 24px;
    font-weight: 600;
    color: #0C7A07;
    margin-bottom: 24px;
  }
  
  .info-item {
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }
  
  .info-item i {
    color: #06B841;
    font-size: 20px;
    margin-top: 4px;
    min-width: 24px;
  }
  
  .info-item svg {
    color: #06B841;
    min-width: 24px;
    margin-top: 4px;
  }
  
  .info-item strong {
    display: block;
    color: #333;
    font-weight: 600;
    margin-bottom: 4px;
  }
  
  .info-item a {
    color: #0C7A07;
    text-decoration: none;
  }
  
  .info-item a:hover {
    text-decoration: underline;
  }
  
  .contact-form {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e0e0e0;
  }
  
  .contact-form h2 {
    font-size: 24px;
    font-weight: 600;
    color: #0C7A07;
    margin-bottom: 24px;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-group label {
    display: block;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
  }
  
  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: 'Montserrat', sans-serif;
  }
  
  .form-group input:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: #0C7A07;
  }
  
  .form-group textarea {
    min-height: 120px;
    resize: vertical;
  }
  
  .submit-btn {
    background: #0C7A07;
    color: white;
    padding: 14px 40px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
  }
  
  .submit-btn:hover {
    background: #095505;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(12, 122, 7, 0.3);
  }
  
  .map-section {
    margin-top: 40px;
  }
  
  .map-section h2 {
    font-size: 24px;
    font-weight: 600;
    color: #0C7A07;
    margin-bottom: 20px;
    text-align: center;
  }
  
  .map-container {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .map-container iframe {
    width: 100%;
    height: 450px;
    border: 0;
  }
  
  @media (max-width: 768px) {
    .contact-content {
      grid-template-columns: 1fr;
    }
    
    .contact-info,
    .contact-form {
      padding: 24px;
    }
    
    .contact-page h1 {
      font-size: 28px;
    }
    
    .map-container iframe {
      height: 350px;
    }
  }
</style>

<main class="site-main clr" id="main" role="main">
  <div class="contact-page">
    <div class="contact-container">
      <h1>Liên hệ với MGF</h1>
      
      <div class="contact-content">
        <!-- Thông tin liên hệ -->
        <div class="contact-info">
          <h2>Thông tin liên hệ</h2>
          
          <div class="info-item">
            <i class="fas fa-building"></i>
            <div>
              <strong>Công ty:</strong>
              CÔNG TY CỔ PHẦN NÔNG NGHIỆP CÔNG NGHỆ CAO MGF
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <strong>Địa chỉ:</strong>
              TT19-09, khu đấu giá 31ha, Xã Gia Lâm, TP. Hà Nội
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-phone"></i>
            <div>
              <strong>Hotline:</strong>
              <a href="tel:0968989255">0968 989 255</a>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <div>
              <strong>Email:</strong>
              <a href="mailto:info@mgf.com.vn">info@mgf.com.vn</a>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-globe"></i>
            <div>
              <strong>Website:</strong>
              <a href="https://mgf.com.vn" target="_blank">mgf.com.vn</a>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-id-card"></i>
            <div>
              <strong>Mã số doanh nghiệp:</strong>
              0110181052
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-calendar-alt"></i>
            <div>
              <strong>Giờ làm việc:</strong>
              Thứ 2 - Thứ 6: 8:00 - 17:00<br>
              Thứ 7: 8:00 - 12:00
            </div>
          </div>
        </div>
        
        <!-- Form liên hệ -->
        <div class="contact-form">
          <h2>Gửi tin nhắn cho chúng tôi</h2>
          <form action="#" method="post" id="contact-form">
            <div class="form-group">
              <label for="name">Họ và tên <span style="color: red;">*</span></label>
              <input type="text" id="name" name="name" required placeholder="Nhập họ và tên của bạn">
            </div>
            
            <div class="form-group">
              <label for="email">Email <span style="color: red;">*</span></label>
              <input type="email" id="email" name="email" required placeholder="email@example.com">
            </div>
            
            <div class="form-group">
              <label for="phone">Số điện thoại <span style="color: red;">*</span></label>
              <input type="tel" id="phone" name="phone" required placeholder="0123456789">
            </div>
            
            <div class="form-group">
              <label for="subject">Tiêu đề</label>
              <input type="text" id="subject" name="subject" placeholder="Tiêu đề tin nhắn">
            </div>
            
            <div class="form-group">
              <label for="message">Nội dung <span style="color: red;">*</span></label>
              <textarea id="message" name="message" required placeholder="Nhập nội dung tin nhắn của bạn..."></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Gửi tin nhắn</button>
          </form>
        </div>
      </div>
      
      <!-- Google Map -->
      <div class="map-section">
        <h2>Vị trí trên bản đồ</h2>
        <div class="map-container">
          <!-- Google Map embed - Địa chỉ: TT19-09, khu đấu giá 31ha, Xã Gia Lâm, Hà Nội -->
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4737888968636!2d105.98!3d21.04!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDAyJzI0LjAiTiAxMDXCsDU4JzQ4LjAiRQ!5e0!3m2!1svi!2s!4v1234567890"
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
// Form submission handler
document.getElementById('contact-form').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Get form data
  const formData = new FormData(this);
  
  // Here you can add AJAX call to send data to server
  // For now, just show a success message
  alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
  
  // Reset form
  this.reset();
});
</script>

<?php 
include __DIR__ . '/footer.php';
?>
