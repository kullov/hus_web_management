<?php
// Initialize the session
session_start();
// Include config file
require "../../config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: ../../");
  exit;
}
$amount = $register = $assignment = $position = $date_created = $description = $type = $status = "";
$id_request = trim($_GET["id"]);
$stmt = $link->prepare("SELECT rq.`amount`, ( SELECT COUNT(*) FROM `register` rg WHERE rg.request_id = rq.id ) register, ( SELECT COUNT(*) FROM `request_assignment` ra WHERE ra.request_id = rq.id ) assigment, rq.`position`, rq.`date_created`, rq.`description`, rq.`type`, s.name 'status' FROM `request` rq, STATUS s WHERE rq.id = ? AND s.id = rq.status");
$stmt->bind_param("s", $id_request);
if ($stmt->execute()) {
  $stmt->bind_result($amount, $register, $assignment, $position, $date_created, $description, $type, $status);
  $stmt->fetch();
} else {
  echo "<script>alert('Failed!!')</script>";
  header('location: scr_1001B.php');
  exit;
}
$stmt->close();


?>
<!DOCTYPE html>
<html>
<title>Detail Recruit Form</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
.mySlides {display: none}
</style>
<body class="w3-light-grey w3-content" style="max-width:1600px">
  <?php include("../../navigation.php"); ?>
  <div style="margin-top: 55px;">
    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-light-grey w3-bar-block w3-collapse w3-top w3-center" style="z-index:3;width:250px; padding-top: 55px;padding-bottom: 55px;" id="mySidebar">
      <h3 class="w3-padding-64 w3-center"><b>NEWWAVE <br>Solution JSC</b></h3>
      <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-hide-large">ĐÓNG</a>
      <a href="#space" onclick="w3_close()" class="w3-bar-item w3-button">KHÔNG GIAN</a> 
      <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">THÔNG TIN</a> 
      <a href="#require" onclick="w3_close()" class="w3-bar-item w3-button">YÊU CẦU</a> 
      <form action="scr_1001A.php?id=<?php echo $id_request?>" method="post"><button type="submit" name="registerBtnSmt" onclick="w3_close()" class="w3-bar-item w3-button  <?php if (($_SESSION["role"]) !== "student") { ?> w3-hide <?php }?> ">ĐĂNG KÝ</button></form> 
      <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button">LIÊN HỆ</a>
      <a href="scr_1001B.php" onclick="w3_close()" class="w3-bar-item w3-button">TRỞ VỀ</a>
    </nav>

    <!-- Top menu on small screens -->
    <header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
      <span class="w3-bar-item">Rental</span>
      <a href="javascript:void(0)" class="w3-right w3-bar-item w3-button" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-white w3-padding" style="margin-left:260px">

      <!-- Push down content on small screens -->
      <div class="w3-hide-large" style="margin-top:80px"></div>

      <!-- Slideshow Header -->
      <h3 class="w3-center"><i>PHIẾU YÊU CẦU CỦA DOANH NGHIỆP</i></h3>
      <h3 class="w3-center"><i><span>VỊ TRÍ TUYỂN DỤNG:</span> <strong style="font-size: xx-large;" class="w3-text-red"><?php echo $position ?></strong></i></h3>
      <h6>Mã phiếu: <b><?php echo $id_request ?></b></h6>
      <div class="w3-container" id="space">
        <hr>
        <br>
        <div class="w3-display-container mySlides">
          <img src="https://we25.vn/media/images/anh3(13).jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
        <div class="w3-display-container mySlides">
          <img src="https://file4.batdongsan.com.vn/resize/745x510/2019/06/10/20190610085624-b7e0_wm.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
          </div>
        <div class="w3-display-container mySlides">
          <img src="https://cogo.vn/2018_cogo_contents/images/SYL_7995.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
        <div class="w3-display-container mySlides">
          <img src="https://znews-photo.zadn.vn/w660/Uploaded/wyhktpu/2018_05_10/image007.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
      </div>
      <div class="w3-row-padding w3-section">
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://we25.vn/media/images/anh3(13).jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(1)" title="Living room">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://cogo.vn/2018_cogo_contents/images/SYL_7995.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(3)" title="Bedroom">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://znews-photo.zadn.vn/w660/Uploaded/wyhktpu/2018_05_10/image007.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(4)" title="Second Living Room">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://file4.batdongsan.com.vn/resize/745x510/2019/06/10/20190610085624-b7e0_wm.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(2)" title="Dining room">
        </div>
      </div>
      
      <div id="about" class="w3-container">
        <br><br><br>
        <h4><strong>THÔNG TIN</strong></h4>
        <div class="w3-row w3-large">
          <div class="w3-col s6" style="padding-left: 50px;">
            <p><i class="fa fa-fw fa-male"></i> Chúng tôi cần: <b><?php echo $amount ?></b> người</p>
            <p><i class="fa fa-fw fa-check-square"></i> Số lượng đã đăng ký: <?php echo $register ?></p>
            <p><i class="fa fa-fw fa-clock-o"></i> Check In: 8:30 AM</p>
            <p><i class="fas fa-map-marker-alt"></i> Địa điểm làm việc: 334 Nguyễn Trãi, Thanh Xuân, Hà Nội</p>
          </div>
          <div class="w3-col s6" style="padding-left: 100px;">
            <p><i class="fa fa-fw fa-check"></i> Trạng thái: Còn hiệu lực</p>
            <p><i class="fas fa-check-double"></i> Đã được phân công: <?php echo $assignment ?></p>
            <p><i class="fa fa-fw fa-clock-o"></i> Check Out: 5:30 PM</p>
            <p><i class="fas fa-calendar-alt"></i> Hình thức làm việc: <?php echo $type ?></p>
          </div>
        </div>
        <hr>
        
        <h4><strong>MÔ TẢ CÔNG VIỆC</strong></h4>
        <p>• <?php echo $description ?></p>
        <p>• Tham gia triển khai dự án nền tảng ngân hàng số, trực tiếp lập trình và hỗ trợ các thành viên trong nhóm lập trình (Java/JavaScripts)</p>
        <p>• Tiếp nhận chuyển giao công nghệ từ nhà cung cấp giải pháp</p>
        <p>• Chủ động cập nhật các xu hướng, công nghệ, giải pháp mới nhằm đề xuất những ứng dụng đáp ứng tốt hơn nhu cầu của Khách hàng và các bộ phận trong Ngân hàng</p>
        <hr>

        <h4><strong>PHÚC LỢI</strong></h4>
        <div class="w3-row w3-large">
          <div class="w3-col s6" style="padding-left: 50px;">
            <p><i class="fas fa-volleyball-ball"></i> Playing</p>
            <p><i class="fa fa-fw fa-wifi"></i> WiFi</p>
            <p><i class="fa fa-fw fa-tv"></i> Equipment</p>
          </div>
          <div class="w3-col s6"style="padding-left: 100px;">
            <p><i class="fa fa-fw fa-cutlery"></i> Banquet</p>
            <p><i class="fa fa-fw fa-thermometer"></i> Heating</p>
            <p><i class="fa fa-fw fa-wheelchair"></i> Accessible</p>
          </div>
        </div>
        <div>
          <h4>Ngoài ra, bạn sẽ được hưởng:</h4>
          <p>• Mức lương hỗ trợ từ 3 triệu VND trở lên</p>
          <p>• Môi trường làm việc chuyên nghiệp</p>
          <p>• Có cơ hội thăng tiến, đào tạo</p>
        </div>
      </div>
      <hr>
      
      <!-- Yêu cầu -->
      <div class="w3-container" id="require">
        <br><br><br>
        <h4><strong>YÊU CẦU</strong></h4>
        <h5><strong>Danh sách năng lực yêu cầu:</strong></h5>
        <ul style="padding-left: 270px;">
          <?php 
            $stmt = $link->prepare("SELECT ra.`request_id`, ra.`ability_id`, dic.name FROM `request_ability` ra, ability_dictionary dic WHERE ra.`request_id` = ? and ra.`ability_id`= dic.id");
            $stmt->bind_param("s", $id_request);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
              echo '<li value="'.$row["ability_id"].'">'.$row["name"].'</li><hr style="width: 20%;">';
            }
            $stmt->close();
          ?>
        </ul>
        <h5><strong>Yêu cầu thêm:</strong></h5>
        <ul class="w3-ul">
          <li>• Tốt nghiệp Đại học nước ngoài hoặc tốt nghiệp hệ kỹ sư tài năng các trường Đại học chính quy như ĐH Quốc Gia Hà Nội, ĐH Bách Khoa, ĐH Khoa học tự nhiên, Đại học FPT…</li>
          <li>• Có kinh nghiệm lập trình về <b>Java</b></li>
          <li>• Có thể làm việc bằng tiếng Anh với người nước ngoài – tương đương TOEFL iBT 85 điểm trở lên</li>
          <li>• Có kỹ năng làm việc nhóm, có tinh thần trách nhiệm cao.</li>
          <li>• Ưu tiên kinh nghiệm với AngularJS (từ 2 trở lên), CSS (SASS), HTML5, Bootstrap</li>
          <li>• Ưu tiên kinh nghiệm với Java 8, Spring Boot, Hibernate, Rest APIs, Micro services, design patterns và TDD</li>
          <li>• Cam kết thực tập tối thiểu 3 tháng</li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="w3-container" id="contact" style="margin-bottom:120px">
        <h2>LIÊN HỆ</h2>
        <i class="fa fa-map-marker" style="width:30px"></i> 334 Nguyễn Trãi, Thanh Xuân, Hà Nội<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone: 0349.749.393<br>
        <i class="fa fa-envelope" style="width:30px"> </i> Email: tranthanhnga_t61@hus.edu.vn<br>
      </div>
      
      <footer class="w3-container w3-padding-16" style="margin-top:32px">Powered by 
        <a href="./" title="Origen" target="_blank" class="w3-hover-text-green">Origen</a>
        <a class="w3-button w3-green w3-right" href="scr_1001B.php">Trở về</a>
      </footer>

    <!-- End page content -->
    </div>

    <script>
    // Script to open and close sidebar when on tablets and phones
    function w3_open() {
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
      document.getElementById("myOverlay").style.display = "none";
    }

    // Slideshow Apartment Images
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function currentDiv(n) {
      showDivs(slideIndex = n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      if (n > x.length) {slideIndex = 1}
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
      }
      x[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " w3-opacity-off";
    }
    </script>
  </div>
</body>
</html>
