@extends('frontend.layout.master')
@section('content')
<!-- Start Banner -->
<section class="banner-area organic-breadcrumb">
	<div class="container">
		<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
			<div class="col-first">
				<h1>លក់ផលិតផល</h1>
				<nav class="d-flex align-items-center">
					<a href="index.html">ទំព័រដើម<span class="lnr lnr-arrow-right"></span></a>
					<a href="post-product.html">លក់ផលិតផល</a>
				</nav>
			</div>
		</div>
	</div>
</section>
<!-- End Banner -->

<!--================ Sell Product Form =================-->
<section class="checkout_area section_gap">
	<div class="container">
		<div class="billing_details">
			<div class="row">
				<div class="col-lg-8">
					<h3>បញ្ចេញផលិតផលរបស់អ្នក</h3>
					<form class="row contact_form" action="upload_product.php" method="post" enctype="multipart/form-data">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="name" placeholder="ឈ្មោះផលិតផល" required>
						</div>
						<div class="col-md-6 form-group">
							<input type="number" step="0.01" class="form-control" name="price" placeholder="តម្លៃ ($)" required>
						</div>
						<div class="col-md-6 form-group">
							<input type="text" class="form-control" name="category" placeholder="ប្រភេទ (ឧ. អេឡិចត្រូនិក)" required>
						</div>
						<div class="col-md-6 form-group">
							<input type="text" class="form-control" name="brand" placeholder="ម៉ាក (ឧ. Apple)" required>
						</div>
						<div class="col-md-6 form-group">
							<input type="text" class="form-control" name="tag" placeholder="ស្លាក (ឧ. iPhone, ទូរស័ព្ទ)">
						</div>
						<div class="col-md-12 form-group">
							<textarea class="form-control" name="description" rows="4" placeholder="ពិពណ៌នាផលិតផល" required></textarea>
						</div>
						<div class="col-md-12 form-group">
							<label for="image">រូបភាពផលិតផល</label>
							<input type="file" class="form-control-file" name="image" accept="image/*" required>
						</div>
						<div class="col-md-12 form-group text-right">
							<button type="submit" class="primary-btn">បញ្ចេញផលិតផល</button>
						</div>
					</form>
				</div>

				<div class="col-lg-4">
					<div class="order_box">
						<h2>គន្លឹះសម្រាប់លក់បានល្អ</h2>
						<ul class="list">
							<li>ប្រើចំណងជើងផលិតផលដែលច្បាស់លាស់</li>
							<li>បញ្ចូលរូបភាពមានគុណភាពខ្ពស់</li>
							<li>ផ្តល់ពិពណ៌នាផលិតផលលម្អិត</li>
							<li>កំណត់តម្លៃប្រកួតប្រជែង</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================ End Sell Product Form =================-->

@endsection
