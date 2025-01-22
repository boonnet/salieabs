document.addEventListener("DOMContentLoaded", function () {
  // Get all filter buttons
  const filterButtons = document.querySelectorAll(
    ".product-list .product-link"
  );

  // Add click event to each filter button
  filterButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove active class from all buttons
      filterButtons.forEach((btn) => btn.classList.remove("active"));

      // Add active class to clicked button
      this.classList.add("active");

      // Get filter value from the button text
      const filterValue = this.textContent
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-");

      // Get all product items
      const products = document.querySelectorAll(".isotope_item");

      // Show all products if "SHOW ALL" is clicked
      if (filterValue === "show-all") {
        products.forEach((product) => {
          product.closest(".col").style.display = "block";
        });
        return;
      }

      // Filter products based on category text
      products.forEach((product) => {
        const filterElement = product.querySelector(".filter"); // Check if .filter exists
        if (filterElement) {
          const category = filterElement.innerText
            .trim()
            .toLowerCase()
            .replace(/\s+/g, "-");
          const productContainer = product.closest(".col");

          if (category === filterValue) {
            productContainer.style.display = "block";
            console.log(category);
            console.log(filterValue);
          } else {
            productContainer.style.display = "none";
          }
        } else {
          console.warn("No .filter element found in:", product); // Log missing .filter elements
        }
      });
    });
  });
});
