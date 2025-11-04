<!DOCTYPE html>
<html lang="vi" prefix="og: https://ogp.me/ns#">
 <meta content="text/html;charset=utf-8" http-equiv="content-type"/>

 <!-- Includes header.php -->
 <link href="02_css/style_lienhe.css" id="main-style-css" media="all" rel="stylesheet" type="text/css"/>
 <link href="02_css/contact.css" id="page-style-css" media="all" rel="stylesheet" type="text/css"/>
 <?php 
 $page_title = "Liên hệ";
 require_once __DIR__ . '/../includes/db.php';
 
 // Get banner for this page
 $banner_stmt = $pdo->query("SELECT * FROM banners 
                             WHERE location_code = 'lien_he' AND is_active = 1 
                             ORDER BY sort_order ASC, id DESC 
                             LIMIT 1");
 $banner = $banner_stmt->fetch();
 
 // Set banner image
 $banner_image = $banner && $banner['image_path'] 
    ? '../uploads/banners/' . $banner['image_path']
    : 'https://www.greenfeed.com.vn/wp-content/uploads/2024/12/833356f8e36564addde08211c286f5ef.jpg';
 
 include '01_includes/header.php'; 
 ?>

 <body class="wp-singular page-template page-template-page-templates page-template-contact page-template-page-templatescontact-php page page-id-155 wp-theme-greenfeed loading-effect">

  <!-- Includes header1.php -->
  <?php include '01_includes/header_02.php'; ?>

   <!-- main -->
   <main class="site-main" id="dt-main-content" role="main">
   <div class="header-background" style="background-image:url('<?= htmlspecialchars($banner_image) ?>')">
    <div class="container">
     <div class="dt-breadscrumb">
      <ul class="breadcrumb">
       <li>
        <a href="trang-chu">
         Trang chủ
        </a>
       </li>
       <li>
        <span class="active">
         Liên hệ
        </span>
       </li>
      </ul>
     </div>
     <h1 class="header-title">
      Liên hệ
     </h1>
    </div>
   </div>
   <div class="container">
    <div class="company-introduce flex">
     <div class="company-image">
      <img alt="" class="attachment-full size-full" decoding="async" fetchpriority="high" height="629" src="https://www.greenfeed.com.vn/wp-content/uploads/2021/08/nha-may-cam-thuc-an-chan-nuoi-greenfeed.jpg" width="1200">
      </img>
     </div>
     <div class="company-content">
      <div class="form-wrap" data-trigger="#cooperate">
       <div class="form-header">
        <span class="form__subtitle">
         Liên hệ
        </span>
        <h2 class="form__title">
         MGF VIỆT NAM
        </h2>
        <span class="form__close close-btn">
         <img alt="Close" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/close.svg" width="10"/>
        </span>
       </div>
       <div class="form-content">
        <form action="../api/contact.php" class="cooperate-form form-content-3" id="contactForm" method="post">
          <div class="form-content__info">
           <div class="form-group input-group full-group">
            <label for="fullname">
             Họ tên <span style="color: red;">*</span>
            </label>
            <input data-missing-error="Vui lòng nhập họ tên" id="fullname" name="name" placeholder="Họ tên" required type="text"/>
           </div>
           <div class="form-group input-group">
            <label for="phone">
             Số điện thoại <span style="color: red;">*</span>
            </label>
            <input data-format-error="Số điện thoại không đúng định dạng" data-missing-error="Vui lòng nhập số điện thoại" id="phone" name="phone" placeholder="Số điện thoại" required type="tel"/>
           </div>
           <div class="form-group input-group" style="width:100%">
            <label for="email">
             Email <span style="color: red;">*</span>
            </label>
            <input data-format-error="Email không đúng định dạng" data-missing-error="Vui lòng nhập email" id="email" name="email" placeholder="Email" required type="email"/>
           </div>
           <div class="form-group input-group full-group">
            <label for="subject">
             Tiêu đề
            </label>
            <input id="subject" name="subject" placeholder="Tiêu đề (không bắt buộc)" type="text"/>
           </div>
           <div class="form-line abs-icon">
            <img alt="Line" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Line4.svg" width="10"/>
           </div>
          </div>
          <div class="form-content__message">
           <div class="form-group textarea-group">
            <label for="message">
             Nội dung <span style="color: red;">*</span>
            </label>
            <textarea id="message" name="message" placeholder="Nhập nội dung tin nhắn của bạn tại đây" required></textarea>
           </div>
          </div>
          <div class="form-content__action">
           <div class="form-message" style="margin: 15px 0; padding: 10px; border-radius: 4px; display: none;"></div>
           <div class="form-buttons">
            <button class="btn btn--primary text-upcase form-submit" type="submit">
             Gửi
            </button>
           </div>
           <div class="form-notes">
            <p>
             * Chúng tôi cam kết không chia sẻ thông tin của bạn với bất cứ bên thứ ba.
            </p>
           </div>
          </div>
         </form>
       </div>

       <script>
       jQuery(document).ready(function($) {
         $('#contactForm').on('submit', function(e) {
           e.preventDefault();
           
           var form = $(this);
           var submitBtn = form.find('.form-submit');
           var messageDiv = form.find('.form-message');
           
           // Disable submit button
           submitBtn.prop('disabled', true).text('Đang gửi...');
           messageDiv.hide();
           
           $.ajax({
             url: form.attr('action'),
             type: 'POST',
             data: form.serialize(),
             dataType: 'json',
             success: function(response) {
               if (response.success) {
                 messageDiv.removeClass('error').addClass('success')
                   .css({
                     'background-color': '#d4edda',
                     'color': '#155724',
                     'border': '1px solid #c3e6cb'
                   })
                   .html(response.message).fadeIn();
                 
                 // Reset form
                 form[0].reset();
                 
                 // Auto hide after 5 seconds
                 setTimeout(function() {
                   messageDiv.fadeOut();
                 }, 5000);
               } else {
                 var errorMsg = response.message;
                 if (response.errors && response.errors.length > 0) {
                   errorMsg += '<br>' + response.errors.join('<br>');
                 }
                 messageDiv.removeClass('success').addClass('error')
                   .css({
                     'background-color': '#f8d7da',
                     'color': '#721c24',
                     'border': '1px solid #f5c6cb'
                   })
                   .html(errorMsg).fadeIn();
               }
             },
             error: function() {
               messageDiv.removeClass('success').addClass('error')
                 .css({
                   'background-color': '#f8d7da',
                   'color': '#721c24',
                   'border': '1px solid #f5c6cb'
                 })
                 .html('Có lỗi xảy ra. Vui lòng thử lại sau.').fadeIn();
             },
             complete: function() {
               // Re-enable submit button
               submitBtn.prop('disabled', false).text('Gửi');
             }
           });
         });
       });
       </script>
      </div>

     </div>
    </div>
    <div class="contact-offices">
     <div class="company-info">
      <h2>
       CÔNG TY CỔ PHẦN NÔNG NGHIỆP CÔNG NGHỆ CAO MGF
      </h2>
      <p>
       <strong style="font-weight: 500;">
        Trụ sở chính
       </strong>
      </p>
      <p>
       <a data-schema-attribute="" href="https://www.google.com/maps/place/GreenFeed+VietNam+-+LongAn/@10.6251181,106.4735345,369m/data=!3m1!1e3!4m14!1m7!3m6!1s0x310acb887909aa0b:0xde7ba49d50797ba8!2sGreenFeed+VietNam+-+LongAn!8m2!3d10.6251181!4d106.4741782!16s%2Fg%2F11rvvdl2b!3m5!1s0x310acb887909aa0b:0xde7ba49d50797ba8!8m2!3d10.6251181!4d106.4741782!16s%2Fg%2F11rvvdl2b?entry=ttu&amp;g_ep=EgoyMDI1MDcwOC4wIKXMDSoASAFQAw%3D%3D" rel="noopener" target="_blank">
        TT19-09, khu đấu giá 31ha, Xã Gia Lâm, Thành Phố Hà Nội, Việt Nam
       </a>
      </p>
      <p>
       Số điện thoại:
       <a href="tel:+842723632881">
        +84 98 773 8533
       </a>
      </p>
      <p>
       Email:
       <a href="mailto:info@mgf.com.vn">
        info@mgf.com.vn
       </a>
       |  Email truyền thông:
       <a href="mailto:truyenthong@greenfeed.com.vn">
        truyenthong@greenfeed.com.vn
       </a>
      </p>
     </div>
     <div class="offices-wrap flex">
      <div class="offices-image">
       <img alt="" class="attachment-full size-full" decoding="async" height="1440" src="https://www.greenfeed.com.vn/wp-content/uploads/2024/12/703e9a26ee9dc31c8d57c44f8d17c949.jpg" width="1920">
       </img>
      </div>
      <div class="offices-content">
       <h2 class="area-title">
        Chi nhánh Việt Nam
       </h2>
       <div class="offices-list flex">
        <div class="office-item">
         <h3 class="office-item__title">
          Văn phòng TP. HCM
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/MGF+Việt+Nam+(Văn+phòng+TP.+HCM)/@10.7826153,106.6973054,138m/data=!3m1!1e3!4m6!3m5!1s0x31752f3b142e0f21:0x6ef4afcd99b61c9b!8m2!3d10.7827533!4d106.6974318!16s%2Fg%2F11f636shtq?entry=ttu&amp;g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Tầng 22, tòa nhà Centec, 72 – 74 Nguyễn Thị Minh Khai, phường Xuân Hòa, TP. HCM.
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: +84 283 520 5579
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          Chi nhánh Đồng Nai
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/MGF+ĐỒNG+NAI/@10.98594,106.9466864,17z/data=!3m1!4b1!4m6!3m5!1s0x3174e7f416feeee3:0x6f926e30b055728f!8m2!3d10.9859348!4d106.951552!16s%2Fg%2F11fj58dcd_?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            KCN Sông Mây, xã Bình Minh, tỉnh Đồng Nai.
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: (0251) 897 2881
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          Chi nhánh Bình Định
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed+Bình+Định/@13.8411402,109.033621,14z/data=!4m10!1m2!2m1!1zZ3JlZW5mZWVkIGLDrG5oIMSR4buLbmg!3m6!1s0x316f6b598fc8a71d:0xf9f4b7187df95221!8m2!3d13.8411402!4d109.0717298!15sChdncmVlbmZlZWQgYsOsbmggxJHhu4tuaJIBDGZvb2Rfc2VydmljZaoBTxABKg0iCWdyZWVuZmVlZChCMh8QASIbrS6yT3M8kwgMwftg_397nkqNyln4qEVI9oMGMhsQAiIXZ3JlZW5mZWVkIGLDrG5oIMSR4buLbmjgAQA!16s%2Fg%2F1hc561lj9?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Lô D2.2 KCN Nhơn Hòa, phường An Nhơn Nam, tỉnh Gia Lai.
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: (0256) 373 8881
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          Chi nhánh Hà Nam
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed+Việt+Nam+-+Chi+Nhánh+Hà+Nam/@20.6680714,105.9237163,17z/data=!3m1!4b1!4m6!3m5!1s0x3135c9388228ec0b:0x958f62c99fc8aa09!8m2!3d20.6680664!4d105.9262966!16s%2Fg%2F11ghq00y7x?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Lô E, KCN Đồng Văn II, phường Đồng Văn, tỉnh Ninh Bình
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: (0226) 357 7888
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          Chi nhánh Vĩnh Long
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed/@10.0337732,105.8165658,17z/data=!3m1!4b1!4m6!3m5!1s0x31a063d437904c0d:0xa37fc4e44ccf9b60!8m2!3d10.0337679!4d105.8191461!16s%2Fg%2F11ghq9f9b4?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Lô H8 – H9 – H10 – H11 KCN Bình Minh, ấp Mỹ Lợi, phường Cái Vồn, tỉnh Vĩnh Long
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: (0270) 390 0888
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          Chi nhánh Hưng Yên
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed+Việt+Nam+-+Chi+Nhánh+Hưng+Yên/@20.9686849,106.0141666,16z/data=!4m10!1m2!2m1!1zZ3JlZW5mZWVkIGjGsG5nIHnDqm4!3m6!1s0x3135c7e2de00c64d:0xe089f0a3ab7602ed!8m2!3d20.9686849!4d106.0236938!15sChRncmVlbmZlZWQgaMawbmcgecOqbpIBEWZlZWRfbWFudWZhY3R1cmVyqgFMEAEqDSIJZ3JlZW5mZWVkKEIyHxABIhuqxG3Q1QttK4igPgCb-_g-SpYaVmiR8LW5kZ4yGBACIhRncmVlbmZlZWQgaMawbmcgecOqbuABAA!16s%2Fg%2F11f659_l_1?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Đường A5, Khu A, KCN Phố Nối A, xã Như Quỳnh, tỉnh Hưng Yên.
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: (0221) 378 9770
          </p>
         </div>
        </div>
       </div>
       <h2 class="area-title">
        Chi nhánh nước ngoài
       </h2>
       <div class="offices-list flex">
        <div class="office-item">
         <h3 class="office-item__title">
          MGF Campuchia
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           Ấp Suông, xã Suông, huyện Tbongkhmum, tỉnh Kampong Cham, Campuchia
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: +85 542 500 0186
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          MGF Myanmar
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed+Vietnam+Company+Limited/@16.9923664,96.0890887,17z/data=!3m1!4b1!4m6!3m5!1s0x30c1979476ad9edf:0x5a96828e5ba5d730!8m2!3d16.9923613!4d96.091669!16s%2Fg%2F11fylyfrjx?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Lô 11/A &amp; 11/B-1, Khu 552-C Myaytaing, KCN Thar Du Kan, thị trấn Shwe Pyi Thar, Yangon, Myanmar​
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: +95 942 336 5168
          </p>
         </div>
        </div>
        <div class="office-item">
         <h3 class="office-item__title">
          MGF Lào
         </h3>
         <div class="office-item__address">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Map.svg" width="10"/>
          <p>
           <a href="https://www.google.com/maps/place/GreenFeed+Laos+Co.,LTD/@18.0494701,102.7605216,17z/data=!3m1!4b1!4m6!3m5!1s0x31245f1ee49bf19f:0xb4b334e04e97a247!8m2!3d18.049465!4d102.7631019!16s%2Fg%2F11lhdm00__?entry=ttu&amp;g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D" rel="nofollow noopener sponsored" target="_blank">
            Đường 13 Nam Lào, Quận Saythany, Thủ đô Vientiane, Lào ​
           </a>
          </p>
         </div>
         <div class="office-item__phone">
          <img alt="Location" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/PhoneCall.svg" width="10"/>
          <p>
           Sđt: + 856 21618888 – 021617777
          </p>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
   
  </main>

    <!-- footer -->
    <?php include '01_includes/footer.php'; ?>
    <script id="trangchu-js" src="03_js/trangchu.js" type="text/javascript"></script>

   <div class="loading">
    <div class="overlay">
    </div>
    <div class="loader">
    </div>
   </div>
  </link>
 </body>

</html>
