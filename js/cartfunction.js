$(document).ready(function (){

	
	$(document).on('click', '.btn-minus', function(){

		var $quantityInput = $(this).closest('.quantity').find('.qty');
		var productId = $(this).closest('.quantity').find('.prodid');
		var currentValue = parseInt($quantityInput.val());

		if (!isNaN(currentValue)) {
			var qtyVal = currentValue + 1;
			$quantityInput.val(qtyVal);
			quantityIncDec(productId, qtyVal);
		}				
	});
	$(document).on('click', '.btn-plus', function(){

		var $quantityInput = $(this).closest('.quantity').find('.qty');
		var $productId = $(this).closest('.quantity').find('.prodid');
		var currentValue = parseInt($quantityInput.val());

		if (!NaN(currentValue) && currentValue > 1) {
			var qtyVal = currentValue - 1;
			$quantityInput.val(qtyVal);
			quantityIncDec(productId, qtyVal);

		}
	});

	function quantityIncDec(prodid, qty){


		$.ajax({
			type: "POST",
			url: "cart.php",
			data: {
				'productIncDec': true,
				'productid': prodid, 
				'inputqty': qty

			},
			success: function (response) {
				var res = JSON.parse(response);

				if (res.status == 200) {
					window.location.reload();
					
				}
			}
		});

	}


});
