function createArticle(xx) {
  const article = document.createElement("div");
  article.classList.add("filterOeuvre");

  article.innerHTML = `
        
        <div class="filterOeuvreOne">
        <h5>  ${xx.titre}  </h5>
        <img src="images/oeuvre/${xx.image}" alt="${xx.titre}" class="image1">
        <p> prix : ${xx.prix} </p>
        <p class="colorYellow"> dimention: ${xx.dimention} </p>
        </div>
        `;
  return article;
}

async function filterMain() {
  try {
    // appel api
    const response = await fetch("/api/oeuvres", {
      headers: {
        Accept: "application/json",
      },
    });
    if (!response.ok) {
      throw new Error("erreur serveur");
    }
    const oeuvres = await response.json();
    document
      .querySelector(".formFilterOeuvre")
      .addEventListener("submit", function (event) {
        event.preventDefault();
        const loader = document.createElement("p");
        loader.innerHTML = "";
        document.querySelector(".filter").append(loader);


        const category = parseInt(
          document.querySelector("#selectFilter").value
        );
        const minPrice = document.querySelector("#range1").value;
        const maxPrice = document.querySelector("#range2").value;

        if (parseInt(maxPrice) < parseInt(minPrice)) {
          loader.innerText =
            "Erreur : le prix maximum ne peut pas être inférieur au prix minimum.";
          loader.style.color = "red";
          loader.style.textAlign = "center";
          loader.style.display = "block";
          return;
        } else {
          loader.style.display = "none";
        }
        loader.innerText = "";

        const filterOeuvres = oeuvres.filter((oeuvre) => {
          const categorySelect = document.querySelector("#selectFilter");
          const categoryValue =
            categorySelect.options[categorySelect.selectedIndex].value;
          const categoryUrl = oeuvre.categorie;
          const categoryId = parseInt(categoryUrl.split("/").pop());

          if (categoryId === parseInt(categoryValue)) {
            return (
              categoryId === category &&
              oeuvre.prix >= minPrice &&
              oeuvre.prix <= maxPrice
            );
          }
        });
        loader.remove();

        document.querySelector(".cardFilter").innerHTML = "";
        for (let oeuvre of filterOeuvres) {
          document.querySelector(".cardFilter").append(createArticle(oeuvre));
        }
      });
  } catch (e) {
    loader.innerText = "impossible de charger les oeuvres";
    loader.style.color = "red";
    loader.style.display = "block";
    return;
  }
}
filterMain();

// ***********range***********
//  form range()

const rangePrices = document.querySelectorAll(".rangePrice");
rangePrices.forEach((range) => {
  const priceSpan = range.nextElementSibling;
  range.addEventListener("input", (event) => {
    priceSpan.textContent = event.target.value;
  });
});
