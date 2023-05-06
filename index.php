<?php
require("config.php");

$data = mysqli_query($conn, "SELECT * FROM user");
$row = mysqli_fetch_assoc($data);

if (!empty($_SESSION['user'])) {
  $idUser = $_SESSION['id'];
  $queryTotalCart = mysqli_query($conn, "SELECT COUNT(*) AS totalCart FROM keranjang WHERE id_user = $idUser");
  if (mysqli_num_rows($queryTotalCart) === 0) {
    $result = [
      'totalCart' => 0
    ];
  } else {
    $result = mysqli_fetch_array($queryTotalCart);
  }
}

$barang = mysqli_query($conn, "SELECT * FROM orderan");


if (isset($_POST['addToCart'])) {
  if (addToCart($_POST) > 0) {
    echo "
            <script>
                alert('Barang telah dimasukan ke keranjang');
                document.location.href = 'index.php';
            </script>
        ";
  } else {
    echo "
            <script>
                alert('Barang gagal dimasukan kedalam keranjang');
                document.location.href = 'index.php';
            </script>
        ";
  }
}



?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, maximum-scale=1">
  <title>BetaGlowing Shop</title>
  <link rel="icon" href="iconwebsite.png" type="image/png">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/animasi.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
  <link href="css/animate.css" rel="stylesheet" type="text/css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Gloock&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://kit.fontawesome.com/1b05bcc72f.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
  <style>
    .cart__count {
      position: absolute;
      right: -10px;
      top: -10px;
      display: inline-block;
      padding: 2px 7px;
      color: #fff;
      background-color: crimson;
      border-radius: 100%;
    }
  </style>

</head>

<body>
  <div id="wrapper">
    <!--Header_section-->
    <header id="header_wrapper">
      <div class="container" style="width: 90%;">
        <div class="header_box">
          <div class="logo">
            <h2 id="font-berjalan" style="display: flex; align-items: center; color: white; font-family: 'Bebas Neue', cursive;">BetaGlowing
              Shop
            </h2>
          </div>
          <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
              <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <div id="main-nav" class="collapse navbar-collapse navStyle">
              <ul class="nav navbar-nav" id="mainNav">
                <li class="active"><a href="#hero_section" class="scroll-link">Home</a></li>
                <li><a href="#aboutUs" class="scroll-link">About Us</a></li>
                <li><a href="#service" class="scroll-link">Services</a></li>
                <li><a href="#Portfolio" class="scroll-link">Galeri</a></li>
                <li><a href="#team" class="scroll-link">Testimonials</a></li>
                <li><a href="#contact" class="scroll-link">Contact</a></li>
                <li style=" justify-content: flex-end; margin-left: 30px;">
                  <?php if (isset($_SESSION['admin'])) : ?>
                    <a href="Admin/profile.php"><i class="fa-solid fa-user" style="margin-right: 10px;"></i>Profile</a>
                  <?php endif; ?>
                  <?php if (isset($_SESSION['user'])) : ?>
                    <a href="user/profile.php"><i class="fa-solid fa-user" style="margin-right: 10px;"></i>Profile</a>
                  <?php endif; ?>
                  <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) : ?>
                    <a href="Gate/login.php"><i class="fa-solid fa-right-to-bracket" style="margin-right: 10px;"></i>Login</a>
                  <?php endif; ?>
                </li>
                <?php if (isset($_SESSION['user'])) : ?>
                  <li style=" width: 50px; height: 50px; display:flex; align-items:center;">
                    <span class="cart">
                      <a href="user/keranjang.php"><i class="fa-solid fa-cart-shopping fa-xl" style="color: #ffffff;"></i></a>
                      <span class="cart__count"><?= $result['totalCart'] ?></span>
                    </span>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!--Header_section-->

    <!--Hero_Section-->
    <section id="hero_section" class="top_cont_outer">
      <div class="hero_wrapper">
        <div class="container">
          <div class="hero_section">
            <div class="row">
              <div class="col-lg-5 col-sm-7">
                <div class="top_left_cont zoomIn wow animated">
                  <h2 style="font-family: 'Gloock', serif;">Ingin Kulitmu Lebih Bersinar dan Sehat?
                  </h2>
                  <p>Temukan produk skincare terbaik dari kami dan nikmati hasilnya dalam waktu singkat!</p>
                  <a href="#service" class="read_more2">Read more</a>
                </div>
              </div>
              <div>
                <img src="img/6.png" class="bannerImg zoomIn wow animated" style="height: 100%;" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Hero_Section-->

    <section id="aboutUs">
      <!--Aboutus-->
      <div class="inner_wrapper">
        <div class="container">
          <h2>About Us</h2>
          <div class="inner_section">
            <div class="row">
              <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right"><img src="img/about-img.jpg" class="img-circle delay-03s animated wow zoomIn" alt=""></div>
              <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left">
                <div class=" delay-01s animated fadeInDown wow animated">
                  <h3>Sekilas Mengenai BetaGlowing Shop</h3><br />
                  <p>Kami adalah toko skincare yang berkomitmen untuk menyediakan produk-produk skincare berkualitas tinggi dan aman untuk kulit. Dengan pengalaman lebih dari 10 tahun di industri skincare, kami memahami betapa pentingnya perawatan kulit yang tepat untuk mencapai kulit yang sehat dan bercahaya. Produk-produk kami terdiri dari bahan-bahan alami yang dipilih dengan cermat untuk memberikan hasil yang optimal dan memenuhi kebutuhan semua jenis kulit. Kami bangga dapat memberikan solusi perawatan kulit yang efektif dan terjangkau bagi pelanggan kami.</p>
                </div>
                <div class="work_bottom"> <span>Ingin Tau Lebih??..</span> <a href="#contact" class="contact_btn">Contact
                    Us</a> </div>
              </div>

            </div>


          </div>
        </div>
      </div>
    </section>
    <!--Aboutus-->


    <!--Service-->
    <section id="service">
      <div class="container">
        <h2>Services</h2>
        <div class="service_wrapper">
          <div class="row">
            <div class="col-lg-4">
              <div class="service_block">
                <div class="service_icon icon2  delay-03s animated wow zoomIn"> <span><i class="fa fa-cart-plus"></i></span>
                </div>
                <h3 class="animated fadeInUp wow">Tambahkan Ke Keranjang</h3>
                <p class="animated fadeInDown wow">pilih produk yang anda ingin beli, setelah itu tambahkan ke keranjang
                </p>
              </div>
            </div>
            <div class="col-lg-4 borderLeft">
              <div class="service_block">
                <div class="service_icon delay-03s animated wow  zoomIn"> <span><i class="fa fa-credit-card"></i></span>
                </div>
                <h3 class="animated fadeInUp wow">Pembayaran Mudah</h3>
                <p class="animated fadeInDown wow">Nikmati Pembayaran Yang Cepat dan Mudah</p>
              </div>
            </div>
            <div class="col-lg-4 borderLeft">
              <div class="service_block">
                <div class="service_icon icon3  delay-03s animated wow zoomIn"> <span><i class="fa fa-truck"></i></span>
                </div>
                <h3 class="animated fadeInUp wow">Fast Delivery</h3>
                <p class="animated fadeInDown wow">Pengiriman Cepat, Secepat Badai Seroja</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Service-->




    <!-- Portfolio -->
    <section id="Portfolio" class="content">

      <!-- Container -->
      <div class="container portfolio_title">

        <!-- Title -->
        <div class="section-title">
          <h2>Galeri</h2>
        </div>
        <!--/Title -->

      </div>
      <!-- Container -->

      <div class="portfolio-top"></div>

      <!-- Portfolio Filters -->
      <div class="portfolio">

        <div id="filters" class="sixteen columns">
          <ul class="clearfix">
            <li><a id="all" href="#" data-filter="*" class="active">
                <h5>All</h5>
              </a></li>
            <li><a class="" href="#" data-filter=".serum">
                <h5>Serum</h5>
              </a></li>
            <li><a class="" href="#" data-filter=".sunscreen">
                <h5>Sunscreen</h5>
              </a></li>
            <li><a class="" href="#" data-filter=".pelembab">
                <h5>Pelembab</h5>
              </a></li>
            <li><a class="" href="#" data-filter=".toner">
                <h5>Toner</h5>
              </a></li>
            <li><a class="" href="#" data-filter=".cleanser">
                <h5>Cleanser</h5>
              </a></li>
          </ul>
        </div>
        <!--/Portfolio Filters -->

        <!-- Portfolio Wrapper -->
        <div class="isotope fadeInLeft animated wow" style="position: relative; overflow: hidden; height: 480px;" id="portfolio_wrapper">

          <!-- Portfolio Item -->
          <?php if (!empty($idUser)) : ?>
            <?php while ($dataBarang = mysqli_fetch_assoc($barang)) : ?>
              <div style="position: absolute; left: 0px; top: 0px; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); width: 337px; opacity: 1;" class="portfolio-item one-four   <?= $dataBarang['kategori'] ?> isotope-item">
                <div class="portfolio_img"> <img style="width: 350px ; height: 260px; margin-top: 25px; " src="Admin/assets/img/profile/<?= $dataBarang['gambar'] ?>" alt="Portfolio 1"> </div>
                <div class="item_overlay" style="width: 350px ; height: 260px; margin-top: 25px; ">
                  <div class="item_info">
                    <h4 class="project_name" style="font-family: 'Roboto Slab', serif;"><?= $dataBarang['nama'] ?></h4>
                    <h4 style="color: white;">Rp.<?= $dataBarang['harga'] ?></h4>
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $dataBarang['id_produk'] ?>">
                      <input type="hidden" name="harga" value="<?= $dataBarang['harga'] ?>">
                      <input type="hidden" name="id_user" value="<?= $_SESSION['id'] ?>">
                      <!-- button add to chart -->
                      <button type="submit" name="addToCart" style="  border: none; background: none; margin-top:20px;"><i class="fa-solid fa-cart-plus fa-xl" style="color:#ffffff;"></i></button>
                      <!-- end button add to chart -->
                    </form>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else : ?>
            <?php while ($dataBarang = mysqli_fetch_assoc($barang)) : ?>
              <div style="position: absolute; left: 0px; top: 0px; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); width: 337px; opacity: 1;" class="portfolio-item one-four   <?= $dataBarang['kategori'] ?> isotope-item">
                <div class="portfolio_img"> <img style="width: 350px ; height: 260px; margin-top: 25px; " src="Admin/assets/img/profile/<?= $dataBarang['gambar'] ?>" alt="Portfolio 1"> </div>
                <div class="item_overlay" style="width: 350px ; height: 260px; margin-top: 25px; ">
                  <div class="item_info">
                    <h4 class="project_name" style="font-family: 'Roboto Slab', serif;"><?= $dataBarang['nama'] ?></h4>
                    <h4 style="color: white;">Rp.<?= $dataBarang['harga'] ?></h4>
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $dataBarang['id_produk'] ?>">
                      <input type="hidden" name="harga" value="<?= $dataBarang['harga'] ?>">
                    </form>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
          <!--/Portfolio Item -->



        </div>
        <!--/Portfolio Wrapper -->

      </div>
      <!--/Portfolio Filters -->

      <div class="portfolio_btm"></div>


      <div id="project_container">
        <div class="clear"></div>
        <div id="project_data"></div>
      </div>


    </section>
    <!--/Portfolio -->

    <section class="page_section" id="clients">
      <!--page_section-->
      <!--page_section-->
      <div class="client_logos">
        <!--client_logos-->
        <div class="container">
          </ul>
        </div>
      </div>
    </section>
    <!--client_logos-->

    <section class="page_section team" id="team">
      <!--main-section team-start-->
      <div class="container">
        <h2>Testimonials</h2>
        <h6>Beberapa Komentar Mengenai Produk Kami</h6>

        <div class="member-area">
          <div class="row">
            <div class="col-md-6">
              <div class="member wow bounceInUp animated">
                <div class="member-container" data-wow-delay=".1s">
                  <div class="inner-container">
                    <div class="author-avatar">
                      <img class="img-circle" src="img/team_pic1.jpg" alt="Team Menber">
                    </div><!-- /.author-avatar -->

                    <div class="member-details">
                      <div class="member-top">
                        <h4 class="name">
                          John Doe
                        </h4>
                        <span class="designation">
                          Manager
                        </span>
                      </div><!-- /.member-top -->

                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus.
                        Dolor sit amet, consectetur adipiscing elit proin consequat.
                      </p>
                      <div class="member-social-link">
                        <a href="#" class="twitter-btn"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="facebook-btn"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="dribbble-btn"><i class="fa fa-dribbble"></i></a>
                        <a href="#" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
                      </div><!-- /.member-social-link -->
                    </div><!-- /.member-details -->
                  </div><!-- /.inner-container -->
                </div><!-- /.member-container -->
              </div><!-- /.member -->
            </div>

            <div class="col-md-6">
              <div class="member wow bounceInUp animated">
                <div class="member-container" data-wow-delay=".3s">
                  <div class="inner-container">
                    <div class="author-avatar">
                      <img class="img-circle" src="img/team_pic2.jpg" alt="Team Menber">
                    </div><!-- /.author-avatar -->
                    <div class="member-details">
                      <div class="member-top">
                        <h4 class="name">
                          Mark lores
                        </h4>
                        <span class="designation">
                          Web Developer
                        </span>
                      </div><!-- /.member-top -->
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus.
                        Dolor sit amet, consectetur adipiscing elit proin consequat.
                      </p>
                      <div class="member-social-link">
                        <a href="#" class="twitter-btn"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="facebook-btn"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="dribbble-btn"><i class="fa fa-dribbble"></i></a>
                        <a href="#" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
                      </div><!-- /.member-social-link -->
                    </div><!-- /.member-details -->
                  </div><!-- /.inner-container -->
                </div><!-- /.member-container -->
              </div><!-- /.member -->
            </div>

            <div class="col-md-6">
              <div class="member wow bounceInUp animated">
                <div class="member-container" data-wow-delay=".5s">
                  <div class="inner-container">
                    <div class="author-avatar">
                      <img class="img-circle" src="img/team_pic3.jpg" alt="Team Menber">
                    </div><!-- /.author-avatar -->
                    <div class="member-details">
                      <div class="member-top">
                        <h4 class="name">
                          Thomas Lere
                        </h4>
                        <span class="designation">
                          UX Designer
                        </span>
                      </div><!-- /.member-top -->
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus.
                        Dolor sit amet, consectetur adipiscing elit proin consequat.
                      </p>
                      <div class="member-social-link">
                        <a href="#" class="twitter-btn"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="facebook-btn"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="dribbble-btn"><i class="fa fa-dribbble"></i></a>
                        <a href="#" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
                      </div><!-- /.member-social-link -->
                    </div><!-- /.member-details -->
                  </div><!-- /.inner-container -->
                </div><!-- /.member-container -->
              </div><!-- /.member -->
            </div>

            <div class="col-md-6">
              <div class="member wow bounceInUp animated">
                <div class="member-container" data-wow-delay=".7s">
                  <div class="inner-container">
                    <div class="author-avatar">
                      <img class="img-circle" src="img/team_pic4.jpg" alt="Team Menber">
                    </div><!-- /.author-avatar -->
                    <div class="member-details">
                      <div class="member-top">
                        <h4 class="name">
                          Grintel Mark
                        </h4>
                        <span class="designation">
                          Web Designer
                        </span>
                      </div><!-- /.member-top -->
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus.
                        Dolor sit amet, consectetur adipiscing elit proin consequat.
                      </p>
                      <div class="member-social-link">
                        <a href="#" class="twitter-btn"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="facebook-btn"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="dribbble-btn"><i class="fa fa-dribbble"></i></a>
                        <a href="#" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
                      </div><!-- /.member-social-link -->
                    </div><!-- /.member-details -->
                  </div><!-- /.inner-container -->
                </div><!-- /.member-container -->
              </div><!-- /.member -->
            </div>
          </div><!-- /.row -->
        </div>


      </div>
      <!--/Team-->
      <!--Footer-->
      <footer class="footer_wrapper" id="contact">
        <div class="container">
          <section class="page_section contact" id="contact">
            <div class="contact_section">
              <h2>Contact Us</h2>
              <div class="row">
                <div class="col-lg-4">

                </div>
                <div class="col-lg-4">

                </div>
                <div class="col-lg-4">

                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-lg-12 wow fadeInLeft delay-06s">
                <div class="form">
                  <input class="input-text" type="text" name="" value="Your Name *" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
                  <input class="input-text" type="text" name="" value="Your E-mail *" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">
                  <textarea class="input-text text-area" cols="0" rows="0" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;">Your Message *</textarea>
                  <input class="input-btn" type="submit" value="send message">
                </div>
              </div>

            </div>
          </section>
        </div>
    </section>
    <div class="footer_bottom"><span>Copyright ©BetaGlowing Shop 2023</a>
      </span></div>
    </footer>
  </div>

  <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery-scrolltofixed.js"></script>
  <script type="text/javascript" src="js/jquery.nav.js"></script>
  <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="js/jquery.isotope.js"></script>
  <script type="text/javascript" src="js/wow.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
  <script src="https://kit.fontawesome.com/1b05bcc72f.js" crossorigin="anonymous"></script>

</body>

</html>