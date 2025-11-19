<script src="{{ asset('frontend/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
$(function(){
  // AJAX add-to-cart
  $('.btn-add-cart').on('click', function(e){
    e.preventDefault();
    let pid = $(this).data('id');
    $.post("{{ route('cart.add') }}", { product_id: pid, quantity: 1, _token: '{{ csrf_token() }}' }, function(res){
      alert('Added to cart');
    });
  });
});
</script>
