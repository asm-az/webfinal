// 1) تمييز الرابط النشط في الـ Navbar
const currentPage = window.location.href;

const links = document.querySelectorAll(".nav-link");

links.forEach(link => {
  if (currentPage.includes(link.getAttribute("href"))) {
    link.classList.add("active");
  } else {
    link.classList.remove("active");
  }
});
 

//2) تأثير ظهور الكروت عند التمرير(scroll animation)

window.addEventListener("DOMContentLoaded", () => {

  const cards = document.querySelectorAll(".card");

  const observer = new IntersectionObserver(entries => {

    entries.forEach(entry => {

      if (entry.isIntersecting) {
        entry.target.classList.add("active");
      }

    });

  }, { threshold: 0.2 });

  cards.forEach(card => observer.observe(card));

});

const counters = document.querySelectorAll(".counter");

counters.forEach(counter => {

  const updateCounter = () => {
    const target = +counter.getAttribute("data-target");
    const current = +counter.innerText;

    const increment = target / 100;

    if(current < target){
      counter.innerText = Math.ceil(current + increment);
      setTimeout(updateCounter, 20);
    } else {
      counter.innerText = target;
    }
  };

  updateCounter();

});
  
document.addEventListener("DOMContentLoaded", function () {

  const toggleBtn = document.getElementById("theme-toggle");

  if (!toggleBtn) return; // حماية لو العنصر غير موجود

  toggleBtn.addEventListener("click", function (e) {
    e.preventDefault();

    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
      this.innerHTML = "☀️ الوضع النهاري";
    } else {
      this.innerHTML = "🌙 تغيير المظهر";
    }
  });

});




// 4) سكرول ناعم عند الضغط على الروابط
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();

    document.querySelector(this.getAttribute("href"))
      ?.scrollIntoView({ behavior: "smooth" });
  });
});

const stars = document.querySelectorAll(".rating span");
const ratingInput = document.getElementById("rating-value");

stars.forEach(star => {
  star.addEventListener("click", () => {

    const value = star.getAttribute("data-value");
    ratingInput.value = value;

    stars.forEach(s => {
      s.classList.remove("active");

      if(s.getAttribute("data-value") <= value){
        s.classList.add("active");
      }
    });

  });
});



