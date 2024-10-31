// document.getElementById("tang").addEventListener("click", function(event) {
//     event.preventDefault();
//     let quantityInput = document.getElementById("soluong_input");
//     let currentValue = parseInt(quantityInput.value);
//     quantityInput.value = currentValue + 1;
// });

// document.getElementById("giam").addEventListener("click", function(event) {
//     event.preventDefault();
//     let quantityInput = document.getElementById("soluong_input");
//     let currentValue = parseInt(quantityInput.value);
    
//     if (currentValue > 1) { // Đảm bảo giá trị không xuống dưới 1
//         quantityInput.value = currentValue - 1;
//     }
// });
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("soluong_input");
        const btnDecrease = document.getElementById("giam");
        const btnIncrease = document.getElementById("tang");
        const maxQuantity = parseInt(input.max);

        btnIncrease.addEventListener("click", function() {
            event.preventDefault();
            let currentQuantity = parseInt(input.value);
            if (currentQuantity < maxQuantity) {
                input.value = currentQuantity + 1;
            }
        });

        btnDecrease.addEventListener("click", function() {
            event.preventDefault();
            let currentQuantity = parseInt(input.value);
            if (currentQuantity > 1) {
                input.value = currentQuantity - 1;
            }
        });

        // input.addEventListener("input", function() {
        //     if (input.value > maxQuantity) {
        //         input.value = maxQuantity;
        //     } else if (input.value < 1) {
        //         input.value = 1;
        //     }
        // });
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



