  <header id="dt-header">
<?php
// Detect current page
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
   <div class="dt-header-wrapper">
    <div class="container-wide">
     <div class="header-main">
      <div class="logo">
       <a href="trang-chu"<?php echo ($current_page == 'trang-chu') ? ' class="active"' : ''; ?>>
        <img alt="MGF Việt Nam" src="05_images/logo-GMF.png" width="178" height="49"/>
       </a>
      </div>
      <div class="dt-main-menu">
       <div class="menu-main-menu-container">
        <ul class="dt-primary-menu header-menu" id="primary">
         <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-4478 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children dropdown menu-item-5270<?php echo ($current_page == 'trang-chu') ? ' active' : ''; ?>" id="menu-item-5270">
          <a class="dropdown-toggle<?php echo ($current_page == 'trang-chu') ? ' active' : ''; ?>" data-hover="dropdown" data-toggle="dropdown" href="trang-chu">
           <span>
            Trang Chủ
           </span>
          </a>
         </li>
         <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-4478 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children dropdown menu-item-5270<?php echo ($current_page == 'gioi-thieu') ? ' active' : ''; ?>" id="menu-item-5270">
          <a class="dropdown-toggle<?php echo ($current_page == 'gioi-thieu') ? ' active' : ''; ?>" data-hover="dropdown" data-toggle="dropdown" href="gioi-thieu">
           <span>
            Giới thiệu
           </span>
          </a>
         </li>
         <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown menu-item-4574<?php echo ($current_page == 'san-pham' || $current_page == 'chi-tiet-san-pham') ? ' active' : ''; ?>" id="menu-item-4574">
          <a class="dropdown-toggle<?php echo ($current_page == 'san-pham' || $current_page == 'chi-tiet-san-pham') ? ' active' : ''; ?>" data-hover="dropdown" data-toggle="dropdown" href="san-pham">
           <span>
            Sản phẩm và dịch vụ
           </span>
          </a>
         </li>
         <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-5733<?php echo ($current_page == 'tin-tuc' || $current_page == 'chi-tiet-tin-tuc') ? ' active' : ''; ?>" id="menu-item-5733">
          <a href="tin-tuc"<?php echo ($current_page == 'tin-tuc' || $current_page == 'chi-tiet-tin-tuc') ? ' class="active"' : ''; ?>>
           <span>
            Tin tức & sự kiện
           </span>
          </a>
         </li>
        </ul>
       </div>
      </div>
      <div class="header-utility">
       <div class="header-utility__wrapper">
        <a class="btn btn--outline contact-btn" href="lien-he">
         Liên hệ
         <img alt="arr-next" height="60" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next.svg" width="60"/>
        </a>
       </div>
      </div>

      <div class="header-mobile">
       <a class="offcanvas-menu" href="#">
        <button class="hamburger">
         <span>
         </span>
        </button>
       </a>
      </div>
      
     </div>
    </div>
   </div>
  </header>