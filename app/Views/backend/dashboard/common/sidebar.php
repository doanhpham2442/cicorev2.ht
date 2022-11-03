<nav class="navbar-default navbar-static-side" role="navigation">
   <?php
      $user = authentication();
      $uri = service('uri');
      $uri = current_url(true);
      $uriModule = $uri->getSegment(2);
      $uriModule_name = $uri->getSegment(3);
      $baseController = new App\Controllers\BaseController();
      // pre($sidebar);
      $language = $baseController->currentLanguage();
   ?>
   <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
         <li class="nav-header">
            <div class="dropdown profile-element">
               <span><img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="min-width:48px;height:48px;" /></span>
               <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                  <span class="clear">
                     <span class="block m-t-xs"> <strong class="font-bold" style="color:#fff"><?php echo $user['fullname'] ?></strong>
                  </span>
                  <span class="text-muted text-xs block"><?php echo $user['job'] ?> <b class="caret" style="color: #8095a8"></b></span> </span>
               </a>
               <ul class="dropdown-menu animated fadeInRight m-t-xs">
                  <li><a href="<?php echo base_url('backend/user/profile/profile/'.$user['id']) ?>">Profile</a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
               </ul>
            </div>
            <div class="logo-element">HT+</div>
         </li>
         <li class="<?php echo ( $uriModule == 'article') ? 'active'  : '' ?>">
            <a href="index.html"><i class="fa fa-file"></i> <span class="nav-label">QL Bài Viết</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/catalogue/index') ?>">QL Nhóm Bài Viết</a></li>
               <li class="<?php echo ( $uriModule_name == 'article') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/article/index') ?>">QL Bài Viết</a></li>
            </ul>
         </li>
         <li class="<?php echo ( $uriModule == 'product') ? 'active'  : '' ?>">
            <a href="index.html"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span class="nav-label">QL Sản phẩm</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.product.catalogue.index')) ?>">QL Nhóm Sản phẩm</a></li>
               <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.product.product.index')) ?>">QL Sản phẩm</a></li>
            </ul>
         </li>
         <li class="<?php echo ( $uriModule == 'attribute') ? 'active'  : '' ?>">
            <a href="index.html"><i class="fa fa-linode" aria-hidden="true"></i> <span class="nav-label">QL Thuộc tính</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.attribute.catalogue.index')) ?>">QL Nhóm thuộc tính</a></li>
               <li class="<?php echo ( $uriModule_name == 'attribute') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.attribute.attribute.index')) ?>">QL thuộc tính</a></li>
            </ul>
         </li>
         <li class="<?php echo ( $uriModule == 'order') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.order.order.index')) ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span class="nav-label">QL Đơn hàng</span></a>
         </li>

         <li class="<?php echo ( $uriModule == 'marketing') ? 'active'  : '' ?>">
            <a href="index.html"><i class="fa fa-gift" aria-hidden="true"></i> <span class="nav-label">QL Marketing</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li class="<?php echo ( $uriModule_name == 'promotion') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.marketing.promotion.index')) ?>">QL CT khuyến mãi</a></li>
               <li class="<?php echo ( $uriModule_name == 'voucher') ? 'active'  : '' ?>"><a href="<?php echo base_url(route('backend.marketing.voucher.index')) ?>">QL Mã KM</a></li>
            </ul>
         </li>

         <li class="<?php echo ( $uriModule == 'review') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.review.review.index')) ?>"><i class="fa fa-wpforms" aria-hidden="true"></i> <span class="nav-label">QL Review</span></a>
         </li>

         <li class="<?php echo ( $uriModule == 'widget') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.widget.widget.index')) ?>"><i class="fa fa-wpforms" aria-hidden="true"></i> <span class="nav-label">QL Widget</span></a>
         </li>


         <li class="<?php echo ( $uriModule == 'slide') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.slide.slide.index')) ?>"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span class="nav-label">QL Slide</span></a>
         </li>
         <li class="<?php echo ( $uriModule == 'language') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.language.language.index')) ?>"><i class="fa fa-language" aria-hidden="true"></i> <span class="nav-label">QL Ngôn ngữ</span></a>
         </li>
         <li class="<?php echo ( $uriModule == 'menu') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.menu.menu.listmenu')) ?>"><i class="fa fa-bars" aria-hidden="true"></i> <span class="nav-label">QL Menu</span></a>
         </li>
         <li class="<?php echo ( $uriModule == 'system') ? 'active'  : '' ?>">
            <a href="<?php echo base_url(route('backend.system.general.index')) ?>"><i class="fa fa-cog" aria-hidden="true"></i> <span class="nav-label">Cài đặt chung</span></a>
         </li>
         <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
            <a href="index.html"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label">Quản lý User</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/catalogue/index') ?>">Nhóm Thành Viên</a></li>
               <li class="<?php echo ( $uriModule_name == 'user') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/user/index') ?>">Thành viên</a></li>
            </ul>
         </li>
      </ul>
   </div>
</nav>
