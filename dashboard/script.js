document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("ad-form-container");
    const postAdBtn = document.getElementById("post-ad-btn");
    const closeFormBtn = document.getElementById("close-form");

    postAdBtn.addEventListener("click", () => formContainer.classList.remove("hidden"));
    closeFormBtn.addEventListener("click", () => formContainer.classList.add("hidden"));

    document.getElementById("listing-form").addEventListener("submit", function (event) {
        event.preventDefault();

        let title = document.getElementById("title").value;
        let price = document.getElementById("price").value;
        let imageInput = document.getElementById("image-upload").files[0];

        if (!imageInput) {
            alert("Please upload an image!");
            return;
        }

        let reader = new FileReader();
        reader.onload = function (e) {
            let imageUrl = e.target.result;
            
            let newItem = document.createElement("div");
            newItem.classList.add("item");

            newItem.innerHTML = `
                <img src="${imageUrl}" alt="${title}">
                <h3>${title}</h3>
                <p class="price">💰 ${price ? `₹${price}` : "Negotiable"}</p>
            `;

            document.getElementById("list-container").appendChild(newItem);
            document.getElementById("listing-form").reset();
            formContainer.classList.add("hidden");
            alert("✅ Ad Posted Successfully!");
        };

        reader.readAsDataURL(imageInput);
    });
});
