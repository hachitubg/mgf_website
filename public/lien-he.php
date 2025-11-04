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
        <a href="trang-chu.php">
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
        <form action="#" class="cooperate-form form-content-3" method="post">
         <input name="dt_nonce" type="hidden" value="912f49459c">
          <input name="action" type="hidden" value="save_cooperate_form_data"/>
          <input name="formname" type="hidden" value="Hợp tác"/>
          <input name="hiddenfield" type="hidden" value=""/>
          <input class="sr-only" name="srfield" type="text" value=""/>
          <div class="form-content__info">
           <div class="form-group select-group">
            <label for="demand">
             Nhu cầu
            </label>
            <select data-missing-error="Demand is required." id="demand" name="demand" placeholder="Nhu cầu">
             <option disabled="disabled" selected="true">
              Nhu cầu
             </option>
             <option value="Đặt hàng">
              Đặt hàng
             </option>
             <option value="Hợp tác">
              Hợp tác
             </option>
             <option value="Tư vấn thêm">
              Tư vấn thêm
             </option>
             <option value="Câu hỏi người chăn nuôi">
              Câu hỏi người chăn nuôi
             </option>
             <option value="Khác">
              Khác
             </option>
            </select>
           </div>
           <div class="form-group select-group">
            <label for="product">
             Sản phẩm
            </label>
            <select data-missing-error="Product is required." id="product" name="product" placeholder="Sản phẩm">
             <option disabled="disabled" selected="true">
              Sản phẩm
             </option>
             <optgroup label="Thức ăn chăn nuôi">
              <option value="Heo">
               Heo
              </option>
              <option value="Gia cầm">
               Gia cầm
              </option>
              <option value="Đại gia súc">
               Đại gia súc
              </option>
             </optgroup>
             <optgroup label="Trang trại và con giống">
              <option value="Trang trại">
               Trang trại
              </option>
              <option value="Heo giống">
               Heo giống
              </option>
              <option value="Gà giống">
               Gà giống
              </option>
              <option value="Tinh heo">
               Tinh heo
              </option>
             </optgroup>
             <optgroup label="Sản phẩm thương phẩm">
              <option value="Heo thịt">
               Heo thịt
              </option>
              <option value="Heo thịt loại">
               Heo thịt loại
              </option>
              <option value="Gà thịt">
               Gà thịt
              </option>
             </optgroup>
             <optgroup label="Thực phẩm">
              <option value="G">
               G
              </option>
              <option value="Wyn">
               Wyn
              </option>
              <option value="leBOUCHER">
               leBOUCHER
              </option>
             </optgroup>
             <optgroup label="Thuỷ sản">
              <option value="Thức ăn thuỷ sản">
               Thức ăn thuỷ sản
              </option>
              <option value="Ao hồ thủy sản">
               Ao hồ thủy sản
              </option>
              <option value="Con giống thuỷ sản">
               Con giống thuỷ sản
              </option>
              <option value="Thực phẩm thuỷ sản">
               Thực phẩm thuỷ sản
              </option>
             </optgroup>
             <optgroup label="Xuất khẩu">
              <option value="Xuất khẩu">
               Xuất khẩu
              </option>
             </optgroup>
             <optgroup label="Khác">
              <option value="Khác">
               Khác
              </option>
             </optgroup>
             <optgroup label="Thuốc thú y">
              <option value="Heo">
               Heo
              </option>
              <option value="Gà">
               Gà
              </option>
              <option value="Vịt">
               Vịt
              </option>
             </optgroup>
            </select>
           </div>
           <div class="form-group input-group full-group">
            <label for="fullname">
             Họ tên
            </label>
            <input data-missing-error="Fullname is required." id="fullname" name="fullname" placeholder="Họ tên" type="text"/>
           </div>
           <div class="form-group input-group">
            <label for="phone">
             Số điện thoại
            </label>
            <input data-format-error="Phone number incorrect format." data-missing-error="Phone number is required." id="phone" name="phone" placeholder="Số điện thoại" type="number"/>
           </div>
           <div class="form-group input-group">
            <label for="email">
             Email
            </label>
            <input data-format-error="Email incorrect format." data-missing-error="Email is required." id="email" name="email" placeholder="Email" type="text"/>
           </div>
           <div class="form-group select-group address-group country-group">
            <label for="country">
             Quốc gia
            </label>
            <select data-missing-error="Country is required." id="country" name="country" placeholder="Quốc gia">
             <option disabled="disabled" selected="true">
              Quốc gia
             </option>
             <option data-id="VN" selected="" value="Vietnam">
              Vietnam
             </option>
             <option data-id="KH" value="Cambodia">
              Cambodia
             </option>
             <option data-id="LA" value="Laos">
              Laos
             </option>
             <option data-id="MM" value="Myanmar">
              Myanmar
             </option>
             <option data-id="AF" value="Afghanistan">
              Afghanistan
             </option>
             <option data-id="AX" value="Aland Islands">
              Aland Islands
             </option>
             <option data-id="AL" value="Albania">
              Albania
             </option>
             <option data-id="DZ" value="Algeria">
              Algeria
             </option>
             <option data-id="AS" value="American Samoa">
              American Samoa
             </option>
             <option data-id="AD" value="Andorra">
              Andorra
             </option>
             <option data-id="AO" value="Angola">
              Angola
             </option>
             <option data-id="AI" value="Anguilla">
              Anguilla
             </option>
             <option data-id="AQ" value="Antarctica">
              Antarctica
             </option>
             <option data-id="AG" value="Antigua and Barbuda">
              Antigua and Barbuda
             </option>
             <option data-id="AR" value="Argentina">
              Argentina
             </option>
             <option data-id="AM" value="Armenia">
              Armenia
             </option>
             <option data-id="AW" value="Aruba">
              Aruba
             </option>
             <option data-id="AU" value="Australia">
              Australia
             </option>
             <option data-id="AT" value="Austria">
              Austria
             </option>
             <option data-id="AZ" value="Azerbaijan">
              Azerbaijan
             </option>
             <option data-id="BS" value="The Bahamas">
              The Bahamas
             </option>
             <option data-id="BH" value="Bahrain">
              Bahrain
             </option>
             <option data-id="BD" value="Bangladesh">
              Bangladesh
             </option>
             <option data-id="BB" value="Barbados">
              Barbados
             </option>
             <option data-id="BY" value="Belarus">
              Belarus
             </option>
             <option data-id="BE" value="Belgium">
              Belgium
             </option>
             <option data-id="BZ" value="Belize">
              Belize
             </option>
             <option data-id="BJ" value="Benin">
              Benin
             </option>
             <option data-id="BM" value="Bermuda">
              Bermuda
             </option>
             <option data-id="BT" value="Bhutan">
              Bhutan
             </option>
             <option data-id="BO" value="Bolivia">
              Bolivia
             </option>
             <option data-id="BA" value="Bosnia and Herzegovina">
              Bosnia and Herzegovina
             </option>
             <option data-id="BW" value="Botswana">
              Botswana
             </option>
             <option data-id="BV" value="Bouvet Island">
              Bouvet Island
             </option>
             <option data-id="BR" value="Brazil">
              Brazil
             </option>
             <option data-id="IO" value="British Indian Ocean Territory">
              British Indian Ocean Territory
             </option>
             <option data-id="BN" value="Brunei">
              Brunei
             </option>
             <option data-id="BG" value="Bulgaria">
              Bulgaria
             </option>
             <option data-id="BF" value="Burkina Faso">
              Burkina Faso
             </option>
             <option data-id="BI" value="Burundi">
              Burundi
             </option>
             <option data-id="CM" value="Cameroon">
              Cameroon
             </option>
             <option data-id="CA" value="Canada">
              Canada
             </option>
             <option data-id="CV" value="Cape Verde">
              Cape Verde
             </option>
             <option data-id="KY" value="Cayman Islands">
              Cayman Islands
             </option>
             <option data-id="CF" value="Central African Republic">
              Central African Republic
             </option>
             <option data-id="TD" value="Chad">
              Chad
             </option>
             <option data-id="CL" value="Chile">
              Chile
             </option>
             <option data-id="CN" value="China">
              China
             </option>
             <option data-id="CX" value="Christmas Island">
              Christmas Island
             </option>
             <option data-id="CC" value="Cocos (Keeling) Islands">
              Cocos (Keeling) Islands
             </option>
             <option data-id="CO" value="Colombia">
              Colombia
             </option>
             <option data-id="KM" value="Comoros">
              Comoros
             </option>
             <option data-id="CG" value="Congo">
              Congo
             </option>
             <option data-id="CD" value="Democratic Republic of the Congo">
              Democratic Republic of the Congo
             </option>
             <option data-id="CK" value="Cook Islands">
              Cook Islands
             </option>
             <option data-id="CR" value="Costa Rica">
              Costa Rica
             </option>
             <option data-id="CI" value="Ivory Coast">
              Ivory Coast
             </option>
             <option data-id="HR" value="Croatia">
              Croatia
             </option>
             <option data-id="CU" value="Cuba">
              Cuba
             </option>
             <option data-id="CY" value="Cyprus">
              Cyprus
             </option>
             <option data-id="CZ" value="Czech Republic">
              Czech Republic
             </option>
             <option data-id="DK" value="Denmark">
              Denmark
             </option>
             <option data-id="DJ" value="Djibouti">
              Djibouti
             </option>
             <option data-id="DM" value="Dominica">
              Dominica
             </option>
             <option data-id="DO" value="Dominican Republic">
              Dominican Republic
             </option>
             <option data-id="TL" value="Timor-Leste">
              Timor-Leste
             </option>
             <option data-id="EC" value="Ecuador">
              Ecuador
             </option>
             <option data-id="EG" value="Egypt">
              Egypt
             </option>
             <option data-id="SV" value="El Salvador">
              El Salvador
             </option>
             <option data-id="GQ" value="Equatorial Guinea">
              Equatorial Guinea
             </option>
             <option data-id="ER" value="Eritrea">
              Eritrea
             </option>
             <option data-id="EE" value="Estonia">
              Estonia
             </option>
             <option data-id="ET" value="Ethiopia">
              Ethiopia
             </option>
             <option data-id="FK" value="Falkland Islands">
              Falkland Islands
             </option>
             <option data-id="FO" value="Faroe Islands">
              Faroe Islands
             </option>
             <option data-id="FJ" value="Fiji Islands">
              Fiji Islands
             </option>
             <option data-id="FI" value="Finland">
              Finland
             </option>
             <option data-id="FR" value="France">
              France
             </option>
             <option data-id="GF" value="French Guiana">
              French Guiana
             </option>
             <option data-id="PF" value="French Polynesia">
              French Polynesia
             </option>
             <option data-id="TF" value="French Southern Territories">
              French Southern Territories
             </option>
             <option data-id="GA" value="Gabon">
              Gabon
             </option>
             <option data-id="GM" value="The Gambia">
              The Gambia
             </option>
             <option data-id="GE" value="Georgia">
              Georgia
             </option>
             <option data-id="DE" value="Germany">
              Germany
             </option>
             <option data-id="GH" value="Ghana">
              Ghana
             </option>
             <option data-id="GI" value="Gibraltar">
              Gibraltar
             </option>
             <option data-id="GR" value="Greece">
              Greece
             </option>
             <option data-id="GL" value="Greenland">
              Greenland
             </option>
             <option data-id="GD" value="Grenada">
              Grenada
             </option>
             <option data-id="GP" value="Guadeloupe">
              Guadeloupe
             </option>
             <option data-id="GU" value="Guam">
              Guam
             </option>
             <option data-id="GT" value="Guatemala">
              Guatemala
             </option>
             <option data-id="GG" value="Guernsey">
              Guernsey
             </option>
             <option data-id="GN" value="Guinea">
              Guinea
             </option>
             <option data-id="GW" value="Guinea-Bissau">
              Guinea-Bissau
             </option>
             <option data-id="GY" value="Guyana">
              Guyana
             </option>
             <option data-id="HT" value="Haiti">
              Haiti
             </option>
             <option data-id="HM" value="Heard Island and McDonald Islands">
              Heard Island and McDonald Islands
             </option>
             <option data-id="HN" value="Honduras">
              Honduras
             </option>
             <option data-id="HK" value="Hong Kong S.A.R.">
              Hong Kong S.A.R.
             </option>
             <option data-id="HU" value="Hungary">
              Hungary
             </option>
             <option data-id="IS" value="Iceland">
              Iceland
             </option>
             <option data-id="IN" value="India">
              India
             </option>
             <option data-id="ID" value="Indonesia">
              Indonesia
             </option>
             <option data-id="IR" value="Iran">
              Iran
             </option>
             <option data-id="IQ" value="Iraq">
              Iraq
             </option>
             <option data-id="IE" value="Ireland">
              Ireland
             </option>
             <option data-id="IL" value="Israel">
              Israel
             </option>
             <option data-id="IT" value="Italy">
              Italy
             </option>
             <option data-id="JM" value="Jamaica">
              Jamaica
             </option>
             <option data-id="JP" value="Japan">
              Japan
             </option>
             <option data-id="JE" value="Jersey">
              Jersey
             </option>
             <option data-id="JO" value="Jordan">
              Jordan
             </option>
             <option data-id="KZ" value="Kazakhstan">
              Kazakhstan
             </option>
             <option data-id="KE" value="Kenya">
              Kenya
             </option>
             <option data-id="KI" value="Kiribati">
              Kiribati
             </option>
             <option data-id="KP" value="North Korea">
              North Korea
             </option>
             <option data-id="KR" value="South Korea">
              South Korea
             </option>
             <option data-id="KW" value="Kuwait">
              Kuwait
             </option>
             <option data-id="KG" value="Kyrgyzstan">
              Kyrgyzstan
             </option>
             <option data-id="LV" value="Latvia">
              Latvia
             </option>
             <option data-id="LB" value="Lebanon">
              Lebanon
             </option>
             <option data-id="LS" value="Lesotho">
              Lesotho
             </option>
             <option data-id="LR" value="Liberia">
              Liberia
             </option>
             <option data-id="LY" value="Libya">
              Libya
             </option>
             <option data-id="LI" value="Liechtenstein">
              Liechtenstein
             </option>
             <option data-id="LT" value="Lithuania">
              Lithuania
             </option>
             <option data-id="LU" value="Luxembourg">
              Luxembourg
             </option>
             <option data-id="MO" value="Macau S.A.R.">
              Macau S.A.R.
             </option>
             <option data-id="MK" value="North Macedonia">
              North Macedonia
             </option>
             <option data-id="MG" value="Madagascar">
              Madagascar
             </option>
             <option data-id="MW" value="Malawi">
              Malawi
             </option>
             <option data-id="MY" value="Malaysia">
              Malaysia
             </option>
             <option data-id="MV" value="Maldives">
              Maldives
             </option>
             <option data-id="ML" value="Mali">
              Mali
             </option>
             <option data-id="MT" value="Malta">
              Malta
             </option>
             <option data-id="IM" value="Man (Isle of)">
              Man (Isle of)
             </option>
             <option data-id="MH" value="Marshall Islands">
              Marshall Islands
             </option>
             <option data-id="MQ" value="Martinique">
              Martinique
             </option>
             <option data-id="MR" value="Mauritania">
              Mauritania
             </option>
             <option data-id="MU" value="Mauritius">
              Mauritius
             </option>
             <option data-id="YT" value="Mayotte">
              Mayotte
             </option>
             <option data-id="MX" value="Mexico">
              Mexico
             </option>
             <option data-id="FM" value="Micronesia">
              Micronesia
             </option>
             <option data-id="MD" value="Moldova">
              Moldova
             </option>
             <option data-id="MC" value="Monaco">
              Monaco
             </option>
             <option data-id="MN" value="Mongolia">
              Mongolia
             </option>
             <option data-id="ME" value="Montenegro">
              Montenegro
             </option>
             <option data-id="MS" value="Montserrat">
              Montserrat
             </option>
             <option data-id="MA" value="Morocco">
              Morocco
             </option>
             <option data-id="MZ" value="Mozambique">
              Mozambique
             </option>
             <option data-id="NA" value="Namibia">
              Namibia
             </option>
             <option data-id="NR" value="Nauru">
              Nauru
             </option>
             <option data-id="NP" value="Nepal">
              Nepal
             </option>
             <option data-id="BQ" value="Bonaire, Sint Eustatius and Saba">
              Bonaire, Sint Eustatius and Saba
             </option>
             <option data-id="NL" value="Netherlands">
              Netherlands
             </option>
             <option data-id="NC" value="New Caledonia">
              New Caledonia
             </option>
             <option data-id="NZ" value="New Zealand">
              New Zealand
             </option>
             <option data-id="NI" value="Nicaragua">
              Nicaragua
             </option>
             <option data-id="NE" value="Niger">
              Niger
             </option>
             <option data-id="NG" value="Nigeria">
              Nigeria
             </option>
             <option data-id="NU" value="Niue">
              Niue
             </option>
             <option data-id="NF" value="Norfolk Island">
              Norfolk Island
             </option>
             <option data-id="MP" value="Northern Mariana Islands">
              Northern Mariana Islands
             </option>
             <option data-id="NO" value="Norway">
              Norway
             </option>
             <option data-id="OM" value="Oman">
              Oman
             </option>
             <option data-id="PK" value="Pakistan">
              Pakistan
             </option>
             <option data-id="PW" value="Palau">
              Palau
             </option>
             <option data-id="PS" value="Palestinian Territory Occupied">
              Palestinian Territory Occupied
             </option>
             <option data-id="PA" value="Panama">
              Panama
             </option>
             <option data-id="PG" value="Papua New Guinea">
              Papua New Guinea
             </option>
             <option data-id="PY" value="Paraguay">
              Paraguay
             </option>
             <option data-id="PE" value="Peru">
              Peru
             </option>
             <option data-id="PH" value="Philippines">
              Philippines
             </option>
             <option data-id="PN" value="Pitcairn Island">
              Pitcairn Island
             </option>
             <option data-id="PL" value="Poland">
              Poland
             </option>
             <option data-id="PT" value="Portugal">
              Portugal
             </option>
             <option data-id="PR" value="Puerto Rico">
              Puerto Rico
             </option>
             <option data-id="QA" value="Qatar">
              Qatar
             </option>
             <option data-id="RE" value="Reunion">
              Reunion
             </option>
             <option data-id="RO" value="Romania">
              Romania
             </option>
             <option data-id="RU" value="Russia">
              Russia
             </option>
             <option data-id="RW" value="Rwanda">
              Rwanda
             </option>
             <option data-id="SH" value="Saint Helena">
              Saint Helena
             </option>
             <option data-id="KN" value="Saint Kitts and Nevis">
              Saint Kitts and Nevis
             </option>
             <option data-id="LC" value="Saint Lucia">
              Saint Lucia
             </option>
             <option data-id="PM" value="Saint Pierre and Miquelon">
              Saint Pierre and Miquelon
             </option>
             <option data-id="VC" value="Saint Vincent and the Grenadines">
              Saint Vincent and the Grenadines
             </option>
             <option data-id="BL" value="Saint-Barthelemy">
              Saint-Barthelemy
             </option>
             <option data-id="MF" value="Saint-Martin (French part)">
              Saint-Martin (French part)
             </option>
             <option data-id="WS" value="Samoa">
              Samoa
             </option>
             <option data-id="SM" value="San Marino">
              San Marino
             </option>
             <option data-id="ST" value="Sao Tome and Principe">
              Sao Tome and Principe
             </option>
             <option data-id="SA" value="Saudi Arabia">
              Saudi Arabia
             </option>
             <option data-id="SN" value="Senegal">
              Senegal
             </option>
             <option data-id="RS" value="Serbia">
              Serbia
             </option>
             <option data-id="SC" value="Seychelles">
              Seychelles
             </option>
             <option data-id="SL" value="Sierra Leone">
              Sierra Leone
             </option>
             <option data-id="SG" value="Singapore">
              Singapore
             </option>
             <option data-id="SK" value="Slovakia">
              Slovakia
             </option>
             <option data-id="SI" value="Slovenia">
              Slovenia
             </option>
             <option data-id="SB" value="Solomon Islands">
              Solomon Islands
             </option>
             <option data-id="SO" value="Somalia">
              Somalia
             </option>
             <option data-id="ZA" value="South Africa">
              South Africa
             </option>
             <option data-id="GS" value="South Georgia">
              South Georgia
             </option>
             <option data-id="SS" value="South Sudan">
              South Sudan
             </option>
             <option data-id="ES" value="Spain">
              Spain
             </option>
             <option data-id="LK" value="Sri Lanka">
              Sri Lanka
             </option>
             <option data-id="SD" value="Sudan">
              Sudan
             </option>
             <option data-id="SR" value="Suriname">
              Suriname
             </option>
             <option data-id="SJ" value="Svalbard and Jan Mayen Islands">
              Svalbard and Jan Mayen Islands
             </option>
             <option data-id="SZ" value="Eswatini">
              Eswatini
             </option>
             <option data-id="SE" value="Sweden">
              Sweden
             </option>
             <option data-id="CH" value="Switzerland">
              Switzerland
             </option>
             <option data-id="SY" value="Syria">
              Syria
             </option>
             <option data-id="TW" value="Taiwan">
              Taiwan
             </option>
             <option data-id="TJ" value="Tajikistan">
              Tajikistan
             </option>
             <option data-id="TZ" value="Tanzania">
              Tanzania
             </option>
             <option data-id="TH" value="Thailand">
              Thailand
             </option>
             <option data-id="TG" value="Togo">
              Togo
             </option>
             <option data-id="TK" value="Tokelau">
              Tokelau
             </option>
             <option data-id="TO" value="Tonga">
              Tonga
             </option>
             <option data-id="TT" value="Trinidad and Tobago">
              Trinidad and Tobago
             </option>
             <option data-id="TN" value="Tunisia">
              Tunisia
             </option>
             <option data-id="TR" value="Turkey">
              Turkey
             </option>
             <option data-id="TM" value="Turkmenistan">
              Turkmenistan
             </option>
             <option data-id="TC" value="Turks and Caicos Islands">
              Turks and Caicos Islands
             </option>
             <option data-id="TV" value="Tuvalu">
              Tuvalu
             </option>
             <option data-id="UG" value="Uganda">
              Uganda
             </option>
             <option data-id="UA" value="Ukraine">
              Ukraine
             </option>
             <option data-id="AE" value="United Arab Emirates">
              United Arab Emirates
             </option>
             <option data-id="GB" value="United Kingdom">
              United Kingdom
             </option>
             <option data-id="US" value="United States">
              United States
             </option>
             <option data-id="UM" value="United States Minor Outlying Islands">
              United States Minor Outlying Islands
             </option>
             <option data-id="UY" value="Uruguay">
              Uruguay
             </option>
             <option data-id="UZ" value="Uzbekistan">
              Uzbekistan
             </option>
             <option data-id="VU" value="Vanuatu">
              Vanuatu
             </option>
             <option data-id="VA" value="Vatican City State (Holy See)">
              Vatican City State (Holy See)
             </option>
             <option data-id="VE" value="Venezuela">
              Venezuela
             </option>
             <option data-id="VG" value="Virgin Islands (British)">
              Virgin Islands (British)
             </option>
             <option data-id="VI" value="Virgin Islands (US)">
              Virgin Islands (US)
             </option>
             <option data-id="WF" value="Wallis and Futuna Islands">
              Wallis and Futuna Islands
             </option>
             <option data-id="EH" value="Western Sahara">
              Western Sahara
             </option>
             <option data-id="YE" value="Yemen">
              Yemen
             </option>
             <option data-id="ZM" value="Zambia">
              Zambia
             </option>
             <option data-id="ZW" value="Zimbabwe">
              Zimbabwe
             </option>
             <option data-id="XK" value="Kosovo">
              Kosovo
             </option>
             <option data-id="CW" value="Curaçao">
              Curaçao
             </option>
             <option data-id="SX" value="Sint Maarten (Dutch part)">
              Sint Maarten (Dutch part)
             </option>
            </select>
           </div>
           <div class="form-group select-group address-group">
            <label for="province">
             Tỉnh thành
            </label>
            <select data-missing-error="Province is required." id="province" name="province" placeholder="Tỉnh thành">
             <option disabled="disabled" selected="true">
              Tỉnh thành
             </option>
             <option data-id="1" value="Thành phố Hà Nội">
              Thành phố Hà Nội
             </option>
             <option data-id="79" value="Thành phố Hồ Chí Minh">
              Thành phố Hồ Chí Minh
             </option>
             <option data-id="48" value="Thành phố Đà Nẵng">
              Thành phố Đà Nẵng
             </option>
             <option data-id="92" value="Thành phố Cần Thơ">
              Thành phố Cần Thơ
             </option>
             <option data-id="31" value="Thành phố Hải Phòng">
              Thành phố Hải Phòng
             </option>
             <option data-id="46" value="Thành phố Huế">
              Thành phố Huế
             </option>
             <option data-id="91" value="Tỉnh An Giang">
              Tỉnh An Giang
             </option>
             <option data-id="24" value="Tỉnh Bắc Ninh">
              Tỉnh Bắc Ninh
             </option>
             <option data-id="96" value="Tỉnh Cà Mau">
              Tỉnh Cà Mau
             </option>
             <option data-id="4" value="Tỉnh Cao Bằng">
              Tỉnh Cao Bằng
             </option>
             <option data-id="52" value="Tỉnh Gia Lai">
              Tỉnh Gia Lai
             </option>
             <option data-id="42" value="Tỉnh Hà Tĩnh">
              Tỉnh Hà Tĩnh
             </option>
             <option data-id="33" value="Tỉnh Hưng Yên">
              Tỉnh Hưng Yên
             </option>
             <option data-id="56" value="Tỉnh Khánh Hòa">
              Tỉnh Khánh Hòa
             </option>
             <option data-id="12" value="Tỉnh Lai Châu">
              Tỉnh Lai Châu
             </option>
             <option data-id="68" value="Tỉnh Lâm Đồng">
              Tỉnh Lâm Đồng
             </option>
             <option data-id="20" value="Tỉnh Lạng Sơn">
              Tỉnh Lạng Sơn
             </option>
             <option data-id="15" value="Tỉnh Lào Cai">
              Tỉnh Lào Cai
             </option>
             <option data-id="40" value="Tỉnh Nghệ An">
              Tỉnh Nghệ An
             </option>
             <option data-id="37" value="Tỉnh Ninh Bình">
              Tỉnh Ninh Bình
             </option>
             <option data-id="25" value="Tỉnh Phú Thọ">
              Tỉnh Phú Thọ
             </option>
             <option data-id="51" value="Tỉnh Quảng Ngãi">
              Tỉnh Quảng Ngãi
             </option>
             <option data-id="22" value="Tỉnh Quảng Ninh">
              Tỉnh Quảng Ninh
             </option>
             <option data-id="44" value="Tỉnh Quảng Trị">
              Tỉnh Quảng Trị
             </option>
             <option data-id="14" value="Tỉnh Sơn La">
              Tỉnh Sơn La
             </option>
             <option data-id="80" value="Tỉnh Tây Ninh">
              Tỉnh Tây Ninh
             </option>
             <option data-id="19" value="Tỉnh Thái Nguyên">
              Tỉnh Thái Nguyên
             </option>
             <option data-id="38" value="Tỉnh Thanh Hóa">
              Tỉnh Thanh Hóa
             </option>
             <option data-id="8" value="Tỉnh Tuyên Quang">
              Tỉnh Tuyên Quang
             </option>
             <option data-id="86" value="Tỉnh Vĩnh Long">
              Tỉnh Vĩnh Long
             </option>
             <option data-id="66" value="Tỉnh Đắk Lắk">
              Tỉnh Đắk Lắk
             </option>
             <option data-id="11" value="Tỉnh Điện Biên">
              Tỉnh Điện Biên
             </option>
             <option data-id="75" value="Tỉnh Đồng Nai">
              Tỉnh Đồng Nai
             </option>
             <option data-id="82" value="Tỉnh Đồng Tháp">
              Tỉnh Đồng Tháp
             </option>
            </select>
           </div>
           <div class="form-group select-group address-group">
            <label for="district">
             Xã / Phường
            </label>
            <select data-missing-error="Xã / Phường là bắt buộc." id="district" name="district" placeholder="Xã / Phường">
             <option disabled="disabled" selected="true">
              Xã / Phường
             </option>
            </select>
           </div>
           <div class="form-line abs-icon">
            <img alt="Line" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/Line4.svg" width="10"/>
           </div>
          </div>
          <div class="form-content__message">
           <div class="form-group textarea-group">
            <label for="messenge">
             Nội dung
            </label>
            <textarea id="messenge" name="messenge" placeholder="Nội dung (Nhập nhu cầu chi tiết của bạn tại đây)"></textarea>
           </div>
          </div>
          <div class="form-content__action">
           <div class="form-group checkbox-group">
            <input autocomplete="off" class="form-control checkbox-control" data-missing-error="You must agree to the privacy policy" id="privacy_policy_#cooperate" name="privacy_policy" type="checkbox" value="1"/>
            <label for="privacy_policy_#cooperate">
             <p>
              Tôi đã đọc và đồng ý với
              <a href="ccos.php" rel="noopener" target="_blank">
               chính sách bảo mật
              </a>
              của MGF Vietnam.
             </p>
            </label>
           </div>
           <div class="form-group checkbox-group">
            <input checked="" class="form-control checkbox-control" id="newsletter_#cooperate" name="newsletter" type="checkbox" value="1"/>
            <label for="newsletter_#cooperate">
             <p>
              Tôi đồng ý nhận thông tin mới nhất từ MGF Vietnam.
             </p>
            </label>
           </div>
           <div class="form-buttons">
            <span class="btn btn--outline text-upcase form-close-btn">
             Hủy
            </span>
            <button class="btn btn--primary text-upcase form-submit" name="save_form" type="submit">
             Gửi
            </button>
           </div>
           <div class="form-notes">
            <p>
             * Chúng tôi cam kết không chia sẻ thông tin của bạn với bất cứ bên thứ ba.
            </p>
           </div>
          </div>
         </input>
        </form>
       </div>
      </div>
      <script>
       jQuery(document).ready(function ($) {
                var temp_minipopup = '<div class="mini-popup"> <span class="close-btn mini-popup__close"><img width="10" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/close.svg" alt="Close"></span> <div class="mini-popup__content">{{content}}</div> </div>';
                $demand = $('.form-wrap #demand').selectize({
                    onInitialize: function () {
                        $('.form-wrap #demand').next().find('div.selectize-input > input').prop('disabled', 'disabled');
                    },
                    onDropdownOpen:  function(value)
                    {
                        //remove disbale option
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                            s.removeOption($(this)[0].text);
                        }
                        });
                        //clear default value
                        if(this.getValue() && this.options[this.getValue()].disabled == true)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if(value.toLowerCase() == 'đặt hàng' || value.toLowerCase() == 'order')
                        {
                            $('.form-wrap .cooperate-form #product')[0].selectize.clear();
                            $('.form-wrap .cooperate-form  #product').parent().removeClass('success');
                            $('.form-wrap .cooperate-form  #product').parent().addClass('hideexport');
                        }
                        else
                        {
                            $('.form-wrap .cooperate-form  #product').parent().removeClass('hideexport');
                        }
                    }
                });
                $product = $('.form-wrap .cooperate-form  #product').selectize({
                     onInitialize: function() {
                        this.$control_input.attr('readonly', true);
                    },
                    onDropdownOpen:  function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                            if($(this)[0].disabled)
                            {
                                s.removeOption($(this)[0].text);
                            }
                        });
                        if(this.getValue() && this.options[this.getValue()].disabled == true)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        var s = this;
                        var demand = $('.form-wrap #demand')[0].selectize.getValue();
                        if((demand.toLowerCase() == 'đặt hàng' || demand.toLowerCase() == 'order') &&(value.toLowerCase() == 'g kitchen' || value.toLowerCase() == 'mamachoice' || value.toLowerCase() == 'wyn'))
                        {
                            jQuery.ajax({
                                url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                type: "POST",
                                data: { action: "food_notes", food: value, security: jQuery('[name=dt_nonce]').val() },
                                dataType: "html",
                                success: function (response) {
                                if(response)
                                {
                                        var html = temp_minipopup;
                                        html = html.replace("{{content}}", response);
                                        $('body').append(html).addClass('minipopup-show');
                                        s.clear();
                                        $('.form-wrap .cooperate-form #product').parent().removeClass('success');
                                        //Show placehoder when deselect
                                }
                                },
                            });
                        }
                        
                    }
                });
                
                  $country = $('.form-wrap[data-trigger="#cooperate"] #country').selectize({
                    persist: false,
                    create: false,
                    onInitialize: function () {
                        this.$control_input.attr('readonly', true);
                        var s = this;
                        this.revertSettings.$children.each(function () {
                            $.extend(s.options[this.value], $(this).data());
                        });
                    },
                    onDropdownOpen: function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                                s.removeOption($(this)[0].text);
                        }
                        });
                        if(this.getValue() && this.options[this.getValue()].$order == 1)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if (!value.length) return;
                        var option = this.options[value];
                       districtcf3.disable();
                       districtcf3.clearOptions(); 
                       province.disable(); 
                       province.clearOptions();  
                       $('.cooperate-form #province').parent().removeClass('success');
                       $('.cooperate-form #district').parent().removeClass('success');

                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                            type: "POST",
                            data: { action: "province_by_country", country: option.id, security: jQuery('[name=dt_nonce]').val() },
                            dataType: "json",
                            success: function (json_data) {
                                console.log(json_data);
                                
                                if(json_data)
                                {
                                    province.clearOptions();
                                    province.load(function(callback) {
                                        province.enable();
                                        callback(json_data);
                                    }); 
                                    
                                }
                            },
                        });
                        //scroll2bottom
                        if ($('.form-wrap[data-trigger="#cooperate"] .form').length)
                        {
                            $('.form-wrap .form').animate({
                                scrollTop: $('.form-wrap[data-trigger="#cooperate"] .form').get(0).scrollHeight
                            },100,'linear'); 
                        }
                        
                    },
                    score: function (search)
                    {
                        return function (option)
                        {
                            search = removeVietnameseTones(search.toLowerCase());
                            var option_value = removeVietnameseTones(option.text.toLowerCase());
                            if (option_value.indexOf(search) > -1)
                            {
                                return 1;
                            }
                            return 0;
                        }
                    },
                    
                });


                $province = $('.form-wrap[data-trigger="#cooperate"] #province').selectize({
                    // persist: false,
                    // create: false,
                    // Template với data-id
                    render: {
                        option: function(item, escape) {
                            return '<div class="option" data-id="' + escape(item.id) + '">' +
                                '<span class="province-name">' + escape(item.text) + '</span>' +
                                (item.code ? '' : '') +
                                '</div>';
                        },
                        item: function(item, escape) {
                            return '<div class="item" data-id="' + escape(item.id) + '">' +
                                escape(item.text) +
                                '</div>';
                        }
                    },
                    onInitialize: function () {
                        this.$control_input.attr('readonly', true);
                        var s = this;
                        this.revertSettings.$children.each(function () {
                            $.extend(s.options[this.value], $(this).data());
                        });
                    },
                    onDropdownOpen: function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                                s.removeOption($(this)[0].text);
                        }
                        });
                        if(this.getValue() && this.options[this.getValue()].$order == 1)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if (!value.length) return;
                        var option = this.options[value];
                        // district.disable();
                        // district.clearOptions();  
                        var selectedCountry = country.getValue();
                        var selectedOptionCountry = country.options[selectedCountry];
                        var countryId = selectedOptionCountry.id;
                         $('.cooperate-form #district').parent().removeClass('success');
                    
                        console.log('country: '+countryId);
                        
                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                            type: "POST",
                            data: { action: "district_by_province", province: option.id, country: countryId, security: jQuery('[name=dt_nonce]').val() },
                            dataType: "json",
                            success: function (json_data) {
                               
                                if(json_data)
                                {
                                    districtcf3.clearOptions();
                                    districtcf3.load(function(callback) {
                                        districtcf3.enable();
                                        callback(json_data);
                                    }); 
                                    
                                }
                            },
                        });
                        //scroll2bottom
                        if ($('.form-wrap[data-trigger="#cooperate"] .form').length)
                        {
                            $('.form-wrap .form').animate({
                                scrollTop: $('.form-wrap[data-trigger="#cooperate"] .form').get(0).scrollHeight
                            },100,'linear'); 
                        }
                        
                    },
                    score: function (search)
                    {
                        return function (option)
                        {
                            search = removeVietnameseTones(search.toLowerCase());
                            var option_value = removeVietnameseTones(option.text.toLowerCase());
                            if (option_value.indexOf(search) > -1)
                            {
                                return 1;
                            }
                            return 0;
                        }
                    },
                    
                });
                $districtcf3 = $('.form-wrap[data-trigger="#cooperate"] #district').selectize({
                     onInitialize: function() {
                        this.$control_input.attr('readonly', true);
                    },
                    onDropdownOpen:  function(value)
                    {
                    var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                            s.removeOption($(this)[0].text);
                        }
                        });
                    },
                });
                var districtcf3  = $districtcf3[0].selectize;
                var province = $province[0].selectize;
                var country = $country[0].selectize;
                districtcf3.disable();

                function removeVietnameseTones(str) {
                    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
                    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
                    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
                    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
                    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
                    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
                    str = str.replace(/đ/g,"d");
                    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
                    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
                    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
                    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
                    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
                    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
                    str = str.replace(/Đ/g, "D");
                    // Một vài bộ encode coi các dấu mũ, dấu chữ như một kí tự riêng biệt nên thêm hai dòng này
                    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
                    str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
                    // Remove extra spaces
                    // Bỏ các khoảng trắng liền nhau
                    str = str.replace(/ + /g," ");
                    str = str.trim();
                    // Remove punctuations
                    // Bỏ dấu câu, kí tự đặc biệt
                    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g," ");
                    return str;
                }

               
                jQuery('body').on('click', '.mini-popup', function(e) {
                    e.stopPropagation();
                });
                jQuery('body').on('click', '.mini-popup__close', function(e) {
                    e.stopPropagation();
                    $('.mini-popup').remove();
                    $('body').removeClass('minipopup-show');
                });
                jQuery('body').on('click', '.scrollbot-btn', function(e) {
                    $('.form-wrap .form').animate({
                        scrollTop: $('.form-wrap[data-trigger="#cooperate"] .form').get(0).scrollHeight
                    },100,'linear'); 
                    
                });

                ScrollArrow();
                function ScrollArrow()
                {
                    $('.form').scroll(function() {
                        if($(this).scrollTop() + $(this).outerHeight() < $(this).get(0).scrollHeight - 60)
                        {
                            $('.scrollbot-btn').fadeIn('faster');
                            $('.scrollbot-btn').css('top',get_rem_value($(this).scrollTop() + $(this).outerHeight()) - 2.5 +'rem');
                        }
                        else
                        {
                            $('.scrollbot-btn').fadeOut('faster');
                        }
                        
                    });
                }
                function get_rem_value(px)
                {
                    return px/parseFloat(jQuery('html').css('font-size'));
                }
                function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    FormSubmit();
                    function FormSubmit()
                    {
                        $('.form-wrap form.cooperate-form').submit(function(e) {
                            e.preventDefault();
                            $('[name=save_form]').prop('disabled', true);
                            var flag = true;
                            var form = $(this);
                            $('.form-wrap .cooperate-form .invalid').remove();
                            $(".form-wrap .cooperate-form .form-group>*").removeClass('is-invalid');

                            $(".form-wrap .cooperate-form input[name ='fullname'],.form-wrap .cooperate-form input[name ='privacy_policy'],.form-wrap .cooperate-form .select-group select").each(function() {
                                if($(this).attr('type') == 'checkbox')
                                {
                                    if(!$(this).is(':checked'))
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                                else if($(this).prop("tagName").toLowerCase() == 'select')
                                {
                                    if(!$(this).val() || $(this).val() == $(this).attr('placeholder'))
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                                else
                                {
                                    if(!$(this).val() || $(this).val().length < 3)
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                            });
                            if(!$(".form-wrap .cooperate-form input[name ='phone']").val())
                            {
                                flag = false;
                                $(".form-wrap .cooperate-form input[name ='phone']").addClass('is-invalid');
                                $(".form-wrap .cooperate-form input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-missing-error')+'</span>');
                            }
                            else if(!isPhone($(".form-wrap .cooperate-form input[name ='phone']").val()))
                            {
                                flag = false;
                                $(".form-wrap .cooperate-form input[name ='phone']").addClass('is-invalid');
                                $(".form-wrap .cooperate-form input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-format-error')+'</span>');
                            }
                            if(!$(".form-wrap .cooperate-form input[name ='email']").val())
                            {
                                flag = false;
                                $(".form-wrap .cooperate-form input[name ='email']").addClass('is-invalid');
                                $(".form-wrap .cooperate-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-missing-error')+'</span>');
                            }
                            else if(!isEmail($(".form-wrap .cooperate-form input[name ='email']").val()))
                            {
                                flag = false;
                                $(".form-wrap .cooperate-form input[name ='email']").addClass('is-invalid');
                                $(".form-wrap .cooperate-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-format-error')+'</span>');
                            }
                        
                            if(flag)
                            {
                                                                var formData = form.serialize();
                                 formData = formData+"&SubmitPlatform=Website&SourceMedium=" + 'Unknown'+"&current_url="+window.location.href+"&current_title=Liên hệ - MGF Việt Nam";
                                jQuery.ajax({
                                    url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                    type: "POST",
                                    data: formData,
                                    dataType: "json",
                                    beforeSend: function (response) {
                                        jQuery('.loading').addClass('show');
                                    },
                                    success: function (json_data) {
                                        if(json_data && json_data.status)
                                        {

                                            //Add2GSheet(form.serializeObject());
                                            Add2Manychat(formData);
                                            $('.form-wrap').empty();
                                            $('.form-wrap').append(json_data.php);
                                           
                                            // dataLayer.push({'event': '05b.orip.success'});
                                            // fbq('track', "CompleteRegistration");
                                        }
                                        jQuery('.loading').removeClass('show');
                                        $('.form-wrap .cooperate-form [name=save_form]').prop('disabled', false);
                                    },
                                });
                            }
                            else
                            {
                                $('.form-wrap .cooperate-form input.is-invalid,textarea.is-invalid').first().focus();
                                $('.form-wrap .cooperate-form [name=save_form]').prop('disabled', false);
                            }
                        
                        });
                        $.fn.serializeObject = function()
                        {
                        var o = {};
                        var a = this.serializeArray();
                        $.each(a, function() {
                            if (o[this.name]) {
                                if (!o[this.name].push) {
                                    o[this.name] = [o[this.name]];
                                }
                                o[this.name].push(this.value || '');
                            } else {
                                o[this.name] = this.value || '';
                            }
                        });
                        return o;
                        };
                    function Add2GSheet(data)
                    {
                                                var url = 'https://script.google.com/macros/s/AKfycbzdK0YTQOHPFhoTSb9B7kn5jUHWlSBli98HxtTNpdCvbmJ5eVdDZ-L8RADFe49VP6jmjQ/exec';
                        $.ajax({
                            url: url,
                            method: "GET",
                            dataType: "json",
                            data: {
                                'STT' : '',
                                'Tên' :  data.fullname,
                                'SĐT' :  data.phone,
                                'Khu vực' :  data.district+' '+data.province,
                                'Quan tâm' :  data.demand,
                                'Danh mục SP' :  data.product,
                                'Nội dung' :  data.messenge,
                                'Ngày liên hệ fanpage' :  '2025-11-01 13:00:53',
                                'Status' :  'chờ gọi',
                                'Submit Platform' :  'Website', 
                                'Source Medium' : 'Unknown'
                            },
                            success: function (response) {
                
                            },
                        });
                    }
                    function Add2Manychat(data)
                    {
                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/fb_chatbot_alert/sale-regis-alert-sales.php', 
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (json_data) {
                            
                            },
                        });
                    }
                    function isEmail(email) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        return regex.test(email);
                    }
                    function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    jQuery('body').on('input','.form-group input',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        jQuery(this).parent().removeClass('success');
                        if($(this).val().length > 3)
                        {
                            if($(this).attr('name') == 'phone')
                            {
                                if(isPhone($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else if($(this).attr('name') == 'email')
                            {
                                if(isEmail($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else
                            {
                                $(this).parent().addClass('success');
                            }
                            
                        }
                        
                    });
                    jQuery('body').on('change','.form-group select',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        if($(this).val() && $(this).val() != $(this).attr('placeholder'))
                        {
                            $(this).parent().addClass('success');
                        }
                    });
                }
                rise_label();
                function rise_label()
                {
                    jQuery(".rise-label input, .rise-label textarea").focusin(function(){
                        jQuery(this).parent().addClass('active');
                    }).focusout(function(){
                        if(!jQuery(this).val())
                        {
                            jQuery(this).parent().removeClass('active');
                        }
                    });
                }
                jQuery('a[href^="#cooperate"]').on('click', function(e) {
                    e.preventDefault();
                        e.stopPropagation();
                        $this = $(this);
                        if(jQuery(e.target).closest('.cta__close').length)
                        {
                            $this.removeClass('show');
                        }
                        else
                        {
                            if($this.hasClass('circle-cta') && !window.matchMedia("(max-width: 1023px)").matches)
                            {
                                $this.removeClass('show');
                                $this.removeClass('circle-cta').addClass('show');
                                setTimeout(function(){
                                    $this.addClass('circle-cta');
                                }, 15000);
                            }
                            else
                            {
                                $('.form-wrap[data-trigger="#cooperate"]').addClass('show');
                                var line = $('.form-wrap[data-trigger="#cooperate"]').find('.form-line').php();
                                $('.form-wrap[data-trigger="#cooperate"]').find('.form-line').empty().append(line);
                                if($this.hasClass('cta-btn'))
                                {
                                    $this.removeClass('show');
                                }
                                /* set default val */
                                if($('.g3f-tabs__navs').length)
                                {
                                    var s = $product[0].selectize;
                                    var val = $('.g3f-tabs__navs').find('.btn.active').attr('href').replace('#', '');
                                    val = removeVietnameseTones(val.toLowerCase().replace("-", " "));
                                    $.each(s.options, function (e) {
                                    if(removeVietnameseTones($(this)[0].text.toLowerCase()) == val)
                                    {
                                            $product[0].selectize.setValue($(this)[0].text);
                                    }
                                    });
                                }
                                                                if ($(".form-wrap .form").outerHeight() < ($(".form-wrap .form-content").height() + 80) ) {
                                    if(!$(".form-wrap .form .scrollbot-btn").length)
                                    {
                                        $(".form-wrap .form").append('<div class="scrollbot-btn"><span class="nav-arrow arrow-1"></span> <span class="nav-arrow arrow-2"></span> <span class="nav-arrow arrow-3"></span></div>');
                                        $('.scrollbot-btn').css('top',get_rem_value($(".form-wrap .form").scrollTop() + $(".form-wrap .form").outerHeight()) - 2.5 +'rem');
                                    }   
                                }
                            }
                        }
                        
                    });
            });
      </script>
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
