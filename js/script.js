
document.addEventListener('DOMContentLoaded', function () {
  const stars = document.querySelectorAll('.star');
  const ratingInput = document.getElementById('rating');
  
  stars.forEach(function(star, index) {
   
    star.addEventListener('mouseover', function() {
      resetStarColors();
      highlightStars(index + 1);
    });

    star.addEventListener('mouseout', function() {
      resetStarColors();
      if (ratingInput.value) {
        highlightStars(ratingInput.value);
      }
    });

    star.addEventListener('click', function() {
      ratingInput.value = index + 1;
    });
  });

  function highlightStars(count) {
    for (let i = 0; i < count; i++) {
      stars[i].classList.add('text-yellow-500');
    }
  }

  function resetStarColors() {
    stars.forEach(function(star) {
      star.classList.remove('text-yellow-500');
    });
  }
});

// document.getElementById("carForm").addEventListener("submit", function(event) {
// let carSelect = document.getElementById("car");
// let carValue = carSelect.value;

// if (carValue === "") {
//   Swal.fire({
//     title: 'erour!',
//     text: 'no.',
//     icon: 'error',
//     confirmButtonText: 'ok'
//   });

//   event.preventDefault();
// }
// });
