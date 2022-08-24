<!-- ======= Footer ======= -->
<footer id="footer">



	<div class="footer-top">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 col-md-6 footer-contact">
					<h3><img src="{{asset('front_style/image/logo.png')}}"></h3>
					<p>
						{{--$setting->address--}}
						<br>
						<strong>Phone:</strong> +{{--$setting->whatsapp--}}<br>
						<strong>Email:</strong> info{{--$setting->email--}}<br>
					</p>
				</div>

				<div class="col-lg-3 col-md-6 footer-links">
					<h4>روابط مفيدة</h4>
					<ul>
						<li><i class="bx bx-chevron-right"></i> <a href="#">الرئيسية</a></li>
						<li><i class="bx bx-chevron-right"></i> <a href="#">وصفاتنا</a></li>
						<li><i class="bx bx-chevron-right"></i> <a href="#">الشيفات</a></li>
						<li><i class="bx bx-chevron-right"></i> <a href="#"> انضم كشيف</a></li>
					</ul>
				</div>

				<div class="col-lg-3 col-md-6 footer-links">
					<h4>اقسامنا</h4>
					<ul>
						{{-- @forelse($categories as $cat)
						<li><i class="bx bx-chevron-right"></i> <a href="#">{{$cat->name}}</a></li>
						@empty

						@endforelse--}}
					</ul>
				</div>

				<div class="col-lg-3 col-md-6 footer-links">
					<h4>حسابات التواصل الاجتماعي</h4>
					<p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
					<div class="social-links mt-3">
						<a href="{{--$setting->twiter--}}" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a>
						<a href="{{--$setting->facebook--}}" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
						<a href="{{--$setting->instagram--}}" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
						<a href="{{--$setting->whatsapp--}}" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
					</div>
				</div>

			</div>
		</div>
	</div>


</footer><!-- End Footer -->
<div class="modal fade" id="orangeModalSubscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold">تسجيل</h4>

			</div>
			<form method="post" action="{{ route('login') }}">
				@csrf
				<div class="modal-body mx-3">

					<div class="md-form mb-5">
						<i class="fas fa-envelope prefix grey-text"></i>
						<label data-error="wrong" data-success="right" for="defaultForm-email">ايميل</label>
						<input type="email" id="defaultForm-email" name="email" class="form-control validate">
					</div>

					<div class="md-form mb-4">
						<i class="fas fa-lock prefix grey-text"></i>
						<label data-error="wrong" data-success="right" for="defaultForm-pass">كلمة السر</label>
						<input type="password" id="defaultForm-pass" name="password" class="form-control validate">
					</div>

				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button class="btn btn-default" style=" width: 310px; height: 50px; border-radius: 15px; color: #fff !important; border: 2px solid #ff7040; min-width: 106px; height: 39px; text-align: center; background: #ff7040 !important; ">دخول</button>
				</div>

				<div class="pb-5">
					<span style="margin-right:80px;color:#ffc472">لاتمتلك حسابا</span>
					<span style="margin-right:180px;color:#ffc472"> استعادة كلمة السر</span>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset('front_style/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
<script src="{{asset('front_style/assets/vendor/php-email-form/validate.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('front_style/assets/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
	$(() => {
		$('body').on('click', '.register-btn', () => {

			$('#orangeModalSubscription').modal('show');
		})

	})
</script>

</body>

</html>