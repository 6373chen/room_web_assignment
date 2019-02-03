// javascript for the product detail page

//functions
function setQuantity( quantity ){
  if( quantity > 0 ){
    $('input[name="quantity"]').val( quantity );
  }
}

function showTotal( quantity , price ){
  let totalPrice = (quantity * price).toFixed(2);
  $('#total').text( totalPrice );
}


$(document).ready( () => {
  //plus and minus buttons
  let plus = $('button[name="plus"]');
  let minus = $('button[name="minus"]');
  let quantity = $('input[name="quantity"]').val();
  let price = parseFloat( $('#product-price').text().trim() );
  $(plus).click(() => {
    quantity++;
    setQuantity( quantity );
    showTotal( quantity, price );
  });
  $(minus).click(() => {
    quantity = ( quantity <= 1 )? 1 : quantity - 1;
    setQuantity( quantity );
    showTotal( quantity, price );
  });
});

