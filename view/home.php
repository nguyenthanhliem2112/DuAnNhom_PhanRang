<?php
    $html_dssp_new=showsp($dssp_new);
    // $html_dssp_best=showsp($dssp_best);
    $html_dssp_view=showsp($dssp_view);
    $html_luotmua = showluotmua($dssp_luotmua);
?>

<style>
        body {
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        }

        .slider-container {
        background: #1A1A1A;
        display: flex;
        height:700px;
        }

        .text-container {
        flex: 0.8;
        margin-top:200px;
        padding: 50px;
        }
        .text-container h2,h5,p{
            color:white;
        }
        .text-container h4{
            color:black;
        }
        .image-slider {
        flex: 1.2;
        overflow: hidden;
        }

        .image-slider img {
        width: 850px;
        display: none;
        }
        .text-container button {
        background-color: #523713;
        color: white;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        }

        .text-container button:hover {
        background-color: black;
        }
    </style>
    <div class="slider-container">
    <div class="text-container">
  <h5 style="color: white;">Chào Mừng Đến Với PHANRANG</h5>
  <h4 style="color: white;">Ưu Đãi</h4>
  <h2 style="color: white;">Trên Tất Cả Sản Phẩm</h2>
  <p style="color: gray;">Tiết kiệm nhiều hơn với phiếu giảm giá và giảm giá tới 70%!</p>
  <a href="index.php?pg=shop"><button>Mua Ngay</button></a>
</div>
    <div class="image-slider" id="imageSlider">
      <!-- Your image slides go here -->
      <img src="layout/img/banner/b24.jpg" alt="Image 1">
      <img src="layout/img/banner/b25.jpg" alt="Image 2">
      <img src="layout/img/banner/b26.jpg" alt="Image 3">
      <img src="layout/img/banner/b27.jpg" alt="Image 4">
      <!-- Add more images as needed -->
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
  const imageSlider = document.getElementById("imageSlider");
  const images = document.querySelectorAll(".image-slider img");

  let currentIndex = 0;

  // Show the first image initially
  images[currentIndex].style.display = "block";

  // Function to switch to the next image
  function nextImage() {
    images[currentIndex].style.display = "none";
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].style.display = "block";
  }

  // Set an interval to switch images every 3 seconds (adjust as needed)
  setInterval(nextImage, 3000);
});

  </script>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="layout/img/features/f1.png" alt="">
            <h6>Miễn Phí Giao Hàng</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f2.png" alt="">
            <h6>Đặt Hàng Online</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f3.png" alt="">
            <h6>Tiết Kiệm Tiền</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f4.png" alt="">
            <h6>Khuyến Mãi</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f5.png" alt="">
            <h6>Thân Thiện</h6>
        </div>
        <div class="fe-box">
            <img src="layout/img/features/f6.png" alt="">
            <h6>Hỗ Trợ 24h</h6>
        </div>
    </section>

    <section id="product1" class="section-p1">
    <div class="pro-container">
            <!--sản phẩm mới -->
            
        </div>
        <h2>SẢN PHẨM BÁN CHẠY</h2>
        <!-- <p>Summer Collection New Morden Design</p> -->
        <div class="pro-container">
            <!--sản phẩm mới -->
            <?=$html_luotmua;?>
        </div>
    </section>

    <section id="product1" class="section-p1">

        <h2>SẢN PHẨM MỚI</h2>
        <!-- <p>Summer Collection New Morden Design</p> -->
        <div class="pro-container">
            <!--sản phẩm mới -->
            <?=$html_dssp_new;?>
        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>MUA SẢN PHẨM TẠI PHANRANG </h4>
        <h2>Giảm Giá <span>15% </span> Sản Phẩm Mới</h2>
        <a href="index.php?pg=shop"><button class="normal">XEM NGAY </button></a>
    </section>

    <section id="product1" class="section-p1">
        <!-- <p>Summer Collection New Morden Design</p> -->
        <div class="pro-container">
      
        </div>
    </section>
    
    <section id="product1" class="section-p1">

        <h2>SẢN PHẨM HOT</h2>
        <!-- <p>Summer Collection New Morden Design</p> -->
        <div class="pro-container">
            <!--sản phẩm mới -->
            <?=$html_dssp_new;?>
        </div>
    </section>

    <!-- <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>buy 1 get 1 free</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white"><a href="index.php?pg=shop&iddm=103">Learn More</a></button>
        </div>
        <div class="banner-box banner-box2">
            <h4>spring/summer</h4>
            <h2>upcomming season</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white">Collection</button>
        </div>
    </section> -->

    <!-- <section id="banner3">
        <div class="banner-box">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>NEW FOOTWEAR COLLECTION</h2>
            <h3>Spring/Summer 2022</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>T-SHIRTS</h2>
            <h3>New Trendy Printe</h3>
        </div>
    </section> -->

    

