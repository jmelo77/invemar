<?php
session_start();
include("sitefiles/includes/header.php");
?>
	<!-- begin::Body -->
	<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="index.php">
					<img alt="Logo" src="assets/media/logos/logoInvemar.png" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar">
            <!--
				<div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>-->
				<div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
                <!--
				<div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
                -->
			</div>
		</div>

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->
				<!-- end:: Aside -->
                
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">

						<!-- begin:: Aside -->
						<div class="kt-header__brand kt-grid__item" id="kt_header_brand">
							<div class="kt-header__brand-logo">
								<a href="index.php">
									<img alt="Logo" src="assets/media/logos/logoInvemar.png" />
								</a>
							</div>
						</div>

						<!-- end:: Aside -->

						<!-- begin:: Title -->
                        <!--
						<h3 class="kt-header__title kt-grid__item">
							Aplicaci&oacute;n Invemar
						</h3>
						-->
						<!-- end:: Title -->

							<!-- begin: Header Menu -->
							<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
								<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                    
									<ul class="kt-menu__nav ">
                                    
										<li class="kt-menu__item kt-menu__item--active" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="index.php" class="kt-menu__link "><span class="kt-menu__link-text">Listado de Especies</span></a>
										</li>                                                                   
                                        
									</ul>                                    
                                    
								</div>
							</div>

							<!-- end: Header Menu -->

						<!-- begin:: Header Topbar -->
                       
						<div class="kt-header__topbar">

							<!--begin: Search -->

							<!--end: Search -->

							<!--begin: Notifications -->

							<!--end: Notifications -->

							<!--begin: Quick actions -->
							<!--end: Quick actions -->

							<!--begin: Cart -->
							<!--end: Cart-->

							<!--begin: Language bar -->
							<!--end: Language bar -->

							<!--begin: User bar -->
							<!--end: User bar -->

							<!--begin: Quick panel toggler -->
							<!--end: Quick panel toggler -->
						</div>

						<!-- end:: Header Topbar -->
					</div>

					<!-- end:: Header -->
					<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
						<!-- begin:: Content -->

						<!-- begin:: Content -->
						<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

						<!--Begin::Dashboard 6-->

						<!-- begin:: Content -->
						<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

							<div class="kt-portlet kt-portlet--mobile">
								<div class="kt-portlet__head kt-portlet__head--lg">
									<div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-paper"></i>
										</span>
										<h3 class="kt-portlet__head-title">
											Listado de Especies
										</h3>
									</div>
									<div class="kt-portlet__head-toolbar">
										<div class="kt-portlet__head-wrapper">
											<div class="kt-portlet__head-actions">
                                                <a href="#addnew" data-toggle="modal" class="btn btn-brand btn-elevate btn-icon-sm">
                                                <i class="la la-plus"></i>
													Crear&nbsp;Especie
                                                </a>
											</div>
										</div>
									</div>
								</div>
								<div class="kt-portlet__body">

									<!--begin: Datatable -->
                                                                      
            <div class="row">
			<?php
				if(isset($_SESSION['error'])){
					
											echo '<div class="alert alert-danger fade show" role="alert">
														<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
														<div class="alert-text">'.$_SESSION['error'].'</div>
														<div class="alert-close">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true"><i class="la la-close"></i></span>
															</button>
														</div>
													</div>';					
					
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					
											echo '<div class="alert alert-success fade show" role="alert">
														<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
														<div class="alert-text">'.$_SESSION['success'].'</div>
														<div class="alert-close">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true"><i class="la la-close"></i></span>
															</button>
														</div>
													</div>';				
					
					unset($_SESSION['success']);
				}
				
				if(isset($_GET['s'])){
					
											echo '<div class="alert alert-success fade show" role="alert">
														<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
														<div class="alert-text">Registro Guardado con &Eacute;xito</div>
														<div class="alert-close">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true"><i class="la la-close"></i></span>
															</button>
														</div>
													</div>';
				}
				
				if(isset($_GET['b'])){
					
											echo '<div class="alert alert-success fade show" role="alert">
														<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
														<div class="alert-text">Registro Borrado con &Eacute;xito</div>
														<div class="alert-close">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true"><i class="la la-close"></i></span>
															</button>
														</div>
													</div>';
				}							
			?>
			</div>
                                                                        
									<table class="table table-striped table-bordered table-hover table-checkable" id="kt_table_1">
										<thead>
											<tr>
												<th class="text-center">Id</th>
                                                <th class="text-center">Especie</th>
												<th class="text-center">Familia</th>
												<th class="text-center">Nombre Com&uacute;n</th>
												<th class="text-center">Proyecto</th>
												<th class="text-center">Base Registro</th>
                                                <th class="text-center">Iden</th>
												<th class="text-center">A&ntilde;o Iden</th>
                                                <th class="text-center">Dpto</th>
                                                <th class="text-center">Mun</th>
                                                <th class="text-center">Loc</th>
												<th class="text-center">Lat</th>
                                                <th class="text-center">Lon</th>
                                                <th class="text-center">Autor</th>
                                                <th class="text-center">Fecha Captura</th>
                                                <th class="text-center">Ecorregion</th>
                                                <th class="text-center">Accion</th>
											</tr>
										</thead>
									</table>

									<!--end: Datatable -->
								</div>
							</div>
						</div>                   

						<!-- end:: Content -->
                        

							<!--End::Dashboard 6-->
						</div>

						<!-- end:: Content -->

						<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
						<div class="kt-footer__copyright">
							<?=date("Y");?>&nbsp;&copy;&nbsp;<a href="index.php" class="kt-link">Invemar</a>
						</div>
					</div>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Panel -->
		<!-- end::Quick Panel -->
        
		<!--begin::Modal-->

        <?php include('add_modal.php'); ?>
                                    
		<!--end::Modal-->  

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>

		<!-- end::Scrolltop -->

		<!-- begin::Sticky Toolbar -->
		<!-- end::Sticky Toolbar -->

		<!-- begin::Demo Panel -->
		<!-- end::Demo Panel -->

<? include("sitefiles/includes/footer.php");  ?>        
        
	</body>

	<!-- end::Body -->
</html>