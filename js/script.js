document.getElementById("tang").addEventListener("click", function(event) {
    event.preventDefault();
    let quantityInput = document.getElementById("soluong_input");
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
});

document.getElementById("giam").addEventListener("click", function(event) {
    event.preventDefault();
    let quantityInput = document.getElementById("soluong_input");
    let currentValue = parseInt(quantityInput.value);
    
    if (currentValue > 1) { // Đảm bảo giá trị không xuống dưới 1
        quantityInput.value = currentValue - 1;
    }
});

// Show the first tab and hide the rest
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
  $('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();
  
  var activeTab = $(this).find('a').attr('href');
  $(activeTab).fadeIn();
  return false;
});



